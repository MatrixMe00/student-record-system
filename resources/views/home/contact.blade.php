<x-main-layout>
    {{-- Hero Section --}}
    <x-hero-section 
        title="Contact Us"
        subtitle="Get in touch with the EduRecordsGH team. We're here to help Basic and Secondary Schools with their record management needs."
    />

    {{-- Contact Section --}}
    <section class="py-20 px-4 bg-white md:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- Contact Information --}}
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Have questions about EduRecordsGH? Want to learn more about how we can help your school? We'd love to hear from you.
                    </p>

                    {{-- Contact Details --}}
                    <div class="space-y-6 mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Email Us</h3>
                                <p class="text-gray-600 text-sm mb-2">Send us an email and we'll respond within 24 hours</p>
                                <a href="mailto:info@edurecordsgh.com" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    info@edurecordsgh.com
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone text-purple-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Call Us</h3>
                                <p class="text-gray-600 text-sm mb-2">Monday - Friday, 8:00 AM - 5:00 PM GMT</p>
                                <a href="tel:+233XXXXXXXXX" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    +233 XX XXX XXXX
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">WhatsApp</h3>
                                <p class="text-gray-600 text-sm mb-2">Quick support via WhatsApp</p>
                                <a href="https://wa.me/233XXXXXXXXX" target="_blank" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    Chat with us on WhatsApp
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-yellow-600 text-xl"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Location</h3>
                                <p class="text-gray-600 text-sm mb-2">Based in Ghana, serving schools nationwide</p>
                                <p class="text-gray-900 font-medium">Ghana</p>
                            </div>
                        </div>
                    </div>

                    {{-- Response Time Info --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-blue-600 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Response Time</h4>
                                <p class="text-sm text-gray-700">
                                    We typically respond to inquiries within <strong>24 hours</strong> during business days. For urgent matters, please call us directly.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('register') }}" class="block text-indigo-600 hover:text-indigo-700 font-medium">
                                <i class="fas fa-school mr-2"></i> Register Your School
                            </a>
                            <a href="{{ route('school.index') }}" class="block text-indigo-600 hover:text-indigo-700 font-medium">
                                <i class="fas fa-list mr-2"></i> View Our Schools
                            </a>
                            <a href="{{ route('about') }}" class="block text-indigo-600 hover:text-indigo-700 font-medium">
                                <i class="fas fa-info-circle mr-2"></i> Learn More About Us
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div>
                    <div class="bg-gray-50 rounded-xl p-8 border border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Send us a Message</h2>
                            <div class="hidden sm:flex items-center text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>All fields marked * are required</span>
                            </div>
                        </div>
                        <form action="#" method="POST" class="space-y-6" x-data="{ submitting: false }" @submit="submitting = true">
                            @csrf
                            
                            {{-- Name Fields --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="first_name" 
                                        id="first_name" 
                                        required
                                        class="block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="John"
                                    >
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="last_name" 
                                        id="last_name" 
                                        required
                                        class="block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Doe"
                                    >
                                </div>
                            </div>

                            {{-- School Name --}}
                            <div>
                                <label for="school_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                    School Name (Optional)
                                </label>
                                <input 
                                    type="text" 
                                    name="school_name" 
                                    id="school_name"
                                    class="block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Your School Name"
                                >
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    required
                                    class="block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="your.email@example.com"
                                >
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                        +233
                                    </span>
                                    <input 
                                        type="tel" 
                                        name="phone" 
                                        id="phone" 
                                        required
                                        class="block w-full rounded-r-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="XX XXX XXXX"
                                    >
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="subject" 
                                    id="subject" 
                                    required
                                    class="block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Select a subject...</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="registration">School Registration</option>
                                    <option value="support">Technical Support</option>
                                    <option value="pricing">Pricing Information</option>
                                    <option value="partnership">Partnership Opportunities</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            {{-- Message --}}
                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Message <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="message" 
                                    id="message" 
                                    rows="5" 
                                    required
                                    class="block w-full rounded-lg border-gray-300 px-4 py-3 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Tell us how we can help you..."
                                ></textarea>
                            </div>

                            {{-- Privacy Policy --}}
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input 
                                        id="privacy_policy" 
                                        name="privacy_policy" 
                                        type="checkbox" 
                                        required
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="privacy_policy" class="text-gray-600">
                                        I agree to the 
                                        <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold">Privacy Policy</a>
                                        and consent to being contacted by EduRecordsGH.
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div>
                                <button 
                                    type="submit" 
                                    :disabled="submitting"
                                    class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span x-show="!submitting">
                                        Send Message <i class="fas fa-paper-plane ml-2"></i>
                                    </span>
                                    <span x-show="submitting" class="flex items-center justify-center">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Sending...
                                    </span>
                                </button>
                            </div>
                            
                            {{-- Help Text --}}
                            <p class="text-xs text-gray-500 text-center">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Your information is secure and will only be used to respond to your inquiry.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-16 px-4 bg-gray-50 md:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600">
                    Quick answers to common questions about EduRecordsGH
                </p>
            </div>

            <div class="space-y-4" x-data="{ openFaq: null }">
                @php
                    $faqs = [
                        [
                            'question' => 'How do I register my school?',
                            'answer' => 'Click on "Register Your School" in the navigation menu or visit the registration page. You\'ll need to provide your school details and create an admin account. The process is simple and takes just a few minutes.'
                        ],
                        [
                            'question' => 'Is EduRecordsGH free to use?',
                            'answer' => 'EduRecordsGH offers flexible pricing plans for Basic and Secondary Schools. Contact us to learn more about our pricing options and find a plan that works for your school.'
                        ],
                        [
                            'question' => 'What types of schools can use EduRecordsGH?',
                            'answer' => 'EduRecordsGH is designed specifically for Basic Schools (Primary) and Secondary Schools (JHS and SHS) in Ghana. Both public and private schools are welcome to use our platform.'
                        ],
                        [
                            'question' => 'How secure is my school\'s data?',
                            'answer' => 'We take data security seriously. Each school\'s data is completely isolated and secure. We use industry-standard encryption and security practices to protect your information.'
                        ],
                        [
                            'question' => 'Can I try EduRecordsGH before committing?',
                            'answer' => 'Yes! Contact us to schedule a demo or trial period. We\'d be happy to show you how EduRecordsGH can benefit your school.'
                        ],
                        [
                            'question' => 'What kind of support do you provide?',
                            'answer' => 'We provide comprehensive support including email support, phone support during business hours, WhatsApp support, and detailed documentation. Our team is here to help you succeed.'
                        ]
                    ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <button 
                            @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                            class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors"
                        >
                            <span class="font-semibold text-gray-900">{{ $faq['question'] }}</span>
                            <i 
                                class="fas fa-chevron-down text-indigo-600 transition-transform duration-200"
                                :class="{ 'rotate-180': openFaq === {{ $index }} }"
                            ></i>
                        </button>
                        <div 
                            x-show="openFaq === {{ $index }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-96"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 max-h-96"
                            x-transition:leave-end="opacity-0 max-h-0"
                            class="overflow-hidden"
                        >
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <p class="text-gray-700 leading-relaxed">{{ $faq['answer'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-6">
                    Still have questions? We're here to help!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('about') }}" class="px-6 py-3 bg-white text-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors font-semibold">
                        Learn More About Us
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                        Register Your School
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-main-layout>
