<table class="w-full">
    <tbody>
        @php
            list(
                $teacher, $class, $subject, $student, $subj_teacher,
                $user_payment, $school_payment, $price_amount_provided
            ) = array_values($tasks);
        @endphp

        @if (in_array(false, array_values($tasks)))
            <tr @if (!$teacher)
                    onclick="location.href='{{ route('users.all') }}'"
                    class="bg-red-100 hover:bg-red-50 cursor-pointer"
                @endif>
                <x-table-td :main="true">Add A Teacher</x-table-td>
                <x-table-td class="text-right">{{ $teacher ? "Completed" : "Pending" }}</x-table-td>
            </tr>
            <tr @if (!$class)
                    onclick="location.href='{{ route('program.all') }}'"
                    class="bg-red-100 hover:bg-red-50 cursor-pointer"
                @endif>
                <x-table-td :main="true">Add A Class</x-table-td>
                <x-table-td class="text-right">{{ $class ? "Completed" : "Pending" }}</x-table-td>
            </tr>
            <tr @if (!$subject)
                    onclick="location.href='{{ route('subject.all') }}'"
                    class="bg-red-100 hover:bg-red-50 cursor-pointer"
                @endif>
                <x-table-td :main="true">Add A Subject</x-table-td>
                <x-table-td class="text-right">{{ $subject ? "Completed" : "Pending" }}</x-table-td>
            </tr>
        <tr @if (!$student)
                onclick="location.href='{{ route('users.all') }}'"
                class="bg-red-100 hover:bg-red-50 cursor-pointer"
            @endif>
            <x-table-td :main="true">Add a student</x-table-td>
            <x-table-td class="text-right">{{ $student ? "Completed" : "Pending" }}</x-table-td>
        </tr>
        <tr @if (!$subj_teacher)
                onclick="location.href='{{ route('subject.assign') }}'"
                class="bg-red-100 hover:bg-red-50 cursor-pointer"
            @endif>
            <x-table-td :main="true">Assign Subject Teachers</x-table-td>
            <x-table-td class="text-right">{{ $subj_teacher ? "Completed" : "Pending" }}</x-table-td>
        </tr>
        @if (session('payment_is_ready'))
            <tr @if (!$price_amount_provided)
                    onclick="location.href='{{ route('payment-account.user') }}'"
                    class="bg-red-100 hover:bg-red-50 cursor-pointer"
                @endif>
                <x-table-td :main="true">Add your charge for result checking</x-table-td>
                <x-table-td class="text-right">{{ $price_amount_provided ? "Completed" : "Pending" }}</x-table-td>
            </tr>
            @if ($price_amount_provided)
                <tr @if (!$school_payment)
                        onclick="location.href='{{ route('payment-account.user') }}'"
                        class="bg-red-100 hover:bg-red-50 cursor-pointer"
                    @endif>
                    <x-table-td :main="true">Add a school payment account</x-table-td>
                    <x-table-td class="text-right">{{ $school_payment ? "Completed" : "Pending" }}</x-table-td>
                </tr>

                @if ($school_payment)
                    <tr @if (!$user_payment)
                            onclick="location.href='{{ route('payment-account.user') }}'"
                            class="bg-red-100 hover:bg-red-50 cursor-pointer"
                        @endif>
                        <x-table-td :main="true">Add a personal payment account</x-table-td>
                        <x-table-td class="text-right">{{ $user_payment ? "Completed" : "Pending" }}</x-table-td>
                    </tr>
                @endif
            @endif
        @else
            <tr>
                <x-table-td :main="true">System Payment Status</x-table-td>
                <x-table-td class="text-right">{{ __("Not Ready") }}</x-table-td>
            </tr>
        @endif
        @else
            <x-table-td :main="true" class="text-center">Your school is fully set up. No New Tasks to perform</x-table-td>
        @endif

    </tbody>
</table>
