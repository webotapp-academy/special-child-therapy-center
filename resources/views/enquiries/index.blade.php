@extends('layouts.app')

@section('title', 'Enquiries & Lead Screening - SpecialCare')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Step 1: Parent Enquiries & Screening</h1>
            </div>
            <p class="text-sm text-slate-500 mt-1">
                Record initial walk-ins, parent phone queries, and developmental concerns before diagnostic assessment.
            </p>
        </div>
        <div>
            <a href="{{ route('enquiries.create') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow-sm transition">
                <i class="fa-solid fa-plus mr-2"></i> Register New Enquiry
            </a>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('enquiries.index', ['status' => 'all']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ ($status === 'all' || !$status) ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('enquiries.index', ['status' => 'new']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'new' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            New / Pending ({{ $statusCounts['new'] }})
        </a>
        <a href="{{ route('enquiries.index', ['status' => 'assessment_scheduled']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'assessment_scheduled' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            Assessment Scheduled ({{ $statusCounts['assessment_scheduled'] }})
        </a>
        <a href="{{ route('enquiries.index', ['status' => 'assessed']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'assessed' ? 'bg-teal-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            Assessed ({{ $statusCounts['assessed'] }})
        </a>
        <a href="{{ route('enquiries.index', ['status' => 'admitted']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $status === 'admitted' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            Admitted ({{ $statusCounts['admitted'] }})
        </a>
    </div>

    <!-- Enquiries Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500 font-semibold text-xs border-b border-slate-200 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Enquiry No & Child</th>
                        <th class="px-6 py-3.5">Parent / Contact</th>
                        <th class="px-6 py-3.5">Developmental Concerns</th>
                        <th class="px-6 py-3.5">Assessment Date</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($enquiries as $enquiry)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $enquiry->child_name }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    {{ $enquiry->enquiry_no }} • {{ $enquiry->gender ?? 'N/A' }} 
                                    @if($enquiry->dob)
                                        • {{ \Carbon\Carbon::parse($enquiry->dob)->age }} yrs
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800 text-xs">{{ $enquiry->parent_name }} ({{ $enquiry->relation }})</div>
                                <div class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-phone text-slate-400 mr-1"></i> {{ $enquiry->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if(!empty($enquiry->primary_concerns))
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @foreach($enquiry->primary_concerns as $concern)
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-800 border border-amber-200/60 rounded text-2xs font-semibold">
                                                {{ $concern }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">None specified</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if($enquiry->assessment_scheduled_at)
                                    <span class="font-bold text-slate-800 block">
                                        {{ \Carbon\Carbon::parse($enquiry->assessment_scheduled_at)->format('M d, Y') }}
                                    </span>
                                    <span class="text-slate-400">
                                        {{ \Carbon\Carbon::parse($enquiry->assessment_scheduled_at)->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Not scheduled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($enquiry->status === 'new')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> New Lead
                                    </span>
                                @elseif($enquiry->status === 'assessment_scheduled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span> Assessment Booked
                                    </span>
                                @elseif($enquiry->status === 'assessed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 mr-1.5"></span> Diagnostic Done
                                    </span>
                                @elseif($enquiry->status === 'admitted')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Enrolled
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('enquiries.show', $enquiry) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition inline-flex items-center">
                                    View Details
                                </a>
                                @if($enquiry->status === 'assessment_scheduled' || $enquiry->status === 'new')
                                    <a href="{{ route('diagnostics.create', ['enquiry_id' => $enquiry->id]) }}" class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-lg transition inline-flex items-center" title="Conduct Clinical Diagnostic">
                                        <i class="fa-solid fa-stethoscope mr-1"></i> Assess
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                No enquiries found in this category.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($enquiries->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $enquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

