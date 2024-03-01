@props(["options", "value" => "", "default" => "", "value_key" => "id", "text_key" => "name"])

<select
{!! $attributes->merge(['class' => 'w-full mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}
>
@if (is_array($options))
    <option value="">{{ $default }}</option>
    @foreach ($options as $option)
        <option value="{{ $option[$value_key] }}"
            @if ($value == $option[$value_key])
                {{ "selected" }}
            @endif
        >{{ ucfirst($option[$text_key]) }}</option>
    @endforeach
@elseif ($options == 0)
    {{ $slot }}
@else
    <option value="">No Options Data</option>
@endif


</select>
