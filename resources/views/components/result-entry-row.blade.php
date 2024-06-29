@props(["student", "key", "classmark", "exammark", "rowid" => 0, "readonly" => false, "painttd" => ""])

@php
    $total_score = $classmark + $exammark;
@endphp

<tr x-data="{c_score:{{ $classmark }}, e_score:{{ $exammark }}, c_old:{{ $classmark }}, e_old:{{ $exammark }}, total:{{ $total_score }}}" x-cloak=""
    {{ $attributes->merge(["class" => ""]) }}
>
    <td>
        <span class="{{ empty($painttd) ? 'bg-white' : $painttd }} border rounded-md mt-2 block py-3 px-2 text-nowrap">{{ $student->user->username }}</span>
        <x-text-input name="student_id[]" :value="$student->user_id" type="hidden"/>
        @if ($rowid > 0)
            <x-text-input name="id[]" :value="$rowid" type="hidden" />
        @endif
    </td>
    <td>
        <span class="{{ empty($painttd) ? 'bg-white' : $painttd }} border rounded-md mt-2 block py-3 px-2 {{ count(explode(' ', $student->oname)) < 2 ? 'text-nowrap' : '' }}">{{ $student->lname.' '.$student->oname }}</span>
    </td>
    <td>
        <x-text-input name="class_mark[]" class="min-w-24 md:min-w-20 {{ $painttd }}" x-model="c_score"
            @focus="c_score=c_old"
            @blur="c_old=c_score;c_score=parseInt(c_score)/2;total=parseInt(c_score)+parseInt(e_score)"

            :readonly="$readonly" />
        <x-input-error :messages="$errors->get('class_mark.'.$key)" class="mt-2" />
    </td>
    <td>
        <x-text-input name="exam_mark[]" class="min-w-24 md:min-w-20 {{ $painttd }}" x-model="e_score"
            @focus="e_score=e_old"
            @blur="e_old=e_score;e_score=parseInt(e_score)/2;total=parseInt(c_score)+parseInt(e_score)"

            :readonly="$readonly" />
        <x-input-error :messages="$errors->get('exam_mark.'.$key)" class="mt-2" />
    </td>
    <td>
        <x-text-input class="total" class="min-w-24 md:min-w-20 {{ $painttd }}" readonly x-model="total" />
    </td>
</tr>
