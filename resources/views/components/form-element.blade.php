<form {{ $attributes->merge(["class"=>"grid grid-cols-1 gap-6 mt-8 md:grid-cols-2 border p-4"]) }}>
        {{ $slot }}
</form>
