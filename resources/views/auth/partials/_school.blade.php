<section class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="flex min-h-screen">
        {{-- Left Side Image - Sticky on large screens --}}
        <div class="hidden bg-cover lg:block lg:w-2/5 bg-center lg:sticky lg:top-0 lg:h-screen relative" style="background-image: url('https://images.unsplash.com/photo-1494621930069-4fd4b2e24a11?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=715&q=80')">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/90 to-purple-900/90"></div>
            <div class="relative z-10 flex flex-col items-center justify-center h-full p-8 text-white">
                <div class="mb-8">
                    <x-application-logo variant="icon-only" text-color="text-white" />
                </div>
                <h2 class="text-3xl font-bold mb-4 text-center">Welcome to EduRecordsGH</h2>
                <p class="text-lg text-indigo-100 text-center max-w-sm leading-relaxed">
                    Complete your school registration to start managing your students, grades, and academic records
                </p>
            </div>
        </div>

        {{-- Right Side Form - Scrollable on large screens --}}
        <div class="flex items-center justify-center w-full lg:w-3/5 bg-white dark:bg-gray-800">
            <div class="w-full max-w-2xl mx-auto p-6 sm:p-8 lg:p-12 lg:overflow-y-auto lg:h-screen">
                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
                        School Registration
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Set up your school by providing the necessary details. Please provide valid data.
                    </p>
                </div>

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-red-800 dark:text-red-200 mb-2">
                                    Please correct the following errors:
                                </h3>
                                <ul class="list-disc list-inside space-y-1 text-sm text-red-700 dark:text-red-300">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form class="space-y-6" enctype="multipart/form-data" method="POST" action="{{ route('school.store') }}" x-data="{ submitting: false }" @submit="submitting = true">
                    @csrf

                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-6">
                        {{-- School Basic Information --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">School Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="school_name" :value="__('School Name')" />
                                    <x-text-input id="school_name" type="text" name="school_name" :value="old('school_name')" placeholder="Name of School" autofocus required />
                                    <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="school_slug" :value="__('School Abbreviation')" />
                                    <x-text-input id="school_slug" type="text" name="school_slug" :value="old('school_slug')" placeholder="Slug name for school" required />
                                    <x-input-error :messages="$errors->get('school_slug')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="school_email" :value="__('School Email')" />
                                    <x-text-input id="school_email" type="email" name="school_email" :value="old('school_email')" placeholder="example@email.com" required />
                                    <x-input-error :messages="$errors->get('school_email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="school_head" :value="__('Headmaster / Headmistress')" />
                                    <x-text-input id="school_head" type="text" name="school_head" :value="old('school_head')" placeholder="Headmaster / Headmistress" required />
                                    <x-input-error :messages="$errors->get('school_head')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="school_type" :value="__('Type of School')" />
                                    <x-input-select name="school_type" id="school_type" options="0">
                                        <option value="">Select a type</option>
                                        <option value="public" {{ old('school_type') == 'public' ? 'selected' : '' }}>Public School</option>
                                        <option value="private" {{ old('school_type') == 'private' ? 'selected' : '' }}>Private School</option>
                                    </x-input-select>
                                    <x-input-error :messages="$errors->get('school_type')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="education_level" :value="__('Education Level')" subtext="Define the education level of your school as Basic or Secondary level" />
                                    <x-input-select name="education_level" id="education_level" options="0" required>
                                        <option value="">Select education level</option>
                                        <option value="basic" {{ old('education_level') == 'basic' ? 'selected' : '' }}>Basic School</option>
                                        <option value="secondary" {{ old('education_level') == 'secondary' ? 'selected' : '' }}>Secondary School</option>
                                    </x-input-select>
                                    <x-input-error :messages="$errors->get('education_level')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="logo_path" :value="__('School Logo')" />
                                    <x-text-input id="logo_path" type="file" accept="image" name="logo_path" :value="old('logo_path')" subtext="Optional: Upload your school logo" />
                                    <x-input-error :messages="$errors->get('logo_path')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- School Location --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">School Location</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="circuit" :value="__('Circuit')" />
                                    <x-text-input id="circuit" type="text" name="circuit" :value="old('circuit')" placeholder="Circuit of School" required />
                                    <x-input-error :messages="$errors->get('circuit')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="district" :value="__('District')" />
                                    <x-text-input id="district" type="text" name="district" :value="old('district')" placeholder="Circuit District" required />
                                    <x-input-error :messages="$errors->get('district')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="gps_address" :value="__('GPS Address')" />
                                    <x-text-input id="gps_address" type="text" name="gps_address" :value="old('gps_address')" placeholder="XX-XXX-XXXX [Include the dashes]" required />
                                    <x-input-error :messages="$errors->get('gps_address')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="box_number" :value="__('School Box Number')" />
                                    <x-text-input id="box_number" type="text" name="box_number" :value="old('box_number')" placeholder="P.O.Box XX" required />
                                    <x-input-error :messages="$errors->get('box_number')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- School Description --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">School Description</h3>
                            <div>
                                <x-input-label for="description" :value="__('School Description')" />
                                <x-input-textarea id="description" type="text" name="description" class="min-h-32 max-h-44" :value="old('description')" placeholder="A short description about the school" required />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- Hidden Fields --}}
                    <x-text-input name="admin_id" id="admin_id" type="hidden" value="{{ $admin_id }}" />

                    {{-- Submit Button --}}
                    <div>
                        <button
                            type="submit"
                            :disabled="submitting"
                            class="w-full flex items-center justify-center px-6 py-3 text-base
                                font-semibold text-white bg-indigo-600 rounded-lg
                                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed
                                transition-all duration-200 shadow-md hover:shadow-lg">
                            <span x-show="!submitting" class="flex items-center">
                                <i class="fas fa-school mr-2"></i>
                                Set Up My School
                            </span>
                            <span x-show="submitting" class="flex items-center">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Setting up school...
                            </span>
                        </button>
                    </div>

                    {{-- Help Text & Cancel Link --}}
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            After registration, you'll be able to start managing your school's records.
                        </p>
                        <div>
                            @auth
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('logout') }}">
                                    {{ __('Log Out') }}
                                </a>
                            @else
                                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('admin.login') }}">
                                    {{ __('Cancel Registration') }}
                                </a>
                            @endauth
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
