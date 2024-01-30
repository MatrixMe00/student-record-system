<x-guest-layout>
    @section('title', $page_title)
    <!-- component -->
    @switch($role_id)
        @case(1)
        @case(2)
            @include("auth.partials._superadmin")
            @break
        @case(3)
            @include("auth.partials._admin")
        @break

        @default
            {{ "No form to deliver" }}
    @endswitch
</x-guest-layout>
