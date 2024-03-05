@session('success')
    <x-session-message class="mb-2">
        {{ __(session('message')) }}
    </x-session-message>
@endsession
