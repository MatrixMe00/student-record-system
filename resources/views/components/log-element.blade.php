@props(["activity", "is_admin" => false, "summary" => false, "dev" => false, "show_name" => false, "user_id" => 0])

@php
    $owner = $activity->user;
@endphp

<li class="mb-3 ms-6" title="{{ $activity->created_at }}">
    <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
        {{-- <img class="rounded-full shadow-lg" src="/docs/images/people/profile-picture-5.jpg" alt="Thomas Lean image"/> --}}
        <i class="{{ activity_log_icon($activity->activity_type) }}"></i>
    </span>
    <div class="p-4 {{ $activity->is_error ? 'bg-red-100' : 'bg-white' }} border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
        @if ($show_name && $owner->id != $user_id)
            <p class="text-xs {{ $activity->is_error ? 'text-gray-600' : 'text-gray-500' }}">{{ $owner->username }}</p>
        @elseif ($show_name && $is_admin)
            <p class="text-xs {{ $activity->is_error ? 'text-gray-600' : 'text-gray-500' }}">{{ __("You") }}</p>
        @endif
        <div class="items-center justify-between sm:flex">
            <time class="mb-1 text-xs font-normal {{ $activity->is_error ? 'text-gray-700' : 'text-gray-400' }} sm:order-last sm:mb-0">{{ time_difference($activity->created_at) }} ago</time>
            {{-- <div class="text-sm font-normal {{ $activity->is_error ? 'text-gray-700' : 'text-gray-500' }} lex dark:text-gray-300">Thomas Lean commented on  <a href="#" class="font-semibold text-gray-900 dark:text-white hover:underline">Flowbite Pro</a></div> --}}
            <div class="text-sm font-normal {{ $activity->is_error ? 'text-gray-700' : 'text-gray-400' }} lex dark:text-gray-300">{{ __($activity->message) }}</div>
        </div>
        @if ($summary && !empty($activity))
            <div class="p-3 text-xs italic font-normal text-gray-500 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300">

            </div>
        @endif
    </div>
</li>
