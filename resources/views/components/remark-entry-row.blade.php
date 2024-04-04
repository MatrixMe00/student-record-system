@props(["remarkhead", "result" => "", "student" => "", "key", "totalmark",
    "is_admin" => false, "remarks", "total_studs", "readonly" => false, "painttd" => ""])

@php
    if($result){
        $student = $result->student;
    }
@endphp

<tr
    {{ $attributes->merge(["class" => "relative"]) }}
>
    {{-- index number --}}
    <td>
        <span class="{{ empty($painttd) ? 'bg-white' : $painttd }} border rounded-md mt-2 block py-3 px-2 text-nowrap">{{ $student->user->username }}</span>
        <x-text-input name="student_id[]" :value="$student->user_id" type="hidden"/>
        @if (!empty($result))
            <x-text-input name="id[]" :value="$result->id" type="hidden" />
        @endif
    </td>

    {{-- fullname --}}
    <td class="sticky left-0 z-10">
        <span class="{{ empty($painttd) ? 'bg-white' : $painttd }} border rounded-md mt-2 block py-3 px-2 {{ count(explode(' ', $student->oname)) < 2 ? 'text-nowrap' : '' }}">{{ $student->lname.' '.$student->oname }}</span>
    </td>

    {{-- total score --}}
    <td>
        <x-text-input class="total" class="min-w-24 md:min-w-20 {{ $painttd }}" readonly :value="$result->total_marks" name="total_marks[]" />
        <x-input-error :messages="$errors->get('total_marks.'.$key)" class="mt-2" />
    </td>

    {{-- attendance --}}
    <td>
        <x-text-input type="number" name="attendance[]" min="0" max="80" class="min-w-24 md:min-w-20 {{ $painttd }}" :value="old('attendance.'.$key, $result->attendance ?? 0)" :readonly="$readonly" />
        <x-input-error :messages="$errors->get('attendance.'.$key)" class="mt-2" />
    </td>

    {{-- position --}}
    <td>
        <x-input-select name="position[]" options="auto" min="1" :max="$total_studs" :value="old('position.'.($key+1), $result->position ?? $key+1)" default="Verify Position" :abled="!$readonly" />
        <x-input-error :messages="$errors->get('position.'.$key)" class="mt-2" />
    </td>

    {{-- remark --}}
    <td>
        <x-input-select name="remark[]" :options="$remarks" :value="old('remark.'.$key, $result->remark ?? '')" value_key="name" default="Select a remark" :abled="!$readonly" />
        <x-input-error :messages="$errors->get('remark.'.$key)" class="mt-2" />
    </td>

    {{-- headmaster remark --}}
    @if ($is_admin || $remarkhead->status == "accepted")
        <td>
            <x-input-select name="h_remark[]" :options="$remarks" :value="old('h_remark.'.$key, $result->h_remark ?? '')" value_key="name" default="Select a remark" :abled="$remarkhead->status == 'submitted'" />
            <x-input-error :messages="$errors->get('h_remark.'.$key)" class="mt-2" />
        </td>
    @endif

    {{-- student conduct --}}
    <td>
        <x-text-input name="conduct[]" placeholder="Conduct" :value="old('conduct.'.$key, $result->conduct ?? '')" :readonly="$readonly" />
        <x-input-error :messages="$errors->get('conduct.'.$key)" class="mt-2" />
    </td>

    {{-- student interest --}}
    <td>
        <x-text-input name="interest[]" placeholder="Interest" :value="old('interest.'.$key, $result->interest ?? '')" :readonly="$readonly" />
        <x-input-error :messages="$errors->get('interest.'.$key)" class="mt-2" />
    </td>

    {{-- student attitude --}}
    <td>
        <x-text-input name="attitude[]" placeholder="Attitude" :value="old('attitude.'.$key, $result->attitude ?? '')" :readonly="$readonly" />
        <x-input-error :messages="$errors->get('attitude.'.$key)" class="mt-2" />
    </td>

    @if ($remarkhead->semester == 3 && $is_admin)
        <td>
            <x-input-select name="promoted" class="w-[100px]" options="0">
                <option value="1" {!! old('promoted.'.$key, 1) == 1 ? "selected" : '' !!}>Yes</option>
                <option value="0" {!! old('promoted.'.$key, 1) == 0 ? "selected" : '' !!}>No</option>
            </x-input-select>
        </td>
    @endif
</tr>
