<div class="overflow-auto py-4">
    <table class="border-separate border-spacing-x-2">
        <thead>
            <tr>
                <th class="min-w-[120px]">Index Number</th>
                <th class="min-w-[200px]">Fullname</th>
                <th class="min-w-[120px]">Total Score</th>
                <th class="min-w-[120px]">Attendance</th>
                <th class="min-w-[80px]">Position</th>
                <th class="min-w-[200px]">T. Remark</th>

                @if ($is_admin || $remark_head->status == "approved")
                    <th class="min-w-[200px]">H. Remark</th>
                @endif

                <th class="min-w-[200px]">Conduct</th>
                <th class="min-w-[200px]">Interest</th>
                <th class="min-w-[200px]">Attitude</th>

                @if ($is_admin)
                    <th class="min-w-[80px]">Promote</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $key = 0;
                $total_studs = $remarks->count();
                $remark_options = $remark_options->toArray();
            @endphp
            @foreach($remarks as $remark)
                <x-remark-entry-row
                    :result="$remark" :key="$key"
                    :readonly="$is_admin || !$edit_once"
                    :total_studs="$total_studs"
                    :remarks="$remark_options"
                    :remarkhead="$remark_head"
                    :is_admin="$is_admin"
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
