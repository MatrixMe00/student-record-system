@props(["message"])

<th {{ $attributes->merge([
        "class"=>"px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
    ]) }}>
    {{ $message ?? $slot }}
</th>
