@extends('layouts.app')

@section('title', 'Enroll Student & Profile - SpecialCare')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('students.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Students
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Step 3: Student Admission & IEP Setup</h1>
            <p class="text-xs text-slate-500">Official student enrollment, classroom allocation, autism accommodations, and parent account provisioning.</p>
        </div>
        <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 font-mono text-xs font-bold">
            {{ $nextAdmissionNo }}
        </span>
    </div>

    @if($diagnostic)
        <div class="p-4 rounded-xl bg-teal-50 border border-teal-200 flex items-center justify-between">
            <div class="flex items-center space-x-3 text-xs">
                <span class="w-8 h-8 rounded-lg bg-teal-600 text-white flex items-center justify-center font-bold">
                    <i class="fa-solid fa-notes-medical"></i>
                </span>
                <div>
                    <span class="font-bold text-teal-900 block">Pre-filled from Diagnostic: {{ $diagnostic->assessment_no }} ({{ $diagnostic->child_name }})</span>
                    <span class="text-teal-700">Diagnosis: {{ $diagnostic->primary_diagnosis }} (CARS Score: {{ $diagnostic->cars_score }})</span>
                </div>
            </div>
            <a href="{{ route('diagnostics.show', $diagnostic) }}" class="text-xs font-bold text-teal-800 underline">View Diagnostic</a>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST" class="space-y-6" x-data="{
        dob: '{{ old('dob', $diagnostic && $diagnostic->dob ? $diagnostic->dob->format('Y-m-d') : ($enquiry && $enquiry->dob ? $enquiry->dob->format('Y-m-d') : '')) }}',
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
        }
    }">
        @csrf

        @if($diagnostic)
            <input type="hidden" name="diagnostic_assessment_id" value="{{ $diagnostic->id }}">
            @if($diagnostic->enquiry_id)
                <input type="hidden" name="enquiry_id" value="{{ $diagnostic->enquiry_id }}">
            @endif
        @endif

        <!-- Card 1: Official Student Demographics -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-id-badge text-indigo-600"></i> Student Enrollment & Demographics
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Admission Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="admission_no" required value="{{ old('admission_no', $nextAdmissionNo) }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm font-mono font-bold text-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Admission Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="admission_date" required value="{{ old('admission_date', date('Y-m-d')) }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Classroom / Batch <span class="text-rose-500">*</span></label>
                    <select name="classroom_batch" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="Early Intervention - Batch Lotus">Early Intervention - Batch Lotus</option>
                        <option value="Junior Bloomers (Age 4-7)">Junior Bloomers (Age 4-7)</option>
                        <option value="Life Skills & Independence Group">Life Skills & Independence Group</option>
                        <option value="Transition & Communication Batch">Transition & Communication Batch</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Special Educator</label>
                    <select name="primary_educator_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Assign Educator --</option>
                        @foreach($educators as $edu)
                            <option value="{{ $edu->id }}">{{ $edu->name }} ({{ $edu->specialization ?? 'Educator' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Child's First Name <span class="text-rose-500">*</span></label>
                    @php
                        $parts = explode(' ', $diagnostic ? $diagnostic->child_name : ($enquiry ? $enquiry->child_name : ''));
                        $firstName = $parts[0] ?? '';
                        $lastName = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : '';
                    @endphp
                    <input type="text" name="first_name" required value="{{ old('first_name', $firstName) }}" placeholder="First Name"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $lastName) }}" placeholder="Last Name"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gender <span class="text-rose-500">*</span></label>
                    <select name="gender" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="Male" {{ old('gender', $diagnostic->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $diagnostic->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700">Date of Birth <span class="text-rose-500">*</span></label>
                        <span class="text-2xs font-extrabold px-1.5 py-0.5 rounded bg-indigo-50 text-indigo-700 border border-indigo-200" x-text="calculatedAge"></span>
                    </div>
                    <input type="date" name="dob" required x-model="dob"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Blood Group</label>
                    <input type="text" name="blood_group" value="{{ old('blood_group', 'B+') }}" placeholder="e.g. B+, O+, A+"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assigned Shadow Aide / Caregiver</label>
                    <input type="text" name="shadow_teacher" value="{{ old('shadow_teacher', 'Sunita Verma (Dedicated Aide)') }}" placeholder="Name of Shadow Teacher / Aide"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
            </div>
        </div>

        <!-- Card 2: Autism & Sensory Accommodations Profile -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-shapes text-purple-600"></i> Autism, Sensory & Accommodation Profile
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Diagnosis <span class="text-rose-500">*</span></label>
                    <input type="text" name="primary_diagnosis" required value="{{ old('primary_diagnosis', $diagnostic->primary_diagnosis ?? 'Autism Spectrum Disorder (ASD)') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Severity Level</label>
                    <input type="text" name="severity_level" value="{{ old('severity_level', $diagnostic->severity_level ?? 'Level 2') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Mode of Communication <span class="text-rose-500">*</span></label>
                    <select name="communication_mode" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="PECS & Emerging 2-Word Phrases">PECS & Emerging 2-Word Phrases</option>
                        <option value="Verbal (Fluent)">Verbal (Fluent)</option>
                        <option value="Verbal (Single Words / Echolalia)">Verbal (Single Words / Echolalia)</option>
                        <option value="Completely Non-Verbal">Completely Non-Verbal</option>
                        <option value="AAC Tablet / Digital Speech App">AAC Tablet / Digital Speech App</option>
                        <option value="Gestural & Physical Leading">Gestural & Physical Leading</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        <i class="fa-solid fa-bolt text-amber-500 mr-1"></i> Known Sensory Triggers
                    </label>
                    <input type="text" name="sensory_triggers" value="{{ old('sensory_triggers', 'Sudden loud bells, fluorescent light flickering, scratchy shirt tags, crowded halls') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        <i class="fa-solid fa-heart-pulse text-emerald-500 mr-1"></i> Calming Mechanisms & De-escalation
                    </label>
                    <input type="text" name="calming_methods" value="{{ old('calming_methods', 'Weighted vest, linear hammock swing, deep squeeze hug, bubble blowing, quiet corner') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        <i class="fa-solid fa-shield-heart text-purple-500 mr-1"></i> Comfort Item
                    </label>
                    <input type="text" name="comfort_item" value="{{ old('comfort_item', 'Weighted green dinosaur vest & sensory teether') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Food Texture Tolerances / Aversions</label>
                    <input type="text" name="food_texture_preferences" value="{{ old('food_texture_preferences', 'Prefers crispy snacks. Rejects mixed wet textures.') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Allergies / Dietary Restrictions</label>
                    <input type="text" name="allergies" value="{{ old('allergies', 'Mild lactose intolerance (almond milk preferred)') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Medical Notes (Seizures / Meds)</label>
                    <input type="text" name="medical_notes" value="{{ old('medical_notes', 'No seizure history. Regular multivitamin.') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Card 3: Parent & Emergency Contact -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-users text-blue-600"></i> Parent / Guardian & Portal Login
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Guardian Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="guardian_name" required value="{{ old('guardian_name', $enquiry->parent_name ?? 'Rajesh Gupta') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Relationship</label>
                    <select name="guardian_relation" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Guardian">Legal Guardian</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Phone <span class="text-rose-500">*</span></label>
                    <input type="text" name="guardian_phone" required value="{{ old('guardian_phone', $enquiry->phone ?? '+91 98111 22334') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Parent Email (For Portal Access)</label>
                    <input type="email" name="guardian_email" value="{{ old('guardian_email', $enquiry->email ?? 'parent@specialcare.com') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                    <span class="text-2xs text-slate-400 mt-0.5 block">Auto-creates Parent Portal login. Default password: parent123</span>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Emergency Contact Phone</label>
                    <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', '+91 98111 22335 (Mother: Pooja)') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Residential Address</label>
                    <input type="text" name="address" value="{{ old('address', $enquiry->address ?? 'Flat 402, Sunshine Heights, Mumbai') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-md shadow-indigo-600/20 transition">
                Enroll Student & Initialize IEP &rarr;
            </button>
        </div>

    </form>

</div>
@endsection

