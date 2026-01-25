<x-main-layout>
    <x-hero-section 
        title="About EduRecordsGH"
        subtitle="Empowering Basic and Secondary Schools with Digital Record Management"
    />

    {{-- About Section --}}
    <section class="py-20 px-4 bg-white md:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Who We Are</h2>
                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                    <strong>EduRecordsGH</strong> is a comprehensive multi-tenant student record management system designed specifically for Basic Schools and Secondary Schools in Ghana. Our platform provides schools with a complete digital solution to manage students, grades, payments, and academic activities all in one place.
                </p>
                <p class="text-lg text-gray-700 leading-relaxed mb-6">
                    We understand the challenges that schools face in managing academic records manually. That's why we've built a system that streamlines operations, reduces paperwork, and provides real-time access to student information for administrators, teachers, students, and parents.
                </p>
            </div>
        </div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-20 px-4 bg-gray-50 md:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-8 bg-white rounded-xl shadow-md">
                    <div class="w-16 h-16 bg-indigo-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                    <p class="text-gray-700 leading-relaxed">
                        To empower Basic and Secondary Schools across Ghana with modern, efficient, and secure digital tools that simplify academic record management, enabling educators to focus on what matters most - teaching and student development.
                    </p>
                </div>

                <div class="p-8 bg-white rounded-xl shadow-md">
                    <div class="w-16 h-16 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                    <p class="text-gray-700 leading-relaxed">
                        To become the leading student record management platform in Ghana, transforming how schools handle academic data and making quality education administration accessible to all educational institutions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- What We Offer --}}
    <section class="py-20 px-4 bg-white md:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    What EduRecordsGH Offers
                </h2>
                <p class="text-xl text-gray-600">
                    Comprehensive solutions tailored for Basic and Secondary Schools
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-feature-card 
                    icon="fas fa-users" 
                    title="Multi-School Platform" 
                    description="Support for multiple schools with complete data isolation and security."
                    iconBg="indigo"
                    gradientFrom="blue"
                    variant="simple"
                />
                <x-feature-card 
                    icon="fas fa-user-graduate" 
                    title="Student Management" 
                    description="Complete student registration, profiles, and academic tracking."
                    iconBg="purple"
                    gradientFrom="purple"
                    variant="simple"
                />
                <x-feature-card 
                    icon="fas fa-chart-bar" 
                    title="Grade Management" 
                    description="Streamlined grade entry, approval workflow, and result reporting."
                    iconBg="green"
                    gradientFrom="green"
                    variant="simple"
                />
                <x-feature-card 
                    icon="fas fa-money-bill-wave" 
                    title="Payment Integration" 
                    description="Seamless Paystack integration for payments and billing."
                    iconBg="yellow"
                    gradientFrom="yellow"
                    variant="simple"
                />
                <x-feature-card 
                    icon="fas fa-file-pdf" 
                    title="Report Generation" 
                    description="Export results to Excel and PDF formats for easy sharing."
                    iconBg="red"
                    gradientFrom="red"
                    variant="simple"
                />
                <x-feature-card 
                    icon="fas fa-shield-alt" 
                    title="Secure & Reliable" 
                    description="Role-based access control with complete data security."
                    iconBg="cyan"
                    gradientFrom="cyan"
                    variant="simple"
                />
            </div>
        </div>
    </section>

    <x-target-audience-section 
        title="Designed for Ghanaian Schools"
        description="EduRecordsGH is specifically built for Basic Schools and Secondary Schools in Ghana, including:"
    />

    <x-cta-section 
        title="Ready to Transform Your School?"
        description="Join Basic and Secondary Schools already using EduRecordsGH to streamline their operations"
        :buttons="[
            ['href' => route('register'), 'text' => 'Register Your School'],
            ['href' => route('contact'), 'text' => 'Contact Us', 'class' => 'inline-block px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg border-2 border-indigo-400 hover:bg-indigo-800 transition-all duration-200']
        ]"
    />

</x-main-layout>
