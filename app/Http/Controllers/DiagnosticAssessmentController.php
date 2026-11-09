<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticAssessment;
use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Http\Request;

class DiagnosticAssessmentController extends Controller
{
    public function index()
    {
        $assessments = DiagnosticAssessment::with(['enquiry', 'assessor', 'student'])->latest()->paginate(15);
        return view('diagnostics.index', compact('assessments'));
    }

    public function create(Request $request)
    {
        $enquiryId = $request->query('enquiry_id');
        $enquiry = $enquiryId ? Enquiry::find($enquiryId) : null;
        $assessors = User::whereIn('role', ['admin', 'therapist'])->get();
        $nextAssessmentNo = 'DIAG-' . date('Y') . '-' . str_pad((DiagnosticAssessment::count() + 1), 3, '0', STR_PAD_LEFT);

        return view('diagnostics.create', compact('enquiry', 'assessors', 'nextAssessmentNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enquiry_id' => 'nullable|exists:enquiries,id',
            'child_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'assessment_date' => 'required|date',
            'assessor_id' => 'nullable|exists:users,id',
            'assessor_name' => 'nullable|string|max:255',
            'cars_score' => 'nullable|numeric|min:15|max:60',
            'isaa_score' => 'nullable|numeric|min:0|max:200',
            'primary_diagnosis' => 'required|string|max:255',
            'severity_level' => 'nullable|string|max:100',
            'speech_evaluation' => 'nullable|string',
            'motor_evaluation' => 'nullable|string',
            'sensory_profile' => 'nullable|array',
            'behavioral_observations' => 'nullable|string',
            'recommendation' => 'nullable|string',
        ]);

        // Automatically calculate CARS Severity
        $carsSeverity = null;
        if (!empty($validated['cars_score'])) {
            $score = (float)$validated['cars_score'];
            if ($score < 30) {
                $carsSeverity = 'Non-Autistic / Minimal Symptoms';
            } elseif ($score <= 36.5) {
                $carsSeverity = 'Mild-to-Moderate Autism';
            } else {
                $carsSeverity = 'Severe Autism';
            }
        }

        $assessmentNo = 'DIAG-' . date('Y') . '-' . str_pad((DiagnosticAssessment::count() + 1), 3, '0', STR_PAD_LEFT);

        $assessment = DiagnosticAssessment::create([
            'assessment_no' => $assessmentNo,
            'enquiry_id' => $validated['enquiry_id'] ?? null,
            'child_name' => $validated['child_name'],
            'dob' => $validated['dob'] ?? null,
            'gender' => $validated['gender'],
            'assessment_date' => $validated['assessment_date'],
            'assessor_id' => $validated['assessor_id'] ?? null,
            'assessor_name' => $validated['assessor_name'] ?? null,
            'cars_score' => $validated['cars_score'] ?? null,
            'cars_severity' => $carsSeverity,
            'isaa_score' => $validated['isaa_score'] ?? null,
            'primary_diagnosis' => $validated['primary_diagnosis'],
            'severity_level' => $validated['severity_level'] ?? null,
            'speech_evaluation' => $validated['speech_evaluation'] ?? null,
            'motor_evaluation' => $validated['motor_evaluation'] ?? null,
            'sensory_profile' => $validated['sensory_profile'] ?? [],
            'behavioral_observations' => $validated['behavioral_observations'] ?? null,
            'recommendation' => $validated['recommendation'] ?? null,
            'status' => 'completed',
        ]);

        if (!empty($validated['enquiry_id'])) {
            $enquiry = Enquiry::find($validated['enquiry_id']);
            if ($enquiry) {
                $enquiry->update(['status' => 'assessed']);
            }
        }

        return redirect()->route('diagnostics.show', $assessment)->with('success', "Diagnostic Assessment {$assessment->assessment_no} finalized. You can now admit the student.");
    }

    public function show(DiagnosticAssessment $diagnostic)
    {
        $diagnostic->load(['enquiry', 'assessor', 'student']);
        return view('diagnostics.show', compact('diagnostic'));
    }
}
