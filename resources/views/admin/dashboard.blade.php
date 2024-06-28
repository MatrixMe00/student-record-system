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
        <div class="grid gap-4">
            <x-section-component title="Tasks" class="shadow-md rounded">
                <div class="overflow-auto border mt-2">
                    @include('admin.partials._dash_table')
                </div>
            </x-section-component>

            <x-user-activity title="Recent Activities"
                :logs="$activity_logs" :is_admin="true"
            />
        </div>

        <x-user-activity title="School Activities"
            :logs="$school_logs" :is_admin="true" :show_name="true"
        />
    </section>
</x-app-main>
