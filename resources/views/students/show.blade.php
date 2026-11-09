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
        <button @click="activeTab = 'attendance'" :class="activeTab === 'attendance' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-calendar-check text-indigo-500"></i> Attendance & Transit ({{ $student->attendances->count() }})
        </button>
        <button @click="activeTab = 'billing'" :class="activeTab === 'billing' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-file-invoice-dollar text-emerald-600"></i> Fees & Invoices ({{ $student->invoices->count() }})
        </button>
        <button @click="activeTab = 'iep'" :class="activeTab === 'iep' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-bullseye"></i> IEP Goals ({{ $student->iepGoals->count() }})
        </button>
        <button @click="activeTab = 'therapy'" :class="activeTab === 'therapy' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-stethoscope"></i> Therapy Logs ({{ $student->therapySessions->count() }})
        </button>
        <button @click="activeTab = 'daily_log'" :class="activeTab === 'daily_log' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-clipboard-check"></i> Daily Care Sheets ({{ $student->dailyCareLogs->count() }})
        </button>
        <button @click="activeTab = 'abc'" :class="activeTab === 'abc' ? 'border-b-2 border-indigo-600 text-indigo-600 font-bold' : 'text-slate-600 font-medium hover:text-slate-900'" class="px-4 py-3 text-sm flex items-center gap-2 whitespace-nowrap transition">
            <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> ABC Incidents ({{ $student->behavioralIncidents->count() }})
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

    <!-- TAB: Attendance & Transit -->
    <div x-show="activeTab === 'attendance'" class="space-y-6">
        @php
            $totalDays = $student->attendances->count();
            $presentDays = $student->attendances->where('status', 'present')->count();
            $sensoryDays = $student->attendances->where('status', 'sensory_recovery_day')->count();
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 100;
        @endphp

        <!-- Attendance Stats Row -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Total Days Logged</span>
                <p class="text-2xl font-black text-slate-800 mt-1">{{ $totalDays }}</p>
                <span class="text-2xs text-slate-500">School sessions</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Present Rate</span>
                <p class="text-2xl font-black text-emerald-600 mt-1">{{ $attendanceRate }}%</p>
                <span class="text-2xs text-slate-500">{{ $presentDays }} of {{ $totalDays }} days present</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Sensory Recovery Days</span>
                <p class="text-2xl font-black text-purple-600 mt-1">{{ $sensoryDays }}</p>
                <span class="text-2xs text-purple-600 font-medium">Neurodivergent excused</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Transit Mode</span>
                <p class="text-sm font-black text-indigo-700 mt-2 truncate">
                    {{ $student->attendances->first()?->transport_mode ?? 'School Bus' }}
                </p>
                <span class="text-2xs text-slate-500 truncate block">
                    {{ $student->attendances->first()?->bus_route ?? 'Guwahati South Route' }}
                </span>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Attendance & Morning Transit Log</h2>
                <p class="text-xs text-slate-500">Track daily arrivals, transportation routes, and morning sensory states.</p>
            </div>
            <button type="button" @click="$refs.attendanceForm.classList.toggle('hidden')" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm transition">
                <i class="fa-solid fa-plus mr-1"></i> Log Daily Attendance
            </button>
        </div>

        <!-- Add Attendance Form -->
        <div x-ref="attendanceForm" class="hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h3 class="text-sm font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-clipboard-user text-indigo-600"></i> Record Today's Attendance & Arrival
            </h3>
            <form action="{{ route('students.markAttendance', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Date</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Attendance Status</label>
                        <select name="status" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="present" selected>Present in School</option>
                            <option value="sensory_recovery_day">Sensory Recovery Day (Home Excused)</option>
                            <option value="late">Late Arrival</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Arrival Time</label>
                        <input type="time" name="arrival_time" value="08:45" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Arrival Sensory State</label>
                        <select name="arrival_state" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Calm" selected>Calm & Regulated</option>
                            <option value="Anxious">Anxious / Hesitant</option>
                            <option value="Agitated">Agitated / Restless</option>
                            <option value="Overstimulated">Overstimulated (High Sensory Load)</option>
                            <option value="Sleepy">Sleepy / Low Energy</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Transport Mode</label>
                        <select name="transport_mode" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="School Bus" selected>School Bus</option>
                            <option value="Parent Drop">Parent Drop</option>
                            <option value="Shadow Aide Walk">Shadow Aide Walk</option>
                            <option value="Private Cab">Private Cab</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Bus Route</label>
                        <input type="text" name="bus_route" value="Route 3 - South Belt" placeholder="e.g. Route 3" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Transit Attendant</label>
                        <input type="text" name="transit_attendant" value="Rekha Das" placeholder="Attendant name" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Morning Sensory Notes</label>
                        <input type="text" name="notes" placeholder="e.g. Arrived happy holding dinosaur plush" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="$refs.attendanceForm.classList.add('hidden')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold">Save Attendance Log</button>
                </div>
            </form>
        </div>

        <!-- Attendance Logs Table -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-2xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-200">
                        <tr>
                            <th class="p-3.5">Date & Day</th>
                            <th class="p-3.5">Status</th>
                            <th class="p-3.5">Arrival Time</th>
                            <th class="p-3.5">Sensory State on Arrival</th>
                            <th class="p-3.5">Transport & Route</th>
                            <th class="p-3.5">Attendant & Morning Observations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($student->attendances->sortByDesc('date') as $att)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 whitespace-nowrap font-bold text-slate-900">
                                    {{ $att->date->format('M d, Y') }}
                                    <span class="block text-2xs font-normal text-slate-400">{{ $att->date->format('l') }}</span>
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($att->status === 'present')
                                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <i class="fa-solid fa-check mr-1"></i> Present
                                        </span>
                                    @elseif($att->status === 'sensory_recovery_day')
                                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fa-solid fa-heart mr-1"></i> Sensory Recovery Day
                                        </span>
                                    @elseif($att->status === 'late')
                                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            <i class="fa-solid fa-clock mr-1"></i> Late
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                            <i class="fa-solid fa-xmark mr-1"></i> Absent
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap font-medium text-slate-700">
                                    {{ $att->arrival_time ? date('h:i A', strtotime($att->arrival_time)) : '—' }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($att->arrival_state === 'Calm')
                                        <span class="px-2 py-0.5 rounded-md text-2xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            😊 Calm & Regulated
                                        </span>
                                    @elseif($att->arrival_state === 'Anxious')
                                        <span class="px-2 py-0.5 rounded-md text-2xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                            😟 Anxious / Hesitant
                                        </span>
                                    @elseif($att->arrival_state === 'Overstimulated')
                                        <span class="px-2 py-0.5 rounded-md text-2xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                            ⚡ Overstimulated
                                        </span>
                                    @elseif($att->arrival_state === 'Agitated')
                                        <span class="px-2 py-0.5 rounded-md text-2xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                                            ⚠️ Agitated
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md text-2xs font-bold bg-slate-100 text-slate-600">
                                            {{ $att->arrival_state }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="font-semibold text-slate-800">{{ $att->transport_mode }}</span>
                                    @if($att->bus_route)
                                        <span class="block text-2xs text-slate-400 font-mono">{{ $att->bus_route }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-xs text-slate-700">
                                    @if($att->transit_attendant)
                                        <span class="font-bold text-slate-800">{{ $att->transit_attendant }}:</span>
                                    @endif
                                    {{ $att->notes ?? 'Normal morning transit with no incidents.' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">
                                    No attendance logs recorded yet. Click "Log Daily Attendance" above.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB: Fees & Invoices (Monthly & Per Class Packages) -->
    <div x-show="activeTab === 'billing'" class="space-y-6" x-data="{
        selectedPackageId: '',
        packageDescription: '',
        packageAmount: '',
        packageType: 'monthly',
        printInvoice: null,
        feePackages: {{ Js::from($feePackages) }},
        updatePackage() {
            const pkg = this.feePackages.find(p => p.id == this.selectedPackageId);
            if (pkg) {
                this.packageDescription = pkg.name + (pkg.billing_cycle === 'Per Session' ? ' (Per Class)' : ' (' + pkg.billing_cycle + ')');
                this.packageAmount = pkg.amount;
                this.packageType = pkg.billing_cycle === 'Per Session' ? 'per_class' : 'monthly';
            }
        }
    }">
        @php
            $totalInvoiced = $student->invoices->sum('amount');
            $totalPaid = $student->invoices->where('status', 'paid')->sum('amount');
            $totalPending = $student->invoices->where('status', 'pending')->sum('amount');
        @endphp

        <!-- Financial Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Total Invoiced</span>
                <p class="text-2xl font-black text-slate-800 mt-1">₹{{ number_format($totalInvoiced, 2) }}</p>
                <span class="text-2xs text-slate-500">{{ $student->invoices->count() }} bills issued</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Total Paid</span>
                <p class="text-2xl font-black text-emerald-600 mt-1">₹{{ number_format($totalPaid, 2) }}</p>
                <span class="text-2xs text-emerald-600 font-medium">Cleared payments</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Pending Balance</span>
                <p class="text-2xl font-black text-amber-600 mt-1">₹{{ number_format($totalPending, 2) }}</p>
                <span class="text-2xs text-amber-600 font-medium">{{ $student->invoices->where('status', 'pending')->count() }} due invoices</span>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
                <span class="text-2xs font-bold uppercase tracking-wider text-slate-400">Enrolled Plan</span>
                <p class="text-sm font-black text-indigo-700 mt-2 truncate">{{ $student->classroom_batch }}</p>
                <span class="text-2xs text-slate-500">Monthly Tuition + Per-Class Therapy</span>
            </div>
        </div>

        <!-- Available Fee Structure Reference (Monthly & Per-Class Rates) -->
        <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5 space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Center Fee Schedule</h3>
                    <p class="text-xs text-slate-700 font-semibold mt-0.5">Approved Rates for Monthly Tuition & Per-Class Clinical Therapies</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    Transparent Special Education Pricing
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($feePackages as $pkg)
                    <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs hover:border-indigo-300 transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-xs text-slate-800">{{ $pkg->name }}</span>
                                <span class="text-2xs px-2 py-0.5 rounded-full font-bold {{ $pkg->billing_cycle === 'Per Session' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $pkg->billing_cycle === 'Per Session' ? 'Per Class' : $pkg->billing_cycle }}
                                </span>
                            </div>
                            <p class="text-2xs text-slate-500 mb-2 leading-relaxed">{{ $pkg->description }}</p>
                        </div>
                        <div class="flex items-center justify-between border-t border-slate-100 pt-2 mt-1">
                            <span class="text-xs font-extrabold text-slate-900">₹{{ number_format($pkg->amount, 0) }}</span>
                            <button type="button" @click="
                                selectedPackageId = '{{ $pkg->id }}';
                                updatePackage();
                                $refs.invoiceForm.classList.remove('hidden');
                                $refs.invoiceForm.scrollIntoView({ behavior: 'smooth' });
                            " class="text-2xs font-bold text-indigo-600 hover:text-indigo-800">
                                Bill This &rarr;
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Invoices & Billing History</h2>
                <p class="text-xs text-slate-500">Generate monthly tuition fee bills, per-class therapy invoices, and print receipts.</p>
            </div>
            <button type="button" @click="$refs.invoiceForm.classList.toggle('hidden')" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-sm transition">
                <i class="fa-solid fa-plus mr-1"></i> Generate Invoice / Bill
            </button>
        </div>

        <!-- Add Invoice Form -->
        <div x-ref="invoiceForm" class="hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h3 class="text-sm font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-file-circle-plus text-emerald-600"></i> Generate Monthly / Per-Class Fee Bill
            </h3>
            <form action="{{ route('students.addInvoice', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Quick Select Predefined Fee Package</label>
                        <select x-model="selectedPackageId" @change="updatePackage()" name="fee_package_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 font-medium">
                            <option value="">-- Custom Invoice Item --</option>
                            @foreach($feePackages as $pkg)
                                <option value="{{ $pkg->id }}">
                                    {{ $pkg->name }} — ₹{{ number_format($pkg->amount, 0) }} ({{ $pkg->billing_cycle === 'Per Session' ? 'Per Class' : $pkg->billing_cycle }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Item / Service Description</label>
                        <input type="text" name="item_description" x-model="packageDescription" required placeholder="e.g. November 2026 Tuition or Speech Therapy (4 Classes)" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Amount (₹)</label>
                        <input type="number" step="0.01" name="amount" x-model="packageAmount" required placeholder="0.00" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 font-bold text-slate-900">
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Invoice Date</label>
                        <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Payment Status</label>
                        <select name="status" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="pending" selected>Pending / Unpaid</option>
                            <option value="paid">Paid & Cleared</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Payment Method</label>
                        <select name="payment_method" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="UPI / GPay">UPI / GooglePay</option>
                            <option value="Cash">Cash (Reception Desk)</option>
                            <option value="Bank Transfer">Bank Transfer (NEFT/IMPS)</option>
                            <option value="Card">Debit / Credit Card</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Notes / Transaction Reference</label>
                        <input type="text" name="notes" placeholder="e.g. Paid by father via UPI, or Receipt #4021" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="$refs.invoiceForm.classList.add('hidden')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-bold">Generate Invoice</button>
                </div>
            </form>
        </div>

        <!-- Invoices List Table -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-2xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-200">
                        <tr>
                            <th class="p-3.5">Invoice #</th>
                            <th class="p-3.5">Fee Item / Package Description</th>
                            <th class="p-3.5">Billing Type</th>
                            <th class="p-3.5">Invoice Date</th>
                            <th class="p-3.5">Due Date</th>
                            <th class="p-3.5">Amount</th>
                            <th class="p-3.5">Status</th>
                            <th class="p-3.5 text-right">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($student->invoices->sortByDesc('invoice_date') as $inv)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="p-3.5 whitespace-nowrap font-mono font-bold text-slate-900">
                                    {{ $inv->invoice_no }}
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-slate-900 text-xs">{{ $inv->item_description }}</div>
                                    @if($inv->notes)
                                        <div class="text-2xs text-slate-500 mt-0.5">{{ $inv->notes }}</div>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($inv->feePackage && $inv->feePackage->billing_cycle === 'Per Session')
                                        <span class="px-2 py-0.5 rounded-full text-2xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                            Per Class / Session
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-2xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                            Monthly Tuition
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap text-slate-600">
                                    {{ $inv->invoice_date->format('M d, Y') }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap text-slate-600">
                                    {{ $inv->due_date->format('M d, Y') }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap font-black text-slate-900 text-sm">
                                    ₹{{ number_format($inv->amount, 2) }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($inv->status === 'paid')
                                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1 w-max">
                                            <i class="fa-solid fa-check"></i> Paid ({{ $inv->payment_method ?? 'Cleared' }})
                                        </span>
                                        @if($inv->paid_date)
                                            <span class="block text-2xs text-slate-400 mt-0.5">on {{ $inv->paid_date->format('M d, Y') }}</span>
                                        @endif
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-2xs font-bold bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1 w-max">
                                            <i class="fa-solid fa-clock"></i> Due / Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap text-right">
                                    <button type="button" @click="printInvoice = {{ Js::from($inv) }}" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 text-2xs font-bold transition inline-flex items-center gap-1">
                                        <i class="fa-solid fa-print text-indigo-600"></i> Receipt
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-slate-400">
                                    No invoices issued for this student yet. Click "Generate Invoice / Bill" above.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Receipt Print Modal -->
        <div x-show="printInvoice" style="display: none;" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div @click.away="printInvoice = null" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-5 text-slate-800">
                <!-- Receipt Header -->
                <div class="flex items-start justify-between border-b border-slate-200 pb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black">
                            <i class="fa-solid fa-puzzle-piece"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-base">Aura SpecialCare Academy</h3>
                            <p class="text-2xs text-slate-500">Center for Autism & Child Neurodevelopment</p>
                        </div>
                    </div>
                    <span class="text-2xs font-mono font-bold bg-slate-100 text-slate-600 px-2 py-1 rounded-md" x-text="printInvoice ? printInvoice.invoice_no : ''"></span>
                </div>

                <!-- Receipt Body -->
                <div class="space-y-3 text-xs">
                    <div class="bg-slate-50 p-4 rounded-2xl space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Student Name:</span>
                            <strong class="text-slate-900">{{ $student->full_name }} ({{ $student->admission_no }})</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Guardian / Parent:</span>
                            <span class="font-medium text-slate-800">{{ $student->guardian_name }} ({{ $student->guardian_phone }})</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Classroom:</span>
                            <span class="font-medium text-slate-800">{{ $student->classroom_batch }}</span>
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-2xl p-4 space-y-2">
                        <div class="flex justify-between font-bold text-slate-800 border-b border-slate-100 pb-2">
                            <span>Service / Package Description</span>
                            <span>Amount</span>
                        </div>
                        <div class="flex justify-between items-center text-slate-700 pt-1">
                            <span x-text="printInvoice ? printInvoice.item_description : ''"></span>
                            <span class="font-black text-slate-900 text-sm" x-text="printInvoice ? '₹' + parseFloat(printInvoice.amount).toFixed(2) : ''"></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs px-1">
                        <div>
                            <span class="text-slate-500 block">Status:</span>
                            <span class="font-bold uppercase text-emerald-600" x-text="printInvoice ? printInvoice.status : ''"></span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Payment Mode:</span>
                            <span class="font-semibold text-slate-800" x-text="printInvoice ? (printInvoice.payment_method || 'Standard') : ''"></span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Date:</span>
                            <span class="font-semibold text-slate-800" x-text="printInvoice ? printInvoice.invoice_date : ''"></span>
                        </div>
                    </div>
                </div>

                <!-- Footer & Print Actions -->
                <div class="flex items-center justify-between border-t border-slate-200 pt-4">
                    <span class="text-2xs text-slate-400">System Generated Clinical Fee Receipt</span>
                    <div class="flex items-center space-x-2">
                        <button type="button" @click="printInvoice = null" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Close</button>
                        <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5">
                            <i class="fa-solid fa-print"></i> Print Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: ABC Behavioral Incidents -->
    <div x-show="activeTab === 'abc'" class="space-y-6">
        <div class="bg-amber-50/70 border border-amber-200 rounded-2xl p-5">
            <h3 class="text-xs font-bold uppercase tracking-wider text-amber-900 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-600"></i> Antecedent - Behavior - Consequence (ABC) Framework
            </h3>
            <p class="text-xs text-amber-900/80 mt-1 leading-relaxed">
                Documenting behavioral antecedents and calming interventions helps identify sensory triggers and refine de-escalation strategies for neurodivergent children.
            </p>
        </div>

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-800">Behavioral Incidents & Sensory Overload Log</h2>
                <p class="text-xs text-slate-500">Record distress events, environmental antecedents, and successful calming techniques.</p>
            </div>
            <button type="button" @click="$refs.abcForm.classList.toggle('hidden')" class="px-3.5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold shadow-sm transition">
                <i class="fa-solid fa-plus mr-1"></i> Log ABC Incident
            </button>
        </div>

        <!-- Add ABC Form -->
        <div x-ref="abcForm" class="hidden bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
            <h3 class="text-sm font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-amber-600"></i> New Behavioral ABC Incident
            </h3>
            <form action="{{ route('students.addBehavioralIncident', $student) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Date</label>
                        <input type="date" name="incident_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Time</label>
                        <input type="time" name="incident_time" value="{{ date('H:i') }}" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Location</label>
                        <input type="text" name="location" value="Classroom" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">A — Antecedent (Trigger / Context immediately before behavior)</label>
                        <input type="text" name="antecedent" placeholder="e.g. Loud bell rang, unexpected transition to playground, peer approached abruptly" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">B — Behavior Type</label>
                        <select name="behavior_type" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Sensory Meltdown" selected>Sensory Meltdown (Crying / Covering Ears)</option>
                            <option value="Self-Stimulatory / Flapping">Intense Stimming / Rocking</option>
                            <option value="Aggression / Hitting">Aggression / Hitting Aide</option>
                            <option value="Elopement / Running">Elopement / Running away</option>
                            <option value="Task Refusal">Task Refusal / Dropping to floor</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Intensity</label>
                        <select name="intensity" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                            <option value="Mild">Mild</option>
                            <option value="Moderate" selected>Moderate</option>
                            <option value="Severe">Severe</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Duration (Minutes)</label>
                        <input type="number" name="duration_minutes" value="5" min="1" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Behavior Details</label>
                        <textarea name="behavior_description" rows="2" placeholder="Specific behavioral description" class="w-full px-3 py-1.5 rounded-lg border border-slate-300"></textarea>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">C — Consequence & Calming Intervention Applied</label>
                        <input type="text" name="intervention_used" placeholder="e.g. Guided to sensory tent, applied weighted dinosaur vest, offered quiet space" required class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-2xs font-bold text-slate-700 mb-1">Post-Incident Student State</label>
                        <input type="text" name="post_incident_state" placeholder="e.g. Regulated after 5 mins, had water, resumed activity" class="w-full px-3 py-1.5 rounded-lg border border-slate-300">
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" @click="$refs.abcForm.classList.add('hidden')" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs">Cancel</button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-amber-600 text-white text-xs font-bold">Log ABC Incident</button>
                </div>
            </form>
        </div>

        <!-- Incidents List -->
        <div class="space-y-4">
            @forelse($student->behavioralIncidents->sortByDesc('incident_date') as $inc)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-slate-900 text-sm">{{ $inc->incident_date->format('M d, Y') }} at {{ date('h:i A', strtotime($inc->incident_time)) }}</span>
                            <span class="text-2xs px-2 py-0.5 rounded-full font-bold {{ $inc->intensity === 'Severe' ? 'bg-rose-100 text-rose-800' : ($inc->intensity === 'Moderate' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                {{ $inc->intensity }} Intensity ({{ $inc->duration_minutes }}m)
                            </span>
                        </div>
                        <span class="text-2xs text-slate-400">Location: {{ $inc->location }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                        <div class="p-3 bg-rose-50/70 border border-rose-100 rounded-xl">
                            <strong class="text-rose-900 block font-bold text-2xs uppercase mb-1">A: Antecedent Trigger</strong>
                            <p class="text-slate-800">{{ $inc->antecedent }}</p>
                        </div>
                        <div class="p-3 bg-amber-50/70 border border-amber-100 rounded-xl">
                            <strong class="text-amber-900 block font-bold text-2xs uppercase mb-1">B: Observed Behavior</strong>
                            <p class="font-semibold text-slate-900">{{ $inc->behavior_type }}</p>
                            @if($inc->behavior_description)
                                <p class="text-slate-700 mt-1 text-2xs">{{ $inc->behavior_description }}</p>
                            @endif
                        </div>
                        <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl">
                            <strong class="text-emerald-900 block font-bold text-2xs uppercase mb-1">C: Calming Intervention</strong>
                            <p class="text-slate-800">{{ $inc->intervention_used }}</p>
                            @if($inc->post_incident_state)
                                <span class="block text-2xs text-emerald-700 font-medium mt-1">Post: {{ $inc->post_incident_state }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-400 text-sm">
                    No behavioral incidents recorded.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

