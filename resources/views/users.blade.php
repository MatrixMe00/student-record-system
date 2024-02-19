<x-app-layout>
    <x-slot name="header">
        <x-app-header>Users</x-app-header>
    </x-slot>

    @section("title", "Users")

    @php
        $is_add = request()->routeIs('user.add');
    @endphp

    <x-app-main>
        @if (auth()->user()->role_id <= 3)
            <section class="mt-4 ml-6">
                @if ($is_add)
                    <x-primary-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'create_user')"
                        type="button">
                        {{ __("Add New User") }}
                    </x-primary-button>
                @else
                    <x-primary-button onclick="location.href='{{ route('user.add') }}'"
                        type="button">
                        {{ __("Add New User") }}
                    </x-primary-button>
                @endif
            </section>
        @endif

        <x-app-tab :tabs="array_keys($options)">
            @foreach ($options as $content_id => $option)
            @if ($option->count() > 0)
                <div id="{{ $content_id }}"
                    class="bg-gray-50 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 shadow border border-gray-100 p-8 text-gray-700 rounded-lg -mt-2"
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
        @if (auth()->user()->role_id <= 3 && request()->routeIs('user.add'))
            <x-modal name="create_user" show="true">
                @include("auth.partials._add_user")
            </x-modal>
        @endif
    </x-app-main>
</x-app-layout>
