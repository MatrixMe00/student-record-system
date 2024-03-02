<section>
    @if ($results->count() > 0)
        {{ "I have results" }}
    @else
        <x-empty-div>{{ __("You have no results uploaded") }}</x-empty-div>
    @endif
</section>
