<section class="bg-white dark:bg-gray-900 md:w-[80vw]">
    <div class="flex justify-center min-h-screen">
        <div class="hidden bg-cover lg:block lg:w-2/5" style="background-image: url('https://images.unsplash.com/photo-1494621930069-4fd4b2e24a11?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=715&q=80')">
        </div>

        <div class="flex items-center w-full max-w-3xl p-8 mx-auto lg:px-12 lg:w-3/5">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    Provide Your School Details.
                </h1>

                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Set up your school by providing the necessary details. Please provide valid data.
                </p>

                <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name of school -->
                    <div>
                        <x-input-label for="school_name" :value="__('School Name')" />
                        <x-text-input id="school_name" type="text" name="school_name" :value="old('school_name')" placeholder="Name of School" autofocus required />
                        <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
                    </div>

                    <!-- School Slug -->
                    <div>
                        <x-input-label for="school_slug" :value="__('School Abbreviation')" />
                        <x-text-input id="school_slug" type="text" name="school_slug" :value="old('school_slug')" placeholder="Slug name for school" required />
                        <x-input-error :messages="$errors->get('school_slug')" class="mt-2" />
                    </div>

                    <!-- School Email -->
                    <div>
                        <x-input-label for="school_email" :value="__('School Email')" />
                        <x-text-input id="school_email" type="email" name="school_email" :value="old('school_email')" placeholder="example@email.com" required />
                        <x-input-error :messages="$errors->get('school_email')" class="mt-2" />
                    </div>

                    <!-- Headmaster or Headmistress -->
                    <div>
                        <x-input-label for="head_name" :value="__('Headmaster / Headmistress name')" />
                        <x-text-input id="head_name" type="text" name="head_name" :value="old('head_name')" placeholder="Headmaster / Headmistress" required />
                        <x-input-error :messages="$errors->get('head_name')" class="mt-2" />
                    </div>

                    <!-- School Logo -->
                    <div>
                        <x-input-label for="school_logo" :value="__('School Logo')" />
                        <x-text-input id="school_logo" type="file" accept="image" name="school_logo" :value="old('school_logo')" />
                        <x-input-error :messages="$errors->get('school_logo')" class="mt-2" />
                    </div>

                    <!-- School Location -->
                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" type="text" name="location" :value="old('location')" placeholder="Location of School" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- GPS Address -->
                    <div>
                        <x-input-label for="gps_address" :value="__('GPS Address')" />
                        <x-text-input id="gps_address" type="text" name="gps_address" :value="old('gps_address')" placeholder="XX-XXX-XXXX [Include the dashes]" required />
                        <x-input-error :messages="$errors->get('gps_address')" class="mt-2" />
                    </div>

                    <!-- Box Number -->
                    <div>
                        <x-input-label for="box_number" :value="__('School Box Number')" />
                        <x-text-input id="box_number" type="text" name="box_number" :value="old('box_number')" placeholder="P.O.Box XX" required />
                        <x-input-error :messages="$errors->get('box_number')" class="mt-2" />
                    </div>

                    <!-- School type -->
                    <div>
                        <x-input-label for="school_type" :value="__('Type of School')" />
                        <x-input-select name="school_type" id="school_type" options="0" >
                            <option value="">Select a type</option>
                            <option value="public">Public School</option>
                            <option value="private">Private School</option>
                        </x-input-select>
                        <x-input-error :messages="$errors->get('school_type')" class="mt-2" />
                    </div>

                    <!-- School description -->
                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('School Description')" />
                        <x-input-textarea id="description" type="text" name="description" class="min-h-32 max-h-44" :value="old('description')" placeholder="A short description about the school" required />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <x-text-input name="admin_id" id="admin_id" type="hidden" value="{{ $admin_id }}" />

                    <button
                        class="flex items-center justify-between w-full px-6 py-3 text-sm
                            tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                            hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                            focus:ring-opacity-50">
                        <span>Set Up My School</span>
                        <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                    </button>
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('admin.login') }}">
                            {{ __('Cancel Registration') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
