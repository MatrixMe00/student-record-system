@props(["student", "key", "is_grade", "classmark", "exammark", "rowid" => 0])

@php
    $total_score = $classmark + $exammark;
@endphp

<tr x-data="{c_score:{{ $classmark }}, e_score:{{ $exammark }}, total:{{ $total_score }}}" x-cloak="">
    <td>
        <span class="bg-white border rounded-md mt-2 block py-3 px-2 text-nowrap">{{ $student->user->username }}</span>
        <x-text-input name="student_id[]" :value="$student->user_id" type="hidden" />
        @if ($rowid > 0)
            <x-text-input name="id[]" :value="$rowid" type="hidden" />
        @endif
    </td>
    <td>
        <span class="bg-white border rounded-md mt-2 block py-3 px-2 {{ count(explode(' ', $student->oname)) < 2 ? 'text-nowrap' : '' }}">{{ $student->lname.' '.$student->oname }}</span>
    </td>
    <td>
        <x-text-input name="class_mark[]" class="min-w-24 md:min-w-20" x-model="c_score" @input="total=parseInt(c_score)+parseInt(e_score)" />
        <x-input-error :messages="$errors->get('class_mark.'.$key)" class="mt-2" />
    </td>
    <td>
        <x-text-input name="exam_mark[]" class="min-w-24 md:min-w-20" x-model="e_score" @input="total=parseInt(c_score)+parseInt(e_score)" />
        <x-input-error :messages="$errors->get('exam_mark.'.$key)" class="mt-2" />
    </td>
    <td>
        <x-text-input class="total" class="min-w-24 md:min-w-20" readonly x-model="total" />
    </td>
</tr>
