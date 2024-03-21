@props(["mdcols" => "md:grid-cols-2"])
<form {{ $attributes->merge(["class"=>"grid grid-cols-1 gap-6 mt-8 $mdcols border p-4"]) }}>
        {{ $slot }}
</form>
