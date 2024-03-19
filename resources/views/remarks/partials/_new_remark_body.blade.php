<div class="overflow-auto py-4">
    <table class="w-full">
        <thead>
            <tr>
                <th>Index Number</th>
                <th>Fullname</th>
                <th>Total Score</th>
                <th>Attendance</th>
                <th>Position</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student_marks as $student)
                <x-remark-entry-row
                    :student="$student['student']" :key="$loop->index"
                    :totalmark="old('class_mark.'.$loop->index, $student['total'])"
                    :total_studs="count($student_marks)"
                    :remarks="$remark_options->toArray()"
                />
            @endforeach
        </tbody>
    </table>
</div>
