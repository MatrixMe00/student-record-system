@props(["title", "item_id", "path_head", "sub_title" => "", "content" => null, "avatar_url" => "", "extras" => []])

<a
  href="javascript:void(0)"
  {!! $attributes->merge(["class"=>"relative block overflow-hidden rounded-lg border border-gray-100 p-4 sm:p-6 lg:p-8"]) !!}
>

  <span
    class="absolute inset-x-0 bottom-0 h-2 bg-gradient-to-r from-green-300 via-blue-500 to-purple-600"
  ></span>

  <div class="sm:flex sm:justify-between sm:gap-4 relative">
    <div>
      <h3 class="text-lg font-bold text-gray-900 sm:text-xl">
        {{ __($title) }}
      </h3>

      @if (!empty($sub_title))
        <p class="mt-1 text-xs font-medium text-gray-600">{{ __($sub_title) }}</p>
      @endif
    </div>

    @if (!empty($avatar_url))
        <div class="hidden sm:block sm:shrink-0">
            <img
            alt=""
            src="{{ $avatar_url }}"
            class="size-16 rounded-lg object-cover shadow-sm"
            />
        </div>
    @endif
  </div>

  <div class="mt-4">
    <p class="text-pretty text-sm text-gray-500">
      {{ $content ?? $slot }}
    </p>
  </div>

  @if (!empty($extras))
    <dl class="mt-6 flex gap-4 sm:gap-6">
        @foreach ($extras as $extra)
            <div class="flex flex-col-reverse">
                <dt class="text-sm font-medium text-gray-600">{{ __($extra["title"]) }}</dt>
                <dd class="text-xs text-gray-500">{{ __($extra["content"]) }}</dd>
            </div>
        @endforeach
    </dl>
  @endif
  <div class="flex gap-2 text-sm mt-6">
    <span class="cursor-pointer text-blue-500 hover:underline hover:underline-offset-4" onclick="location.href='/{{ $path_head }}/{{ $item_id }}/edit'">Edit</span>
    <span class="cursor-pointer text-red-500 hover:underline hover:underline-offset-4" onclick="location.href='/{{ $path_head }}/{{ $item_id }}/delete'">Delete</span>
  </div>
</a>
