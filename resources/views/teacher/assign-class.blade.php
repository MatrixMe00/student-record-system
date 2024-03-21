<x-app-layout>
    <x-slot name="header">
        <x-app-header>{{ "Assign Subject Teacher" }} {{ $teacher ? "[{$teacher->lname}]":"" }}</x-app-header>
    </x-slot>

    @section("title", "Subject Assign")

    <x-app-main class="py-4">
        <div class="flex bg-zinc-50 items-center w-full p-8 mx-auto lg:px-12">
            <div class="w-full">
                <h1 class="text-2xl font-semibold tracking-wider text-gray-800 capitalize dark:text-white">
                    Assign Subjects
                </h1>

                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Use this form to assign subjects to a teacher
                </p>

                @php
                    $abled = empty($teacher_id) ? true : false
                @endphp

                <x-session-component />
                @if ($errors->any())
                    <x-input-error :messages="$errors->all()" />
                @endif

                <form class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"
                    method="POST" action="{{ route('teacher.assign-subject') }}">
                    @csrf

                    @if ($abled)
                        {{-- teacher_id --}}
                        <div>
                            <x-input-label for="teacher_id" :value="__('Subject Teacher')" />
                            <x-input-select :options="$teachers->toArray()" default="Select A Teacher" name="teacher_id" id="teacher_id" :value="old('teacher_id', $teacher_id)" :abled="$abled" :text_key="['lname', 'oname']" value_key="user_id" />
                            <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                        </div>

                        <x-text-input type="hidden" name="proceed" value="1" />
                    @else
                        {{-- teacher_id --}}
                        <div>
                            <x-input-label for="teacher_id" :value="__('Subject Teacher')" />
                            <x-text-input id="teacher_id" :value="$teacher->lname.' '.$teacher->oname" readonly />
                            <x-text-input type="hidden" name="teacher_id" value="{{ $teacher->user_id }}" />
                            <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                        </div>
                        <div class="md:col-span-2 bg-zinc-50 py-4">
                            <x-table-component title="Teacher Subjects">
                                @section("thead")
                                    <thead>
                                        <tr>
                                            <x-thead-data>Class</x-thead-data>
                                            <x-thead-data>Subject</x-thead-data>
                                            <x-thead-data></x-thead-data>
                                        </tr>
                                    </thead>
                                @endsection

                                @section("button")
                                    <x-primary-button type="button" @click="addBlock()">
                                        Add A Field
                                    </x-primary-button>
                                @endsection

                                {{-- table body --}}
                                <tbody>
                                    @if (!$abled && $teacher->classes->count() > 0)
                                        @foreach ($teacher->classes as $class)
                                            <tr>
                                                <x-table-data>
                                                    <x-input-select :options="$classes" name="program_id[]" :value="$class->program_id" />
                                                </x-table-data>
                                                <x-table-data>
                                                    <x-input-select :options="$subjects" name="subject_id[]" :value="$class->subject_id" />
                                                </x-table-data>
                                                <x-text-input type="hidden" name="id[]" :value="$class->id" />
                                                <x-table-data>
                                                    <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="removeElement($(this), {{ $class->id }})"></i>
                                                </x-table-data>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if (old("program_id"))
                                        @foreach (old("program_id") as $key => $program_id)
                                            <tr>
                                                <x-table-data>
                                                    <x-input-select :options="$classes" name="program_id[]" :value="$program_id" />
                                                </x-table-data>
                                                <x-table-data>
                                                    <x-input-select :options="$subjects" name="subject_id[]" :value="old('subject_id.'.$key)" />
                                                </x-table-data>
                                                <x-text-input type="hidden" name="id[]" :value="old('id.'.$key)" />
                                                <x-table-data>
                                                    <i title="Remove Field" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer hover:text-red-600" onclick="$(this).parents('tr').remove()"></i>
                                                </x-table-data>
                                            </tr>
                                        @endforeach
                                    @endif

                                    <template>
                                        <tr>
                                            <x-table-data>
                                                <x-input-select :options="$classes" name="program_id[]" />
                                            </x-table-data>
                                            <x-table-data>
                                                <x-input-select :options="$subjects" name="subject_id[]" />
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
                                        url: "/teacher/assign-delete/" + id,
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
                    @endif

                    <div class="md:col-span-2">
                        <button type="submit"
                            class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
                                tracking-wide text-white capitalize group transform bg-blue-500 rounded-md
                                hover:bg-blue-400 focus:outline-none focus:ring focus:ring-blue-300
                                focus:ring-opacity-50">
                            <span>{{ __($abled ? "Proceed" : "Assign Subjects") }}</span>
                            <i class="fas fa-angle-right group-hover:mr-2 transition-all duration-500"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-app-main>
</x-app-layout>
