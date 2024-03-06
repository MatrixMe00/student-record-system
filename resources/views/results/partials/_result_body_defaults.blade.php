{{-- result_token --}}
<x-text-input type="hidden" name="result_token" :value="$result->result_token" required readonly />

{{-- school id --}}
<x-text-input type="hidden" name="school_id" value="{{ $result->school_id }}" />

{{-- teacher id --}}
<x-text-input type="hidden" name="teacher_id" value="{{ $result->teacher_id }}" />

{{-- program id --}}
<x-text-input type="hidden" name="program_id" value="{{ $program->id }}" />

{{-- program id --}}
<x-text-input type="hidden" name="semester" value="{{ $result->semester }}" />
