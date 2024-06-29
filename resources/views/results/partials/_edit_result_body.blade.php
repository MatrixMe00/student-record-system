<h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
    {{ __($program->name.' result list') }}
</h1>

<form class="grid grid-cols-1 gap-6 mt-8 border p-4"
    method="POST" action="{{ route($grades->count() > 0 ? 'grades.update' : 'grades.create') }}">
    @csrf

    @php
        $show_submit = $grades->count() > 0 || $students->count() > 0;
    @endphp

    @if ($errors->any())
        <x-input-error :messages="$errors->all()" />
    @endif

    {{-- default items --}}
    @include('results.partials._result_body_defaults')

    @if (!$show_submit)
        <p class="p-4 text-center">
            {{ __("No Student data was found for this class") }}
        </p>
    @elseif ($grades->count() > 0)
        @method("PUT")
        <p class="text-sm text-center text-red-500">Please provide your raw marks. Clicking a field will show its original value</p>

        {{-- table with grades --}}
        @include('results.partials._result_body_grades')
    @else
        <p class="text-sm text-center text-red-500">Please provide your raw marks. Clicking a field will show its original value</p>
        {{-- table with new student data --}}
        @include('results.partials._new_result_body')
    @endif

    @if ($show_submit && !$is_admin)
        {{-- submissions for teacher --}}
        @include("results.partials._teacher_buttons")

    @elseif ($is_admin)
        {{-- submission buttons for admin --}}
        @include("results.partials._admin_buttons")
    @endif
</form>
