<x-guest-layout :showLogo="false">
    @section('title', $page_title)
    <!-- component -->
    @if (isset($role_id))
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

    @elseif (isset($admin_id))
        @include("auth.partials._school")
    @else
        {{ "There is nothing to show" }}
    @endif

</x-guest-layout>
