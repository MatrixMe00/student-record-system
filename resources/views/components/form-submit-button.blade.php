@props(["color" => "blue", "icon" => "fas fa-angle-right"])
<button type="submit"
    class="flex items-center justify-between w-full md:w-1/2 px-6 py-3 text-sm
        tracking-wide text-white capitalize group transform bg-{{ $color }}-500 rounded-md
        hover:bg-{{ $color }}-400 focus:outline-none focus:ring focus:ring-{{ $color }}-300
        focus:ring-opacity-50">
    <span>{{ $slot }}</span>
    <i class="{{ $icon }} group-hover:mr-2 transition-all duration-500"></i>
</button>
