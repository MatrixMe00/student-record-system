<h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
    {{ __($program->name.' result summary list') }}
</h1>

<form class="grid grid-cols-1 gap-6 mt-8 border p-4"
    method="POST" action="">
    @csrf

    @php
        $show_submit = $remarks->count() > 0 || $student_marks->count() > 0;
    @endphp

    @if ($errors->any())
        <x-input-error :messages="$errors->all()" />
    @endif

    {{-- default items --}}
    @include('remarks.partials._remark_body_defaults')

    @if (!$show_submit)
        <p class="p-4 text-center">
            {{ __("No Student data was found for this class") }}
        </p>
    @elseif ($remarks->count() > 0)
        @method("PUT")

        {{-- table with grades --}}
        @include('remarks.partials._remark_body_grades')
    @else
        {{-- table with new student data --}}
        @include('remarks.partials._new_remark_body')
    @endif

    @if ($show_submit && !$is_admin)
        {{-- submissions for teacher --}}
        @include("results.partials._teacher_buttons")

    @elseif ($is_admin)
        {{-- submission buttons for admin --}}
        @include("results.partials._admin_buttons")
    @endif
</form>
