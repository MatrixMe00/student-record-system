<x-app-main>
    <div class="bg-transparent grid grid-cols-1 sm:grid-cols-2
        md:grid-cols-3 lg:grid-cols-4 dark:bg-gray-800 overflow-hidden
        shadow-sm sm:rounded-lg py-4 gap-4">
        <x-dashboard-card icon="fas fa-school-flag" context="{{ $school_count }}" title="Schools" />
        @if (Auth::user()->role_id == 1)
            <x-dashboard-card icon="fas fa-user-secret" context="{{ $superadmin_count }}" title="Developers" />
        @endif
        <x-dashboard-card icon="fas fa-user-lock" context="{{ __(round_number($superadmin_count)) }}" title="Superadmins" />
        <x-dashboard-card icon="fas fa-user-tie" context="{{ __(round_number($admin_count)) }}" title="Admins" />
        <x-dashboard-card icon="fas fa-chalkboard-user" context="{{ __(round_number($teacher_count)) }}" title="Teachers" />
        <x-dashboard-card icon="fas fa-user-graduate" context="{{ __(round_number($student_count)) }}" title="Students" />
        <x-dashboard-card icon="fas fa-user-minus" context="{{ __(round_number($delete_count)) }}" title="Deleted Users" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 mt-4 p-2 gap-4 items-start">
        <x-user-activity title="Recent Activities"
            :logs="$activity_logs" :is_admin="true" :show_name="true"
        />

        <x-user-activity title="System Activities"
            :logs="$system_logs" :is_admin="true" :show_name="true"
            :dev="auth()->user()->role_id == 1"
        />
    </div>
</x-app-main>
