<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ __("Candidate Data") }}</x-app-header>
    </x-slot>

    @section("title", "Candidate Data")

    <x-app-main>
        <x-session-component />

        <x-form-container maintitle="Data For {{ $student->fullname }}">
            <x-form-element method="POST" enctype="multipart/form-data" action="{{ route('school.candidate.update', ['beceCandidate' => $candidate->id]) }}">
                @method("PUT")
                {{-- display full name --}}
                <div>
                    <x-input-label for="vale">{{ _(("Full Name")) }}</x-input-label>
                    <x-text-input name="vale" id="vale" placeholder="" readonly :value="$student->fullname" />
                    <x-input-error :messages="$errors->get('vale')" class="mt-2" />
                </div>

                {{-- index number --}}
                <div>
                    <x-input-label for="index_number">{{ _(("Index Number")) }}</x-input-label>
                    <x-text-input name="index_number" id="index_number" placeholder="Index Number" :readonly="$editable && $candidate->status == false" :value="old('index_number')" />
                    <x-input-error :messages="$errors->get('index_number')" class="mt-2" />
                </div>

                {{-- results file --}}
                <div>
                    <x-input-label for="bece_result">{{ _(("BECE Result")) }}</x-input-label>
                    <x-text-input type="file" accept="application/pdf" name="bece_result" id="bece_result" readonly :value="old('bece_result', $candidate->placement['bece_result'] ?? '')" />
                    <x-input-error :messages="$errors->get('bece_result')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="placement_school">{{ _(("Placement School")) }}</x-input-label>
                    <x-text-input name="placement_school" id="placement_school" placeholder="Placement School" :readonly="$editable && $candidate->status == false" :value="old('placement_school', $candidate->placement['placement_school'] ?? '')" />
                    <x-input-error :messages="$errors->get('placement_school')" class="mt-2" />
                </div>

                @if ($editable && $candidate->status)
                    <x-form-button-container>
                        <x-form-submit-button icon="far fa-save text-xl">Save Changes</x-form-submit-button>
                    </x-form-button-container>
                @endif
            </x-form-element>
        </x-form-container>

        @if ($candidate->placement)
            <section class="bg-white mt-2">
                @component('components.school.attachment-container')
                    @slot('download_link', url('storage/'.$candidate->placement["bece_result"]))
                    <p>Result File for {{ $candidate->index_number }}</p>
                @endcomponent
            </section>
        @else
            <x-empty-div>No files attached to this account</x-empty-div>
        @endif

    </x-app-main>
</x-app-layout>
