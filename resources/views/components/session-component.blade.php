@props(["main" => "success", "message" => "message"])

@session($main)
    <x-session-message class="mb-2" :success="session('success') ?? true">
        {{ __(session($message) ?? $message) }}
    </x-session-message>
@endsession
