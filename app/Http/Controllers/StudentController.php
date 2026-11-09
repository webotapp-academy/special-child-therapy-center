<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\DiagnosticAssessment;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\IepGoal;
use App\Models\TherapySession;
use App\Models\DailyCareLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['educator', 'iepGoals'])->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_no', 'like', "%{$search}%")
                  ->orWhere('primary_diagnosis', 'like', "%{$search}%");
            });
        }

        if ($classroom = $request->query('classroom')) {
            $query->where('classroom_batch', $classroom);
        }

        $students = $query->paginate(12);
        $totalStudents = Student::count();
        $classrooms = Student::select('classroom_batch')->distinct()->pluck('classroom_batch');

        return view('students.index', compact('students', 'totalStudents', 'classrooms', 'search', 'classroom'));
    }

    public function create(Request $request)
    {
        $diagnosticId = $request->query('diagnostic_id');
        $diagnostic = $diagnosticId ? DiagnosticAssessment::with('enquiry')->find($diagnosticId) : null;
        $enquiry = $diagnostic ? $diagnostic->enquiry : null;

        $educators = User::whereIn('role', ['educator', 'therapist', 'admin'])->get();
        $nextAdmissionNo = 'SC-' . date('Y') . '-' . str_pad((Student::count() + 1), 3, '0', STR_PAD_LEFT);

        return view('students.create', compact('diagnostic', 'enquiry', 'educators', 'nextAdmissionNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_no' => 'required|string|unique:students,admission_no',
            'diagnostic_assessment_id' => 'nullable|exists:diagnostic_assessments,id',
            'enquiry_id' => 'nullable|exists:enquiries,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'blood_group' => 'nullable|string|max:10',
            'admission_date' => 'required|date',
            'classroom_batch' => 'required|string|max:255',
            'primary_educator_id' => 'nullable|exists:users,id',
            'shadow_teacher' => 'nullable|string|max:255',
            'primary_diagnosis' => 'required|string|max:255',
            'severity_level' => 'nullable|string|max:100',
            'communication_mode' => 'required|string',
            'sensory_triggers' => 'nullable|string',
            'calming_methods' => 'nullable|string',
            'comfort_item' => 'nullable|string|max:255',
            'food_texture_preferences' => 'nullable|string',
            'allergies' => 'nullable|string',
            'medical_notes' => 'nullable|string',
            'guardian_name' => 'required|string|max:255',
            'guardian_relation' => 'required|string',
            'guardian_phone' => 'required|string|max:50',
            'guardian_email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string|max:50',
        ]);

        // Auto-provision Parent User Account if email is provided
        $parentUserId = null;
        if (!empty($validated['guardian_email'])) {
            $parentUser = User::where('email', $validated['guardian_email'])->first();
            if (!$parentUser) {
                $parentUser = User::create([
                    'name' => $validated['guardian_name'],
                    'email' => $validated['guardian_email'],
                    'password' => Hash::make('parent123'),
                    'role' => 'parent',
                    'phone' => $validated['guardian_phone'],
                ]);
            }
            $parentUserId = $parentUser->id;
        }

        $student = Student::create(array_merge($validated, [
            'parent_user_id' => $parentUserId,
            'status' => 'active',
        ]));

        // Update Diagnostic and Enquiry status
        if (!empty($validated['diagnostic_assessment_id'])) {
            $diag = DiagnosticAssessment::find($validated['diagnostic_assessment_id']);
            if ($diag) {
                $diag->update(['status' => 'admitted']);
            }
        }
        if (!empty($validated['enquiry_id'])) {
            $enq = Enquiry::find($validated['enquiry_id']);
            if ($enq) {
                $enq->update(['status' => 'admitted']);
            }
        }

        // Initialize default baseline IEP goals
        IepGoal::create([
            'student_id' => $student->id,
            'domain' => 'Speech & Communication',
            'title' => 'Functional communication & requesting (' . $student->communication_mode . ')',
            'description' => 'Target spontaneous requests for everyday items with high independence.',
            'baseline' => 'Initial baseline established during diagnostic intake.',
            'target_date' => Carbon::now()->addMonths(3),
            'progress_percentage' => 15,
            'status' => 'in_progress',
        ]);

        IepGoal::create([
            'student_id' => $student->id,
            'domain' => 'Occupational & Sensory',
            'title' => 'Sensory regulation & coping with primary triggers',
            'description' => 'Tolerate classroom sensory stimulus using sensory diet & calming techniques.',
            'baseline' => $student->sensory_triggers ?? 'Sensory sensitivities observed during intake.',
            'target_date' => Carbon::now()->addMonths(3),
            'progress_percentage' => 20,
            'status' => 'in_progress',
        ]);

        return redirect()->route('students.show', $student)->with('success', "Student {$student->full_name} enrolled successfully! Initial IEP goals generated.");
    }

    public function show(Student $student)
    {
        $student->load([
            'educator',
            'parentUser',
            'diagnosticAssessment',
            'enquiry',
            'iepGoals.milestones',
            'therapySessions.therapist',
            'dailyCareLogs.loggedBy',
            'behavioralIncidents.loggedBy',
            'invoices.feePackage',
            'attendances',
        ]);

        $therapists = User::whereIn('role', ['therapist', 'admin'])->get();
        $educators = User::whereIn('role', ['educator', 'staff', 'admin'])->get();
        $feePackages = \App\Models\FeePackage::where('is_active', true)->get();

        return view('students.show', compact('student', 'therapists', 'educators', 'feePackages'));
    }

    public function addBehavioralIncident(Request $request, Student $student)
    {
        $validated = $request->validate([
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'location' => 'required|string',
            'antecedent' => 'required|string',
            'behavior_type' => 'required|string',
            'behavior_description' => 'nullable|string',
            'intensity' => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
            'intervention_used' => 'required|string',
            'post_incident_state' => 'nullable|string',
        ]);

        $student->behavioralIncidents()->create(array_merge($validated, [
            'logged_by_id' => auth()->id() ?? $student->primary_educator_id,
            'notified_parent' => true,
        ]));

        return redirect()->route('students.show', ['student' => $student, 'tab' => 'abc'])
            ->with('success', 'Behavioral ABC Incident successfully logged!');
    }

    public function addInvoice(Request $request, Student $student)
    {
        $validated = $request->validate([
            'fee_package_id' => 'nullable|exists:fee_packages,id',
            'item_description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $invoiceNo = 'INV-' . date('Y') . '-' . str_pad((\App\Models\Invoice::count() + 1), 3, '0', STR_PAD_LEFT);

        $student->invoices()->create(array_merge($validated, [
            'invoice_no' => $invoiceNo,
            'paid_date' => ($validated['status'] === 'paid') ? date('Y-m-d') : null,
        ]));

        return redirect()->route('students.show', ['student' => $student, 'tab' => 'billing'])
            ->with('success', "Invoice {$invoiceNo} generated successfully!");
    }

    public function addIepGoal(Request $request, Student $student)
    {
        $validated = $request->validate([
            'domain' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'baseline' => 'nullable|string',
            'target_date' => 'nullable|date',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'status' => 'required|string',
            'evaluator_notes' => 'nullable|string',
        ]);

        $student->iepGoals()->create($validated);

        return redirect()->route('students.show', ['student' => $student, 'tab' => 'iep'])
            ->with('success', 'New IEP Goal added successfully!');
    }

    public function addTherapySession(Request $request, Student $student)
    {
        $validated = $request->validate([
            'therapy_type' => 'required|string',
            'therapist_id' => 'nullable|exists:users,id',
            'session_date' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:180',
            'activities_performed' => 'nullable|string',
            'engagement_level' => 'required|string',
            'clinical_soap_notes' => 'nullable|string',
            'parent_summary' => 'required|string',
        ]);

        $therapistName = null;
        if (!empty($validated['therapist_id'])) {
            $user = User::find($validated['therapist_id']);
            $therapistName = $user ? $user->name : null;
        }

        $student->therapySessions()->create(array_merge($validated, [
            'therapist_name' => $therapistName,
        ]));

        return redirect()->route('students.show', ['student' => $student, 'tab' => 'therapy'])
            ->with('success', 'Therapy session logged! Parent summary will be visible on the Parent Portal.');
    }

    public function addDailyCareLog(Request $request, Student $student)
    {
        $validated = $request->validate([
            'log_date' => 'required|date',
            'morning_mood' => 'required|string',
            'afternoon_mood' => 'required|string',
            'meal_intake' => 'required|string',
            'meal_notes' => 'nullable|string',
            'potty_training_log' => 'required|string',
            'nap_minutes' => 'required|integer|min:0',
            'meltdown_count' => 'required|integer|min:0',
            'meltdown_triggers' => 'nullable|string',
            'teacher_notes_for_parent' => 'nullable|string',
        ]);

        $student->dailyCareLogs()->create(array_merge($validated, [
            'logged_by_id' => auth()->id() ?? $student->primary_educator_id,
        ]));

        return redirect()->route('students.show', ['student' => $student, 'tab' => 'daily_log'])
            ->with('success', 'Daily care sheet updated successfully!');
    }
}
