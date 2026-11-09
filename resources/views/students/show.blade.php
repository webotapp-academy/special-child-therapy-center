@extends('layouts.app')

@section('title', "{$student->full_name} ({$student->admission_no}) - 360° Profile")

@section('content')
<div class="space-y-6" x-data="{ activeTab: '{{ request()->query('tab', 'profile') }}' }">

    <!-- Top Profile Header Bar -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-black text-2xl flex items-center justify-center shadow-md">
                {{ substr($student->first_name, 0, 1) }}
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $student->full_name }}</h1>
                    <span class="font-mono text-xs px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-bold border border-indigo-200">
                        {{ $student->admission_no }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        Active Student
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    {{ $student->gender }} • {{ $student->age }} years old (DOB: {{ $student->dob->format('M d, Y') }})
                    • Classroom: <strong class="text-slate-700">{{ $student->classroom_batch }}</strong>
                    • Primary Educator: <strong class="text-slate-700">{{ $student->educator ? $student->educator->name : 'Unassigned' }}</strong>
                </p>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('parent.progress', ['student_id' => $student->id]) }}" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs sm:text-sm font-bold shadow-md transition flex items-center">
                <i class="fa-solid fa-heart-pulse mr-2"></i> Open Parent Portal View &rarr;
            </a>
            @if($student->diagnosticAssessment)
                <a href="{{ route('diagnostics.show', $student->diagnosticAssessment) }}" class="px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs font-bold hover:bg-slate-50 transition flex items-center">
                    <i class="fa-solid fa-notes-medical mr-1.5 text-teal-600"></i> Diagnostic
                </a>
            @endif
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center space-x-2 border-b border-slate-200 overflow-x-auto pb-1">
        <button @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-shapes"></i> Sensory & Autism Profile
        </button>
        <button @click="activeTab = 'iep'" :class="activeTab === 'iep' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-bullseye"></i> IEP Goals & Milestones ({{ $student->iepGoals->count() }})
        </button>
        <button @click="activeTab = 'therapy'" :class="activeTab === 'therapy' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-stethoscope"></i> Therapy Logs & SOAP Notes ({{ $student->therapySessions->count() }})
        </button>
        <button @click="activeTab = 'daily_log'" :class="activeTab === 'daily_log' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-clipboard-check"></i> Daily Care Sheets ({{ $student->dailyCareLogs->count() }})
        </button>
    </div>

    <!-- TAB 1: Sensory, Autism & Accommodation Profile -->
    <div x-show="activeTab === 'profile'" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Autism & Clinical Summary -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">
                    Clinical Classification
                </h3>
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Primary Diagnosis:</span>
                        <span class="font-extrabold text-slate-800 text-sm">{{ $student->primary_diagnosis }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">DSM-5 Support Level:</span>
                        <span class="font-bold text-indigo-600">{{ $student->severity_level ?? 'Level 2' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Primary Communication Mode:</span>
                        <span class="font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md inline-block mt-0.5">
                            {{ $student->communication_mode }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Shadow Teacher / Aide:</span>
                        <span class="font-medium text-slate-700">{{ $student->shadow_teacher ?? 'Dedicated Support Staff' }}</span>
                    </div>
                </div>
            </div>

            <!-- Sensory Triggers & Calming Kit -->
            <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-heart text-purple-600"></i> Individual Sensory Profile & De-escalation
                </h3>
                
                <div class="space-y-4 text-xs">
                    <div class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-200">
                        <span class="text-2xs font-extrabold text-amber-800 uppercase tracking-wider block mb-1">
                            <i class="fa-solid fa-triangle-exclamation mr-1 text-amber-600"></i> Known Sensory Triggers
                        </span>
                        <p class="text-slate-800 font-medium leading-relaxed">{{ $student->sensory_triggers ?? 'None documented' }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-200">
                        <span class="text-2xs font-extrabold text-emerald-800 uppercase tracking-wider block mb-1">
                            <i class="fa-solid fa-heart mr-1 text-emerald-600"></i> Calming Mechanisms & Calming Kit
                        </span>
                        <p class="text-slate-800 font-medium leading-relaxed">{{ $student->calming_methods ?? 'None documented' }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-purple-50/50 border border-purple-100">
                            <span class="text-2xs font-bold text-purple-700 uppercase tracking-wider block">Comfort Item</span>
                            <span class="font-semibold text-slate-800 text-xs">{{ $student->comfort_item ?? 'Sensory Teether / Plush' }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-blue-50/50 border border-blue-100">
                            <span class="text-2xs font-bold text-blue-700 uppercase tracking-wider block">Food Texture Tolerances</span>
                            <span class="font-semibold text-slate-800 text-xs">{{ $student->food_texture_preferences ?? 'Crispy textures preferred' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guardian & Emergency Contacts -->
            <div class="md:col-span-3 bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 flex items-center gap-1.5">
                    <i class="fa-solid fa-users text-blue-600"></i> Guardian Contact & Home Address
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Guardian Name:</span>
                        <span class="font-bold text-slate-800">{{ $student->guardian_name }} ({{ $student->guardian_relation }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Primary Phone:</span>
                        <span class="font-bold text-slate-800">{{ $student->guardian_phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Emergency Phone:</span>
                        <span class="font-bold text-rose-600">{{ $student->emergency_contact_phone ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Parent Email:</span>
                        <span class="font-medium text-slate-700">{{ $student->guardian_email ?? 'N/A' }}</span>
                    </div>
                    <div class="sm:col-span-4">
                        <span class="text-slate-400 block font-medium">Home Address:</span>
                        <span class="text-slate-700 font-medium">{{ $student->address ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- TAB 2: IEP Goals & Milestones -->
    <div x-show="activeTab === 'iep'" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Individualized Education Program (IEP) Goals</h3>
                <p class="text-xs text-slate-500">Measurable SMART targets tailored to {{ $student->first_name }}'s sensory and developmental milestones.</p>
            </div>
            <!-- Add IEP Goal Button (opens simple form inline) -->
            <button @click="$refs.newGoalForm.classList.toggle('hidden')" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center">
                <i class="fa-solid fa-plus mr-1.5"></i> Add New IEP Goal
            </button>
        </div>

        <!-- Inline New IEP Goal Form (collapsible) -->
        <div x-ref="newGoalForm" class="hidden bg-white p-6 rounded-2xl border border-indigo-200 shadow-sm space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-indigo-700">Create New Target IEP Goal</h4>
            <form action="{{ route('students.addIepGoal', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Domain</label>
                        <select name="domain" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            <option value="Speech & Communication">Speech & Communication</option>
                            <option value="Occupational & Sensory">Occupational & Sensory</option>
                            <option value="Behavioral Regulation">Behavioral Regulation</option>
                            <option value="Cognitive & Academics">Cognitive & Academics</option>
                            <option value="Social & Play Skills">Social & Play Skills</option>
                            <option value="Life Skills (ADL)">Life Skills (ADL)</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Goal Title</label>
                        <input type="text" name="title" required placeholder="e.g. Will request items using 2-word PECS phrases"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Detailed Description & Criteria</label>
                        <textarea name="description" rows="2" placeholder="Specific observable criteria for mastery..."
                                  class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs"></textarea>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Target Date</label>
                        <input type="date" name="target_date" value="{{ date('Y-m-d', strtotime('+3 months')) }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Current Progress (%)</label>
                        <input type="number" min="0" max="100" name="progress_percentage" value="20"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            <option value="in_progress">In Progress</option>
                            <option value="achieved">Achieved</option>
                            <option value="mastered">Mastered</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="$refs.newGoalForm.classList.add('hidden')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold">Save Goal</button>
                </div>
            </form>
        </div>

        <!-- Goals Cards List -->
        <div class="space-y-4">
            @forelse($student->iepGoals as $goal)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center space-x-2.5">
                            <span class="px-2.5 py-1 rounded-md text-2xs font-bold uppercase 
                                @if(str_contains($goal->domain, 'Speech')) bg-teal-100 text-teal-800 
                                @elseif(str_contains($goal->domain, 'Sensory') || str_contains($goal->domain, 'Occupational')) bg-purple-100 text-purple-800 
                                @elseif(str_contains($goal->domain, 'Social')) bg-amber-100 text-amber-800 
                                @else bg-indigo-100 text-indigo-800 @endif">
                                {{ $goal->domain }}
                            </span>
                            <h4 class="font-extrabold text-slate-900 text-sm">{{ $goal->title }}</h4>
                        </div>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">
                            {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed">{{ $goal->description }}</p>

                    @if($goal->baseline)
                        <div class="text-2xs text-slate-500 bg-slate-50 p-2 rounded-lg">
                            <strong>Baseline:</strong> {{ $goal->baseline }}
                        </div>
                    @endif

                    <!-- Progress Bar -->
                    <div class="space-y-1 pt-1">
                        <div class="flex justify-between text-2xs font-bold">
                            <span class="text-slate-400">Target Mastery</span>
                            <span class="text-indigo-600">{{ $goal->progress_percentage }}%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $goal->progress_percentage }}%"></div>
                        </div>
                    </div>

                    <!-- Milestones -->
                    @if($goal->milestones->count() > 0)
                        <div class="pt-2 border-t border-slate-100 space-y-1.5">
                            <span class="text-2xs font-bold text-slate-400 uppercase tracking-wider block">Sub-Milestones</span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                @foreach($goal->milestones as $milestone)
                                    <div class="flex items-center space-x-2 text-2xs">
                                        <i class="fa-solid {{ $milestone->is_completed ? 'fa-circle-check text-emerald-500' : 'fa-circle text-slate-300' }}"></i>
                                        <span class="{{ $milestone->is_completed ? 'line-through text-slate-400' : 'text-slate-700 font-medium' }}">
                                            {{ $milestone->milestone_title }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-sm">
                    No IEP goals generated yet. Click "Add New IEP Goal" above.
                </div>
            @endforelse
        </div>
    </div>

    <!-- TAB 3: Therapy Sessions & SOAP Notes -->
    <div x-show="activeTab === 'therapy'" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Multi-Disciplinary Therapy Session Logs</h3>
                <p class="text-xs text-slate-500">Document Speech Therapy, OT, and Behavioral clinical SOAP notes with parent updates.</p>
            </div>
            <button @click="$refs.newTherapyForm.classList.toggle('hidden')" class="px-3.5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition flex items-center">
                <i class="fa-solid fa-plus mr-1.5"></i> Log Therapy Session
            </button>
        </div>

        <!-- Inline Therapy Log Form -->
        <div x-ref="newTherapyForm" class="hidden bg-white p-6 rounded-2xl border border-teal-200 shadow-sm space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-teal-700">Record Specialist Therapy Session</h4>
            <form action="{{ route('students.addTherapySession', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Therapy Type</label>
                        <select name="therapy_type" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            <option value="Speech Therapy">Speech Therapy</option>
                            <option value="Occupational Therapy">Occupational Therapy (OT)</option>
                            <option value="ABA / Behavior Therapy">ABA / Behavior Therapy</option>
                            <option value="Sensory Integration">Sensory Integration</option>
                            <option value="Physiotherapy">Physiotherapy</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Therapist</label>
                        <select name="therapist_id" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            @foreach($therapists as $t)
                                <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->specialization ?? 'Therapist' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Session Date & Duration</label>
                        <div class="flex gap-2">
                            <input type="date" name="session_date" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            <input type="number" name="duration_minutes" value="45" class="w-20 px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Child Engagement Level</label>
                        <select name="engagement_level" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                            <option value="Excellent">Excellent - Highly receptive and responsive</option>
                            <option value="Good" selected>Good - Engaged with minor prompts</option>
                            <option value="Distracted">Distracted - Required frequent sensory regulation</option>
                            <option value="Sensory Overload">Sensory Overload / Meltdown</option>
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Clinical SOAP Notes (Subjective, Objective, Assessment, Plan)</label>
                        <textarea name="clinical_soap_notes" rows="2" placeholder="S: Child arrived smiling. O: 8/10 trials successful. A: Good motor improvement. P: Next session focus on..."
                                  class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-purple-700 mb-1">Parent Portal Summary Message (Visible to Parents) <span class="text-rose-500">*</span></label>
                        <input type="text" name="parent_summary" required placeholder="e.g. Aarav had a wonderful Speech session today! He said 'Ball' twice independently."
                               class="w-full px-3.5 py-2 rounded-xl border border-purple-300 text-xs font-semibold text-purple-900 bg-purple-50/30">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="$refs.newTherapyForm.classList.add('hidden')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-teal-600 text-white text-xs font-bold">Save Session Log</button>
                </div>
            </form>
        </div>

        <!-- Sessions Feed -->
        <div class="space-y-4">
            @forelse($student->therapySessions as $session)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs font-bold">
                                <i class="fa-solid fa-stethoscope"></i>
                            </span>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-sm">{{ $session->therapy_type }}</h4>
                                <span class="text-xs text-slate-400">By {{ $session->therapist_name ?? 'Therapist' }} • {{ $session->session_date->format('M d, Y') }} ({{ $session->duration_minutes }} mins)</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Engagement: {{ $session->engagement_level }}
                        </span>
                    </div>

                    <!-- Highlight for Parent -->
                    <div class="p-3 rounded-xl bg-purple-50/70 border border-purple-200 text-xs">
                        <span class="text-2xs font-bold text-purple-800 uppercase tracking-wider block mb-0.5">
                            <i class="fa-solid fa-heart mr-1"></i> Highlight Shared with Parents:
                        </span>
                        <p class="text-purple-950 font-medium">{{ $session->parent_summary }}</p>
                    </div>

                    @if($session->clinical_soap_notes)
                        <div class="text-2xs text-slate-600 bg-slate-50 p-3 rounded-lg leading-relaxed">
                            <strong class="text-slate-700">Clinical SOAP Notes:</strong> {{ $session->clinical_soap_notes }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-sm">
                    No therapy sessions logged yet. Click "Log Therapy Session" above.
                </div>
            @endforelse
        </div>
    </div>

    <!-- TAB 4: Daily Care Logs -->
    <div x-show="activeTab === 'daily_log'" class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Daily Care & Routine Log Sheets</h3>
                <p class="text-xs text-slate-500">Track meals, toilet routines, sleep, and emotional regulation updates for parents.</p>
            </div>
            <button @click="$refs.newDailyCareForm.classList.toggle('hidden')" class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center">
                <i class="fa-solid fa-plus mr-1.5"></i> Add Daily Care Log
            </button>
        </div>

        <!-- Inline Daily Care Form -->
        <div x-ref="newDailyCareForm" class="hidden bg-white p-6 rounded-2xl border border-blue-200 shadow-sm space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-blue-700">Submit Daily Care Sheet</h4>
            <form action="{{ route('students.addDailyCareLog', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Date</label>
                        <input type="date" name="log_date" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Morning Mood</label>
                        <select name="morning_mood" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Happy">Happy / Cheerful</option>
                            <option value="Calm" selected>Calm / Settled</option>
                            <option value="Anxious">Anxious / Cautious</option>
                            <option value="Agitated">Agitated / Tearful</option>
                            <option value="Tired">Tired</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Afternoon Mood</label>
                        <select name="afternoon_mood" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Happy" selected>Happy</option>
                            <option value="Calm">Calm</option>
                            <option value="Tired">Tired</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Meal Intake</label>
                        <select name="meal_intake" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Full Meal" selected>Full Meal (100%)</option>
                            <option value="Half Eaten">Half Eaten (50%)</option>
                            <option value="Picky / Textures Refused">Picky / Aversion to Texture</option>
                            <option value="Fed with Support">Fed with Support</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Toilet Training Log</label>
                        <select name="potty_training_log" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Routine Success" selected>Routine Success</option>
                            <option value="Prompted Success">Prompted Success</option>
                            <option value="1 Accident">1 Accident</option>
                            <option value="Diaper">Diaper Routine</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Nap Time (Mins)</label>
                        <input type="number" name="nap_minutes" value="30" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Meltdowns Today</label>
                        <input type="number" name="meltdown_count" value="0" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Teacher Notes for Parents (Daily Message)</label>
                        <input type="text" name="teacher_notes_for_parent" placeholder="e.g. Aarav had a pleasant day. Participated enthusiastically in circle time music."
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="$refs.newDailyCareForm.classList.add('hidden')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-bold">Save Daily Sheet</button>
                </div>
            </form>
        </div>

        <!-- Daily Logs Feed -->
        <div class="space-y-4">
            @forelse($student->dailyCareLogs as $log)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="font-extrabold text-slate-900 text-sm">{{ $log->log_date->format('l, M d, Y') }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold">
                                Mood: {{ $log->morning_mood }} / {{ $log->afternoon_mood }}
                            </span>
                            @if($log->meltdown_count > 0)
                                <span class="text-xs px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-700 font-bold">
                                    {{ $log->meltdown_count }} Meltdown
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <span class="text-2xs text-slate-400 block font-bold uppercase">Meals</span>
                            <span class="font-semibold text-slate-800">{{ $log->meal_intake }}</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <span class="text-2xs text-slate-400 block font-bold uppercase">Potty Routine</span>
                            <span class="font-semibold text-slate-800">{{ $log->potty_training_log }}</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <span class="text-2xs text-slate-400 block font-bold uppercase">Nap Time</span>
                            <span class="font-semibold text-slate-800">{{ $log->nap_minutes }} Minutes</span>
                        </div>
                        <div class="p-2.5 bg-slate-50 rounded-xl">
                            <span class="text-2xs text-slate-400 block font-bold uppercase">Logged By</span>
                            <span class="font-semibold text-slate-800">{{ $log->loggedBy ? $log->loggedBy->name : 'Educator' }}</span>
                        </div>
                    </div>

                    @if($log->teacher_notes_for_parent)
                        <div class="text-xs text-slate-700 bg-amber-50/60 border border-amber-200/50 p-3 rounded-xl">
                            <strong class="text-amber-900">Message for Parent:</strong> {{ $log->teacher_notes_for_parent }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-sm">
                    No daily logs recorded yet. Click "Add Daily Care Log" above.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

