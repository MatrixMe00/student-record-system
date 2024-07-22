<div class="overflow-auto py-4">
    <table>
        <thead>
            <tr>
                <th>Index Number</th>
                <th>Fullname</th>
                <th>Class Score</th>
                <th>Exam Score</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            @php
                $key = 0;
            @endphp
            @foreach($grades as $grade)
                @if ($grade->student)
                    <x-result-entry-row
                        :student="$grade->student" :key="$key"
                        :classmark="old('class_mark.'.$key, $grade->class_mark)"
                        :exammark="old('exam_mark.'.$key, $grade->exam_mark)"
                        :rowid="$grade->id"
                        :readonly="$is_admin || !$edit_once"
                    />

                    @php
                        $key++;
                    @endphp
                @endif
            @endforeach

            {{-- if new students have been added to the class --}}
            @if ($unsaved->count() > 0 && $result->status == "pending")
                @foreach($unsaved as $key => $student)
                    @if ($student)
                        <x-result-entry-row
                            :student="$student" :key="$key"
                            :classmark="old('class_mark.'.$key, 0)"
                            :exammark="old('exam_mark.'.$key, 0)"
                            painttd="border-teal-400"
                            :readonly="$is_admin || !$edit_once"
                        />
                        @php
                            $key++;
                        @endphp
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
</div>
