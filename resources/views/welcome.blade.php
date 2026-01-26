<x-main-layout>
    <x-hero-section 
        title='Manage Your School Records <span class="block text-indigo-200">With Ease & Efficiency</span>'
        subtitle='A comprehensive multi-tenant student record management system designed for <strong class="text-white">Basic Schools and Secondary Schools</strong> to efficiently manage students, grades, payments, and academic activities all in one platform.'
        description="Perfect for primary, junior high, and senior high schools looking to digitize their record management."
        :buttons="[
            ['href' => route('register'), 'text' => 'Register Your School'],
            ['href' => '#features', 'text' => 'Learn More', 'class' => 'w-full sm:w-auto px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg border-2 border-indigo-500 hover:bg-indigo-600 transition-all duration-200']
        ]"
    />

    <x-target-audience-section />

    {{-- Features Section --}}
    <section id="features" class="py-12 sm:py-16 lg:py-20 px-4 bg-white md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-10 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                    Powerful Features for Modern Schools
                </h2>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto px-2">
                    Everything you need to manage your school's academic operations efficiently
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <x-feature-card 
                    icon="fas fa-school" 
                    title="Multi-School Support" 
                    description="Manage multiple schools on a single platform with complete data isolation and security."
                    iconBg="indigo"
                    gradientFrom="blue"
                />
                <x-feature-card 
                    icon="fas fa-user-graduate" 
                    title="Student Management" 
                    description="Complete student registration, profile management, and academic tracking system."
                    iconBg="purple"
                    gradientFrom="purple"
                />
                <x-feature-card 
                    icon="fas fa-chart-line" 
                    title="Grade Management" 
                    description="Streamlined grade entry, approval workflow, and comprehensive result reporting."
                    iconBg="green"
                    gradientFrom="green"
                />
                <x-feature-card 
                    icon="fas fa-credit-card" 
                    title="Payment Integration" 
                    description="Seamless Paystack integration for student payments, billing, and debt tracking."
                    iconBg="yellow"
                    gradientFrom="yellow"
                />
                <x-feature-card 
                    icon="fas fa-file-export" 
                    title="Comprehensive Reporting" 
                    description="Export results to Excel and PDF, historical records, and detailed analytics."
                    iconBg="red"
                    gradientFrom="red"
                />
                <x-feature-card 
                    icon="fas fa-shield-alt" 
                    title="Secure & Isolated" 
                    description="Role-based access control with complete data isolation and security features."
                    iconBg="cyan"
                    gradientFrom="cyan"
                />
            </div>
        </div>
    </section>

    {{-- Login Section --}}
    <section id="logins" class="py-12 sm:py-16 lg:py-20 px-4 bg-gray-50 md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-8 sm:mb-12">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">
                    Access Your Account
                </h2>
                <p class="text-lg sm:text-xl text-gray-600">
                    Choose your login type to access the system
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                <x-welcome-tag href="{{ route('admin.login') }}" tag_name="Admin Login" icon="fas fa-user-clock"/>
                <x-welcome-tag href="{{ route('teacher.login') }}" tag_name="Teacher Login" icon="fas fa-person-chalkboard" />
                <x-welcome-tag href="{{ route('login') }}" tag_name="Student Login" icon="fas fa-user-graduate" />
                <x-welcome-tag href="{{ route('school.index') }}" tag_name="Our Schools" icon="fas fa-school-flag" />
                <x-welcome-tag href="{{ route('register') }}" tag_name="Register School" icon="fas fa-school-circle-check" />
            </div>
        </div>
    </section>

    <x-cta-section 
        title="Ready to Transform Your School Management?"
        description="Join Basic and Secondary Schools already using our platform to streamline their academic operations"
        subDescription="Get started in minutes - Register your school today!"
        :buttons="[
            ['href' => route('register'), 'text' => 'Get Started Today'],
            ['href' => route('contact'), 'text' => 'Contact Us', 'class' => 'inline-block px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg border-2 border-indigo-400 hover:bg-indigo-800 transition-all duration-200']
        ]"
    />

</x-main-layout>
