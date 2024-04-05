<section>
    @if ($results->count() > 0)
        <x-content-grid class="mt-6">
            @foreach ($results as $result)
                @php
                    $extras = [
                        ["title" => "Academic Year", "content" => get_academic_year($result->created_at)]
                    ];
                @endphp
                <x-content-card class="bg-white hover:bg-neutral-50" title="{{ $result->program->name }}" item_id="{{ $result->program_id }}"
                        path_head="my-result" :extras="$extras"
                        :editable="false" :removable="false"
                        card_link="{{ $result->status != 'pending' && $active_payment ? 'my-result/'.$result->program_id : 'javascript:void(0)' }}" />
            @endforeach
        </x-content-grid>
    @else
        <x-empty-div>{{ __("You have no results uploaded") }}</x-empty-div>
    @endif
</section>
