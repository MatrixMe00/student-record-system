@props(['icon', 'title', 'description', 'iconBg' => 'indigo', 'gradientFrom' => 'blue', 'variant' => 'card'])

@php
    $iconBgColors = [
        'indigo' => 'bg-indigo-600',
        'purple' => 'bg-purple-600',
        'green' => 'bg-green-600',
        'yellow' => 'bg-yellow-600',
        'red' => 'bg-red-600',
        'cyan' => 'bg-cyan-600',
    ];
    $iconTextColors = [
        'indigo' => 'text-indigo-600',
        'purple' => 'text-purple-600',
        'green' => 'text-green-600',
        'yellow' => 'text-yellow-600',
        'red' => 'text-red-600',
        'cyan' => 'text-cyan-600',
    ];
    $gradientClasses = [
        'blue' => 'from-blue-50 to-indigo-50 border-blue-100',
        'purple' => 'from-purple-50 to-pink-50 border-purple-100',
        'green' => 'from-green-50 to-emerald-50 border-green-100',
        'yellow' => 'from-yellow-50 to-orange-50 border-yellow-100',
        'red' => 'from-red-50 to-rose-50 border-red-100',
        'cyan' => 'from-cyan-50 to-blue-50 border-cyan-100',
    ];
    $iconBgClass = $iconBgColors[$iconBg] ?? $iconBgColors['indigo'];
    $iconTextClass = $iconTextColors[$iconBg] ?? $iconTextColors['indigo'];
    $gradientClass = $gradientClasses[$gradientFrom] ?? $gradientClasses['blue'];
@endphp

<div class="p-6 bg-gradient-to-br {{ $gradientClass }} rounded-xl border hover:shadow-lg transition-shadow duration-200">
    @if($variant === 'card')
        <div class="w-12 h-12 {{ $iconBgClass }} rounded-lg flex items-center justify-center mb-4">
            <i class="{{ $icon }} text-white text-2xl"></i>
        </div>
    @else
        <i class="{{ $icon }} text-3xl {{ $iconTextClass }} mb-4"></i>
    @endif
    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $title }}</h3>
    <p class="text-gray-600">
        {{ $description }}
    </p>
</div>
