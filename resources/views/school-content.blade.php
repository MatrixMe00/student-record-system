<div>
    <div class="px-4 sm:px-0">
      <h3 class="text-base font-semibold leading-7 text-gray-900">School Information</h3>
      <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">This contains the full contents of <b>{{ $school->school_name }}</b></p>
    </div>
    <div class="mt-6 border-t border-gray-100">
      <dl class="divide-y divide-gray-100">
        {{-- school overview --}}
        <div>
            <h2 class="uppercase border-b w-fit pb-2 mt-2">Overview</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                <x-dl-data title="School Name" content="{{ $school->school_name }}" />
                <x-dl-data title="School Abbreviation" content="{{ $school->school_abbr ?? 'N/A' }}" />
                <x-dl-data title="Circuit" content="{{ $school->circuit }}" />
                <x-dl-data title="District" content="{{ $school->district ?? 'N/A' }}" />
                <x-dl-data title="School Type" content="{{ ucfirst($school->school_type) }}" />
                <x-dl-data title="School Email" content="{{ $school->school_email }}" />
                <x-dl-data title="GPS Address" content="{{ $school->gps_address }}" />
                <x-dl-data title="Box Number" content="{{ $school->box_number }}" />
            </div>
        </div>

        {{-- admin and headmaster --}}
        <div>
            <h2 class="uppercase border-b w-fit pb-2">Authorities</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @php
                    $admin = $school->admin;
                @endphp
                <x-dl-data title="School Head" content="{{ $school->school_head }}" />
                <x-dl-data title="School Admin" content="{{ $admin->lname.' '.$admin->oname }}" />
            </div>
        </div>


        {{-- metrics --}}
        <div>
            <h2 class="uppercase border-b w-fit pb-2">Metrics</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                <x-dl-data title="Total Students" content="{{ $school->students->count() }}" />
                <x-dl-data title="Total Teachers" content="{{ $school->teachers->count() }}" />
                <x-dl-data title="Registered Classes" content="{{ $school->programs->count() }}" />
                <x-dl-data title="Registered Subjects" content="{{ $school->subjects->count() }}" />
            </div>
        </div>

        {{-- school description --}}
        <x-dl-data title="Description" content="{{ $school->description }}" />

        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gray-900">Attachments</dt>
          <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
            <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
              @component('components.school.attachment-container')
                @slot('download_link', url('storage/'.$school->logo_path))
              @endcomponent
              <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                <div class="flex w-0 flex-1 items-center">
                  <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                  </svg>
                  <div class="ml-4 flex min-w-0 flex-1 gap-2">
                    <span class="truncate font-medium">coverletter_back_end_developer.pdf</span>
                    <span class="flex-shrink-0 text-gray-400">4.5mb</span>
                  </div>
                </div>
                <div class="ml-4 flex-shrink-0">
                  <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                </div>
              </li>
            </ul>
          </dd>
        </div>
      </dl>
    </div>
  </div>
