{{-- result_token --}}
<x-text-input type="hidden" name="remark_token" :value="$remark_head->remark_token" />

{{-- school id --}}
<x-text-input type="hidden" name="school_id" value="{{ $remark_head->school_id }}" />

{{-- teacher id --}}
<x-text-input type="hidden" name="teacher_id" value="{{ $remark_head->teacher_id }}" />

{{-- program id --}}
<x-text-input type="hidden" name="program_id" value="{{ $program->id }}" />

{{-- program id --}}
<x-text-input type="hidden" name="semester" value="{{ $remark_head->semester }}" />
