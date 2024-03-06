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
            @foreach($grades as $key => $grade)
                <x-result-entry-row
                    :student="$grade->student" :key="$key"
                    :classmark="old('class_mark.'.$key, $grade->class_mark)"
                    :exammark="old('exam_mark.'.$key, $grade->exam_mark)"
                    :rowid="$grade->id"
                    :readonly="$is_admin"
                />
            @endforeach

            {{-- if new students have been added to the class --}}
            @if ($unsaved->count() > 0 && $result->status == "pending")
                @foreach($unsaved as $key => $student)
                    <x-result-entry-row
                        :student="$student" :key="$key"
                        :classmark="old('class_mark.'.$key, 0)"
                        :exammark="old('exam_mark.'.$key, 0)"
                        painttd="border-teal-400"
                    />
                @endforeach
            @endif
        </tbody>
    </table>
</div>