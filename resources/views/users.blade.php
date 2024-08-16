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

                @if (auth()->user()->role_id == 3)
                    <x-primary-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'add-multiple')"
                        type="button">
                        {{ __("Add Multiple Users") }}
                    </x-primary-button>
                @endif


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

        <x-session-component />

        <x-app-tab :tabs="array_keys($options)">
            @foreach ($options as $content_id => $option)
            @if ($option->count() > 0)
                <div id="{{ $content_id }}"
                    class="bg-gray-50 grid gap-3 md:gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4
                    shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
                    x-show="contentBox=='{{ $content_id }}'">
                    @php
                        $user_role = auth()->user()->role_id;
                        $is_super = $user_role <= 2 || $user_role == 1;
                    @endphp
                    @foreach ($option as $user)
                        <x-app-user-card :user="$user" :is_super="$is_super" />
                    @endforeach
                </div>
            @else
                <div id="{{ $content_id }}"
                    class="bg-gray-50 grid gap-3 md:gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4
                        shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
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
                @include("auth.partials._add_multi_user")
            </x-modal>
        @endif
    </x-app-main>
</x-app-layout>
