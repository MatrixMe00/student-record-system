<x-app-layout>
    <x-slot name="header">
        <x-app-header>Remarks</x-app-header>
    </x-slot>

    @section("title", "Remarks")

    <x-app-main class="py-4">
        <section class="">
            <x-primary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add_remark')"
                type="button">
                {{ __("Make New Entry") }}
            </x-primary-button>

            @if (auth()->user()->role_id == 3)
                <x-primary-button onclick="location.href='{{ route('remark-options') }}'">
                    Add Remark Options
                </x-primary-button>
            @endif
        </section>

        {{-- session messages --}}
        <x-session-component />

        {{-- remarks --}}
        @php
            $tags = array_keys($remarks->toArray());
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

                @foreach ($remarks as $remark)
                    <x-section-component :title="$remark['title']" x-show="tag=='{{ $remark['id'] }}'">
                        @if ($remark["data"]->count() > 0)
                            <x-content-grid class="mt-6">
                                @foreach ($remark["data"] as $result)
                                    @php
                                        $extras = [
                                            ["title" => "Recorded", "content" => "{$result->remarks->count()} Students"],
                                            ["title" => "Term", "content" => "Term $result->semester"],
                                            ["title" => "Academic Year", "content" => get_academic_year($result->created_at)]
                                        ];
                                        if(auth()->user()->role_id == 3)
                                            $sub_title = ucwords($result->teacher->lname." ".$result->teacher->oname);
                                        else
                                            $sub_title = "Term ".$result->semester;
                                    @endphp
                                    <x-content-card class="border-neutral-200 hover:bg-neutral-50 hover:border-neutral-100" title="{{ $result->program->name }}" item_id="{{ $result->result_token }}"
                                            sub_title="{{ __($sub_title) }}" path_head="result" :extras="$extras"
                                            :editable="false" :removable="in_array($result->status, ['pending', 'rejected'])"
                                            card_link="/remark/{{ $result->remark_token }}/show" />
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

        {{-- create remark form --}}
        <x-modal name="add_remark" :show="$errors->any()">
            @include("remarks._createform")
        </x-modal>

    </x-app-main>
</x-app-layout>
