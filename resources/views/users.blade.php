<x-app-layout>
    <x-slot name="header">
        <x-app-header>Users</x-app-header>
    </x-slot>

    @section("title", "Users")

    <x-app-main>
        @if (auth()->user()->role_id <= 3)
            <section class="mt-4 ml-6">
                <x-primary-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'create_user')"
                    type="button">
                    {{ __("Add New User") }}
                </x-primary-button>
                <x-primary-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'add-multiple')"
                    type="button">
                    {{ __("Add Multiple Users") }}
                </x-primary-button>

                @if (auth()->user()->role_id == 3)
                    <a href="{{ route('subject.assign') }}">
                        <x-primary-button
                            type="button">
                            {{ __("Assign Subject Teacher") }}
                        </x-primary-button>
                    </a>
                @endif
            </section>
        @endif

        <x-app-tab :tabs="array_keys($options)">
            @foreach ($options as $content_id => $option)
            @if ($option->count() > 0)
                <div id="{{ $content_id }}"
                    class="bg-gray-50 grid gap-4 md:gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
                    x-show="contentBox=='{{ $content_id }}'">
                    @foreach ($option as $user)
                        <x-app-user-card :user="$user" />
                    @endforeach
                </div>
            @else
                <div id="{{ $content_id }}"
                    class="bg-gray-50 shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
                    x-show="contentBox=='{{ $content_id }}'">
                    <p class="text-center">No user found</p>
                </div>
            @endif

            @endforeach
        </x-app-tab>

        {{-- modal for new user --}}
        @if (auth()->user()->role_id <= 3)
            <x-modal name="create_user" :show="$errors->any() && !$errors->has('upload_error')">
                @include("auth.partials._add_user")
            </x-modal>
            <x-modal name="add-multiple" :show="$errors->has('upload_error')">
                <x-form-container maintitle="Add Multiple Users">
                    @section("sub-title")
                        <p>Upload a document below</p>
                        <p class="mb-4">Accepted document template is <a href="{{ asset('defaults/documents/Student List.xlsx') }}" class="text-blue-600 hover:underline">this</a></p>
                    @endsection
                    <x-form-element action="{{ route('users.add') }}" method="POST" enctype="multipart/form-data" >
                        @csrf

                        <div>
                            <x-input-label value="Select User Group" />
                            <x-input-select options="0" name="user_type" :value="old('user_type')" required>
                                <option value="">Select a user group</option>
                                <option value="student">Students</option>
                            </x-input-select>
                        </div>

                        <div>
                            <x-input-label value="Class Type" />
                            <x-input-select options="0" name="program_id" :value="old('user_type')" required>
                                @if (count($programs) > 0)
                                    <option value="mixed">Mixed Classes</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program['id'] }}">{{ $program['name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">No Classes uploaded</option>
                                @endif
                            </x-input-select>
                        </div>

                        <div>
                            <x-input-label value="Class List" />
                            <x-text-input type="file" name="upload_file" :value="old('upload_file')" accept=".xls,.xlsx" required />
                        </div>

                        @if (count($programs) > 0)
                            <x-form-button-container>
                                <x-form-submit-button>Submit</x-form-submit-button>
                            </x-form-button-container>
                        @endif

                    </x-form-element>
                </x-form-container>

            </x-modal>
        @endif
    </x-app-main>
</x-app-layout>
