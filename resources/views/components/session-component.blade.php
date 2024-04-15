@props(["main" => "success", "message" => "message", "time" => 3500])

@session($main)
    <x-session-message class="mb-2" :success="session('success') ?? true" :time="$time">
        {{ __(session($message) ?? $message) }}
    </x-session-message>
@endsession
