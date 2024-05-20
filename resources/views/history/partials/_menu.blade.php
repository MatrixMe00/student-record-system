@if (auth()->user()->role_id < 3)
    @include("history.partials._superadmin-menu")
@else
    @include("history.partials._admin-menu")
@endif
