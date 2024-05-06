<x-guest-layout clas>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        @if ($is_student)
            {{ __("Forgot your password? No problem. Provide your login index number here. If you do not know the index number, provide your name and class to your school admin and he will get you the index number") }}
        @else
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        @endif
    </div>

    @if ($is_student)
    <x-session-component />
        @include('auth.partials.student-forgot-password')
    @else
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @include('auth.partials.general-forgot-password')
    @endif
</x-guest-layout>
