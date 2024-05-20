@php
    $init = ["text" => "Menu", "icon" => "fas fa-compass", "link" => route('school.menu', ['school_id' => $school_id])];

    $e_tags = [
        ["text" => "Academic Years", "icon" => "fas fa-calendar-alt", "link" => route("school-result.all", ['school_id' => $school_id])],
        ["text" => "Classes", "icon" => "fas fa-graduation-cap", "link" => route("school-result.programs", ['school_id' => $school_id ?? 0, 'academic_year' => year_link($academic_year ?? 0)])],
        ["text" => "Class Results", "icon" => "fas fa-poll", "link" => route('school-result.class', ['academic_year' => year_link($academic_year ?? 0), 'school_id' => $school_id ?? 0, 'program' => $program?->id ?? 0, 'term' => 1])],
        ["text" => "Student Result", "icon" => "fas fa-user-graduate", "link" => null]
    ];
    $s_tags = [
        ["text" => "Academic Years", "icon" => "fas fa-calendar-alt", "link" => route("school-subject.all", ['school_id' => $school_id])],
        ["text" => "Classes", "icon" => "fas fa-graduation-cap", "link" => route("school-subject.programs", ['school_id' => $school_id ?? 0, 'academic_year' => year_link($academic_year ?? 0)])],
        ["text" => "Subjects", "icon" => "fas fa-book-open", "link" => route('school-subject.class', ['academic_year' => year_link($academic_year ?? 0), 'school_id' => $school_id ?? 0, 'program' => $program?->id ?? 0, 'term' => 1])],
        ["text" => "Results", "icon" => "fas fa-chalkboard", "link" => null]
    ];

    if(isset($tag_type)){
        $tags = $tag_type == "exam" ? array_merge([$init], $e_tags) : array_merge([$init], $s_tags);
    }else{
        $tags[] = $init;
    }

    $tag_count = -1;
@endphp

{{-- tags --}}
<x-group-buttons-container class="py-4">
    @while (++$tag_count <= $page)
        <x-group-button
            :icon="$tags[$tag_count]['icon']"
            :first="$tag_count == 0"
            :last="$tag_count == $page"
            text="{{ $tags[$tag_count]['text'] }}"
            :link="$tag_count == $page ? null :  $tags[$tag_count]['link']"
            :text_color="$tag_count == $page ? 'text-blue-800' : 'text-slate-800 hover:text-blue-600'"
        />
    @endwhile
</x-group-buttons-container>
