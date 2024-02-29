<x-app-layout>
    <x-slot name="header">
        <x-app-header>Edit {{ $program->name }}</x-app-header>
    </x-slot>

    @section("title", "Edit Class Data")

    <x-app-main>
        <div class="flex items-center w-full p-8 mx-auto lg:px-12">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    Update {{ $program->name }} details
                </h1>

                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Use the form below to update the details of {{ $program->name }}
                </p>

                @session('success')
                    <x-session-message class="mb-2">
                        {{ __(session('message')) }}
                    </x-session-message>
                @endsession

                @if ($errors->any())
                    <x-input-error :messages="$errors->all()" />
                @endif

                <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
                    method="POST" action="/class/{{ $program->id }}/edit">
                    @csrf
                    @method("PUT")

                    {{-- class name --}}
                    <div>
                        <x-input-label for="name" :value="__('Class Name')" />
                        <x-text-input id="name" type="text" name="name" :value="old('name') ?? $program->name" placeholder="Class 1" autofocus required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- class alias / slug --}}
                    <div>
                        <x-input-label for="slug" :value="__('Class Alias (Slug)')" />
                        <x-text-input id="slug" type="text" name="slug" :value="old('slug') ?? $program->slug" placeholder="Eg. C1 [optional]" />
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    {{-- school id --}}
                    <x-text-input id="school_id" type="hidden" name="school_id" value="{{ $program->school_id }}" />

                    {{-- Class teacher --}}
                    <div>
                        <x-input-label for="class_teacher" :value="__('Class Teacher')" />
                        <x-input-select :options="0" name="class_teacher" id="class_teacher" :value="old('class_teacher')">
                            <option value="">Select A Class Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->user_id }}"
                                    @if ($teacher->user_id == $program->class_teacher)
                                        {{ "selected" }}
                                    @endif
                                >{{ ucwords($teacher->lname." ".$teacher->oname) }}</option>
                            @endforeach
                        </x-input-select>
                        <x-input-error :messages="$errors->get('class_teacher')" />
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit"
                            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                                hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                                focus:ring-opacity-50">
                            <span>Update {{ $program->name }}</span>
                            <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </x-app-main>
</x-app-layout>
