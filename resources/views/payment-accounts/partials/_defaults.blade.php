{{-- school id --}}
<x-text-input type="hidden" name="school_id" :value="session('school_id')" />

{{-- user id --}}
<x-text-input type="hidden" name="user_id" :value="auth()->user()->id" />

{{-- master account --}}
<x-text-input type="hidden" name="master" :value="intval(auth()->user()->role_id < 3)" />
