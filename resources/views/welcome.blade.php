<x-main-layout>
    {{-- Hero Section --}}
    <section class="relative overflow-hidden py-20 px-4 bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 md:px-8">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/50 to-transparent"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="py-8">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Manage Your School Records
                    <span class="block text-indigo-200">With Ease & Efficiency</span>
                </h1>
                <p class="text-xl text-indigo-100 leading-relaxed max-w-2xl mx-auto mb-4">
                    A comprehensive multi-tenant student record management system designed for <strong class="text-white">Basic Schools and Secondary Schools</strong> to efficiently manage students, grades, payments, and academic activities all in one platform.
                </p>
                <p class="text-lg text-indigo-200 max-w-xl mx-auto">
                    Perfect for primary, junior high, and senior high schools looking to digitize their record management.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3 bg-white text-indigo-900 font-semibold rounded-lg shadow-lg hover:bg-indigo-50 transition-all duration-200 transform hover:scale-105">
                    Register Your School
                </a>
                <a href="#features" class="w-full sm:w-auto px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg border-2 border-indigo-500 hover:bg-indigo-600 transition-all duration-200">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    {{-- Who is it for Section --}}
    <section class="py-16 px-4 bg-indigo-50 md:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Designed for Basic and Secondary Schools
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <i class="fas fa-child text-4xl text-indigo-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Primary Schools</h3>
                    <p class="text-gray-600">Perfect for basic schools managing early education records</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <i class="fas fa-graduation-cap text-4xl text-indigo-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Junior High Schools</h3>
                    <p class="text-gray-600">Ideal for JHS managing student progression and results</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <i class="fas fa-university text-4xl text-indigo-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Senior High Schools</h3>
                    <p class="text-gray-600">Comprehensive solution for SHS academic management</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-20 px-4 bg-white md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Powerful Features for Modern Schools
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Everything you need to manage your school's academic operations efficiently
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="w-12 h-12 bg-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-school text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Multi-School Support</h3>
                    <p class="text-gray-600">
                        Manage multiple schools on a single platform with complete data isolation and security.
                    </p>
                </div>

                {{-- Feature 2 --}}
                <div class="p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl border border-purple-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-user-graduate text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Student Management</h3>
                    <p class="text-gray-600">
                        Complete student registration, profile management, and academic tracking system.
                    </p>
                </div>

                {{-- Feature 3 --}}
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Grade Management</h3>
                    <p class="text-gray-600">
                        Streamlined grade entry, approval workflow, and comprehensive result reporting.
                    </p>
                </div>

                {{-- Feature 4 --}}
                <div class="p-6 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl border border-yellow-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Payment Integration</h3>
                    <p class="text-gray-600">
                        Seamless Paystack integration for student payments, billing, and debt tracking.
                    </p>
                </div>

                {{-- Feature 5 --}}
                <div class="p-6 bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border border-red-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-file-export text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Comprehensive Reporting</h3>
                    <p class="text-gray-600">
                        Export results to Excel and PDF, historical records, and detailed analytics.
                    </p>
                </div>

                {{-- Feature 6 --}}
                <div class="p-6 bg-gradient-to-br from-cyan-50 to-blue-50 rounded-xl border border-cyan-100 hover:shadow-lg transition-shadow duration-200">
                    <div class="w-12 h-12 bg-cyan-600 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Secure & Isolated</h3>
                    <p class="text-gray-600">
                        Role-based access control with complete data isolation and security features.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Login Section --}}
    <section id="logins" class="py-20 px-4 bg-gray-50 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Access Your Account
                </h2>
                <p class="text-xl text-gray-600">
                    Choose your login type to access the system
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <x-welcome-tag href="{{ route('admin.login') }}" tag_name="Admin Login" icon="fas fa-user-clock"/>
                <x-welcome-tag href="{{ route('teacher.login') }}" tag_name="Teacher Login" icon="fas fa-person-chalkboard" />
                <x-welcome-tag href="{{ route('login') }}" tag_name="Student Login" icon="fas fa-user-graduate" />
                <x-welcome-tag href="{{ route('school.index') }}" tag_name="Our Schools" icon="fas fa-school-flag" />
                <x-welcome-tag href="{{ route('register') }}" tag_name="Register School" icon="fas fa-school-circle-check" />
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 px-4 bg-indigo-600 md:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Ready to Transform Your School Management?
            </h2>
            <p class="text-xl text-indigo-100 mb-2">
                Join Basic and Secondary Schools already using our platform to streamline their academic operations
            </p>
            <p class="text-lg text-indigo-200 mb-8">
                Get started in minutes - Register your school today!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-lg hover:bg-indigo-50 transition-all duration-200 transform hover:scale-105">
                    Get Started Today
                </a>
                <a href="{{ route('contact') }}" class="inline-block px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg border-2 border-indigo-400 hover:bg-indigo-800 transition-all duration-200">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

</x-main-layout>
