@extends('layouts.app')

@section('title', 'Clinical Diagnostic Assessments - SpecialCare')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-teal-500"></span>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Step 2: Clinical Diagnostic Assessments</h1>
            </div>
            <p class="text-sm text-slate-500 mt-1">
                Standardized pre-admission evaluations (CARS, ISAA, Speech baseline, Sensory profiling) conducted by clinical specialists.
            </p>
        </div>
        <div>
            <a href="{{ route('diagnostics.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold shadow-sm transition">
                <i class="fa-solid fa-stethoscope mr-2"></i> New Diagnostic Assessment
            </a>
        </div>
    </div>

    <!-- Diagnostic List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 font-semibold text-xs border-b border-slate-200 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Assessment & Child</th>
                        <th class="px-6 py-3.5">Date & Assessor</th>
                        <th class="px-6 py-3.5">CARS Autism Score</th>
                        <th class="px-6 py-3.5">Clinical Diagnosis</th>
                        <th class="px-6 py-3.5">Admission Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($assessments as $diag)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $diag->child_name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    {{ $diag->assessment_no }} 
                                    @if($diag->enquiry)
                                        • Ref: {{ $diag->enquiry->enquiry_no }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs">
                                <div class="font-semibold text-slate-800">{{ $diag->assessment_date->format('M d, Y') }}</div>
                                <div class="text-slate-500 mt-0.5">
                                    <i class="fa-solid fa-user-doctor text-slate-400 mr-1"></i>
                                    {{ $diag->assessor_name ?? ($diag->assessor ? $diag->assessor->name : 'Clinical Team') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($diag->cars_score)
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-slate-900 text-sm font-mono">{{ $diag->cars_score }} / 60</span>
                                        @if($diag->cars_score < 30)
                                            <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-2xs font-bold rounded-full">Non-Autistic</span>
                                        @elseif($diag->cars_score <= 36.5)
                                            <span class="px-2 py-0.5 bg-amber-100 text-amber-800 text-2xs font-bold rounded-full">Mild-Moderate</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-rose-100 text-rose-800 text-2xs font-bold rounded-full">Severe</span>
                                        @endif
                                    </div>
                                    <span class="text-2xs text-slate-400 block mt-0.5">{{ $diag->cars_severity }}</span>
                                @else
                                    <span class="text-xs text-slate-400 italic">Score pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800 text-xs block">{{ $diag->primary_diagnosis }}</span>
                                <span class="text-2xs text-indigo-600 font-semibold">{{ $diag->severity_level ?? 'Support Required' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($diag->status === 'admitted' || $diag->student)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-check-circle mr-1 text-emerald-600"></i> Admitted Student
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1.5"></span> Ready for Admission
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('diagnostics.show', $diag) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition inline-flex items-center">
                                    Report
                                </a>
                                @if(!$diag->student)
                                    <a href="{{ route('students.create', ['diagnostic_id' => $diag->id]) }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition inline-flex items-center shadow-xs">
                                        <i class="fa-solid fa-graduation-cap mr-1"></i> Admit Child
                                    </a>
                                @else
                                    <a href="{{ route('students.show', $diag->student) }}" class="px-3 py-1.5 bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold rounded-lg hover:bg-indigo-100 transition inline-flex items-center">
                                        Profile
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-notes-medical text-3xl mb-2 text-slate-300 block"></i>
                                No diagnostic assessments recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($assessments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $assessments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

