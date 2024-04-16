@props(["has_download" => true, "download_text" => "Download", "download_link" => "javascript:void(0)"])

<li {{ $attributes->merge(["class"=>"flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6"]) }}>
    <div class="flex w-0 flex-1 items-center">
        {{ $slot }}
    </div>
    @if ($has_download)
        <div class="ml-4 flex-shrink-0">
            <a href="{{ $download_link }}" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __($download_text) }}</a>
        </div>
    @endif

  </li>
