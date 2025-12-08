<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Privacy Policy">
            <x-slot name="icon">
                <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card">
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-slate-100 dark:bg-slate-900 rounded-lg">
                            <svg class="w-6 h-6 text-slate-700 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="h1">Privacy Policy</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last updated: December 5, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="prose dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-gray-100">
                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Introduction
                    </h2>
                    <p>
                        Welcome to {{ config('app.name') }}. We respect your privacy and are committed to protecting your personal data. 
                        This privacy policy will inform you about how we look after your personal data and tell you about your privacy rights.
                    </p>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Information We Collect
                    </h2>
                    <h3 class="h3 h3-muted mt-6 mb-3">Personal Information</h3>
                    <p>We collect the following personal information when you use our service:</p>
                    <ul>
                        <li><strong>Account Information:</strong> Name, email address, and password (encrypted)</li>
                        <li><strong>Profile Information:</strong> Avatar image, theme preferences</li>
                        <li><strong>Usage Data:</strong> Challenges, goals, habits, and activity logs you create</li>
                    </ul>

                    <h3 class="h3 h3-muted mt-6 mb-3">Automatically Collected Information</h3>
                    <p>We automatically collect certain information when you use our service:</p>
                    <ul>
                        <li>Browser type and version</li>
                        <li>IP address</li>
                        <li>Session data</li>
                        <li>Usage patterns and preferences</li>
                    </ul>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        How We Use Your Information
                    </h2>
                    <p>We use your personal data for the following purposes:</p>
                    <ul>
                        <li>To provide and maintain our service</li>
                        <li>To manage your account and provide customer support</li>
                        <li>To enable social features (following users, viewing public challenges)</li>
                        <li>To improve our service and develop new features</li>
                        <li>To send you important updates about the service</li>
                        <li>To ensure security and prevent fraud</li>
                    </ul>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Data Sharing and Disclosure
                    </h2>
                    <p>We do not sell your personal data. We may share your information in the following situations:</p>
                    <ul>
                        <li><strong>Public Information:</strong> Challenges and activities you mark as public are visible to other users</li>
                        <li><strong>Social Features:</strong> Your profile information is visible to users you follow and who follow you</li>
                        <li><strong>Legal Requirements:</strong> We may disclose your data if required by law or to protect our rights</li>
                    </ul>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Data Security
                    </h2>
                    <p>
                        We implement appropriate technical and organizational security measures to protect your personal data. 
                        Your password is encrypted using industry-standard hashing algorithms. However, no method of transmission 
                        over the internet is 100% secure.
                    </p>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Your Privacy Rights
                    </h2>
                    <p>You have the following rights regarding your personal data:</p>
                    <ul>
                        <li><strong>Access:</strong> Request a copy of your personal data</li>
                        <li><strong>Correction:</strong> Update your personal information in your profile settings</li>
                        <li><strong>Deletion:</strong> Delete your account and all associated data</li>
                        <li><strong>Data Portability:</strong> Request your data in a portable format</li>
                        <li><strong>Withdrawal of Consent:</strong> Withdraw consent for data processing at any time</li>
                    </ul>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Data Retention
                    </h2>
                    <p>
                        We retain your personal data for as long as your account is active or as needed to provide you services. 
                        When you delete your account, all your personal data and associated content will be permanently deleted.
                    </p>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Cookies and Tracking
                    </h2>
                    <p>
                        We use session cookies to maintain your login state and remember your preferences (like theme selection). 
                        These cookies are essential for the service to function properly.
                    </p>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Children's Privacy
                    </h2>
                    <p>
                        Our service is not intended for children under 13 years of age. We do not knowingly collect personal 
                        information from children under 13.
                    </p>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Changes to This Policy
                    </h2>
                    <p>
                        We may update this privacy policy from time to time. We will notify you of any changes by posting the 
                        new privacy policy on this page and updating the "Last updated" date.
                    </p>

                    <h2 class="h2 h2-with-icon mt-8 mb-4">
                        <span class="w-2 h-8 bg-slate-200 dark:bg-slate-800 rounded mr-3"></span>
                        Contact Us
                    </h2>
                    <p>
                        If you have any questions about this privacy policy or our privacy practices, please contact us through 
                        your profile settings or by reaching out to our support team.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
