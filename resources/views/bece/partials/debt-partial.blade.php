@php
    $thead = [
        "Student ID No.", "Lastname", "Othername", "Amount (GHC)", ""
    ];
@endphp

<x-form-container padding="p-2" :showErrors="false">
    <x-session-component />

    <x-form-element mdcols="" method="post" action="{{ route('debtlist.store') }}">
        <x-text-input name="school_id" value="{{ session('school_id') }}" type="hidden" />
        <x-table-component class="mt-3" :thead="$thead" btn_text="Add Student" title=" " btnaction="addStudent()">
            <tbody id="debt-tbody">
                @php
                    $key = 0;
                @endphp
                @foreach ($debtors as $debtor)
                    <tr>
                        <x-table-data>{{ __($debtor->student->user->username) }}</x-table-data>
                        <x-table-data>
                            <input type="hidden" name="id[]" value="{{ $debtor->id }}">
                            <span>{{ $debtor->student->lname }}</span>
                        </x-table-data>
                        <x-table-data>{{ __($debtor->student->oname) }}</x-table-data>
                        <x-table-data>
                            <x-text-input type="text" name="amount[]" :value="old('amount.'.$key, number_format($debtor->amount, 2))" />
                            <x-input-error :messages="$errors->get('amount.'.$key)" class="mt-2" />
                        </x-table-data>
                        <x-table-data>
                            <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement({{ $debtor->id }})"></i>
                        </x-table-data>
                    </tr>
                    @php
                        ++$key;
                    @endphp
                @endforeach

                @if (old('student_id'))
                    @foreach (old('student_id') as $pos => $amount)
                        <tr>
                            <x-table-data>
                                <input type="hidden" name="id[]" value="0">
                                <x-input-select class="debt-select" name="student_id[]" onchange="makeChanges()" onload="makeChanges()" onmouseout="makeChanges()" :options="0">
                                    <option value="">Select a student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->user_id }}" data-id="{{ $student->user->username }}"
                                            @if (old('student_id.'.$pos) == $student->user_id)
                                                selected
                                            @endif
                                        >{{ ucwords("$student->lname $student->oname") }}</option>
                                    @endforeach
                                </x-input-select>
                                <x-text-input type="text" class="display-index hidden" :value="old('student_id'.$pos)" readonly onfocus="showSelect()" />
                                <x-input-error :messages="$errors->get('student_id.'.$pos)" class="mt-2" />
                            </x-table-data>
                            <x-table-data class="lname"></x-table-data>
                            <x-table-data class="oname"></x-table-data>
                            <x-table-data>
                                <x-text-input type="text" name="amount[]" :value="old('amount.'.$key)" />
                                <x-input-error :messages="$errors->get('amount.'.$key)" class="mt-2" />
                            </x-table-data>
                            <x-table-data>
                                <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement(0)"></i>
                            </x-table-data>
                        </tr>
                        @php
                            ++$key;
                        @endphp
                    @endforeach
                @endif
            </tbody>

            <template id="debt-template">
                <tr>
                    <x-table-data>
                        <input type="hidden" name="id[]" value="0">
                        <x-input-select class="debt-select" name="student_id[]" onchange="makeChanges()" onload="makeChanges()" :options="0">
                            <option value="">Select a student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->user_id }}" data-id="{{ $student->user->username }}">{{ ucwords("$student->lname $student->oname") }}</option>
                            @endforeach
                        </x-input-select>
                        <x-text-input type="text" class="display-index hidden" value="" readonly onfocus="showSelect()" />
                    </x-table-data>
                    <x-table-data class="lname"></x-table-data>
                    <x-table-data class="oname"></x-table-data>
                    <x-table-data>
                        <x-text-input name="amount[]" value="0" />
                    </x-table-data>
                    <x-table-data>
                        <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement(0)"></i>
                    </x-table-data>
                </tr>
            </template>
        </x-table-component>

        <x-form-button-container>
            <x-form-submit-button id="debt-submit">
                Update List
            </x-form-submit-button>
        </x-form-button-container>
    </x-form-element>
</x-form-container>

<script>
    $(document).ready(function(){
        $(".debt-select").on({
            change: makeChanges()
        });
        show_submit();
    })

    function removeElement(id){
        const me = event.target;
        if(id == 0){
            $(me).parents("tr").remove();
        }else{
            // perform an ajax request
            $.ajax({
                url: "/debt/" + id + "/remove",
                success: function(response){
                    if(response == true){
                        $(me).parents("tr").remove();
                    }
                }
            })
        }

        show_submit();
    }

    function addStudent(){
        $("#debt-tbody").append($("template#debt-template").html());
        show_submit();
    }

    function makeChanges(){
        const me = event.target;

        if($(me).val() != ""){
            const option = $(me).find("option:selected");
            const index_number = option.attr("data-id");
            const space_index = option.text().indexOf(" ");
            const lname = option.text().substr(0,(space_index + 1));
            const oname = option.text().substr(space_index + 1);

            $(me).siblings(".display-index").val(index_number).removeClass("hidden");
            $(me).parent().siblings(".lname").html(lname);
            $(me).parent().siblings(".oname").html(oname);
            $(me).addClass("hidden");
        }else{
            $(me).siblings(".display-index:not(.hidden)").addClass("hidden");
        }
    }

    function showSelect(){
        const me = event.target;

        $(me).val("").addClass("hidden");
        $(me).siblings("select.debt-select").removeClass("hidden");
    }

    function show_submit(){
        const total = $("#debt-tbody").children("tr").length;

        if(total > 0){
            $("#debt-submit").show();
        }else{
            $("#debt-submit").hide();
        }
    }
</script>
