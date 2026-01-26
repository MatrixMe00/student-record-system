<x-main-layout>
    <x-hero-section 
        title="Privacy Policy"
        subtitle="Your privacy and data security are important to us. Learn how EduRecordsGH protects your information."
    />

    {{-- Privacy Policy Content --}}
    <section class="py-12 sm:py-16 lg:py-20 px-4 bg-white md:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-lg max-w-none">
                <p class="text-sm text-gray-500 mb-6">
                    <strong>Last Updated:</strong> {{ date('F j, Y') }}
                </p>

                <div class="space-y-8">
                    {{-- Introduction --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            Welcome to <strong>EduRecordsGH</strong>. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our student record management system.
                        </p>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            By using EduRecordsGH, you agree to the collection and use of information in accordance with this policy. If you do not agree with our policies and practices, please do not use our service.
                        </p>
                    </div>

                    {{-- Information We Collect --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">2.1 Personal Information</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We collect information that you provide directly to us, including:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>School registration information (school name, address, contact details)</li>
                            <li>Administrator and staff account information (names, email addresses, usernames)</li>
                            <li>Student information (names, student IDs, academic records, grades, attendance)</li>
                            <li>Teacher information (names, qualifications, class assignments)</li>
                            <li>Payment and billing information (processed securely through Paystack)</li>
                            <li>Communication data (messages sent through our contact forms)</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">2.2 Automatically Collected Information</h3>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            When you access our platform, we may automatically collect:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Device information (IP address, browser type, operating system)</li>
                            <li>Usage data (pages visited, features used, time spent on platform)</li>
                            <li>Cookies and similar tracking technologies</li>
                        </ul>
                    </div>

                    {{-- How We Use Information --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We use the collected information for the following purposes:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li><strong>Service Provision:</strong> To provide, maintain, and improve our student record management services</li>
                            <li><strong>Account Management:</strong> To create and manage user accounts, authenticate users, and process transactions</li>
                            <li><strong>Academic Records:</strong> To store, manage, and process student academic records, grades, and attendance</li>
                            <li><strong>Communication:</strong> To respond to inquiries, send notifications, and provide customer support</li>
                            <li><strong>Payment Processing:</strong> To process payments securely through our payment gateway partners</li>
                            <li><strong>Security:</strong> To detect, prevent, and address technical issues, fraud, or security threats</li>
                            <li><strong>Compliance:</strong> To comply with legal obligations and educational regulations in Ghana</li>
                        </ul>
                    </div>

                    {{-- Data Sharing and Disclosure --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">4. Data Sharing and Disclosure</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We do not sell, trade, or rent your personal information to third parties. We may share information only in the following circumstances:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li><strong>Multi-Tenant Isolation:</strong> Your school's data is completely isolated from other schools on the platform</li>
                            <li><strong>Service Providers:</strong> With trusted third-party service providers (e.g., payment processors, hosting services) who assist in operating our platform</li>
                            <li><strong>Legal Requirements:</strong> When required by law, court order, or government regulation</li>
                            <li><strong>School Authorization:</strong> With authorized school administrators and staff as designated by your school</li>
                            <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets (with prior notice)</li>
                        </ul>
                    </div>

                    {{-- Data Security --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">5. Data Security</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We implement appropriate technical and organizational security measures to protect your information:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Encryption of data in transit and at rest</li>
                            <li>Secure authentication and access controls</li>
                            <li>Regular security audits and vulnerability assessments</li>
                            <li>Role-based access control to ensure only authorized users access data</li>
                            <li>Regular data backups and disaster recovery procedures</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            However, no method of transmission over the internet or electronic storage is 100% secure. While we strive to protect your information, we cannot guarantee absolute security.
                        </p>
                    </div>

                    {{-- Data Retention --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">6. Data Retention</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We retain your personal information for as long as necessary to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Provide our services to your school</li>
                            <li>Comply with legal obligations and educational record-keeping requirements</li>
                            <li>Resolve disputes and enforce our agreements</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            When you close your account, we will retain certain information as required by law or for legitimate business purposes. Academic records may be retained longer to comply with educational regulations.
                        </p>
                    </div>

                    {{-- Your Rights --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">7. Your Rights</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            You have the following rights regarding your personal information:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li><strong>Access:</strong> Request access to your personal information</li>
                            <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information</li>
                            <li><strong>Deletion:</strong> Request deletion of your personal information (subject to legal requirements)</li>
                            <li><strong>Objection:</strong> Object to processing of your personal information</li>
                            <li><strong>Data Portability:</strong> Request transfer of your data to another service provider</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            To exercise these rights, please contact us using the information provided in the "Contact Us" section below.
                        </p>
                    </div>

                    {{-- Children's Privacy --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">8. Children's Privacy</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            EduRecordsGH is designed for use by Basic and Secondary Schools in Ghana. Student information is collected and managed by authorized school administrators. We comply with applicable laws regarding the protection of children's privacy and educational records.
                        </p>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            Parents and guardians may request access to their child's educational records through the school administration, in accordance with school policies and applicable laws.
                        </p>
                    </div>

                    {{-- Cookies --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">9. Cookies and Tracking Technologies</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We use cookies and similar tracking technologies to:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Maintain your session and authentication state</li>
                            <li>Remember your preferences and settings</li>
                            <li>Analyze platform usage and improve our services</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            You can control cookie preferences through your browser settings. However, disabling cookies may affect the functionality of our platform.
                        </p>
                    </div>

                    {{-- Changes to Privacy Policy --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">10. Changes to This Privacy Policy</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            We may update this Privacy Policy from time to time. We will notify you of any changes by:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-base sm:text-lg text-gray-700 mb-4 ml-4">
                            <li>Posting the new Privacy Policy on this page</li>
                            <li>Updating the "Last Updated" date</li>
                            <li>Sending email notifications for material changes</li>
                        </ul>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                            We encourage you to review this Privacy Policy periodically to stay informed about how we protect your information.
                        </p>
                    </div>

                    {{-- Contact Us --}}
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">11. Contact Us</h2>
                        <p class="text-base sm:text-lg text-gray-700 leading-relaxed mb-4">
                            If you have any questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:
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
                </div>
            </div>
        </div>
    </section>
</x-main-layout>
