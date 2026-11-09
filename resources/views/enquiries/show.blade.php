@extends('layouts.app')

@section('title', "Enquiry {$enquiry->enquiry_no} - SpecialCare")

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header & Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('enquiries.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Enquiries
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $enquiry->child_name }}</h1>
                <span class="font-mono text-xs px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-bold">
                    {{ $enquiry->enquiry_no }}
                </span>
                @if($enquiry->status === 'new')
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">New Lead</span>
                @elseif($enquiry->status === 'assessment_scheduled')
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Assessment Scheduled</span>
                @elseif($enquiry->status === 'assessed')
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">Diagnostic Completed</span>
                @elseif($enquiry->status === 'admitted')
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Enrolled Student</span>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-3">
            @if($enquiry->status !== 'assessed' && $enquiry->status !== 'admitted')
                <a href="{{ route('diagnostics.create', ['enquiry_id' => $enquiry->id]) }}" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs sm:text-sm font-bold shadow-md transition flex items-center">
                    <i class="fa-solid fa-stethoscope mr-2"></i> Start Clinical Diagnostic
                </a>
            @elseif($enquiry->diagnosticAssessment)
                <a href="{{ route('diagnostics.show', $enquiry->diagnosticAssessment) }}" class="px-4 py-2 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs sm:text-sm font-bold hover:bg-teal-100 transition flex items-center">
                    <i class="fa-solid fa-file-medical mr-2"></i> View Diagnostic Report
                </a>
            @endif

            @if($enquiry->student)
                <a href="{{ route('students.show', $enquiry->student) }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs sm:text-sm font-bold shadow-md hover:bg-indigo-700 transition flex items-center">
                    <i class="fa-solid fa-id-card mr-2"></i> View Student Profile
                </a>
            @endif
        </div>
    </div>

    <!-- Intake Pipeline Step Tracker -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
        <div class="flex items-center justify-between max-w-2xl mx-auto">
            <!-- Step 1 -->
            <div class="flex items-center space-x-2">
                <span class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                    <i class="fa-solid fa-check"></i>
                </span>
                <div>
                    <div class="text-xs font-bold text-slate-800">1. Enquiry</div>
                    <div class="text-2xs text-emerald-600 font-semibold">Registered</div>
                </div>
            </div>
            <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>

            <!-- Step 2 -->
            <div class="flex items-center space-x-2">
                <span class="w-8 h-8 rounded-full {{ $enquiry->diagnosticAssessment ? 'bg-emerald-500 text-white' : ($enquiry->assessment_scheduled_at ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500') }} flex items-center justify-center font-bold text-xs shadow-xs">
                    @if($enquiry->diagnosticAssessment)
                        <i class="fa-solid fa-check"></i>
                    @else
                        2
                    @endif
                </span>
                <div>
                    <div class="text-xs font-bold text-slate-800">2. Diagnostic</div>
                    <div class="text-2xs {{ $enquiry->diagnosticAssessment ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                        {{ $enquiry->diagnosticAssessment ? 'Completed' : ($enquiry->assessment_scheduled_at ? 'Scheduled' : 'Pending') }}
                    </div>
                </div>
            </div>
            <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>

            <!-- Step 3 -->
            <div class="flex items-center space-x-2">
                <span class="w-8 h-8 rounded-full {{ $enquiry->student ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }} flex items-center justify-center font-bold text-xs shadow-xs">
                    @if($enquiry->student)
                        <i class="fa-solid fa-check"></i>
                    @else
                        3
                    @endif
                </span>
                <div>
                    <div class="text-xs font-bold text-slate-800">3. Admission</div>
                    <div class="text-2xs {{ $enquiry->student ? 'text-emerald-600 font-semibold' : 'text-slate-400' }}">
                        {{ $enquiry->student ? 'Enrolled' : 'Awaiting' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid: Enquiry Details + Schedule Assessment Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Child & Parent Info Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-circle-info text-blue-600"></i> Intake Details
                </h2>
                
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Child Name:</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $enquiry->child_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Age / Gender:</span>
                        <span class="font-bold text-slate-800 text-sm">
                            {{ $enquiry->gender }} 
                            @if($enquiry->dob)
                                ({{ \Carbon\Carbon::parse($enquiry->dob)->age }} years old, DOB: {{ $enquiry->dob->format('M d, Y') }})
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Parent / Guardian:</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $enquiry->parent_name }} ({{ $enquiry->relation }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Phone Number:</span>
                        <span class="font-bold text-slate-800 text-sm">{{ $enquiry->phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Email:</span>
                        <span class="font-semibold text-slate-700">{{ $enquiry->email ?? 'Not provided' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Referral Source:</span>
                        <span class="font-semibold text-slate-700">{{ $enquiry->referred_by ?? 'Direct Walk-in' }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-slate-400 block font-medium">Residential Address:</span>
                        <span class="font-medium text-slate-700">{{ $enquiry->address ?? 'Not provided' }}</span>
                    </div>
                </div>

                <!-- Primary Concerns / Red Flags -->
                <div class="pt-3 border-t border-slate-100">
                    <span class="text-xs font-bold text-slate-700 block mb-2">Reported Developmental Concerns:</span>
                    @if(!empty($enquiry->primary_concerns))
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($enquiry->primary_concerns as $concern)
                                <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200 font-semibold text-xs">
                                    <i class="fa-solid fa-triangle-exclamation mr-1 text-amber-500"></i> {{ $concern }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="text-xs text-slate-400 italic">No specific red flags flagged during initial call.</span>
                    @endif
                </div>

                @if($enquiry->notes)
                    <div class="pt-3 border-t border-slate-100">
                        <span class="text-xs font-bold text-slate-700 block mb-1">Counselor / Intake Notes:</span>
                        <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-xl leading-relaxed">
                            {{ $enquiry->notes }}
                        </p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Col: Schedule Assessment Box -->
        <div class="space-y-6">

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-calendar-check text-teal-600"></i> Clinical Assessment
                </h3>

                @if($enquiry->assessment_scheduled_at)
                    <div class="p-4 rounded-xl bg-teal-50 border border-teal-200 space-y-2">
                        <div class="flex items-center space-x-2 text-teal-800 font-bold text-xs">
                            <i class="fa-solid fa-circle-check text-teal-600"></i>
                            <span>Assessment Appointment Booked</span>
                        </div>
                        <p class="text-sm font-extrabold text-teal-900">
                            {{ \Carbon\Carbon::parse($enquiry->assessment_scheduled_at)->format('l, M d, Y') }}
                        </p>
                        <p class="text-xs text-teal-700">
                            Time: {{ \Carbon\Carbon::parse($enquiry->assessment_scheduled_at)->format('h:i A') }}
                        </p>
                    </div>

                    @if(!$enquiry->diagnosticAssessment)
                        <a href="{{ route('diagnostics.create', ['enquiry_id' => $enquiry->id]) }}" class="w-full py-2.5 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition flex items-center justify-center shadow-md">
                            <i class="fa-solid fa-stethoscope mr-2"></i> Conduct Diagnostic Now
                        </a>
                    @endif
                @endif

                <!-- Schedule / Reschedule Form -->
                <form action="{{ route('enquiries.scheduleAssessment', $enquiry) }}" method="POST" class="space-y-3 pt-2">
                    @csrf
                    <p class="text-xs font-bold text-slate-700">
                        {{ $enquiry->assessment_scheduled_at ? 'Reschedule Appointment' : 'Book Assessment Date & Time:' }}
                    </p>
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-1">Date</label>
                        <input type="date" name="assessment_date" required 
                               value="{{ $enquiry->assessment_scheduled_at ? $enquiry->assessment_scheduled_at->format('Y-m-d') : date('Y-m-d', strtotime('+2 days')) }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-1">Time</label>
                        <input type="time" name="assessment_time" required 
                               value="{{ $enquiry->assessment_scheduled_at ? $enquiry->assessment_scheduled_at->format('H:i') : '10:30' }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-1">Lead Assessor / Psychologist</label>
                        <select name="handled_by" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                            @foreach($psychologists as $psych)
                                <option value="{{ $psych->id }}" {{ $enquiry->handled_by == $psych->id ? 'selected' : '' }}>
                                    {{ $psych->name }} ({{ $psych->specialization ?? 'Therapist' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition shadow-xs">
                        <i class="fa-solid fa-clock mr-1.5"></i> Save Appointment
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>
@endsection

