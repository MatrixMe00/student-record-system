<x-app-main>
    <div class="bg-transparent grid grid-cols-1 sm:grid-cols-2
        md:grid-cols-3 lg:grid-cols-4 dark:bg-gray-800 overflow-hidden
        shadow-sm sm:rounded-lg py-4 gap-4">
        <x-dashboard-card icon="fas fa-school-flag" context="{{ $school_count }}" title="Schools" />
        @if (Auth::user()->role_id == 1)
            <x-dashboard-card icon="fas fa-user-secret" context="{{ $superadmin_count }}" title="Developers" />
        @endif
        <x-dashboard-card icon="fas fa-user-lock" context="{{ $superadmin_count }}" title="Superadmins" />
        <x-dashboard-card icon="fas fa-user-tie" context="{{ $admin_count }}" title="Admins" />
        <x-dashboard-card icon="fas fa-chalkboard-user" context="{{ $teacher_count }}" title="Teachers" />
        <x-dashboard-card icon="fas fa-user-graduate" context="{{ $student_count }}" title="Students" />
        <x-dashboard-card icon="fas fa-user-minus" context="{{ $delete_count }}" title="Deleted Users" />
    </div>
</x-app-main>