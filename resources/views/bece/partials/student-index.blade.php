@if ($jhs_valid)
    <section class="mt-2 space-y-2">
        <x-section-component title="BECE Index Number" sub_title="{{ $student->index_number ?? 'Index Number not set' }}"></x-section-component>
        <x-section-component title=""></x-section-component>
    </section>
@else
    <x-empty-div>{{ __("You are not a qualified BECE candidate") }}</x-empty-div>
@endif
