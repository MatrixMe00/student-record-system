<x-app-layout>
    <x-slot name="header">
        <x-app-header>School Management</x-app-header>
    </x-slot>

    @section("title", "School Management")

    <x-app-main class="mt-4">
        <x-content-grid>
            @if ($schools)
                @foreach ($schools as $school)
                    @php
                        $extras = [
                            ["title" => "Students","content" => round_number($school->students->count())],
                            ["title" => "Teachers","content" => round_number($school->teachers->count())],
                            ["title" => "Type","content" => ucfirst($school->school_type)],
                            ["title" => "Head Name","content" => $school->school_head],
                            ["title" => "Joined on","content" => date("M d, Y", strtotime($school->created_at))]
                        ];

                        $buttons = [
                            [
                                "class" => "", "title" => $school->status ? "Deactivate School" : "Activate School", "url" => route("school.status-change", ["school" => $school->id]),
                                "name" => $school->status ? "Deactivate" : "Activate"
                            ],
                            [
                                "class" => "school-delete-btn text-red-500 hover:text-red-600", "title" => "Delete", "modal" => ["name" => "delete-school"],
                                "attributes" => ["data-id" => $school->id], "name" => "Delete"
                            ]
                        ];
                    @endphp
                    <x-content-card
                        class="shadow hover:shadow-lg bg-slate-50 hover:bg-white"
                        title="{{ __($school->school_name) }}"
                        sub_title="{{ __($school->school_slug ?? 'No Slogan') }}"
                        item_id="{{ $school->id }}"
                        avatar_url="{{ asset('storage/'.$school->logo_path) }}"
                        removable="0"
                        editable="0" :card_to_view="true"
                        :extras="$extras"
                        :content="$school->description"
                        view_text="Enter" :buttons="$buttons"
                        :card_link="route('school.menu', ['school_id' => $school->protected_id])"
                    />
                @endforeach

                <x-modal name="delete-school" :show="false">
                    @include("superadmin.partials._school_delete")
                </x-modal>

                @push("scripts")
                    <x-jquery-dispatch />
                    <script>
                        $(document).ready(function(){
                            $(".school-delete-btn").click(function(){
                                const school_id = $(this).attr("data-id");
                                $("#modal_school_id").val(school_id);
                            })
                        })
                    </script>
                @endpush

            @else
                <x-empty-div>{{ __("No Schools have been registered yet") }}</x-empty-div>
            @endif
        </x-content-grid>
    </x-app-main>
</x-app-layout>
