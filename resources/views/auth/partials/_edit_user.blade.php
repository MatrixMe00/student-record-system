<x-app-layout>
    <x-slot name="header">
        <x-app-header>Edit {{ $user->username }}</x-app-header>
    </x-slot>

    @section("title", "Edit {{ $user->username }}")

    <x-app-main>
        <div class="flex items-center w-full p-8 mx-auto my-4 lg:px-12 bg-slate-200 rounded-sm">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    Update Details For {{ $user->username }}
                </h1>

                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Make changes to the user details below
                </p>

                @session('success')
                    <p class="text-center mt-2 -mb-2 p-2 bg-white border cursor-pointer" onclick="this.remove()">{{ session('success') }}</p>
                @endsession

                @if ($errors->any())
                    <x-input-error :messages="$errors->all()" />
                @endif

                <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
                    method="POST" action="/user/{{ $user->username }}/edit">
                    @csrf
                    @method("PUT")

                    {{-- user role --}}
                    <div>
                        <x-input-label for="role_name" :value="__('User Role')" />
                        <x-text-input id="role_name" value="{{ $user->role->name }}" readonly />
                    </div>

                    {{-- user lastname --}}
                    <div>
                        <x-input-label for="lname" :value="__('Last Name')" />
                        <x-text-input id="lname" type="text" name="lname" :value="old('lname') ?? $model->lname" placeholder="Doe" autofocus required />
                        <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                    </div>

                    {{-- user othernames --}}
                    <div>
                        <x-input-label for="oname" :value="__('Other Name(s)')" />
                        <x-text-input id="oname" type="text" name="oname" :value="old('oname') ?? $model->oname" placeholder="John" required />
                        <x-input-error :messages="$errors->get('oname')" class="mt-2" />
                    </div>

                    {{-- user email --}}
                    @if ($user->role_id != 5)
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" :value="old('email') ?? $user->email" placeholder="example@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    @endif

                    {{-- user username --}}
                    <div>
                        <x-input-label for="username" :value="__('Username')" />
                        <x-text-input id="username" type="text" name="username" :value="old('username') ?? $user->username" placeholder="jondoe" required />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    {{-- primary phone number --}}
                    <div>
                        <x-input-label for="primary_phone" :value="__('Primary Phone Number')" />
                        <x-text-input id="primary_phone" type="tel" name="primary_phone" :value="old('primary_phone') ?? $model->primary_phone" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" required />
                        <x-input-error :messages="$errors->get('primary_phone')" class="mt-2" />
                    </div>

                    {{-- secondary phone number --}}
                    <div>
                        <x-input-label for="secondary_phone" :value="__('Secondary Phone Number')" />
                        <x-text-input id="secondary_phone" type="tel" name="secondary_phone" :value="old('secondary_phone') ?? $model->secondary_phone" placeholder="XXX XXX XXXX" maxlength="13" minlength="10" />
                        <x-input-error :messages="$errors->get('secondary_phone')" class="mt-2" />
                    </div>

                    @if ($user->role_id == 5)
                        {{-- student next of kin --}}
                        <div>
                            <x-input-label for="next_of_kin" :value="__('Student Next of Kin')" />
                            <x-text-input id="next_of_kin" name="next_of_kin" :value="old('next_of_kin') ?? $model->next_of_kin" placeholder="Next of Kin" />
                            <x-input-error :messages="$errors->get('next_of_kin')" />
                        </div>

                        {{-- student program --}}
                        <div>
                            <x-input-label for="program_id" :value="__('Student Class')" />
                            <x-input-select :options="$programs ?? ''" default="Select A Class" name="program_id" id="program_id" :value="old('program_id')" />
                            <x-input-error :messages="$errors->get('program_id')" />
                        </div>
                    @endif

                    {{-- school --}}
                    <div>
                        <x-input-label for="school_name" :value="__('School Name')" />
                        <x-text-input id="school_name" type="text" readonly value="{{ $model->school->school_name ?? 'No School' }}" />
                    </div>

                    {{-- form mode --}}
                    <x-text-input type="hidden" name="non_submit" value="1" />

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <button type="submit"
                            class="flex items-center justify-between w-full px-6 py-3 text-sm
                                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                                hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                                focus:ring-opacity-50">
                            <span>Update User Details</span>
                            <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                        </button>
                        <button type="button"
                            class="text-left w-full px-6 py-3 text-sm tracking-wide capitalize group transform
                            bg-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring focus:ring-gray-300
                            focus:ring-opacity-50" onclick="location.href='{{ route('users.all') }}'">
                            <span>Cancel</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </x-app-main>
</x-app-layout>
