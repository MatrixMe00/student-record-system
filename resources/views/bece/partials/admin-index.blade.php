<section class="mt-4">
    @if ($students->count() != $current_candidates)
        <x-primary-button
            {{-- onclick="" --}}
            title="This makes current JHS3 students BECE candidates "
            type="button">
            {{ __("Prepare Candidates") }}
        </x-primary-button>
    @endif
</section>

@php
    $current_tab = $tags[2]["id"];
    $current_tab = $errors->any() || session('success') ? $tags[1]["id"] : $current_tab;
@endphp

<section class="space-y-8 py-4" x-data="{tag:'{{ $current_tab }}'}" x-cloak="">
    <x-group-buttons-container class="sticky top-2 mx-auto w-full">
        @foreach ($tags as $tag)
            <x-group-button :icon="$icons[$tag['id']]" text="{{ $tag['name'] }}" :first="$loop->first" :last="$loop->last" @click="tag='{{ $tag['id'] }}'" />
        @endforeach
    </x-group-buttons-container>

    <x-section-component title="JHS3 Students" x-show="tag=='jhs3'">
        @include('bece.partials.jhs-partial')
    </x-section-component>

    <x-section-component title="Debtors List" x-show="tag=='debt'">
        @include('bece.partials.debt-partial')
    </x-section-component>

    <x-section-component title="BECE Candidates" x-show="tag=='bece'">
        @include('bece.partials.bece-partial')
    </x-section-component>

    {{-- @foreach ($result_slips as $result_slip)
        <x-section-component :title="$result_slip['title']" x-show="tag=='{{ $result_slip['id'] }}'">
            @if ($result_slip["data"]->count() > 0)
                <x-content-grid class="mt-6">
                    @foreach ($result_slip["data"] as $result)
                        @php
                            $extras = [
                                ["title" => "Recorded", "content" => "{$result->grades->count()} Students"],
                                ["title" => "Subject", "content" => $result->subject->name ?? "Not Set"],
                                ["title" => "Academic Year", "content" => get_academic_year($result->created_at)]
                            ];
                        @endphp
                        <x-content-card class="border-neutral-200 hover:bg-neutral-50 hover:border-neutral-100" title="{{ $result->program->name }}" item_id="{{ $result->result_token }}"
                                sub_title="{{ __(ucfirst($result->status).' | Term '.$result->semester) }}" path_head="result" :extras="$extras"
                                :editable="false" :removable="in_array($result->status, ['pending', 'rejected'])"
                                card_link="/result/{{ $result->result_token }}/show" />
                    @endforeach
                </x-content-grid>
            @else
                <x-empty-div>{{ __("No Results for this section") }}</x-empty-div>
            @endif
        </x-section-component>
    @endforeach --}}
</section>
