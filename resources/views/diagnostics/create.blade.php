@extends('layouts.app')

@section('title', 'Conduct Diagnostic Assessment - SpecialCare')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('diagnostics.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Diagnostics
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Step 2: Clinical Diagnostic Assessment</h1>
            <p class="text-xs text-slate-500">Standardized clinical evaluation prior to admission (CARS Autism scale, Speech baseline, Sensory matrix).</p>
        </div>
        <span class="px-3 py-1 rounded-full bg-teal-100 text-teal-800 font-mono text-xs font-bold">
            {{ $nextAssessmentNo }}
        </span>
    </div>

    @if($enquiry)
        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center space-x-3 text-xs">
                <span class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </span>
                <div>
                    <span class="font-bold text-amber-900 block text-sm">Linked to Enquiry: {{ $enquiry->enquiry_no }} ({{ $enquiry->child_name }})</span>
                    <span class="text-amber-700">
                        Parent: <strong>{{ $enquiry->parent_name }}</strong> • Phone: <strong>{{ $enquiry->phone }}</strong>
                        @if($enquiry->dob)
                            • Age: <strong class="text-amber-900 bg-amber-100 px-1.5 py-0.5 rounded">{{ \Carbon\Carbon::parse($enquiry->dob)->age }} yrs (DOB: {{ $enquiry->dob->format('M d, Y') }})</strong>
                        @endif
                    </span>
                </div>
            </div>
            <a href="{{ route('enquiries.show', $enquiry) }}" class="text-xs font-bold text-amber-800 hover:underline shrink-0">View Enquiry Details &rarr;</a>
        </div>
    @endif

    <form action="{{ route('diagnostics.store') }}" method="POST" class="space-y-6" x-data="{
        carsScore: '{{ old('cars_score', '34.0') }}',
        dob: '{{ old('dob', $enquiry && $enquiry->dob ? $enquiry->dob->format('Y-m-d') : '') }}',
        get calculatedAge() {
            if (!this.dob) return 'Enter DOB';
            let birthDate = new Date(this.dob);
            let today = new Date();
            if (isNaN(birthDate.getTime())) return 'Invalid Date';
            
            let years = today.getFullYear() - birthDate.getFullYear();
            let months = today.getMonth() - birthDate.getMonth();
            let days = today.getDate() - birthDate.getDate();

            if (days < 0) {
                months--;
            }
            if (months < 0) {
                years--;
                months += 12;
            }

            if (years < 0) return 'Future date';
            if (years === 0 && months === 0) return 'Newborn (Under 1 month)';
            if (years === 0) return months + (months === 1 ? ' month old' : ' months old');
            if (months === 0) return years + (years === 1 ? ' year old' : ' years old');
            return years + (years === 1 ? ' yr, ' : ' yrs, ') + months + (months === 1 ? ' month old' : ' months old');
        },
        get carsSeverity() {
            let s = parseFloat(this.carsScore);
            if (!s || isNaN(s)) return 'Score Pending';
            if (s < 30) return 'Non-Autistic / Minimal Symptoms (15 - 29.5)';
            if (s <= 36.5) return 'Mild-to-Moderate Autism (30 - 36.5)';
            return 'Severe Autism (37 - 60)';
        }
    }">
        @csrf

        @if($enquiry)
            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">
        @endif

        <!-- Card 1: Child & Assessor Info -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Child & Evaluation Details
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Child's Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="child_name" required value="{{ old('child_name', $enquiry->child_name ?? '') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700">Date of Birth</label>
                        <span class="text-2xs font-extrabold px-1.5 py-0.5 rounded bg-teal-50 text-teal-700 border border-teal-200" x-text="calculatedAge"></span>
                    </div>
                    <input type="date" name="dob" x-model="dob"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Automatic Age</label>
                    <div class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm font-extrabold text-teal-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-text="calculatedAge"></span>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gender <span class="text-rose-500">*</span></label>
                    <select name="gender" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden">
                        <option value="Male" {{ old('gender', $enquiry->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $enquiry->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assessment Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="assessment_date" required value="{{ old('assessment_date', date('Y-m-d')) }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assessor / Clinical Specialist</label>
                    <select name="assessor_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-hidden">
                        <option value="">-- Select Specialist --</option>
                        @foreach($assessors as $assessor)
                            <option value="{{ $assessor->id }}">
                                {{ $assessor->name }} ({{ $assessor->specialization ?? 'Therapist' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Card 2: Standardized Autism Metrics (CARS & ISAA) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-chart-line text-blue-600"></i> Standardized Autism Severity Metrics
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- CARS -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-800">Childhood Autism Rating Scale (CARS)</label>
                        <span class="text-xs font-mono font-bold text-blue-600">Scale: 15 to 60</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="number" step="0.5" min="15" max="60" name="cars_score" x-model="carsScore"
                               class="w-28 px-3.5 py-2 rounded-xl border border-slate-300 text-base font-bold text-slate-900 focus:ring-2 focus:ring-teal-500">
                        <span class="text-xs text-slate-500">Points</span>
                    </div>
                    <!-- Live severity badge -->
                    <div class="pt-1">
                        <span class="text-2xs font-semibold text-slate-400 block uppercase">Calculated Severity:</span>
                        <div class="text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-200 mt-1" x-text="carsSeverity">
                        </div>
                    </div>
                </div>

                <!-- ISAA / Additional Scale -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-800">Indian Scale for Assessment of Autism (ISAA)</label>
                        <span class="text-xs font-mono font-bold text-slate-500">Optional</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="number" step="0.5" min="0" max="200" name="isaa_score" value="{{ old('isaa_score') }}" placeholder="e.g. 88.5"
                               class="w-28 px-3.5 py-2 rounded-xl border border-slate-300 text-base font-bold text-slate-900 focus:ring-2 focus:ring-teal-500">
                        <span class="text-xs text-slate-500">Score (< 70: No ASD, 70-106: Mild, 107-153: Moderate, > 153: Severe)</span>
                    </div>
                </div>

                <!-- Primary Clinical Diagnosis -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Clinical Diagnosis <span class="text-rose-500">*</span></label>
                    <select name="primary_diagnosis" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500">
                        <option value="Autism Spectrum Disorder (ASD)">Autism Spectrum Disorder (ASD)</option>
                        <option value="Autism Spectrum Disorder Non-Verbal">Autism Spectrum Disorder (Non-Verbal)</option>
                        <option value="Attention Deficit Hyperactivity Disorder (ADHD)">Attention Deficit Hyperactivity Disorder (ADHD)</option>
                        <option value="Sensory Processing Disorder (SPD)">Sensory Processing Disorder (SPD)</option>
                        <option value="Global Developmental Delay (GDD)">Global Developmental Delay (GDD)</option>
                        <option value="Down Syndrome">Down Syndrome</option>
                        <option value="Cerebral Palsy">Cerebral Palsy</option>
                    </select>
                </div>

                <!-- Severity Level -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">DSM-5 Severity Support Level</label>
                    <select name="severity_level" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500">
                        <option value="Level 1 (Requiring Support)">Level 1 (Requiring Support)</option>
                        <option value="Level 2 (Requiring Substantial Support)" selected>Level 2 (Requiring Substantial Support)</option>
                        <option value="Level 3 (Requiring Very Substantial Support)">Level 3 (Requiring Very Substantial Support)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Card 3: Domain Clinical Evaluations (Speech, Motor, Sensory, Behavior) -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-brain text-purple-600"></i> Domain Specific Baseline Evaluations
            </h2>

            <!-- Speech Evaluation -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    <i class="fa-solid fa-comment-dots text-teal-600 mr-1"></i> Speech & Language Baseline Evaluation
                </label>
                <textarea name="speech_evaluation" rows="2" placeholder="Receptive language age, expressive language age, single words vs babbling, echolalia, PECS/AAC readiness..."
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500">{{ old('speech_evaluation', 'Receptive language ~18 months; Expressive language minimal. Uses isolated sounds. Ready for PECS Phase 1-2.') }}</textarea>
            </div>

            <!-- Motor Evaluation -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    <i class="fa-solid fa-person-walking text-blue-600 mr-1"></i> Motor & Physical Evaluation
                </label>
                <textarea name="motor_evaluation" rows="2" placeholder="Fine motor skills (pincer grasp, pencil grip), Gross motor (balance, jumping, toe-walking), postural tone..."
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500">{{ old('motor_evaluation', 'Mild toe walking, difficulty with bilateral hand coordination. Enjoys swinging.') }}</textarea>
            </div>

            <!-- Sensory Matrix Breakdown -->
            <div class="pt-2 border-t border-slate-100 space-y-3">
                <span class="text-xs font-bold text-slate-800 block">Sensory Profile Matrix (Check observations):</span>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-0.5">Auditory Sensitivity</label>
                        <input type="text" name="sensory_profile[auditory]" value="{{ old('sensory_profile.auditory', 'Hypersensitive (covers ears with vacuum/blender noise)') }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-0.5">Tactile / Touch Sensitivity</label>
                        <input type="text" name="sensory_profile[tactile]" value="{{ old('sensory_profile.tactile', 'Aversion to sticky clay/slime; seeks deep pressure hugs') }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-0.5">Visual Sensitivity</label>
                        <input type="text" name="sensory_profile[visual]" value="{{ old('sensory_profile.visual', 'Fixates on spinning fan blades and lights') }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-2xs font-semibold text-slate-500 mb-0.5">Vestibular & Proprioceptive</label>
                        <input type="text" name="sensory_profile[vestibular]" value="{{ old('sensory_profile.vestibular', 'Calms with linear swinging and weighted blanket') }}"
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs">
                    </div>
                </div>
            </div>

            <!-- Behavioral Observations -->
            <div class="pt-2 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    <i class="fa-solid fa-eye text-amber-600 mr-1"></i> Behavioral Observations & Stimming Patterns
                </label>
                <textarea name="behavioral_observations" rows="2" placeholder="Eye contact duration, hand flapping, spinning, lining objects up, response to name call..."
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500">{{ old('behavioral_observations', 'Fleeting eye contact (<2 seconds). Hand flapping when excited. Responds to name when paired with visual cue.') }}</textarea>
            </div>
        </div>

        <!-- Card 4: Clinical Recommendations & Admission Prescription -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-clipboard-check text-emerald-600"></i> Multidisciplinary Recommendations
            </h2>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Prescribed Care, Classroom & Therapy Plan</label>
                <textarea name="recommendation" rows="3" placeholder="e.g. Recommended for Early Intervention Day Class (1:3 ratio) + Speech Therapy 3x/week + OT Sensory Integration 3x/week + Shadow Aide..."
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500">{{ old('recommendation', 'Recommend enrollment in Early Intervention Special Class. Prescribe Speech Therapy 3x/week, Occupational Sensory Therapy 3x/week with Shadow Aide support during transition times.') }}</textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('diagnostics.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold shadow-md shadow-teal-600/20 transition">
                Save Diagnostic & Finalize &rarr;
            </button>
        </div>

    </form>

</div>
@endsection

