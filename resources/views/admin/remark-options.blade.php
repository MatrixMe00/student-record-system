<x-app-layout>
    <x-slot name="header">
        <x-app-header>Edit Remark Options</x-app-header>
    </x-slot>

    @section("title", "Remark Options")

    <x-app-main>
        <x-session-component />

        <x-form-container>
            @section("main-title", "Format Remark Options")
            @section("sub-title", "Create or remove remark options for remark allocation to results by class teachers")

            <x-form-element action="" method="POST">
                @csrf

                <div class="md:col-span-2 bg-zinc-50 py-4">
                    <x-table-component title="Class Remark Options">
                        @section("thead")
                            <thead>
                                <tr>
                                    <x-thead-data>Remark</x-thead-data>
                                    <x-thead-data></x-thead-data>
                                </tr>
                            </thead>
                        @endsection

                        {{-- defaults --}}
                        <x-text-input name="admin_id" :value="auth()->user()?->id" type="hidden" />
                        <x-text-input name="school_id" :value="session('school_id')" type="hidden" />

                        @section("button")
                            <x-primary-button type="button" @click="addBlock()">
                                Add New Option
                            </x-primary-button>
                        @endsection

                        {{-- table body --}}
                        <tbody>
                            @php
                                $key = 0;
                            @endphp
                            @if ($remarks->count() > 0 && !old('remark'))
                                @foreach ($remarks as $remark)
                                    <tr>
                                        <x-table-data>
                                            <x-text-input name="remark[]" placeholder="Remark" :value="old('remark.'.$key, $remark->remark)" />
                                            <x-text-input type="hidden" name="id[]" :value="old('id.'.$key, $remark->id)" />
                                        </x-table-data>
                                        <x-table-data>
                                            <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement($(this), {{ $remark->id }})"></i>
                                        </x-table-data>
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            @endif

                            @if (old("remark"))
                                @foreach (old("remark") as $remark)
                                    <tr>
                                        <x-table-data>
                                            <x-text-input name="remark[]" placeholder="Remark" :value="$remark" />
                                        </x-table-data>
                                        <x-text-input type="hidden" name="id[]" :value="old('id.'.$key)" />
                                        <x-table-data>
                                            <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="remPar()"></i>
                                        </x-table-data>
                                    </tr>
                                    @php
                                        $key++;
                                    @endphp
                                @endforeach
                            @endif

                            <template>
                                <tr>
                                    <x-table-data>
                                        <x-text-input name="remark[]" placeholder="Remark" x-model="item" />
                                    </x-table-data>
                                    <x-text-input type="hidden" name="id[]" value="0" />
                                    <x-table-data>
                                        <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" @click="remPar()"></i>
                                    </x-table-data>
                                </tr>
                            </template>
                        </tbody>
                    </x-table-component>
                </div>

                <x-form-button-container>
                    <x-form-submit-button>Submit</x-form-submit-button>
                </x-form-button-container>
            </x-form-element>

            @push("scripts")
                <script>
                    function addBlock(){
                        $("tbody").append($("template").html());
                    }
                    function remPar(){
                        element = event.target;
                        $(element).parents("tr").remove();
                    }

                    function removeElement(element, id){
                        $.ajax({
                            url: "/remark/options/delete/" + id,
                            success: function(response){
                                if(response == true){
                                    $(element).parents('tr').remove();
                                }else{
                                    alert("assignment could not be removed")
                                }
                            },
                            error: function(xhr){
                                console.log(xhr);
                                alert("An error occured. Check logs");
                            }
                        })
                    }
                </script>
            @endpush
        </x-form-container>
    </x-app-main>
</x-app-layout>
