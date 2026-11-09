<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\IepGoal;
use App\Models\TherapySession;
use App\Models\DailyCareLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentPortalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. If logged in as Parent, strictly enforce privacy: Parent can ONLY see their own child
        if ($user && $user->role === 'parent') {
            $myChildren = Student::where('parent_user_id', $user->id)
                ->orWhere('guardian_email', $user->email)
                ->with([
                    'educator',
                    'iepGoals.milestones',
                    'therapySessions.therapist',
                    'dailyCareLogs.loggedBy'
                ])
                ->get();

            if ($myChildren->isEmpty()) {
                // Secondary check by phone if email didn't match
                $myChildren = Student::where('guardian_phone', $user->phone)->get();
            }

            if ($myChildren->isEmpty()) {
                return redirect()->route('login')->with('error', 'No student records associated with this parent account.');
            }

            // If parent has multiple children, they can switch only between their own children
            $allowedIds = $myChildren->pluck('id')->toArray();
            $requestedId = $request->query('student_id');

            if ($requestedId && in_array($requestedId, $allowedIds)) {
                $student = $myChildren->firstWhere('id', $requestedId);
            } else {
                $student = $myChildren->first();
            }

            // Only expose their own children in any dropdown
            $allStudents = $myChildren;
            $isParentRole = true;

        } else {
            // Staff / Administrator / Therapist Preview Mode
            $requestedId = $request->query('student_id');
            
            $query = Student::with([
                'educator',
                'iepGoals.milestones',
                'therapySessions.therapist',
                'dailyCareLogs.loggedBy'
            ]);

            $student = $requestedId ? $query->find($requestedId) : $query->first();

            if (!$student) {
                return redirect()->route('students.index')->with('error', 'No enrolled students found yet.');
            }

            $allStudents = Student::select('id', 'first_name', 'last_name', 'admission_no')->get();
            $isParentRole = false;
        }

        // Calculate domain progress averages
        $domainProgress = [];
        $goalsByDomain = $student->iepGoals->groupBy('domain');
        foreach ($goalsByDomain as $domain => $goals) {
            $domainProgress[$domain] = (int) round($goals->avg('progress_percentage'));
        }

        $overallIepMastery = $student->iepGoals->count() > 0 
            ? (int) round($student->iepGoals->avg('progress_percentage')) 
            : 0;

        $latestCareLog = $student->dailyCareLogs->first();
        $recentSessions = $student->therapySessions->take(5);

        return view('parent.progress', compact(
            'student',
            'allStudents',
            'domainProgress',
            'overallIepMastery',
            'latestCareLog',
            'recentSessions',
            'isParentRole'
        ));
    }
}
