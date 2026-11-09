<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\DiagnosticAssessment;
use App\Models\Student;
use App\Models\IepGoal;
use App\Models\TherapySession;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_enquiries' => Enquiry::count(),
            'pending_enquiries' => Enquiry::where('status', 'new')->count(),
            'assessments_scheduled' => Enquiry::where('status', 'assessment_scheduled')->count(),
            'total_assessments' => DiagnosticAssessment::count(),
            'completed_assessments' => DiagnosticAssessment::where('status', 'completed')->count(),
            'total_students' => Student::where('status', 'active')->count(),
            'active_iep_goals' => IepGoal::where('status', 'in_progress')->count(),
            'recent_sessions' => TherapySession::count(),
        ];

        $recentEnquiries = Enquiry::latest()->take(5)->get();
        $recentAssessments = DiagnosticAssessment::latest()->take(5)->get();
        $recentStudents = Student::with(['educator'])->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentEnquiries', 'recentAssessments', 'recentStudents'));
    }
}
