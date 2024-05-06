<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ __("Candidate Data") }}</x-app-header>
    </x-slot>

    @section("title", "Candidate Data")

    <x-app-main class="pb-6">
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
                    <x-text-input name="index_number" id="index_number" placeholder="Index Number" :readonly="$super_edit || ($candidate->status == false && $admin_edit)" :value="old('index_number', $candidate->index_number)" />
                    <x-input-error :messages="$errors->get('index_number')" class="mt-2" />
                </div>

                {{-- show if its the superadmin or if the placement has been provided --}}
                @if ($super_edit || $candidate->placement)
                    {{-- results file --}}
                    <div>
                        <x-input-label for="bece_result">{{ _(("BECE Result")) }}</x-input-label>
                        <x-text-input type="file" accept="application/pdf" name="bece_result" id="bece_result" :value="old('bece_result', $candidate->placement['bece_result'] ?? '')" :readonly="$super_edit && $candidate->status == false" />
                        <x-input-error :messages="$errors->get('bece_result')" class="mt-2" />
                    </div>

                    {{-- placement school --}}
                    <div>
                        <x-input-label for="placement_school">{{ _(("Placement School")) }}</x-input-label>
                        <x-text-input name="placement_school" type="file" accept="application/pdf" id="placement_school" placeholder="Placement School" :readonly="$super_edit && $candidate->status == false" :value="old('placement_school', $candidate->placement['placement_school'] ?? '')" />
                        <x-input-error :messages="$errors->get('placement_school')" class="mt-2" />
                    </div>

                    {{-- result checker --}}
                    <div>
                        <x-input-label for="result_checker">{{ __("Result Checker Code") }}</x-input-label>
                        <x-text-input name="result_checker" id="result_checker" placeholder="Result Checker Code" :value="old('result_checker', $candidate->result_checker)" :readonly="$super_edit && $candidate->status == false" />
                        <x-input-error :messages="$errors->get('result_checker')" class="mt-2" />
                    </div>
                @endif

                @if ($candidate->status)
                    <x-form-button-container>
                        <x-form-submit-button icon="far fa-save text-xl">Save Changes</x-form-submit-button>
                    </x-form-button-container>
                @endif
            </x-form-element>
        </x-form-container>

        @if ($candidate->placement)
            <section class="bg-white mt-2">
                @component('components.school.attachment-container')
                    @if ($candidate->placement["bece_result"])
                        @slot('download_link', url('storage/'.$candidate->placement["bece_result"]))
                        <p>Result File for {{ $candidate->index_number }}</p>
                    @else
                        <p>No result file uploaded</p>
                    @endif
                @endcomponent

                @component('components.school.attachment-container')
                    @if ($candidate->placement["placement_school"])
                        @slot('download_link', url('storage/'.$candidate->placement["placement_school"]))
                        <p>Placement File for {{ $candidate->index_number }}</p>
                    @else
                        <p>No placement file uploaded</p>
                    @endif
                @endcomponent
            </section>
        @else
            @if ($super_edit || $candidate->index_number)
                <x-empty-div>No file updates attached to this account</x-empty-div>
            @endif
        @endif

    </x-app-main>
</x-app-layout>
