<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Terms of Service" gradient="primary">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Terms of Service</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last updated: December 5, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="prose dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-gray-100">
                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Agreement to Terms
                    </h2>
                    <p>
                        By accessing or using {{ config('app.name') }}, you agree to be bound by these Terms of Service. 
                        If you disagree with any part of these terms, you may not access the service.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Description of Service
                    </h2>
                    <p>
                        {{ config('app.name') }} is a personal goal tracking and challenge management platform that allows users to:
                    </p>
                    <ul>
                        <li>Create and track personal challenges</li>
                        <li>Manage daily habits and routines</li>
                        <li>Build and organize a goal library</li>
                        <li>Follow other users and view their public activities</li>
                        <li>Participate in a social activity feed</li>
                    </ul>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        User Accounts
                    </h2>
                    <h3 class="text-lg font-semibold mt-6 mb-3 text-purple-600 dark:text-purple-400">Account Creation</h3>
                    <p>To use our service, you must:</p>
                    <ul>
                        <li>Be at least 13 years of age</li>
                        <li>Provide accurate and complete registration information</li>
                        <li>Maintain the security of your password</li>
                        <li>Notify us immediately of any unauthorized use of your account</li>
                    </ul>

                    <h3 class="text-lg font-semibold mt-6 mb-3 text-purple-600 dark:text-purple-400">Account Responsibilities</h3>
                    <p>You are responsible for:</p>
                    <ul>
                        <li>All activities that occur under your account</li>
                        <li>Maintaining the confidentiality of your login credentials</li>
                        <li>All content you post or share through the service</li>
                    </ul>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        User Content
                    </h2>
                    <h3 class="text-lg font-semibold mt-6 mb-3 text-purple-600 dark:text-purple-400">Your Content</h3>
                    <p>You retain all rights to the content you create (challenges, goals, habits, activities). By using our service, you grant us a license to:</p>
                    <ul>
                        <li>Store and display your content as necessary to provide the service</li>
                        <li>Share your public content with other users as you specify</li>
                        <li>Use aggregated, anonymized data for service improvement</li>
                    </ul>

                    <h3 class="text-lg font-semibold mt-6 mb-3 text-purple-600 dark:text-purple-400">Content Standards</h3>
                    <p>You agree not to post content that:</p>
                    <ul>
                        <li>Is illegal, harmful, threatening, abusive, or harassing</li>
                        <li>Infringes on intellectual property rights</li>
                        <li>Contains viruses or malicious code</li>
                        <li>Violates any applicable laws or regulations</li>
                        <li>Impersonates another person or entity</li>
                    </ul>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Privacy Settings
                    </h2>
                    <p>
                        You control the visibility of your challenges and activities through privacy settings. Content marked as "public" 
                        will be visible to other users. Please review our <a href="{{ route('privacy.policy') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a> 
                        for more information on how we handle your data.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Social Features
                    </h2>
                    <p>Our service includes social features such as following other users and viewing public activities. When using these features:</p>
                    <ul>
                        <li>Respect other users' privacy and content</li>
                        <li>Do not spam, harass, or abuse the follow/like features</li>
                        <li>Be respectful in all interactions</li>
                    </ul>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Prohibited Activities
                    </h2>
                    <p>You may not:</p>
                    <ul>
                        <li>Use automated systems (bots) to access the service without permission</li>
                        <li>Attempt to gain unauthorized access to any part of the service</li>
                        <li>Interfere with or disrupt the service or servers</li>
                        <li>Use the service for any unlawful purpose</li>
                        <li>Reverse engineer or attempt to extract source code</li>
                        <li>Collect user information without consent</li>
                    </ul>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Service Availability
                    </h2>
                    <p>
                        We strive to provide reliable service, but we do not guarantee that the service will be uninterrupted or error-free. 
                        We may modify, suspend, or discontinue any part of the service at any time with or without notice.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Intellectual Property
                    </h2>
                    <p>
                        The service, including its design, functionality, and content (excluding user-generated content), is owned by 
                        {{ config('app.name') }} and is protected by copyright, trademark, and other intellectual property laws.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Termination
                    </h2>
                    <p>We may terminate or suspend your account and access to the service immediately, without prior notice, if you:</p>
                    <ul>
                        <li>Breach these Terms of Service</li>
                        <li>Engage in prohibited activities</li>
                        <li>Request account deletion</li>
                    </ul>
                    <p>
                        You may terminate your account at any time through your profile settings. Upon termination, all your data 
                        will be permanently deleted.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Disclaimer of Warranties
                    </h2>
                    <p>
                        The service is provided "AS IS" and "AS AVAILABLE" without warranties of any kind, either express or implied. 
                        We do not warrant that the service will be uninterrupted, secure, or error-free.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Limitation of Liability
                    </h2>
                    <p>
                        To the maximum extent permitted by law, {{ config('app.name') }} shall not be liable for any indirect, incidental, 
                        special, consequential, or punitive damages resulting from your use of or inability to use the service.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Changes to Terms
                    </h2>
                    <p>
                        We reserve the right to modify these terms at any time. We will notify users of any material changes by 
                        posting the new terms and updating the "Last updated" date. Your continued use of the service after 
                        changes constitutes acceptance of the new terms.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Governing Law
                    </h2>
                    <p>
                        These Terms shall be governed by and construed in accordance with applicable laws, without regard to 
                        conflict of law provisions.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Contact Information
                    </h2>
                    <p>
                        If you have any questions about these Terms of Service, please contact us through your profile settings 
                        or by reaching out to our support team.
                    </p>

                    <h2 class="flex items-center text-xl font-semibold mt-8 mb-4">
                        <span class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded mr-3"></span>
                        Acknowledgment
                    </h2>
                    <p>
                        By using {{ config('app.name') }}, you acknowledge that you have read, understood, and agree to be bound 
                        by these Terms of Service.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
