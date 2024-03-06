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
            @foreach($students as $key => $student)
                <x-result-entry-row
                    :student="$student" :key="$key"
                    :classmark="old('class_mark.'.$key, 0)"
                    :exammark="old('exam_mark.'.$key, 0)"
                />
            @endforeach
        </tbody>
    </table>
</div>
