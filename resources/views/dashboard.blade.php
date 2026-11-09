@extends('layouts.app')

@section('title', 'Special Child Care Management - Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Welcome & Banner -->
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-teal-700 rounded-2xl p-6 sm:p-7 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold backdrop-blur-xs mb-3 text-white">
                <svg class="w-3.5 h-3.5 text-amber-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Integrated Autism & Clinical Care Workflow
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Special Child Care & Autism Academy</h1>
            <p class="mt-2 text-blue-100 text-xs sm:text-sm leading-relaxed font-normal">
                Streamlining the complete journey for neurodivergent children: from initial parent inquiry, standardized clinical diagnostics (CARS/ISAA), individualized admission with sensory profiles, up to real-time parent progress tracking.
            </p>
            <div class="mt-5 flex flex-wrap items-center gap-3">
                <a href="{{ route('enquiries.create') }}" class="h-9 px-4 rounded-xl bg-white text-blue-800 text-xs sm:text-sm font-bold shadow-md hover:bg-blue-50 transition inline-flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Register New Enquiry</span>
                </a>
                <a href="{{ route('diagnostics.create') }}" class="h-9 px-4 rounded-xl bg-teal-500 hover:bg-teal-600 text-white text-xs sm:text-sm font-bold shadow-md transition inline-flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Clinical Assessment</span>
                </a>
                <a href="{{ route('parent.progress') }}" class="h-9 px-4 rounded-xl bg-white/20 hover:bg-white/30 text-white border border-white/30 text-xs sm:text-sm font-bold transition inline-flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>View Parent Portal Demo</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Enquiries</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total_enquiries'] }}</p>
                <p class="text-xs text-amber-600 font-medium mt-1">{{ $stats['pending_enquiries'] }} pending review</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Diagnostics Done</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total_assessments'] }}</p>
                <p class="text-xs text-teal-600 font-medium mt-1">CARS / ISAA Standard</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Admitted Students</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['total_students'] }}</p>
                <p class="text-xs text-indigo-600 font-medium mt-1">Active specialized care</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active IEP Goals</p>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-1">{{ $stats['active_iep_goals'] }}</p>
                <p class="text-xs text-purple-600 font-medium mt-1">Tracked with milestones</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Two Column Section: Recent Enquiries & Active Students -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent Enquiries -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm sm:text-base">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span> Recent Enquiries (Pipeline)
                </h3>
                <a href="{{ route('enquiries.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                    <span>View All</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentEnquiries as $enq)
                    <div class="p-4 hover:bg-slate-50 transition flex items-start justify-between gap-3">
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <!-- Child Name + Code + Status Badge -->
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-slate-900 text-sm tracking-tight">{{ $enq->child_name }}</span>
                                <span class="font-mono text-xs text-slate-400 font-semibold">({{ $enq->enquiry_no }})</span>
                                @if($enq->status === 'new')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase bg-amber-100 text-amber-800">New</span>
                                @elseif($enq->status === 'assessment_scheduled')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase bg-blue-100 text-blue-800">Assessment Booked</span>
                                @elseif($enq->status === 'assessed')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase bg-teal-100 text-teal-800">Diagnostic Done</span>
                                @elseif($enq->status === 'admitted')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-bold uppercase bg-emerald-100 text-emerald-800">Enrolled</span>
                                @endif
                            </div>
                            <!-- Parent Contact Details -->
                            <p class="text-xs text-slate-500 font-medium">
                                Parent: <span class="text-slate-700 font-semibold">{{ $enq->parent_name }}</span> <span class="text-slate-400">({{ $enq->phone }})</span>
                            </p>
                            <!-- Concern Tags -->
                            @if(!empty($enq->primary_concerns))
                                <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                    @foreach(array_slice($enq->primary_concerns, 0, 2) as $concern)
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md text-xs font-medium border border-slate-200/60">{{ $concern }}</span>
                                    @endforeach
                                    @if(count($enq->primary_concerns) > 2)
                                        <span class="text-xs font-semibold text-slate-400">+{{ count($enq->primary_concerns) - 2 }} more</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <!-- Details Button -->
                        <a href="{{ route('enquiries.show', $enq) }}" class="h-8 px-3 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition inline-flex items-center shrink-0 self-center">
                            Details
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs font-medium">No enquiries found.</div>
                @endforelse
            </div>
        </div>

        <!-- Admitted Students -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm sm:text-base">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shrink-0"></span> Enrolled Students
                </h3>
                <a href="{{ route('students.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                    <span>View All</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentStudents as $student)
                    <div class="p-4 hover:bg-slate-50 transition flex items-start justify-between gap-3">
                        <div class="flex items-start space-x-3 flex-1 min-w-0">
                            <!-- Avatar -->
                            <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 font-extrabold flex items-center justify-center text-xs shadow-xs shrink-0 mt-0.5">
                                {{ substr($student->first_name, 0, 1) }}
                            </div>
                            <div class="space-y-1 flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-900 text-sm tracking-tight truncate">{{ $student->full_name }}</span>
                                    <span class="font-mono text-xs text-slate-400 font-semibold shrink-0">({{ $student->admission_no }})</span>
                                </div>
                                <p class="text-xs text-indigo-700 font-semibold truncate">
                                    {{ $student->primary_diagnosis }} <span class="text-slate-400 font-normal">({{ $student->severity_level ?? 'Level 2' }})</span>
                                </p>
                                <p class="text-xs text-slate-500 font-medium truncate">
                                    Batch: <span class="text-slate-700 font-semibold">{{ $student->classroom_batch }}</span> • Mode: <span class="font-semibold text-slate-700">{{ $student->communication_mode }}</span>
                                </p>
                            </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-1.5 shrink-0 self-center">
                            <a href="{{ route('students.show', $student) }}" class="h-8 px-2.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition inline-flex items-center">
                                360° Profile
                            </a>
                            <a href="{{ route('parent.progress', ['student_id' => $student->id]) }}" class="h-8 px-2.5 rounded-lg bg-purple-50 text-purple-700 border border-purple-200 text-xs font-bold hover:bg-purple-100 transition inline-flex items-center" title="Parent Portal View">
                                Parent View
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 text-xs font-medium">No students admitted yet.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
