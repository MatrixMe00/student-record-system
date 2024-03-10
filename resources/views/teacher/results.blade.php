<section class="">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'add_result')"
        type="button">
        {{ __("Make New Entry") }}
    </x-primary-button>
</section>

<x-session-component />

<section>
    @if ($result_slips->count() > 0)
        <x-content-grid class="mt-6">
            @foreach ($result_slips as $result)
                @php
                    $extras = [
                        ["title" => "Recorded", "content" => "{$result->grades->count()} Students"],
                        ["title" => "Subject", "content" => $result->subject->name ?? "Not Set"],
                        ["title" => "Academic Year", "content" => get_academic_year($result->created_at)]
                    ];
                @endphp
                <x-content-card class="bg-white hover:bg-neutral-50" title="{{ $result->program->name }}" item_id="{{ $result->result_token }}"
                        sub_title="{{ __('Term '.$result->semester.' | '.ucfirst($result->status)) }}" path_head="result" :extras="$extras"
                        :editable="in_array($result->status, ['pending', 'rejected'])" :removable="in_array($result->status, ['pending', 'rejected'])"
                        card_link="{{ $result->status != 'pending' ? 'result/'.$result->result_token.'/show' : 'javascript:void(0)' }}" />
            @endforeach
        </x-content-grid>
    @else
        <x-empty-div>{{ __("No Results found on your account") }}</x-empty-div>
    @endif
</section>

<x-modal name="add_result" :show="$errors->any()">
    @include("results._createform")
</x-modal>
