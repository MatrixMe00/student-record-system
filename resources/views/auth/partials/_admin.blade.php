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
                    Create your school administrator account to get started with managing your school's records
                </p>
            </div>
        </div>

        {{-- Right Side Form - Scrollable on large screens --}}
        <div class="flex items-center justify-center w-full lg:w-3/5 bg-white dark:bg-gray-800">
            <div class="w-full max-w-2xl mx-auto p-6 sm:p-8 lg:p-12 lg:overflow-y-auto lg:h-screen">
                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
                        Create Your Account
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Let's get you all set up so you can verify your personal account and begin creating your school profile.
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
                <form class="space-y-6" action="{{ route('register') }}" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                    @csrf

                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6 space-y-6">
                        {{-- Personal Information --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="lname" :value="__('Last Name')" />
                                    <x-text-input id="lname" type="text" name="lname" :value="old('lname')" placeholder="Doe" autofocus required />
                                    <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="oname" :value="__('Other Name(s)')" />
                                    <x-text-input id="oname" type="text" name="oname" :value="old('oname')" placeholder="John" required />
                                    <x-input-error :messages="$errors->get('oname')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Account Information --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="email" :value="__('Email Address')" />
                                    <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="admin@example.com" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input id="username" type="text" name="username" :value="old('username')" placeholder="jondoe" required />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password" :value="__('Password')" />
                                    <x-text-input id="password" type="password" name="password" :value="old('password')" placeholder="Enter a strong password" required />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-enter your password" required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Contact Information --}}
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="primary_phone" :value="__('Primary Phone Number')" />
                                    <x-text-input id="primary_phone" type="tel" name="primary_phone" :value="old('primary_phone')" placeholder="+233 XX XXX XXXX" maxlength="15" minlength="10" required />
                                    <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="secondary_phone" :value="__('Secondary Phone Number')" />
                                    <x-text-input id="secondary_phone" type="tel" name="secondary_phone" :value="old('secondary_phone')" placeholder="+233 XX XXX XXXX" maxlength="15" minlength="10" />
                                    <x-input-error :messages="$errors->get('secondary_phone')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden Fields --}}
                    <x-text-input name="role_id" id="role_id" type="hidden" value="{{ $role_id }}" />
                    <x-text-input name="new_school" id="new_school" type="hidden" value="1" />

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
                                <i class="fas fa-user-plus mr-2"></i>
                                Create My Account
                            </span>
                            <span x-show="submitting" class="flex items-center">
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Creating account...
                            </span>
                        </button>
                    </div>

                    {{-- Help Text & Login Link --}}
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            After registration, you'll be redirected to set up your school.
                        </p>
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('admin.login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
