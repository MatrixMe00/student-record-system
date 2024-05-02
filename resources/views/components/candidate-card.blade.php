@props(["candidate", "school_id"])

@php
    $student = $candidate->student;

@endphp

<a href="{{ route('school.candidate.show', ['beceCandidate' => $candidate->id]) }}" class="w-full bg-white shadow rounded border border-transparent hover:border-blue-500 cursor-pointer">
    <div class="h-32 w-full checker-bg flex items-center justify-center p-4 text-blue-500">
      <x-application-logo />
    </div>

    <div class="p-4 border-t border-gray-200">
      <div class="flex items-center justify-between relative">
        <h1 class="text-gray-600 font-medium">{{ $student->lname." ".$student->oname }}</h1>
      </div>
      <p class="text-gray-400 text-sm my-1">Index Number: {{ $candidate->index_number ?? "Not Set" }}</p>
    </div>
</a>
