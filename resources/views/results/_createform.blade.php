<div class="flex items-center w-full p-8 mx-auto lg:px-12">
    <div class="w-full">
        <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            Add A Result Slip
        </h1>

        <p class="mt-4 text-gray-500 dark:text-gray-400">
            Use the form below to set a new result slip / card
        </p>

        <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
            method="POST" action="{{ route('result.store') }}">
            @csrf

            {{-- Result id --}}
            <div>
                <x-input-label for="result_token" :value="__('Result ID')" />
                <x-text-input id="result_token" type="text" name="result_token" :value="old('result_token', $result_id)" required readonly />
                <x-input-error :messages="$errors->get('result_token')" class="mt-2" />
            </div>

            {{-- Display status --}}
            <div>
                <x-input-label for="status" :value="__('Result Status')" />
                <x-text-input id="status" type="text" value="Pending" readonly />
            </div>

            {{-- school id --}}
            <x-text-input id="school_id" type="hidden" name="school_id" value="{{ auth()->user()->school->id }}" />

            {{-- teacher id --}}
            <x-text-input id="teacher_id" type="hidden" name="teacher_id" value="{{ auth()->user()->id }}" />

            {{-- program id --}}
            <div>
                <x-input-label for="program_id" :value="__('Select the Class')" />
                <x-input-select :options="$classes" :value="old('program_id')" default="Select a class" name="program_id" />
                <x-input-error :messages="$errors->get('program_id')" class="mt-2" />
            </div>

            {{-- semester --}}
            <div>
                <x-input-label for="semester" :value="__('Select Result Term')" />
                <x-input-select options="auto" :value="old('semester')" default="Select a Term" keyword="Term" min="1" max="3" name="semester" />
                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
            </div>

            <div class="md:col-span-2">
                <button type="submit"
                    class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                        tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                        hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                        focus:ring-opacity-50">
                    <span>Add Subject</span>
                    <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                </button>
            </div>
        </form>
    </div>
</div>
