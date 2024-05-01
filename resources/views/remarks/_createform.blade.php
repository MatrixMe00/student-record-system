<div class="flex items-center w-full p-8 mx-auto lg:px-12">
    <div class="w-full">
        <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            Add A Remark Slip
        </h1>

        <p class="mt-4 text-gray-500 dark:text-gray-400">
            Use the form below to set a new remark slip / card
        </p>
        @if ($errors->any())
            <x-input-error :messages="$errors->all()" />
        @endif

        <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
            method="POST" action="{{ route('remarks-slip.store') }}">
            @csrf

            {{-- Result id --}}
            <div>
                <x-input-label for="remark_token" :value="__('Remark ID')" />
                <x-text-input id="remark_token" type="text" name="remark_token" :value="old('remark_token', $remark_id)" required readonly />
                <x-input-error :messages="$errors->get('remark_token')" class="mt-2" />
            </div>

            {{-- school id --}}
            <x-text-input id="school_id" type="hidden" name="school_id" value="{{ session('school_id') }}" />

            {{-- teacher id --}}
            <x-text-input id="teacher_id" type="hidden" name="teacher_id" value="{{ $teacher->id }}" />

            {{-- program id --}}
            @if ($program)
                <div>
                    <x-input-label for="program_id" :value="__('Class Name')" />
                    <x-text-input name="program_id" type="hidden" :value="$program->id" />
                    <x-text-input id="program_id" :value="$program->name" readonly />
                    <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
                </div>
            @endif


            {{-- semester --}}
            <div>
                <x-input-label for="semester" :value="__('Select Result Term')" />
                <x-input-select options="auto" :value="old('semester')" default="Select a Term" keyword="Term" min="1" max="3" name="semester" />
                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
            </div>

            {{-- display an academic year --}}
            <div>
                <x-input-label for="academic_year" :value="__('Academic Year')" />
                <x-text-input id="academic_year" name="academic_year" :value="get_academic_year(date('d-m-Y'))" readonly />
            </div>

            {{-- is user admin --}}
            <x-text-input name="is_admin" type="hidden" :value="$is_admin" readonly />

            <div class="md:col-span-2">
                <button type="submit"
                    class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                        tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                        hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                        focus:ring-opacity-50">
                    <span>Create Remarks Slip</span>
                    <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                </button>
            </div>
        </form>
    </div>
</div>
