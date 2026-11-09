@extends('layouts.app')

@section('title', 'Register New Enquiry - SpecialCare')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('enquiries.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center mb-1">
                <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Enquiries
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Step 1: Parent Enquiry Intake</h1>
            <p class="text-xs text-slate-500">Record parent concerns, contact details, and child observations for diagnostic pre-screening.</p>
        </div>
        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-mono text-xs font-bold">
            {{ $nextEnquiryNo }}
        </span>
    </div>

    <form action="{{ route('enquiries.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card 1: Child Basic Info -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-child text-blue-600"></i> Child Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Child's Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="child_name" required value="{{ old('child_name') }}" placeholder="e.g. Aarav Gupta"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gender <span class="text-rose-500">*</span></label>
                    <select name="gender" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Card 2: Parent / Guardian Info -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-user-group text-indigo-600"></i> Parent / Guardian Contact
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Parent / Guardian Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="parent_name" required value="{{ old('parent_name') }}" placeholder="e.g. Rajesh & Pooja Gupta"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Relationship</label>
                    <select name="relation" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Both Parents">Both Parents</option>
                        <option value="Legal Guardian">Legal Guardian</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="+91 98765 43210"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="parent@example.com"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Referred By</label>
                    <input type="text" name="referred_by" value="{{ old('referred_by') }}" placeholder="e.g. Pediatrician / School / Online"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assign Counselor / Staff</label>
                    <select name="handled_by" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                        <option value="">-- Select Staff --</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} ({{ ucfirst($member->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Residential Address / City</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Area, Landmark, City"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">
                </div>
            </div>
        </div>

        <!-- Card 3: Autism & Developmental Concerns Checklist -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Primary Developmental Concerns / Red Flags
            </h2>
            <p class="text-xs text-slate-500">Check all behaviors reported by parents or observed during initial interview:</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @php
                    $concerns = [
                        'Speech Delay (Non-Verbal / Few Words)',
                        'Poor or Inconsistent Eye Contact',
                        'Repetitive Hand Flapping or Stimming',
                        'Toe Walking',
                        'Auditory Sensitivity (Covers ears with sounds)',
                        'Sensory Overload / Meltdowns in Crowds',
                        'Picky Eater (Aversion to textures/solid foods)',
                        'Does Not Respond to Name Call',
                        'Extreme Tantrums with Routine Changes',
                        'Difficulty with Peer Interaction / Parallel Play',
                        'Hyperactivity / Inattention',
                        'Uses Adult\'s Hand as a Tool',
                    ];
                @endphp

                @foreach($concerns as $concern)
                    <label class="flex items-start space-x-2.5 p-3 rounded-xl border border-slate-200 hover:border-blue-300 hover:bg-blue-50/30 cursor-pointer transition">
                        <input type="checkbox" name="primary_concerns[]" value="{{ $concern }}"
                               class="mt-0.5 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                        <span class="text-xs font-medium text-slate-700 leading-snug">{{ $concern }}</span>
                    </label>
                @endforeach
            </div>

            <div class="pt-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">Additional Parent Notes / Case History</label>
                <textarea name="notes" rows="3" placeholder="Describe any previous therapy received, milestones, birth history, or specific triggers..."
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-hidden">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('enquiries.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-sm font-semibold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow-md shadow-blue-600/20 transition">
                Register Enquiry &rarr;
            </button>
        </div>

    </form>

</div>
@endsection

