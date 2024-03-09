<table class="w-full">
    <tbody>
        @php
            list($teacher, $class, $subject, $student, $subj_teacher) = array_values($tasks);
        @endphp

        @if (!$teacher || !$class || !$subject || !$student || !$subj_teacher)
            <tr @if (!$teacher)
                onclick="location.href='{{ route('users.all') }}'"
                class="bg-red-100 hover:bg-red-50 cursor-pointer"
            @endif>
            <x-table-td :main="true">Add A Teacher</x-table-td>
            <x-table-td class="text-right">{{ $teacher ? "Completed" : "Pending" }}</x-table-td>
        </tr>
        <tr @if (!$class)
                onclick="location.href='{{ route('program.all') }}'"
                class="hover:bg-neutral-200 cursor-pointer"
            @endif>
            <x-table-td :main="true">Add A Class</x-table-td>
            <x-table-td class="text-right">{{ $class ? "Completed" : "Pending" }}</x-table-td>
        </tr>
        <tr @if (!$subject)
                onclick="location.href=''"
                class="hover:bg-neutral-200 cursor-pointer"
            @endif>
            <x-table-td :main="true">Add A Subject</x-table-td>
            <x-table-td class="text-right">{{ $subject ? "Completed" : "Pending" }}</x-table-td>
        </tr>
        <tr @if (!$student)
                onclick="location.href=''"
                class="hover:bg-neutral-200 cursor-pointer"
            @endif>
            <x-table-td :main="true">Add a student</x-table-td>
            <x-table-td class="text-right">{{ $student ? "Completed" : "Pending" }}</x-table-td>
        </tr>
        <tr @if (!$subj_teacher)
                onclick="location.href=''"
                class="hover:bg-neutral-200 cursor-pointer"
            @endif>
            <x-table-td :main="true">Assign Subject Teachers</x-table-td>
            <x-table-td class="text-right">{{ $subj_teacher ? "Completed" : "Pending" }}</x-table-td>
        </tr>

        @else
            <x-table-td :main="true" class="text-center">Your school is fully set up. No New Tasks to perform</x-table-td>
        @endif

    </tbody>
</table>
