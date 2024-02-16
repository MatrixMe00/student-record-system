@props(["icon", "title", "context", "icon_bg" => "from-purple-700 to-pink-500"])

<div class="w-full max-w-full px-3 sm:flex-none">
    <div class="flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="flex-auto p-4">
        <div class="flex flex-row -mx-3">
          <div class="flex-none w-2/3 max-w-full px-3">
            <div>
              <p class="font-sans text-sm font-semibold leading-normal">{{ $title }}</p>
              <h5 class="font-bold text-4xl">
                {{ $context }}
              </h5>
            </div>
          </div>
          <div class="px-3 text-right self-end basis-1/3">
            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl {{ $icon_bg }}">
              <i class="{{ $icon }} text-lg relative top-3.5 text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>