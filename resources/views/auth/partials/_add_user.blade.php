<div class="flex items-center w-full p-8 mx-auto lg:px-12" x-data="{ selected_role:'{{ old('role_id') }}', email_val:'{{ old('email') }}', index_number:'{{ $index_number }}', username:'{{ old('username') }}' }" x-init="email_val='{{ old('email') }}'">
    <div class="w-full">
        <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
            Add A New User
        </h1>

        <p class="mt-4 text-gray-500 dark:text-gray-400">
            Fill the form below to add a new user
        </p>

        @if ($errors->any())
            <x-input-error :messages="$errors->all()" />
        @endif

        <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
            method="POST" action="{{ route('register') }}">
            @csrf

            {{-- user role --}}
            <div>
                <x-input-label for="role_id" :value="__('User Role')" />
                <x-input-select :options="$roles" default="Select A Role" name="role_id" id="role_id" :value="old('role_id')" x-model="selected_role" @change="selected_role==5 ? username=index_number : username=''" />
                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
            </div>

            {{-- user lastname --}}
            <div>
                <x-input-label for="lname" :value="__('Last Name')" />
                <x-text-input id="lname" type="text" name="lname" :value="old('lname')" placeholder="Doe" autofocus required />
                <x-input-error :messages="$errors->get('lname')" class="mt-2" />
            </div>

            {{-- user othernames --}}
            <div>
                <x-input-label for="oname" :value="__('Other Name(s)')" />
                <x-text-input id="oname" type="text" name="oname" :value="old('oname')" placeholder="John" required />
                <x-input-error :messages="$errors->get('oname')" class="mt-2" />
            </div>

            {{-- user email --}}
            <div x-show="selected_role != 5">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" x-model="email_val" name="email" :value="old('email')" placeholder="example@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- user username --}}
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" type="text" name="username" :value="old('username')" placeholder="jondoe" x-model="username" required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            {{-- user password 1 --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" :value="old('password')" placeholder="Password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- user password 2 --}}
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" :value="old('password_confirmation')" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- primary phone number --}}
            <div>
                <x-input-label for="primary_phone" :value="__('Primary Phone Number')" />
                <x-text-input id="primary_phone" type="tel" name="primary_phone" :value="old('primary_phone')" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" required />
                <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
            </div>

            {{-- secondary phone number --}}
            <div>
                <x-input-label for="secondary_phone" :value="__('Secondary Phone Number')" />
                <x-text-input id="secondary_phone" type="tel" name="secondary_phone" :value="old('secondary_phone')" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" />
                <x-input-error :messages="$errors->get('secondary_phone')" class="mt-2" />
            </div>

            {{-- student next of kin --}}
            <div x-show="selected_role==5">
                <x-input-label for="next_of_kin" :value="__('Student Next of Kin')" />
                <x-text-input id="next_of_kin" name="next_of_kin" :value="old('next_of_kin')" placeholder="Next of Kin" />
                <x-input-error :messages="$errors->get('next_of_kin')" />
            </div>

            {{-- student program --}}
            <div x-show="selected_role==5">
                <x-input-label for="program_id" :value="__('Student Class')" />
                <x-input-select :options="$programs ?? ''" default="Select A Class" name="program_id" id="program_id" :value="old('program_id')" />
                <x-input-error :messages="$errors->get('program_id')" />
            </div>

            {{-- school --}}
            <div>
                @if (is_array($school_id))
                    <x-input-label for="school_id" :value="__('User School')" />
                    @php
                        $school_id = count($school_id) > 0 ? $school_id : "";
                    @endphp
                    <x-input-select :options="$school_id" default="Select A School" name="school_id" id="school_id" :value="old('school_id')" />
                @else
                <x-text-input id="school_id" type="hidden" name="school_id" value="{{ $school_id }}" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" />
                @endif
                <x-input-error :messages="$errors->get('school_id')" class="mt-2" />
            </div>

            {{-- form mode --}}
            <x-text-input type="hidden" name="non_submit" value="1" />

            <div class="md:col-span-2">
                <button type="submit"
                    class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                        tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                        hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                        focus:ring-opacity-50">
                    <span>Create User Account</span>
                    <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                </button>
            </div>
        </form>
    </div>
</div>
