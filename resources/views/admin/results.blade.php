<section class="">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'add_result')"
        type="button">
        {{ __("Make New Entry") }}
    </x-primary-button>
</section>

<x-session-component />

@php
    $tags = array_keys($result_slips->toArray());
    $icons = [
        "pending" => "far fa-edit", "submitted" => "fas fa-check",
        "rejected" => "far fa-thumbs-down", "accepted" => "far fa-thumbs-up"
    ];
@endphp

<section class="space-y-8 py-4" x-data="{tag:'{{ $tags[0] ?? '' }}'}" x-cloak="">
    @if (count($tags) > 0)
        <x-group-buttons-container class="sticky top-2 mx-auto w-full">
            @foreach ($tags as $tag)
                <x-group-button :icon="$icons[$tag]" text="{{ $tag }}" :first="$loop->first" :last="$loop->last" @click="tag='{{ $tag }}'" />
            @endforeach
        </x-group-buttons-container>

        @foreach ($result_slips as $result_slip)
            <x-section-component :title="ucwords($result_slip['title'])" x-show="tag=='{{ $result_slip['id'] }}'">
                @if ($result_slip["data"]->count() > 0)
                    <x-content-grid class="mt-6">
                        @foreach ($result_slip["data"] as $result)
                            @php
                                $extras = [
                                    ["title" => "Recorded", "content" => "{$result->grades->count()} Students"],
                                    ["title" => "Subject", "content" => $result->subject->name ?? "Not Set"],
                                    ["title" => "Academic Year", "content" => $result->academic_year]
                                ];
                            @endphp
                            <x-content-card class="border-neutral-200 hover:bg-neutral-50 hover:border-neutral-100" title="{{ $result->program->name }}" item_id="{{ $result->result_token }}"
                                    sub_title="{{ __(ucfirst($result->status).' | Term '.$result->semester) }}" path_head="result" :extras="$extras"
                                    :editable="false" :removable="in_array($result->status, ['pending', 'rejected'])" />
                        @endforeach
                    </x-content-grid>
                @else
                    <x-empty-div>{{ __("No Results for this section") }}</x-empty-div>
                @endif
            </x-section-component>
        @endforeach
    @else
        <x-empty-div>{{ __("No Results found on your account") }}</x-empty-div>
    @endif
</section>
