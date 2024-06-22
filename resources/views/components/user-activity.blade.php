@props([
    "title", "logs", "subtitle" => "", "is_admin" => false,
    "summary" => false, "dev" => false, "show_name" => false, "class" => "",
    "title_href" => "javascript:void(0)"
])

<x-section-component :title="$title" :sub_title="$subtitle" title_link="See More" :title_href="$title_href" class="shadow-md rounded {{ $class }}">
    @if ($logs->count() > 0)
        <x-log-container class="mt-4">
            @php
                $user_id = auth()->user()->id;
            @endphp
            @foreach ($logs as $activity)
                <x-log-element :activity="$activity"
                    :user_id="$user_id" :show_name="$show_name"
                    :is_admin="$is_admin" :summary="$summary"
                    :dev="$dev" :show_name="$show_name"
                />
            @endforeach
        </x-log-container>
    @else
        <x-empty-div>{{ __("No Activity log to display") }}</x-empty-div>
    @endif
</x-section-component>
