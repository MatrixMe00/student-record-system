<form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
    method="POST" action="/result/{{ $result->id }}/edit">
    @csrf
    @method("PUT")

    {{-- Result id --}}
    <div>
        <x-input-label for="result_token" :value="__('Result ID')" />
        <x-text-input id="result_token" type="text" name="result_token" :value="$result->result_token" required readonly />
        <x-input-error :messages="$errors->get('result_token')" class="mt-2" />
    </div>

    {{-- school id --}}
    <x-text-input id="school_id" type="hidden" name="school_id" value="{{ $result->school_id }}" />

    {{-- teacher id --}}
    <x-text-input id="teacher_id" type="hidden" name="teacher_id" value="{{ $result->teacher_id }}" />

    {{-- program id --}}
    <div>
        <x-input-label for="program_id" :value="__('Result Class')" />
        <x-text-input id="program_id" :value="$program->name" readonly />
        <x-text-input type="hidden" name="program_id" value="{{ $program->id }}" />
        <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
    </div>

    {{-- semester --}}
    <div>
        <x-input-label for="semester" :value="__('Select Result Term')" />
        <x-input-select options="auto" :value="old('semester', $result->semester)" default="Select a Term" keyword="Term" min="1" max="3" name="semester" :abled="!$is_admin" />
        <x-input-error :messages="$errors->get('semester')" class="mt-2" />
    </div>

    {{-- subject id --}}
    <div>
        <x-input-label for="subject_id" :value="__('Result Subject')" />
        <x-text-input name="subject_id" type="hidden" :value="$subject->id" />
        <x-text-input id="subject_id" :value="$subject->name" readonly />
        <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
    </div>

    @if ($edit_all && !$is_admin)
        <div class="md:col-span-2">
            <button type="submit"
                class="flex items-center justify-between w-full md:w-1/2 lg:w-2/3 lg:mx-auto px-6 py-3 text-sm
                    tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                    hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                    focus:ring-opacity-50">
                <span>Update</span>
                <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
            </button>
        </div>
    @endif
</form>
