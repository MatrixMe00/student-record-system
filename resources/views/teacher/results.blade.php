<section class="">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'add_result')"
        type="button">
        {{ __("Make New Entry") }}
    </x-primary-button>
</section>

@session('success')
    <x-session-message class="mb-2">
        {{ __(session('message')) }}
    </x-session-message>
@endsession

<section>
    @if ($result_slips->count() > 0)
        <x-content-grid class="mt-6">
            @foreach ($result_slips as $result)
                @php
                    $extras = [
                        ["title" => "Recorded", "content" => "{$result->grades->count()} Students"],
                        // ["title" => "Teachers Teaching", "content" => $subject->teachers->count()]
                    ];
                @endphp
                <x-content-card class="bg-white hover:bg-neutral-50" title="{{ $result->program->name }}" item_id="{{ $result->result_token }}"
                        sub_title="{{ __(ucfirst($result->status)) }}" path_head="result" :extras="$extras"
                        :editable="in_array($result->status, ['pending', 'rejected'])" :removable="in_array($result->status, ['pending', 'rejected'])" />
            @endforeach
        </x-content-grid>
    @else
        <x-empty-div>{{ __("No Results found on your account") }}</x-empty-div>
    @endif
</section>

<x-modal name="add_result" :show="$errors->any()">
    @include("results._createform")
</x-modal>
