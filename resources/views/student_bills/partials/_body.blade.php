<x-table-component btn_text="Add Field" title=" " btnaction="addBlock()" >
    @section("thead")
        <thead>
            <x-thead-data>Index Number</x-thead-data>
            <x-thead-data>Fullname</x-thead-data>
            <x-thead-data>Amount (GHC)</x-thead-data>
            <x-thead-data></x-thead-data>
        </thead>
    @endsection

    <tbody>
        @if (old('id'))
            @foreach (old('id') as $key => $item)
                @php
                    $id = $item; $fullname = old('fullname.'.$key);
                    $index_number = old('index_number.'.$key); $amount = old('amount.'.$key);
                @endphp
                <tr class="{{ $id == 0 ? 'bg-red-200' : '' }}">
                    <x-table-data>
                        <x-text-input name="id[]" value="{{ $id }}" type="hidden" />

                        @if ($id > 0)
                            <x-text-input name="index_number[]" :value="$index_number" />
                        @else
                            <x-input-select class="student_list" name="student_id[]" onchange="makeChanges()" onload="makeChanges()" :options="0" >
                                <option value="">Select a student</option>
                                @foreach ($class_students as $student)
                                    <option value="{{ $student->user_id }}" data-id="{{ $student->user->username }}" {{ $index_number == $student->user->username ? 'selected' : '' }}>{{ ucwords(strtolower($student->fullname)) }}</option>
                                @endforeach
                            </x-input-select>
                            <x-text-input type="text" class="display-index hidden" value="{{ $index_number }}" readonly onfocus="showSelect()" />
                        @endif
                    </x-table-data>
                    <x-table-data class="fullname_td">
                        <x-text-input class="fullname_show" readonly :value="$fullname" />
                        <x-text-input type="hidden" name="fullname[]" class="fullname_hidden" :value="$fullname" />
                    </x-table-data>
                    <x-table-data>
                        <x-text-input name="amount[]" placeholder="0.00" :value="$amount" />
                    </x-table-data>
                    <x-table-data>
                        <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement({{ $id }})"></i>
                    </x-table-data>
                </tr>
            @endforeach
        @else
            @foreach ($students as $student)
                @php
                    $stud = $student->student;
                @endphp
                <tr>
                    <x-table-data>
                        <x-text-input name="index_number[]" :value="$stud->user->username" readonly />
                        <x-text-input type="hidden" name="id[]" :value="$student->id" />
                        <x-text-input type="hidden" name="student_id[]" :value="$stud->user_id" />
                    </x-table-data>
                    <x-table-data>
                        <x-text-input class="fullname_show" readonly name="fullname[]" :value="$stud->fullname" />
                    </x-table-data>
                    <x-table-data>
                        <x-text-input name="amount[]" :value="$student->amount" placeholder="0.00" />
                    </x-table-data>
                    <x-table-data>
                        <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement({{ $student->id }})"></i>
                    </x-table-data>
                </tr>
            @endforeach
        @endif
    </tbody>
</x-table-component>

<template>
    <tr>
        <x-table-data>
            <x-text-input name="id[]" value="0" type="hidden" />
            <x-input-select class="student_list" name="student_id[]" onchange="makeChanges()" onload="makeChanges()" :options="0" >
                <option value="">Select a student</option>
                @foreach ($class_students as $student)
                    <option value="{{ $student->user_id }}" data-id="{{ $student->user->username }}">{{ ucwords(strtolower($student->fullname)) }}</option>
                @endforeach
            </x-input-select>
            <x-text-input type="text" name="index_number[]" class="display-index hidden" value="" readonly onfocus="showSelect()" />
        </x-table-data>
        <x-table-data class="fullname_td">
            <x-text-input class="fullname_show" readonly />
            <x-text-input type="hidden" name="fullname[]" class="fullname_hidden" />
        </x-table-data>
        <x-table-data>
            <x-text-input name="amount[]" placeholder="0.00" />
        </x-table-data>
        <x-table-data>
            <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement(0)"></i>
        </x-table-data>
    </tr>
</template>

<x-form-button-container class="md:col-span-1">
    <x-form-submit-button id="submit_btn">Save</x-submit-button>
</x-form-button-container>


@push("scripts")
    <script>
        function addBlock(){
            $("tbody").prepend($("template").html());
            show_submit();
        }

        function removeElement(id){
            const element = event.target;
            if(id == 0){
                $(element).parents("tr").remove();
            }else{
                const csrf = $("form").find("input[name=_token]").val();
                // perform an ajax request
                $.ajax({
                    url: "/student-debt/" + id + "/remove",
                    method: "DELETE",
                    data: {_token:csrf},
                    success: function(response){
                        if(response == true){
                            $(element).parents("tr").remove();
                        }else{
                            alert(response);
                        }
                    },
                    error: function(xhr){
                        alert("Error occured. Check console for more information");
                        console.log(xhr);
                    }
                })
            }

            show_submit();
        }

        function makeChanges(){
            const me = event.target;

            if($(me).val() != ""){
                const option = $(me).find("option:selected");
                const index_number = option.attr("data-id");
                const fullname = option.text();

                $(me).siblings(".display-index").val(index_number).removeClass("hidden");
                $(me).parent().siblings(".fullname_td").find(".fullname_show, .fullname_hidden").val(fullname);
                $(me).addClass("hidden");
            }else{
                $(me).siblings(".display-index:not(.hidden)").addClass("hidden");
            }
        }

        function showSelect(){
            const me = event.target;

            $(me).val("").addClass("hidden");
            $(me).siblings("select").removeClass("hidden");
        }

        function show_submit(){
            const total = $("tbody").children("tr").length;

            if(total > 0){
                $("#submit_btn").show();
            }else{
                $("#submit_btn").hide();
            }
        }

        $(document).ready(function(){
            $(".debt-select").on({
                change: makeChanges()
            });
            show_submit();
        })
    </script>
@endpush
