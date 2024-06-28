<x-app-main>
    <div class="bg-transparent grid grid-cols-1 sm:grid-cols-2
        md:grid-cols-3 lg:grid-cols-4 dark:bg-gray-800 overflow-hidden
        shadow-sm sm:rounded-lg py-4 gap-4">
        {{-- <x-dashboard-card icon="fas fa-book-open-reader" context="{{ $subject_count }}" title="Subjects" /> --}}
        <x-dashboard-card icon="fas fa-clipboard-user" context="{{ $current_class }}" title="Current Class" />
        <x-dashboard-card icon="fas fa-clipboard-user" context="{{ $grade_value }}" title="Average Score" />
        <x-dashboard-card icon="fas fa-clipboard-user" context="{{ round($average_grade, 1) }}" title="Average Grade" />
        <x-dashboard-card icon="fas fa-clipboard-user" context="{{ $grade_description }}" title="Grade Description" />

    </div>

    <section class="grid grod-cols-1 lg:grid-cols-2 mt-4 p-2 gap-4 items-start">
        <x-user-activity title="Recent Activities"
            :logs="$activity_logs"
        />
    </section>
</x-app-main>
