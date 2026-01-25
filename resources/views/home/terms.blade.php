<x-main-layout>
    <x-hero-section 
        title="Terms of Service"
        subtitle="Please read these terms carefully before using EduRecordsGH. By using our service, you agree to these terms."
    />

    {{-- Terms of Service Content --}}
    <section class="py-12 sm:py-16 lg:py-20 px-4 bg-white md:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                <p class="text-sm text-gray-500 mb-6">
                    <strong>Last Updated:</strong> {{ date('F j, Y') }}
                </p>

                <div class="space-y-8">
                    {{-- Introduction --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">1. Acceptance of Terms</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            Welcome to <strong>EduRecordsGH</strong>, a multi-tenant student record management system designed for Basic and Secondary Schools in Ghana. These Terms of Service ("Terms") govern your access to and use of our platform, services, and website.
                        </p>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            By accessing or using EduRecordsGH, you agree to be bound by these Terms. If you do not agree to these Terms, you may not access or use our services. These Terms apply to all users, including schools, administrators, teachers, students, and visitors.
                        </p>
                    </div>

                    {{-- Description of Service --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">2. Description of Service</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            EduRecordsGH provides a comprehensive digital platform for schools to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Manage student records, academic information, and attendance</li>
                            <li>Record and manage grades, assessments, and examination results</li>
                            <li>Process payments and manage billing through integrated payment gateways</li>
                            <li>Generate reports and export data in various formats</li>
                            <li>Manage teacher assignments and class schedules</li>
                            <li>Track student progress and academic performance</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            We reserve the right to modify, suspend, or discontinue any aspect of our service at any time, with or without notice.
                        </p>
                    </div>

                    {{-- Account Registration --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">3. Account Registration and Responsibilities</h2>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">3.1 School Registration</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            To use EduRecordsGH, schools must register and create an account. You agree to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Provide accurate, current, and complete information during registration</li>
                            <li>Maintain and promptly update your account information</li>
                            <li>Maintain the security of your account credentials</li>
                            <li>Accept responsibility for all activities that occur under your account</li>
                            <li>Notify us immediately of any unauthorized access or security breach</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">3.2 User Accounts</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            School administrators are responsible for:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Creating and managing user accounts for teachers, staff, and students</li>
                            <li>Ensuring appropriate access levels and permissions are assigned</li>
                            <li>Maintaining the accuracy of student and staff information</li>
                            <li>Complying with applicable data protection and privacy laws</li>
                        </ul>
                    </div>

                    {{-- Acceptable Use --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">4. Acceptable Use Policy</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            You agree not to use EduRecordsGH to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Violate any applicable laws, regulations, or educational policies</li>
                            <li>Infringe upon the rights of others, including intellectual property rights</li>
                            <li>Upload, transmit, or store malicious code, viruses, or harmful software</li>
                            <li>Attempt to gain unauthorized access to other schools' data or system resources</li>
                            <li>Interfere with or disrupt the service or servers connected to the service</li>
                            <li>Use automated systems (bots, scrapers) to access the service without permission</li>
                            <li>Impersonate any person or entity or misrepresent your affiliation</li>
                            <li>Collect or harvest information about other users without consent</li>
                            <li>Use the service for any illegal or unauthorized purpose</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            Violation of these terms may result in immediate termination of your account and legal action.
                        </p>
                    </div>

                    {{-- Data and Privacy --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">5. Data Ownership and Privacy</h2>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">5.1 Data Ownership</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            Schools retain full ownership of all data, including student records, academic information, and other content uploaded to EduRecordsGH. We do not claim ownership of your data.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">5.2 Data Isolation</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            As a multi-tenant platform, we ensure complete data isolation between schools. Your school's data is completely separate and inaccessible to other schools on the platform.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">5.3 Privacy</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            Your use of EduRecordsGH is also governed by our <a href="{{ route('privacy') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Privacy Policy</a>, which explains how we collect, use, and protect your information. By using our service, you consent to the collection and use of information as described in the Privacy Policy.
                        </p>
                    </div>

                    {{-- Payment Terms --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">6. Payment Terms</h2>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">6.1 Fees</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            Some features of EduRecordsGH may require payment. We will clearly communicate any fees associated with your use of the service. Payment processing is handled securely through our payment gateway partners (e.g., Paystack).
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">6.2 Payment Obligations</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            You agree to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Pay all fees associated with your account in a timely manner</li>
                            <li>Provide accurate payment information</li>
                            <li>Authorize us to charge your payment method for applicable fees</li>
                            <li>Notify us of any changes to your payment information</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">6.3 Refunds</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            Refund policies, if applicable, will be communicated at the time of purchase. We reserve the right to modify our pricing and refund policies with reasonable notice.
                        </p>
                    </div>

                    {{-- Intellectual Property --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">7. Intellectual Property Rights</h2>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">7.1 Our Rights</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            EduRecordsGH, including its software, design, logos, trademarks, and content, is owned by us or our licensors and is protected by intellectual property laws. You may not copy, modify, distribute, or create derivative works without our express written permission.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">7.2 Your Content</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            You retain ownership of content you upload to EduRecordsGH. However, by uploading content, you grant us a limited, non-exclusive license to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Store, process, and display your content as necessary to provide our services</li>
                            <li>Create backups and ensure data availability</li>
                            <li>Improve and optimize our services</li>
                        </ul>
                    </div>

                    {{-- Service Availability --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">8. Service Availability and Modifications</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We strive to provide reliable and continuous service. However:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>We do not guarantee uninterrupted or error-free service</li>
                            <li>We may perform scheduled maintenance with advance notice when possible</li>
                            <li>We reserve the right to modify, suspend, or discontinue features at any time</li>
                            <li>We are not liable for any downtime, data loss, or service interruptions</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            We recommend maintaining your own backups of critical data.
                        </p>
                    </div>

                    {{-- Limitation of Liability --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">9. Limitation of Liability</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            To the maximum extent permitted by law:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>EduRecordsGH is provided "as is" and "as available" without warranties of any kind</li>
                            <li>We disclaim all warranties, express or implied, including merchantability and fitness for a particular purpose</li>
                            <li>We are not liable for any indirect, incidental, special, or consequential damages</li>
                            <li>Our total liability shall not exceed the amount you paid us in the 12 months preceding the claim</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            This limitation does not affect your rights as a consumer under applicable Ghanaian law.
                        </p>
                    </div>

                    {{-- Indemnification --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">10. Indemnification</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            You agree to indemnify, defend, and hold harmless EduRecordsGH, its officers, directors, employees, and agents from any claims, damages, losses, liabilities, and expenses (including legal fees) arising from:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Your use of the service</li>
                            <li>Your violation of these Terms</li>
                            <li>Your violation of any rights of another party</li>
                            <li>Content you upload or transmit through the service</li>
                        </ul>
                    </div>

                    {{-- Termination --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">11. Termination</h2>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">11.1 Termination by You</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            You may terminate your account at any time by contacting us. Upon termination, you may request export of your data, subject to applicable data retention requirements.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">11.2 Termination by Us</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We may suspend or terminate your account immediately if:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>You violate these Terms or our Acceptable Use Policy</li>
                            <li>You fail to pay required fees</li>
                            <li>We suspect fraudulent or illegal activity</li>
                            <li>Required by law or regulatory authority</li>
                        </ul>
                    </div>

                    {{-- Governing Law --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">12. Governing Law and Dispute Resolution</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            These Terms are governed by the laws of Ghana. Any disputes arising from these Terms or your use of EduRecordsGH shall be resolved through:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Good faith negotiation between the parties</li>
                            <li>Mediation, if negotiation fails</li>
                            <li>Arbitration or litigation in courts of competent jurisdiction in Ghana</li>
                        </ul>
                    </div>

                    {{-- Changes to Terms --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">13. Changes to Terms</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We reserve the right to modify these Terms at any time. We will notify you of material changes by:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Posting the updated Terms on this page</li>
                            <li>Updating the "Last Updated" date</li>
                            <li>Sending email notifications for significant changes</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            Your continued use of EduRecordsGH after changes become effective constitutes acceptance of the modified Terms.
                        </p>
                    </div>

                    {{-- Contact Information --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">14. Contact Information</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            If you have any questions about these Terms of Service, please contact us:
                        </p>
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <p class="text-base sm:text-lg text-gray-700 mb-2">
                                <strong>EduRecordsGH</strong>
                            </p>
                            <p class="text-base sm:text-lg text-gray-700 mb-2">
                                Email: <a href="mailto:info@edurecordsgh.com" class="text-indigo-600 hover:text-indigo-700">info@edurecordsgh.com</a>
                            </p>
                            <p class="text-base sm:text-lg text-gray-700">
                                <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Contact Us Page</a>
                            </p>
                        </div>
                    </div>

                    {{-- Acknowledgment --}}
                    <div class="bg-indigo-50 rounded-lg p-6 border border-indigo-200 mt-8">
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            <strong>By using EduRecordsGH, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-main-layout>
