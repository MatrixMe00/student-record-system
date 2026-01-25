@props(['title' => 'Designed for Basic and Secondary Schools', 'description' => null])

<section class="py-16 px-4 bg-indigo-50 md:px-8">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
            {{ $title }}
        </h2>
        @if($description)
            <p class="text-xl text-gray-700 mb-8 leading-relaxed">
                {{ $description }}
            </p>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="p-6 bg-white rounded-lg shadow-md">
                <i class="fas fa-child text-4xl text-indigo-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Primary Schools</h3>
                <p class="text-gray-600">Perfect for basic schools managing early education records</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <i class="fas fa-graduation-cap text-4xl text-indigo-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Junior High Schools</h3>
                <p class="text-gray-600">Ideal for JHS managing student progression and {{ $description ? 'BECE preparation' : 'results' }}</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <i class="fas fa-university text-4xl text-indigo-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Senior High Schools</h3>
                <p class="text-gray-600">Comprehensive solution for SHS academic management</p>
            </div>
        </div>
    </div>
</section>
