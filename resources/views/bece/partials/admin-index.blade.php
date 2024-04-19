<section class="mt-4">
    @if ($students->count() != $current_candidates)
        <form action="{{ route('candidates.create') }}" method="POST">
            @csrf
            <x-primary-button
                title="This makes current JHS3 students BECE candidates "
                type="submit">
                {{ __("Prepare Candidates") }}
            </x-primary-button>
        </form>
    @endif
</section>

@php
    $current_tab = $tags[0]["id"];

    if(session('type') == "bece"){

    }if($errors->any() || session('type') == "debt"){
        $current_tab = $tags[1]["id"];
    }
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
</section>
