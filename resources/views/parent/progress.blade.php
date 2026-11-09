@extends('layouts.app')

@section('title', "Parent Progress Portal - {$student->full_name}")

@section('content')
<div class="space-y-6">

    <!-- Parent Header Banner -->
    <div class="bg-gradient-to-r from-purple-800 via-indigo-800 to-blue-800 rounded-2xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 opacity-10 pointer-events-none text-white">
            <i class="fa-solid fa-heart-pulse text-9xl"></i>
        </div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md text-white font-black text-2xl flex items-center justify-center border border-white/30 shadow-inner">
                    {{ substr($student->first_name, 0, 1) }}
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-purple-400/30 text-purple-200 text-2xs font-extrabold uppercase tracking-wider mb-1 border border-purple-300/30">
                        <i class="fa-solid fa-heart text-rose-300"></i> Parent Progress Dashboard
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $student->full_name }}'s Journey</h1>
                    <p class="text-xs sm:text-sm text-purple-200 mt-1">
                        Admission No: <strong class="text-white font-mono">{{ $student->admission_no }}</strong>
                        • Batch: <strong class="text-white">{{ $student->classroom_batch }}</strong>
                        • Primary Educator: <strong class="text-white">{{ $student->educator ? $student->educator->name : 'Special Educator' }}</strong>
                    </p>
                </div>
            </div>

            <!-- Action Box / Student Switcher -->
            <div class="bg-white/10 backdrop-blur-md p-3.5 rounded-xl border border-white/20 flex flex-col gap-2.5 min-w-[240px] shrink-0">
                @if($isParentRole)
                    <!-- Parent Mode: Strictly their own child -->
                    <div class="space-y-1">
                        <span class="text-2xs font-bold uppercase tracking-wider text-purple-200 block">Verified Parent Access:</span>
                        <div class="text-xs font-bold text-white flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                    </div>

                    @if(count($allStudents) > 1)
                        <!-- If parent has multiple children enrolled, let them switch only between their own children -->
                        <div>
                            <label class="text-2xs font-semibold text-purple-200 block mb-1">Select Child:</label>
                            <form method="GET" action="{{ route('parent.progress') }}">
                                <select name="student_id" onchange="this.form.submit()" class="w-full px-3 py-1.5 rounded-lg bg-slate-900/80 text-white text-xs border border-white/30 focus:outline-hidden">
                                    @foreach($allStudents as $s)
                                        <option value="{{ $s->id }}" {{ $s->id == $student->id ? 'selected' : '' }}>
                                            {{ $s->full_name }} ({{ $s->admission_no }})
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    @endif
                @else
                    <!-- Staff / Admin / Therapist Preview Mode -->
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-2xs font-bold uppercase tracking-wider text-purple-200">Staff Preview Mode:</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-400 text-slate-900">Admin</span>
                        </div>
                        <form method="GET" action="{{ route('parent.progress') }}">
                            <select name="student_id" onchange="this.form.submit()" class="w-full px-3 py-1.5 rounded-lg bg-slate-900/80 text-white text-xs border border-white/30 focus:outline-hidden">
                                @foreach($allStudents as $s)
                                    <option value="{{ $s->id }}" {{ $s->id == $student->id ? 'selected' : '' }}>
                                        Preview: {{ $s->full_name }} ({{ $s->admission_no }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif

                <button onclick="window.print()" class="w-full py-1.5 px-3 rounded-lg bg-white text-purple-900 text-xs font-bold hover:bg-purple-50 transition flex items-center justify-center gap-1.5 shadow-xs">
                    <svg class="w-3.5 h-3.5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Print Progress Card</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Vital Insights Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- IEP Overall Mastery -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-2xs font-bold text-slate-400 uppercase tracking-wider">Overall IEP Mastery</p>
                <p class="text-3xl font-black text-indigo-700 mt-1">{{ $overallIepMastery }}%</p>
                <p class="text-2xs text-slate-500 mt-1">{{ $student->iepGoals->count() }} Target Goals Active</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-bullseye"></i>
            </div>
        </div>

        <!-- Communication Status -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-2xs font-bold text-slate-400 uppercase tracking-wider">Communication Mode</p>
                <p class="text-sm font-extrabold text-slate-800 mt-1 line-clamp-1">{{ $student->communication_mode }}</p>
                <p class="text-2xs text-teal-600 font-semibold mt-1">PECS Phase 3 Active</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-comments"></i>
            </div>
        </div>

        <!-- Today's Mood -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-2xs font-bold text-slate-400 uppercase tracking-wider">Latest Mood Check-in</p>
                <p class="text-lg font-black text-slate-800 mt-1">
                    {{ $latestCareLog ? $latestCareLog->morning_mood : 'Calm' }} / {{ $latestCareLog ? $latestCareLog->afternoon_mood : 'Happy' }}
                </p>
                <p class="text-2xs text-emerald-600 font-semibold mt-1">Settled & Cooperative</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-face-smile"></i>
            </div>
        </div>

        <!-- Sensory Status -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-2xs font-bold text-slate-400 uppercase tracking-wider">Comfort Item at School</p>
                <p class="text-xs font-bold text-purple-900 mt-1 line-clamp-1">{{ $student->comfort_item ?? 'Sensory Kit' }}</p>
                <p class="text-2xs text-purple-600 font-semibold mt-1">Accessible in Classroom</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-shield-heart"></i>
            </div>
        </div>

    </div>

    <!-- Main Content: Two Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Milestone Progress & IEP Goals Breakdown -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Domain Progress Bars Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900">Developmental Domain Progress</h2>
                        <p class="text-xs text-slate-500">Live mastery rate based on certified therapist and educator evaluations.</p>
                    </div>
                    <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-full border border-indigo-100">
                        Quarterly Cycle
                    </span>
                </div>

                <div class="space-y-4">
                    @php
                        $domainIcons = [
                            'Speech & Communication' => ['icon' => 'fa-comment-dots', 'color' => 'from-teal-500 to-emerald-600', 'bg' => 'bg-teal-50 text-teal-700'],
                            'Occupational & Sensory' => ['icon' => 'fa-hand-sparkles', 'color' => 'from-purple-500 to-indigo-600', 'bg' => 'bg-purple-50 text-purple-700'],
                            'Social & Play Skills' => ['icon' => 'fa-children', 'color' => 'from-amber-500 to-orange-600', 'bg' => 'bg-amber-50 text-amber-700'],
                            'Life Skills (ADL)' => ['icon' => 'fa-soap', 'color' => 'from-blue-500 to-cyan-600', 'bg' => 'bg-blue-50 text-blue-700'],
                            'Behavioral Regulation' => ['icon' => 'fa-brain', 'color' => 'from-rose-500 to-pink-600', 'bg' => 'bg-rose-50 text-rose-700'],
                            'Cognitive & Academics' => ['icon' => 'fa-book-open', 'color' => 'from-indigo-500 to-violet-600', 'bg' => 'bg-indigo-50 text-indigo-700'],
                        ];
                    @endphp

                    @forelse($domainProgress as $domain => $score)
                        @php
                            $meta = $domainIcons[$domain] ?? ['icon' => 'fa-bullseye', 'color' => 'from-indigo-500 to-blue-600', 'bg' => 'bg-slate-100 text-slate-700'];
                        @endphp
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg {{ $meta['bg'] }} flex items-center justify-center text-xs">
                                        <i class="fa-solid {{ $meta['icon'] }}"></i>
                                    </span>
                                    {{ $domain }}
                                </span>
                                <span class="font-extrabold text-slate-900 font-mono">{{ $score }}%</span>
                            </div>
                            <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full bg-gradient-to-r {{ $meta['color'] }} rounded-full transition-all duration-700" style="width: {{ $score }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Goals are currently being evaluated.</p>
                    @endforelse
                </div>
            </div>

            <!-- Detailed IEP Goals Breakdown -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-extrabold text-slate-900">Current Target IEP Milestones</h2>
                    <p class="text-xs text-slate-500">Every goal has individualized criteria and step-by-step milestones.</p>
                </div>

                <div class="space-y-4">
                    @foreach($student->iepGoals as $goal)
                        <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-200 transition bg-slate-50/40 space-y-2.5">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <span class="text-2xs font-extrabold uppercase tracking-wider text-indigo-600 block">{{ $goal->domain }}</span>
                                    <h3 class="font-bold text-slate-900 text-sm mt-0.5">{{ $goal->title }}</h3>
                                </div>
                                <span class="text-xs font-mono font-bold px-2 py-0.5 rounded-full bg-white border border-slate-200 text-indigo-700 self-start sm:self-auto">
                                    {{ $goal->progress_percentage }}% Mastered
                                </span>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed">{{ $goal->description }}</p>

                            @if($goal->evaluator_notes)
                                <div class="p-2.5 rounded-lg bg-emerald-50 border border-emerald-100 text-2xs text-emerald-900 font-medium flex items-start gap-1.5">
                                    <i class="fa-solid fa-comment-check text-emerald-600 mt-0.5"></i>
                                    <span><strong>Educator Note:</strong> {{ $goal->evaluator_notes }}</span>
                                </div>
                            @endif

                            @if($goal->milestones->count() > 0)
                                <div class="pt-2 border-t border-slate-200/60 space-y-1">
                                    <span class="text-2xs font-bold text-slate-400 uppercase tracking-wider block">Completed Steps:</span>
                                    <div class="space-y-1">
                                        @foreach($goal->milestones as $m)
                                            <div class="flex items-center space-x-2 text-2xs">
                                                <i class="fa-solid {{ $m->is_completed ? 'fa-circle-check text-emerald-500' : 'fa-circle text-slate-300' }}"></i>
                                                <span class="{{ $m->is_completed ? 'line-through text-slate-400' : 'text-slate-700 font-medium' }}">
                                                    {{ $m->milestone_title }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Home Reinforcement Guidance -->
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6 shadow-xs space-y-3">
                <div class="flex items-center space-x-2 text-amber-900 font-bold text-sm">
                    <i class="fa-solid fa-lightbulb text-amber-600"></i>
                    <span>Home Practice Exercises (Recommended for Parents)</span>
                </div>
                <p class="text-xs text-amber-800 leading-relaxed">
                    To maintain consistency with school therapy, our specialists recommend these 3 daily routines at home:
                </p>
                <ul class="space-y-2 text-xs text-amber-900 font-medium list-disc list-inside">
                    <li><strong>Snack Time PECS:</strong> Place his preferred snacks in clear sight but out of reach; wait for him to hand you the "Snack" card before handing the item.</li>
                    <li><strong>Sensory Modulation:</strong> Offer 3 minutes of joint compressions or weighted blanket relaxation before homework or bedtime.</li>
                    <li><strong>Turn-taking Play:</strong> Spend 5 minutes rolling a soft ball or passing toy cars back and forth, saying "Papa's turn" and "{{ $student->first_name }}'s turn".</li>
                </ul>
            </div>

        </div>

        <!-- Right Col: Daily Care Log & Therapist Notes Feed -->
        <div class="space-y-6">

            <!-- Today's Daily Routine Sheet -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-clipboard-check text-teal-600"></i> Daily Care Sheet
                    </h3>
                    @if($latestCareLog)
                        <span class="text-2xs text-slate-400 font-semibold">{{ $latestCareLog->log_date->format('M d, Y') }}</span>
                    @endif
                </div>

                @if($latestCareLog)
                    <div class="space-y-3 text-xs">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Meal Intake:</span>
                            <span class="font-bold text-slate-900">{{ $latestCareLog->meal_intake }}</span>
                        </div>
                        @if($latestCareLog->meal_notes)
                            <div class="text-2xs text-slate-600 pl-2 border-l-2 border-teal-500">
                                {{ $latestCareLog->meal_notes }}
                            </div>
                        @endif

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Potty / Hygiene:</span>
                            <span class="font-bold text-emerald-700">{{ $latestCareLog->potty_training_log }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Nap / Rest Duration:</span>
                            <span class="font-bold text-slate-900">{{ $latestCareLog->nap_minutes }} Minutes</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Meltdown Incidents:</span>
                            <span class="font-bold {{ $latestCareLog->meltdown_count > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                {{ $latestCareLog->meltdown_count }}
                            </span>
                        </div>

                        @if($latestCareLog->teacher_notes_for_parent)
                            <div class="p-3.5 rounded-xl bg-indigo-50 border border-indigo-100 text-xs text-indigo-950 space-y-1">
                                <span class="text-2xs font-bold uppercase tracking-wider text-indigo-700 block">
                                    <i class="fa-solid fa-message text-indigo-500 mr-1"></i> Educator Note:
                                </span>
                                <p class="leading-relaxed font-medium">{{ $latestCareLog->teacher_notes_for_parent }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-xs text-slate-400 text-center py-4">No daily care log entered today yet.</p>
                @endif
            </div>

            <!-- Specialist Therapy Session Highlights -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-amber-500"></i> Specialist Therapy Highlights
                    </h3>
                    <p class="text-2xs text-slate-400">Direct positive milestones logged by Speech & OT therapists.</p>
                </div>

                <div class="space-y-3">
                    @forelse($recentSessions as $session)
                        <div class="p-3.5 rounded-xl border border-purple-100 bg-purple-50/40 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-2xs font-bold text-purple-700 uppercase tracking-wider">{{ $session->therapy_type }}</span>
                                <span class="text-2xs text-slate-400">{{ $session->session_date->format('M d') }}</span>
                            </div>
                            <p class="text-xs font-semibold text-slate-800 leading-snug">
                                "{{ $session->parent_summary }}"
                            </p>
                            <span class="text-2xs text-slate-400 block">
                                — {{ $session->therapist_name ?? 'Therapist' }} ({{ $session->duration_minutes }} min session)
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">No therapy notes recorded yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Emergency & School Helpline -->
            <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xs space-y-3 text-xs">
                <div class="flex items-center space-x-2 text-rose-400 font-bold uppercase tracking-wider text-2xs">
                    <i class="fa-solid fa-phone-volume"></i>
                    <span>School & Emergency Care Desk</span>
                </div>
                <p class="text-slate-300 leading-relaxed">
                    Need immediate communication with {{ $student->first_name }}'s shadow aide or care coordinator?
                </p>
                <div class="space-y-1 font-mono text-sm font-bold text-teal-300">
                    <div>Special Care Desk: +91 98765 43210</div>
                    <div>School Clinic: +91 98765 11111</div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

