@extends('layouts.app')

@section('title', "Diagnostic Report {$diagnostic->assessment_no} - SpecialCare")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('diagnostics.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Diagnostics
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $diagnostic->child_name }}</h1>
                <span class="font-mono text-xs px-2.5 py-1 rounded-full bg-teal-100 text-teal-800 font-bold">
                    {{ $diagnostic->assessment_no }}
                </span>
                @if($diagnostic->status === 'admitted' || $diagnostic->student)
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <i class="fa-solid fa-check-circle mr-1 text-emerald-600"></i> Admitted Student
                    </span>
                @else
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">Ready for Admission</span>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center shadow-xs">
                <i class="fa-solid fa-print mr-1.5"></i> Print Clinical Report
            </button>
            @if(!$diagnostic->student)
                <a href="{{ route('students.create', ['diagnostic_id' => $diagnostic->id]) }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold shadow-md transition flex items-center">
                    <i class="fa-solid fa-graduation-cap mr-2"></i> Proceed to Admission (Step 3) &rarr;
                </a>
            @else
                <a href="{{ route('students.show', $diagnostic->student) }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold shadow-md transition flex items-center">
                    <i class="fa-solid fa-id-card mr-2"></i> View Student Profile
                </a>
            @endif
        </div>
    </div>

    <!-- Official Clinical Diagnostic Sheet Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-md p-6 sm:p-8 space-y-6">

        <!-- Top Header for Clinical Report -->
        <div class="border-b border-slate-200 pb-6 flex items-start justify-between">
            <div>
                <span class="text-xs uppercase tracking-widest text-slate-400 font-bold">Special Education Clinical Evaluation</span>
                <h2 class="text-xl font-extrabold text-slate-900 mt-0.5">Comprehensive Diagnostic & Sensory Assessment</h2>
                <p class="text-xs text-slate-500 mt-1">
                    Evaluated by: <strong class="text-slate-700">{{ $diagnostic->assessor_name ?? ($diagnostic->assessor ? $diagnostic->assessor->name : 'Clinical Specialist') }}</strong> 
                    • Date: <strong class="text-slate-700">{{ $diagnostic->assessment_date->format('M d, Y') }}</strong>
                </p>
            </div>
            <div class="text-right">
                <span class="inline-block p-2 rounded-xl bg-teal-50 text-teal-700 border border-teal-200 text-xs font-bold">
                    <i class="fa-solid fa-shield-halved mr-1"></i> Certified Pre-Admission
                </span>
            </div>
        </div>

        <!-- Child Demographics & Primary Diagnosis Highlight Banner -->
        <div class="bg-gradient-to-r from-teal-50 to-blue-50 border border-teal-200 rounded-xl p-5 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
            <div>
                <span class="text-2xs uppercase tracking-wider text-teal-700 font-bold block">Child Demographics</span>
                <span class="text-base font-extrabold text-slate-900 block mt-0.5">{{ $diagnostic->child_name }}</span>
                <span class="text-xs text-slate-600">
                    {{ $diagnostic->gender }} 
                    @if($diagnostic->dob)
                        • {{ \Carbon\Carbon::parse($diagnostic->dob)->age }} yrs (DOB: {{ $diagnostic->dob->format('M d, Y') }})
                    @endif
                </span>
            </div>

            <div>
                <span class="text-2xs uppercase tracking-wider text-teal-700 font-bold block">Primary Clinical Diagnosis</span>
                <span class="text-base font-extrabold text-teal-950 block mt-0.5">{{ $diagnostic->primary_diagnosis }}</span>
                <span class="text-xs text-indigo-700 font-semibold">{{ $diagnostic->severity_level ?? 'Level 2' }}</span>
            </div>

            <div class="bg-white/80 p-3 rounded-lg border border-teal-200 text-center">
                <span class="text-2xs uppercase tracking-wider text-slate-500 font-bold block">CARS Autism Score</span>
                <span class="text-2xl font-black text-slate-900 font-mono">{{ $diagnostic->cars_score ?? 'N/A' }} <span class="text-xs text-slate-400 font-normal">/ 60</span></span>
                <span class="text-2xs font-bold text-amber-700 block mt-0.5">{{ $diagnostic->cars_severity }}</span>
            </div>
        </div>

        <!-- Section 1: Detailed Clinical Scores -->
        <div class="space-y-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-2">
                Standardized Autism & Developmental Metrics
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-1">
                    <span class="font-bold text-slate-800 block">Childhood Autism Rating Scale (CARS-2)</span>
                    <p class="text-slate-600">Result: <strong>{{ $diagnostic->cars_score }}</strong> ({{ $diagnostic->cars_severity }})</p>
                    <p class="text-2xs text-slate-400">Scale Interpretation: 15-29.5: Non-Autistic | 30-36.5: Mild-to-Moderate Autism | 37-60: Severe Autism.</p>
                </div>
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-1">
                    <span class="font-bold text-slate-800 block">Indian Scale for Assessment of Autism (ISAA)</span>
                    <p class="text-slate-600">Score: <strong>{{ $diagnostic->isaa_score ?? 'Not administered' }}</strong></p>
                    <p class="text-2xs text-slate-400">Standardized clinical tool evaluated across Social Relationship, Communication, and Sensory areas.</p>
                </div>
            </div>
        </div>

        <!-- Section 2: Clinical Domain Breakdown -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-2">
                Domain Evaluations & Clinical Baseline
            </h3>

            <!-- Speech & Communication -->
            <div class="p-4 rounded-xl border border-teal-100 bg-teal-50/30">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-comment-dots text-teal-600 text-xs"></i>
                    <span class="font-bold text-slate-800 text-xs">Speech & Language Baseline</span>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    {{ $diagnostic->speech_evaluation ?? 'Evaluation not recorded.' }}
                </p>
            </div>

            <!-- Motor & Physical -->
            <div class="p-4 rounded-xl border border-blue-100 bg-blue-50/30">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fa-solid fa-person-walking text-blue-600 text-xs"></i>
                    <span class="font-bold text-slate-800 text-xs">Motor & Coordination Evaluation</span>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    {{ $diagnostic->motor_evaluation ?? 'Evaluation not recorded.' }}
                </p>
            </div>

            <!-- Sensory Profile Grid -->
            @if(!empty($diagnostic->sensory_profile))
                <div class="p-4 rounded-xl border border-purple-100 bg-purple-50/30 space-y-2">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid fa-hand-sparkles text-purple-600 text-xs"></i>
                        <span class="font-bold text-slate-800 text-xs">Sensory Profile Matrix</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        @foreach($diagnostic->sensory_profile as $sense => $detail)
                            <div class="bg-white p-2.5 rounded-lg border border-purple-100">
                                <span class="text-2xs font-bold text-purple-700 uppercase tracking-wider block">{{ ucfirst($sense) }}</span>
                                <span class="text-slate-700 font-medium text-xs">{{ $detail }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Behavioral Observations -->
            @if($diagnostic->behavioral_observations)
                <div class="p-4 rounded-xl border border-amber-100 bg-amber-50/30">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-eye text-amber-600 text-xs"></i>
                        <span class="font-bold text-slate-800 text-xs">Behavioral & Stimming Observations</span>
                    </div>
                    <p class="text-xs text-slate-700 leading-relaxed">
                        {{ $diagnostic->behavioral_observations }}
                    </p>
                </div>
            @endif
        </div>

        <!-- Section 3: Recommendations -->
        <div class="p-5 rounded-xl border-2 border-dashed border-emerald-300 bg-emerald-50/40 space-y-2">
            <span class="text-xs font-extrabold text-emerald-800 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-clipboard-check text-emerald-600"></i> Multidisciplinary Recommendations for Admission
            </span>
            <p class="text-sm text-slate-800 font-medium leading-relaxed">
                {{ $diagnostic->recommendation ?? 'No specific clinical recommendation provided.' }}
            </p>
        </div>

        <!-- Bottom Actions -->
        @if(!$diagnostic->student)
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <span class="text-xs text-slate-500 font-medium">Diagnostic completed. Ready to enroll into school roster.</span>
                <a href="{{ route('students.create', ['diagnostic_id' => $diagnostic->id]) }}" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs sm:text-sm font-bold shadow-md transition flex items-center">
                    <i class="fa-solid fa-graduation-cap mr-2"></i> Enroll Student with this Diagnostic &rarr;
                </a>
            </div>
        @endif

    </div>

</div>
@endsection

