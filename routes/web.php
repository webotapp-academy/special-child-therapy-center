<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\DiagnosticAssessmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentPortalController;
use App\Http\Controllers\AuthController;

// Public Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/quick-login/{email}', [AuthController::class, 'quickLogin'])->name('login.quick');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

// Root Route: If authenticated, go to dashboard/portal; otherwise redirect to /login
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return Auth::user()->role === 'parent' 
        ? redirect()->route('parent.progress') 
        : redirect()->route('dashboard');
})->name('home');

// ALL INTERNAL DATA ROUTES PROTECTED BY AUTH MIDDLEWARE
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Enquiry Module (Step 1)
    Route::resource('enquiries', EnquiryController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('enquiries/{enquiry}/schedule-assessment', [EnquiryController::class, 'scheduleAssessment'])->name('enquiries.scheduleAssessment');

    // Diagnostic Assessment Module (Step 2)
    Route::resource('diagnostics', DiagnosticAssessmentController::class)->only(['index', 'create', 'store', 'show']);

    // Student Admission & Management (Step 3)
    Route::resource('students', StudentController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('students/{student}/iep-goals', [StudentController::class, 'addIepGoal'])->name('students.addIepGoal');
    Route::post('students/{student}/therapy-sessions', [StudentController::class, 'addTherapySession'])->name('students.addTherapySession');
    Route::post('students/{student}/daily-care-logs', [StudentController::class, 'addDailyCareLog'])->name('students.addDailyCareLog');
    Route::post('students/{student}/attendance', [StudentController::class, 'markAttendance'])->name('students.markAttendance');
    Route::post('students/{student}/invoices', [StudentController::class, 'addInvoice'])->name('students.addInvoice');
    Route::post('students/{student}/behavioral-incidents', [StudentController::class, 'addBehavioralIncident'])->name('students.addBehavioralIncident');

    // Parent Progress Portal
    Route::get('parent/progress', [ParentPortalController::class, 'index'])->name('parent.progress');

});
