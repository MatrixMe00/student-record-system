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

{{-- total attendance --}}
<div>
    <x-input-label>Total Attendance</x-input-label>
    <x-text-input type="number" name="total_attendance" :value="old('total_attendance', $remark_head->total_attendance)" placeholder="Term Total Attendance" :disabled="$is_admin || $remark_head->status != 'pending'" />
    <x-input-error :messages="$errors->get('total_attendance')" class="mt-2" />
</div>
