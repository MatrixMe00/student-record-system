<div class="overflow-auto py-4">
    <table>
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
            @php
                $key = 0;
            @endphp
            @foreach($remarks as $remark)
                <x-remark-entry-row
                    :student="$remark->student" :key="$key"
                    :totalmark="$remark->total_marks"
                    :rowid="$remark->id"
                    :attendance="$remark->attendance"
                    :readonly="$is_admin || !$edit_once"
                    :total_studs="$remarks->count()"
                    :remarks="$remark_options->toArray()"
                    :remarkval="$remark->remark"
                />
                @php
                    $key++;
                @endphp
            @endforeach

            {{-- if new students have been added to the class --}}
            {{-- @if ($unsaved->count() > 0 && $remark_head->status == "pending")
                @foreach($unsaved as $key => $student)
                    <x-remark-entry-row
                        :student="$student" :key="$key"
                        :classmark="old('class_mark.'.$key, 0)"
                        :exammark="old('exam_mark.'.$key, 0)"
                        painttd="border-teal-400"
                        :readonly="$is_admin || !$edit_once"
                    />
                    @php
                        $key++;
                    @endphp
                @endforeach
            @endif --}}
        </tbody>
    </table>
</div>
