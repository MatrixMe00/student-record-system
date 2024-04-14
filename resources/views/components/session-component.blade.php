@props(["main" => "success", "message" => "message"])

@session($main)
    <x-session-message class="mb-2">
        {{ __(session($message) ?? $message) }}
    </x-session-message>
@endsession
