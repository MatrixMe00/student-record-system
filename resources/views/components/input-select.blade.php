@props([
    "options", "value" => "", "default" => "Select An Option", "value_key" => "id", "text_key" => "name",
    "keyword" => "", "min" => 0, "max" => 0, "abled" => true
])

<select
@if (!$abled)
    disabled
@endif
{!! $attributes->merge(['class' => 'w-full py-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
>
@if (is_array($options) && !empty($options))
    <option value="">{{ $default }}</option>
    @foreach ($options as $option)
        <option value="{{ $option[$value_key] }}"
            @if ($value == $option[$value_key])
                {{ "selected" }}
            @endif
        >{{ ucfirst($option[$text_key]) }}</option>
    @endforeach
@elseif ($options == "auto")
    <option value="">{{ $default }}</option>
    @if ($min > $max)
        @for ($count = $min; $count >= $max; $count--)
            <option value="{{ $count }}"
                @if ($value == $count)
                    {{ "selected" }}
                @endif
            >{{ __($keyword." ".$count) }}</option>
        @endfor
    @else
        @for ($count = $min; $count <= $max; $count++)
            <option value="{{ $count }}"
                @if ($value == $count)
                    {{ "selected" }}
                @endif
            >{{ __($keyword." ".$count) }}</option>
        @endfor
    @endif

@elseif ($options == 0)
    {{ $slot }}
@else
    <option value="">No Options Data</option>
@endif


</select>
