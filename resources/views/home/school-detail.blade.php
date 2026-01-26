<x-main-layout>
    @php
        $school = $school ?? null;
    @endphp

    @if($school)
        {{-- Hero Section with School Info --}}
        <section class="relative overflow-hidden py-16 px-4 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 md:px-8">
            <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    {{-- School Logo/Icon --}}
                    <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        @if($school->logo_path)
                            <img src="{{ asset($school->logo_path) }}" alt="{{ $school->school_name }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <i class="fas fa-school text-4xl sm:text-6xl text-indigo-600"></i>
                        @endif
                    </div>

                    {{-- School Info --}}
                    <div class="flex-1 text-center md:text-left">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 break-words">{{ $school->school_name }}</h1>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 sm:gap-4 text-indigo-100 text-sm sm:text-base">
                            <span class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="break-words">{{ $school->district ?? 'N/A' }}</span>
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-tag mr-2"></i>
                                <span class="capitalize">{{ $school->school_type }}</span>
                            </span>
                            <span class="flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                <span class="break-words">{{ $school->school_head }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Quick Stats --}}
        <section class="py-8 px-4 bg-white border-b border-gray-200 md:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-indigo-600">{{ $school->students->count() }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-purple-600">{{ $school->teachers->count() }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Teachers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-green-600">{{ $school->programs->count() }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Programs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $school->subjects->count() }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Subjects</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-12 px-4 bg-gray-50 md:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Main Content --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- About Section --}}
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">About</h2>
                            <p class="text-gray-700 leading-relaxed">{{ $school->description }}</p>
                        </div>

                        {{-- Programs/Classes --}}
                        @if($school->programs->count() > 0)
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Programs & Classes</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($school->programs as $program)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition-colors">
                                            <h3 class="font-semibold text-gray-900 mb-2">{{ $program->name }}</h3>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">{{ $program->students->count() }}</span> students
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Subjects --}}
                        @if($school->subjects->count() > 0)
                            <div class="bg-white rounded-xl shadow-md p-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Subjects Offered</h2>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($school->subjects as $subject)
                                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm">
                                            {{ $subject->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Sidebar --}}
                    <div class="space-y-6">
                        {{-- Contact Information --}}
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Contact Information</h2>
                            <div class="space-y-3">
                                <div class="flex items-start">
                                    <i class="fas fa-envelope text-indigo-600 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <a href="mailto:{{ $school->school_email }}" class="text-gray-900 hover:text-indigo-600">
                                            {{ $school->school_email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-indigo-600 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Postal Address</p>
                                        <p class="text-gray-900">{{ $school->box_number }}</p>
                                    </div>
                                </div>
                                @if($school->gps_address)
                                    <div class="flex items-start">
                                        <i class="fas fa-location-dot text-indigo-600 mr-3 mt-1"></i>
                                        <div>
                                            <p class="text-sm text-gray-500">GPS Address</p>
                                            <p class="text-gray-900">{{ $school->gps_address }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($school->circuit)
                                    <div class="flex items-start">
                                        <i class="fas fa-route text-indigo-600 mr-3 mt-1"></i>
                                        <div>
                                            <p class="text-sm text-gray-500">Circuit</p>
                                            <p class="text-gray-900">{{ $school->circuit }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- School Details --}}
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">School Details</h2>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500">School Type</p>
                                    <p class="text-gray-900 capitalize font-medium">{{ $school->school_type }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">School Head</p>
                                    <p class="text-gray-900 font-medium">{{ $school->school_head }}</p>
                                </div>
                                @if($school->district)
                                    <div>
                                        <p class="text-sm text-gray-500">District</p>
                                        <p class="text-gray-900 font-medium">{{ $school->district }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $school->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $school->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Actions --}}
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl shadow-md p-6 border border-indigo-100">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                            <div class="space-y-3">
                                <a href="{{ route('admin.login') }}" class="block w-full px-4 py-2 bg-indigo-600 text-white text-center rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                                    Login to School Portal
                                </a>
                                <a href="{{ route('school.index') }}" class="block w-full px-4 py-2 border border-indigo-600 text-indigo-600 text-center rounded-lg hover:bg-indigo-50 transition-colors">
                                    <i class="fas fa-arrow-left mr-2"></i> Back to Schools
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        {{-- School Not Found --}}
        <section class="py-20 px-4 bg-white md:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <div class="mb-8">
                    <i class="fas fa-exclamation-circle text-6xl text-gray-300 mb-4"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">School Not Found</h1>
                <p class="text-lg text-gray-600 mb-2">The school you're looking for doesn't exist or may have been removed.</p>
                <p class="text-gray-500 mb-8">Please check the URL or return to the schools list.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('school.index') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i> View All Schools
                    </a>
                    <a href="{{ route('index') }}" class="inline-block px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                        Go to Homepage
                    </a>
                </div>
            </div>
        </section>
    @endif
</x-main-layout>
