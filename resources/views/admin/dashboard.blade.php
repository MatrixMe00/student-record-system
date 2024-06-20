<x-app-main>
    <div class="bg-transparent grid grid-cols-1 sm:grid-cols-2
        md:grid-cols-3 lg:grid-cols-4 dark:bg-gray-800 overflow-hidden
        shadow-sm sm:rounded-lg py-4 gap-4">
        <x-dashboard-card icon="fas fa-user-tie" context="{{ __(round_number($admin_count)) }}" title="Admins" />
        <x-dashboard-card icon="fas fa-chalkboard-user" context="{{ __(round_number($teacher_count)) }}" title="Teachers" />
        <x-dashboard-card icon="fas fa-user-graduate" context="{{ __(round_number($students->where('completed', false)->count())) }}" title="Current Students" />
        <x-dashboard-card icon="fas fas fa-graduation-cap" context="{{ __(round_number($students->where('completed', true)->count())) }}" title="Completed Students" />
        <x-dashboard-card icon="fas fa-user-minus" context="{{ __(round_number($delete_count)) }}" title="Deleted Users" />
        <x-dashboard-card icon="fas fa-book-open-reader" context="{{ __(round_number($subject_count)) }}" title="Subjects" />
        <x-dashboard-card icon="fas fa-hand-holding-usd" context="{{ __('¢ '.round_number(round($amount_sum,2))) }}" actual_title="{{ number_format($amount_sum, 2) }}" title="Total Payments" />
        <x-dashboard-card icon="fas fa-hand-holding-usd" context="{{ __('¢ '.round_number(round($deduction_sum,2))) }}" actual_title="{{ number_format($deduction_sum, 2) }}" title="Total Deductions" />
    </div>

    <section class="grid grid-cols-1 lg:grid-cols-2 mt-4 p-2 gap-4 items-start">
        <x-section-component title="Tasks" class="shadow-md rounded">
            <div class="overflow-auto border mt-2">
                @include('admin.partials._dash_table')
            </div>
        </x-section-component>

        <x-section-component title="Recent Activities" class="shadow-md rounded">
            @if ($activity_log->count() > 0)
                <div class="overflow-auto border mt-2">
                    <table class="w-full">
                        <tbody>
                            @foreach ($activity_log as $activity)
                                <tr></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-empty-div>{{ __("No Activity log to display") }}</x-empty-div>
            @endif
        </x-section-component>
    </section>
</x-app-main>
