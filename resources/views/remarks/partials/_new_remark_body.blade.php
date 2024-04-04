<div class="overflow-auto py-4">
    <table class="w-full">
        <thead>
            <tr>
                <th class="min-w-[120px]">Index Number</th>
                <th class="min-w-[200px]">Fullname</th>
                <th class="min-w-[120px]">Total Score</th>
                <th class="min-w-[120px]">Attendance</th>
                <th class="min-w-[80px]">Position</th>
                <th class="min-w-[200px]">T. Remark</th>
                <th class="min-w-[200px]">Conduct</th>
                <th class="min-w-[200px]">Interest</th>
                <th class="min-w-[200px]">Attitude</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_studs = count($student_marks);
                $remark_options = $remark_options->toArray();
            @endphp
            @foreach($student_marks as $student)
                <x-remark-entry-row
                    :student="$student['student']" :key="$loop->index"
                    :totalmark="old('class_mark.'.$loop->index, $student['total'])"
                    :total_studs="$total_studs"
                    :remarks="$remark_options"
                    :remarkhead="$remark_head"
                />
            @endforeach
        </tbody>
    </table>
</div>
