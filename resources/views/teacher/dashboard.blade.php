<x-app-main>
    <div class="bg-transparent grid grid-cols-1 sm:grid-cols-2
        md:grid-cols-3 lg:grid-cols-4 dark:bg-gray-800 overflow-hidden
        shadow-sm sm:rounded-lg py-4 gap-4">
        <x-dashboard-card icon="fas fa-user-tie" context="{{ $teacher->class_teacher ? $teacher->teacher_class->name : 'None' }}" title="Your Class" />
        <x-dashboard-card icon="fas fa-school-flag" context="{{ $teacher->classes->unique('program_id')->count() }}" title="Classes Teaching" />
    </div>

    <section class="grid grod-cols-1 lg:grid-cols-2 mt-4 p-2 gap-4 items-start">
        <x-user-activity title="Recent Activities"
            :logs="$activity_logs"
        />
    </section>
</x-app-main>
