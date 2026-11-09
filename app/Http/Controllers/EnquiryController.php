<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Enquiry::with('handler')->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $enquiries = $query->paginate(15);
        $statusCounts = [
            'all' => Enquiry::count(),
            'new' => Enquiry::where('status', 'new')->count(),
            'assessment_scheduled' => Enquiry::where('status', 'assessment_scheduled')->count(),
            'assessed' => Enquiry::where('status', 'assessed')->count(),
            'admitted' => Enquiry::where('status', 'admitted')->count(),
        ];

        return view('enquiries.index', compact('enquiries', 'statusCounts', 'status'));
    }

    public function create()
    {
        $staff = User::whereIn('role', ['admin', 'therapist', 'educator'])->get();
        $nextEnquiryNo = 'ENQ-' . date('Y') . '-' . str_pad((Enquiry::count() + 1), 3, '0', STR_PAD_LEFT);
        return view('enquiries.create', compact('staff', 'nextEnquiryNo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|string',
            'parent_name' => 'required|string|max:255',
            'relation' => 'required|string',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'referred_by' => 'nullable|string|max:255',
            'primary_concerns' => 'nullable|array',
            'notes' => 'nullable|string',
            'handled_by' => 'nullable|exists:users,id',
        ]);

        $enquiryNo = 'ENQ-' . date('Y') . '-' . str_pad((Enquiry::count() + 1), 3, '0', STR_PAD_LEFT);

        $enquiry = Enquiry::create([
            'enquiry_no' => $enquiryNo,
            'child_name' => $validated['child_name'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'parent_name' => $validated['parent_name'],
            'relation' => $validated['relation'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'] ?? null,
            'referred_by' => $validated['referred_by'] ?? null,
            'primary_concerns' => $validated['primary_concerns'] ?? [],
            'notes' => $validated['notes'] ?? null,
            'status' => 'new',
            'handled_by' => $validated['handled_by'] ?? null,
        ]);

        return redirect()->route('enquiries.show', $enquiry)->with('success', "Enquiry {$enquiry->enquiry_no} registered successfully. Proceed to schedule diagnostic assessment.");
    }

    public function show(Enquiry $enquiry)
    {
        $enquiry->load(['handler', 'diagnosticAssessment', 'student']);
        $psychologists = User::whereIn('role', ['therapist', 'admin'])->get();
        return view('enquiries.show', compact('enquiry', 'psychologists'));
    }

    public function scheduleAssessment(Request $request, Enquiry $enquiry)
    {
        $validated = $request->validate([
            'assessment_date' => 'required|date',
            'assessment_time' => 'required',
            'handled_by' => 'nullable|exists:users,id',
        ]);

        $dateTime = Carbon::parse($validated['assessment_date'] . ' ' . $validated['assessment_time']);

        $enquiry->update([
            'assessment_scheduled_at' => $dateTime,
            'status' => 'assessment_scheduled',
            'handled_by' => $validated['handled_by'] ?? $enquiry->handled_by,
        ]);

        return redirect()->route('enquiries.show', $enquiry)->with('success', 'Diagnostic assessment successfully scheduled for ' . $dateTime->format('M d, Y h:i A'));
    }
}
