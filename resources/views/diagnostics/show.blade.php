@extends('layouts.app')

@section('title', "Diagnostic Report {$diagnostic->assessment_no} - SpecialCare")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Screen Only: Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <a href="{{ route('diagnostics.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center mb-1">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Diagnostics
            </a>
            <div class="flex items-center gap-2.5">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $diagnostic->child_name }}</h1>
                <span class="font-mono text-xs px-2.5 py-0.5 rounded-full bg-teal-100 text-teal-800 font-bold border border-teal-200">
                    {{ $diagnostic->assessment_no }}
                </span>
                @if($diagnostic->status === 'admitted' || $diagnostic->student)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        Admitted Student
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                        Ready for Admission
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-2.5">
            <button onclick="window.print()" class="h-9 px-4 rounded-xl border border-slate-300 bg-white text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center gap-1.5 shadow-xs">
                <svg class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Print Diagnostic Report</span>
            </button>
            @if(!$diagnostic->student)
                <a href="{{ route('students.create', ['diagnostic_id' => $diagnostic->id]) }}" class="h-9 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                    <span>Admit Student (Step 3) &rarr;</span>
                </a>
            @else
                <a href="{{ route('students.show', $diagnostic->student) }}" class="h-9 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                    <span>View Student Profile</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Official Clinical Diagnostic Document (Optimized for Screen & Print) -->
    <div id="printableReport" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6 print:border-none print:shadow-none print:p-0 print:space-y-4">

        <!-- Print Letterhead (Header visible in Print & Screen) -->
        <div class="border-b-2 border-slate-900 pb-4 flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-7 h-7 rounded-lg bg-teal-600 text-white font-extrabold flex items-center justify-center text-xs print:border print:border-slate-800">
                        SC
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 uppercase tracking-tight">Aura SpecialCare Academy</h2>
                </div>
                <p class="text-xs font-bold text-teal-800 uppercase tracking-wider">Child Development & Autism Clinical Care Center</p>
                <p class="text-[11px] text-slate-500 mt-0.5">Specialized Neurodevelopmental Screening, Assessment & Intervention Services</p>
            </div>
            <div class="text-right shrink-0">
                <span class="inline-block px-3 py-1 rounded-md bg-slate-100 border border-slate-300 text-slate-800 text-xs font-bold font-mono">
                    {{ $diagnostic->assessment_no }}
                </span>
                <p class="text-[11px] text-slate-500 mt-1">Date: <strong class="text-slate-800">{{ $diagnostic->assessment_date->format('d M Y') }}</strong></p>
                <span class="text-[10px] uppercase font-bold text-teal-700 tracking-wider block mt-0.5">Clinical Evaluation Report</span>
            </div>
        </div>

        <!-- Document Title Banner -->
        <div class="text-center py-2 bg-slate-50 border border-slate-200 rounded-lg print:border-slate-300">
            <h3 class="text-sm sm:text-base font-extrabold text-slate-900 uppercase tracking-wider">
                Comprehensive Neurodevelopmental & Autism Diagnostic Report
            </h3>
        </div>

        <!-- Section 1: Child Demographics & Evaluation Metadata -->
        <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50 print:bg-white print:border-slate-300 space-y-3">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-1.5">
                1. Patient & Evaluation Information
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                <div>
                    <span class="text-slate-400 font-medium block">Child Full Name:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $diagnostic->child_name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Age & Gender:</span>
                    <span class="font-bold text-slate-800">
                        {{ $diagnostic->gender }}
                        @if($diagnostic->dob)
                            • {{ \Carbon\Carbon::parse($diagnostic->dob)->age }} yrs ({{ \Carbon\Carbon::parse($diagnostic->dob)->format('d M Y') }})
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Parent / Guardian:</span>
                    <span class="font-bold text-slate-800">
                        {{ $diagnostic->enquiry ? $diagnostic->enquiry->parent_name : 'Parent Record' }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 font-medium block">Contact Phone:</span>
                    <span class="font-bold text-slate-800 font-mono">
                        {{ $diagnostic->enquiry ? $diagnostic->enquiry->phone : 'N/A' }}
                    </span>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-slate-400 font-medium block">Lead Clinical Assessor:</span>
                    <span class="font-bold text-teal-900">
                        {{ $diagnostic->assessor_name ?? ($diagnostic->assessor ? $diagnostic->assessor->name : 'Clinical Child Psychologist') }}
                    </span>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-slate-400 font-medium block">Intake Reference:</span>
                    <span class="font-medium text-slate-700">
                        {{ $diagnostic->enquiry ? 'Enquiry No: ' . $diagnostic->enquiry->enquiry_no . ' (Referred by ' . ($diagnostic->enquiry->referred_by ?? 'Pediatrician') . ')' : 'Direct Clinical Admission' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Section 2: Clinical Diagnosis & Standardized CARS Autism Score -->
        <div class="border border-teal-200 rounded-xl p-4 bg-teal-50/40 print:bg-white print:border-slate-300 space-y-3">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-teal-900 border-b border-teal-200/60 pb-1.5 flex items-center justify-between">
                <span>2. Diagnostic Impression & Autism Rating Scale</span>
                <span class="text-2xs font-bold px-2 py-0.5 rounded bg-white text-teal-800 border border-teal-200">DSM-5 / CARS-2 Criteria</span>
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                <div class="md:col-span-2 space-y-1">
                    <span class="text-xs text-slate-500 font-medium block">Primary Clinical Diagnosis:</span>
                    <span class="text-base sm:text-lg font-black text-slate-900 block leading-tight">
                        {{ $diagnostic->primary_diagnosis }}
                    </span>
                    <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-200 inline-block mt-0.5">
                        {{ $diagnostic->severity_level ?? 'Level 2 (Requiring Substantial Support)' }}
                    </span>
                </div>

                <!-- CARS Box -->
                <div class="bg-white p-3 rounded-lg border border-teal-200 print:border-slate-300 text-center">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">CARS-2 Score</span>
                    <span class="text-2xl font-black text-slate-900 font-mono">{{ $diagnostic->cars_score ?? 'N/A' }} <span class="text-xs text-slate-400 font-normal">/ 60</span></span>
                    <span class="text-xs font-extrabold text-amber-700 block mt-0.5">{{ $diagnostic->cars_severity }}</span>
                </div>
            </div>

            <div class="pt-2 text-[11px] text-slate-600 border-t border-teal-100 flex flex-wrap gap-4">
                <span><strong>CARS Scale:</strong> 15–29.5: Non-Autistic | 30–36.5: Mild-Moderate | 37–60: Severe</span>
                @if($diagnostic->isaa_score)
                    <span>• <strong>ISAA Score:</strong> {{ $diagnostic->isaa_score }}</span>
                @endif
            </div>
        </div>

        <!-- Section 3: Speech, Motor & Sensory Evaluations -->
        <div class="space-y-3">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 border-b border-slate-200 pb-1.5">
                3. Clinical Domain Baseline Evaluations
            </h4>

            <!-- Speech & Communication -->
            <div class="border border-slate-200 rounded-lg p-3 text-xs space-y-1 print:border-slate-300">
                <span class="font-bold text-slate-800 block">Speech, Language & Communication Baseline:</span>
                <p class="text-slate-700 leading-relaxed">{{ $diagnostic->speech_evaluation ?? 'Evaluation documented in clinical record.' }}</p>
            </div>

            <!-- Motor & Physical -->
            <div class="border border-slate-200 rounded-lg p-3 text-xs space-y-1 print:border-slate-300">
                <span class="font-bold text-slate-800 block">Motor & Physical Coordination:</span>
                <p class="text-slate-700 leading-relaxed">{{ $diagnostic->motor_evaluation ?? 'Evaluation documented in clinical record.' }}</p>
            </div>

            <!-- Sensory Matrix -->
            @if(!empty($diagnostic->sensory_profile))
                <div class="border border-slate-200 rounded-lg p-3 text-xs space-y-2 print:border-slate-300">
                    <span class="font-bold text-slate-800 block">Sensory Profile Matrix (Individual Accommodations):</span>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($diagnostic->sensory_profile as $sense => $detail)
                            <div class="p-2 rounded bg-slate-50 border border-slate-200 print:border-slate-300 print:bg-white text-[11px]">
                                <span class="font-bold text-slate-800 uppercase text-[10px] block">{{ ucfirst($sense) }}</span>
                                <span class="text-slate-700">{{ $detail }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Behavioral Observations -->
            @if($diagnostic->behavioral_observations)
                <div class="border border-slate-200 rounded-lg p-3 text-xs space-y-1 print:border-slate-300">
                    <span class="font-bold text-slate-800 block">Behavioral Observations & Stimming Patterns:</span>
                    <p class="text-slate-700 leading-relaxed">{{ $diagnostic->behavioral_observations }}</p>
                </div>
            @endif
        </div>

        <!-- Section 4: Recommendations & Prescribed Care Plan -->
        <div class="border-2 border-slate-800 rounded-xl p-4 bg-slate-50 print:bg-white space-y-2">
            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900 border-b border-slate-300 pb-1 flex items-center justify-between">
                <span>4. Multidisciplinary Recommendations & Intervention Plan</span>
                <span class="text-[10px] font-bold text-teal-800">Prescribed Dosage</span>
            </h4>
            <p class="text-xs sm:text-sm font-semibold text-slate-800 leading-relaxed">
                {{ $diagnostic->recommendation ?? 'Full time admission to Special Day Class with regular Speech and OT sensory integration.' }}
            </p>
        </div>

        <!-- Section 5: Official Signatures & Stamp Block (Always printed at the bottom) -->
        <div class="pt-8 border-t border-slate-300 mt-6 space-y-6">
            <div class="grid grid-cols-3 gap-6 text-center text-xs">
                
                <!-- Assessor Signature -->
                <div class="space-y-1">
                    <div class="h-12 border-b border-slate-400 flex items-end justify-center pb-1 font-serif italic text-slate-700 text-sm">
                        {{ $diagnostic->assessor_name ?? 'Dr. Priya Sharma' }}
                    </div>
                    <span class="font-bold text-slate-800 block">Lead Clinical Psychologist</span>
                    <span class="text-[10px] text-slate-400">Diagnostic Assessor Sign & Seal</span>
                </div>

                <!-- Medical Director Signature -->
                <div class="space-y-1">
                    <div class="h-12 border-b border-slate-400 flex items-end justify-center pb-1 font-serif italic text-slate-700 text-sm">
                        Director of Education
                    </div>
                    <span class="font-bold text-slate-800 block">Head of Special Education</span>
                    <span class="text-[10px] text-slate-400">School Clinical Stamp</span>
                </div>

                <!-- Parent Signature -->
                <div class="space-y-1">
                    <div class="h-12 border-b border-slate-400 flex items-end justify-center pb-1 font-serif italic text-slate-700 text-sm">
                    </div>
                    <span class="font-bold text-slate-800 block">Parent / Legal Guardian</span>
                    <span class="text-[10px] text-slate-400">Acknowledgment Signature</span>
                </div>

            </div>

            <div class="text-center text-[10px] text-slate-400 pt-2 border-t border-slate-100">
                This document is a certified clinical assessment record issued by Aura SpecialCare Academy. Confidential & Protected.
            </div>
        </div>

    </div>

</div>

<!-- Print Formatting Stylesheet -->
<style>
@media print {
    /* Hide all browser / website navigation */
    header, footer, nav, .print\:hidden {
        display: none !important;
    }

    body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-size: 11pt !important;
        line-height: 1.4 !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    #printableReport {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
    }

    /* Prevent awkward page cuts */
    .space-y-3, .space-y-4, .border {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    @page {
        size: A4 portrait;
        margin: 12mm 15mm 15mm 15mm;
    }
}
</style>
@endsection
