@props(["student", "key", "totalmark", "semester" => 0, "is_admin" => false, "attendance" => 0, "remarks", "total_studs", "rowid" => 0, "readonly" => false, "painttd" => "", "remarkval" => ""])

<tr
    {{ $attributes->merge(["class" => ""]) }}
>
    {{-- index number --}}
    <td>
        <span class="{{ empty($painttd) ? 'bg-white' : $painttd }} border rounded-md mt-2 block py-3 px-2 text-nowrap">{{ $student->user->username }}</span>
        <x-text-input name="student_id[]" :value="$student->user_id" type="hidden"/>
        @if ($rowid > 0)
            <x-text-input name="id[]" :value="$rowid" type="hidden" />
        @endif
    </td>

    {{-- fullname --}}
    <td>
        <span class="{{ empty($painttd) ? 'bg-white' : $painttd }} border rounded-md mt-2 block py-3 px-2 {{ count(explode(' ', $student->oname)) < 2 ? 'text-nowrap' : '' }}">{{ $student->lname.' '.$student->oname }}</span>
    </td>

    {{-- total score --}}
    <td>
        <x-text-input class="total" class="min-w-24 md:min-w-20 {{ $painttd }}" readonly :value="$totalmark" name="total_marks[]" />
        <x-input-error :messages="$errors->get('total_marks.'.$key)" class="mt-2" />
    </td>

    {{-- attendance --}}
    <td>
        <x-text-input name="attendance[]" class="min-w-24 md:min-w-20 {{ $painttd }}" :value="old('attendance.'.$key, $attendance)" :readonly="$readonly" />
        <x-input-error :messages="$errors->get('attendance.'.$key)" class="mt-2" />
    </td>

    {{-- position --}}
    <td>
        <x-input-select name="position[]" options="auto" min="1" :max="$total_studs" :value="old('position.'.($key+1), $key+1)" default="Verify Position" :abled="!$readonly" />
        <x-input-error :messages="$errors->get('position.'.$key)" class="mt-2" />
    </td>

    {{-- remark --}}
    <td class="min-w-[200px]">
        <x-input-select name="remark[]" :options="$remarks" :value="old('remark.'.$key, $remarkval)" value_key="name" default="Select a remark" :abled="!$readonly" />
        <x-input-error :messages="$errors->get('remark.'.$key)" class="mt-2" />
    </td>

    @if ($semester == 3 && $is_admin)
        <td>
            <x-input-select name="promoted" class="w-[100px]" options="0">
                <option value="1" {!! old('promoted.'.$key, 1) == 1 ? "selected" : '' !!}>Yes</option>
                <option value="0" {!! old('promoted.'.$key, 1) == 0 ? "selected" : '' !!}>No</option>
            </x-input-select>
        </td>
    @endif
</tr>
