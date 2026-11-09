@extends('layouts.app')

@section('title', 'Enrolled Students - SpecialCare')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Step 3: Enrolled Students & Special Profiles</h1>
            </div>
            <p class="text-sm text-slate-500 mt-1">
                Active students under specialized education, individual sensory accommodation, and IEP goal plans.
            </p>
        </div>
        <div>
            <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-sm transition">
                <i class="fa-solid fa-graduation-cap mr-2"></i> Enroll New Student
            </a>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row gap-3 items-center justify-between">
        <form method="GET" action="{{ route('students.index') }}" class="flex-1 flex flex-col sm:flex-row gap-3 w-full">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by child name, admission no, or diagnosis..."
                       class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
            </div>
            <select name="classroom" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                <option value="">All Classrooms / Batches</option>
                @foreach($classrooms as $room)
                    <option value="{{ $room }}" {{ $classroom == $room ? 'selected' : '' }}>{{ $room }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition">
                Filter
            </button>
            @if($search || $classroom)
                <a href="{{ route('students.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold hover:bg-slate-200 transition">
                    Clear
                </a>
            @endif
        </form>
        <span class="text-xs font-semibold text-slate-500 whitespace-nowrap">
            Total Students: <strong class="text-slate-800">{{ $totalStudents }}</strong>
        </span>
    </div>

    <!-- Students Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($students as $student)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between space-y-4">
                
                <!-- Card Header -->
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-black text-lg flex items-center justify-center shadow-sm">
                            {{ substr($student->first_name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base leading-tight">{{ $student->full_name }}</h3>
                            <span class="text-xs font-mono font-bold text-slate-400 block">{{ $student->admission_no }}</span>
                            <span class="text-2xs text-slate-500">
                                {{ $student->gender }} • {{ $student->age }} yrs 
                                @if($student->blood_group)
                                    ({{ $student->blood_group }})
                                @endif
                            </span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-2xs font-extrabold uppercase bg-emerald-100 text-emerald-800">
                        Active
                    </span>
                </div>

                <!-- Diagnosis & Batch Badges -->
                <div class="space-y-1.5 pt-2 border-t border-slate-100 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Diagnosis:</span>
                        <span class="font-bold text-indigo-700 text-right">{{ $student->primary_diagnosis }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Classroom Batch:</span>
                        <span class="font-semibold text-slate-800">{{ $student->classroom_batch }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Communication:</span>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-md font-semibold text-2xs">
                            {{ $student->communication_mode }}
                        </span>
                    </div>
                </div>

                <!-- Sensory Highlights -->
                @if($student->comfort_item || $student->calming_methods)
                    <div class="p-2.5 rounded-xl bg-purple-50/50 border border-purple-100 text-2xs space-y-1">
                        @if($student->comfort_item)
                            <div class="text-purple-900 font-medium truncate">
                                <i class="fa-solid fa-teddy-bear mr-1 text-purple-600"></i> Comfort Item: <strong>{{ $student->comfort_item }}</strong>
                            </div>
                        @endif
                        @if($student->calming_methods)
                            <div class="text-purple-800 truncate">
                                <i class="fa-solid fa-heart mr-1 text-purple-500"></i> Calming: {{ $student->calming_methods }}
                            </div>
                        @endif
                    </div>
                @endif

                <!-- IEP Progress Bar -->
                @php
                    $avgProgress = $student->iepGoals->count() > 0 
                        ? (int) round($student->iepGoals->avg('progress_percentage')) 
                        : 0;
                @endphp
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-2xs font-bold">
                        <span class="text-slate-500">IEP Mastery Progress ({{ $student->iepGoals->count() }} Goals)</span>
                        <span class="text-indigo-600">{{ $avgProgress }}%</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500" style="width: {{ $avgProgress }}%"></div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
                    <a href="{{ route('students.show', $student) }}" class="flex-1 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold text-center transition">
                        <i class="fa-solid fa-id-card mr-1"></i> 360° Profile
                    </a>
                    <a href="{{ route('parent.progress', ['student_id' => $student->id]) }}" class="py-2 px-3 rounded-xl bg-purple-100 hover:bg-purple-200 text-purple-800 text-xs font-bold transition flex items-center gap-1" title="Parent Portal View">
                        <i class="fa-solid fa-heart-pulse text-purple-600"></i>
                        <span>Parent View</span>
                    </a>
                </div>

            </div>
        @empty
            <div class="col-span-3 bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400">
                <i class="fa-solid fa-child text-4xl mb-3 text-slate-300 block"></i>
                <p class="text-base font-bold text-slate-700">No students found.</p>
                <p class="text-xs text-slate-400 mt-1">Enroll your first student using the intake pipeline or button above.</p>
            </div>
        @endforelse
    </div>

    @if($students->hasPages())
        <div class="pt-4">
            {{ $students->links() }}
        </div>
    @endif

</div>
@endsection

