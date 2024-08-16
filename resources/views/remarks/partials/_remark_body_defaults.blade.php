{{-- remark token --}}
<x-text-input type="hidden" name="remark_token" :value="$remark_head->remark_token" />

{{-- school id --}}
<x-text-input type="hidden" name="school_id" value="{{ $remark_head->school_id }}" />

{{-- teacher id --}}
<x-text-input type="hidden" name="teacher_id" value="{{ $remark_head->teacher_id }}" />

{{-- program id --}}
<x-text-input type="hidden" name="program_id" value="{{ $program->id }}" />

{{-- program id --}}
<x-text-input type="hidden" name="semester" value="{{ $remark_head->semester }}" />

<div class="flex gap-2 flex-wrap">
    {{-- academic year --}}
    <div>
        <x-input-label>Academic Year</x-input-label>
        <x-text-input type="text" name="academic_year" :value="old('academic_year', $remark_head->academic_year)" readonly />
    </div>

    {{-- school settings --}}
    @php
        if(!$is_admin){
            $attendance = $school_settings["attendance"] ?? 80;
            $r_date = $school_settings["r_date"] ?? "";
            $v_date = $school_settings["v_date"] ?? "";
        }else{
            $attendance = $r_date = $v_date = "";
        }
    @endphp

    {{-- total attendance --}}
    <div class="flex-1">
        <x-input-label>Total Attendance</x-input-label>
        <x-text-input type="number" name="total_attendance" :value="old('total_attendance', $remark_head->total_attendance ?? $attendance)" placeholder="Term Total Attendance [Max: {{ $attendance }}]" max="{{ $attendance }}" :readonly="true" />
        <x-input-error :messages="$errors->get('total_attendance')" class="mt-2" />
    </div>

    {{-- vacation date --}}
    <div class="flex-1">
        <x-input-label>Vacation Date</x-input-label>
        <x-text-input type="date" name="vacation" :value="old('vacation', $remark_head->vacation ?? $v_date)" :readonly="!empty($v_date)" />
        <x-input-error :messages="$errors->get('vacation')" class="mt-2" />
    </div>

    {{-- reopening date --}}
    <div class="flex-1">
        <x-input-label>Reopening Date</x-input-label>
        <x-text-input type="date" name="reopening" :value="old('reopening', $remark_head->reopening ?? $r_date)" :readonly="!empty($r_date)" />
        <x-input-error :messages="$errors->get('reopening')" class="mt-2" />
    </div>

    @if ($is_admin)
        @if ($remark_head->semester == 3)
            {{-- its a promotion semester --}}
            <x-text-input type="hidden" name="is_promotion" value="1" />

            {{-- promotion class --}}
            <div class="flex-1">
                <x-input-label>Promotion Class</x-input-label>
                <x-input-select :options="$programs->toArray()" name="promotion_class" :value="old('promotion_class', $remark_head->promotion_class)">
                    <option value="0">Completed</option>
                </x-input-select>
                <x-input-error :messages="$errors->get('promotion_class')" class="mt-2" />
            </div>
        @endif
    @endif
</div>

