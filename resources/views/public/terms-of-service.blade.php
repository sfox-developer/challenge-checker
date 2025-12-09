<x-public-layout>
    <x-slot name="title">Terms of Service - {{ config('app.name') }}</x-slot>
    
    <div class="section">
        <div class="container max-w-3xl">

            <h1 class="h1">Terms of Service</h1>
            <p class="subtitle mb-10">Last updated: December 5, 2025</p>

            <div class="space-y-10">
            <section>
                <h2 class="h2">Agreement to Terms</h2>
                <div>
                    <p>
                        By accessing or using {{ config('app.name') }}, you agree to be bound by these Terms of Service. 
                        If you disagree with any part of these terms, you may not access the service.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Description of Service</h2>
                <div>
                    <p>{{ config('app.name') }} is a personal goal tracking and challenge management platform that allows users to:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Create and track personal challenges</li>
                        <li>Manage daily habits and routines</li>
                        <li>Build and organize a goal library</li>
                        <li>Follow other users and view their public activities</li>
                        <li>Participate in a social activity feed</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="h2">User Accounts</h2>
                <div>
                    <p><strong>Account Creation</strong></p>
                    <p>To use our service, you must:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Be at least 13 years of age</li>
                        <li>Provide accurate and complete registration information</li>
                        <li>Maintain the security of your password</li>
                        <li>Notify us immediately of any unauthorized use of your account</li>
                    </ul>
                    
                    <p class="mt-4"><strong>Account Responsibilities</strong></p>
                    <p>You are responsible for:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>All activities that occur under your account</li>
                        <li>Maintaining the confidentiality of your login credentials</li>
                        <li>All content you post or share through the service</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="h2">User Content</h2>
                <div>
                    <p><strong>Your Content</strong></p>
                    <p>You retain all rights to the content you create (challenges, goals, habits, activities). By using our service, you grant us a license to:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Store and display your content as necessary to provide the service</li>
                        <li>Share your public content with other users as you specify</li>
                        <li>Use aggregated, anonymized data for service improvement</li>
                    </ul>
                    
                    <p class="mt-4"><strong>Content Standards</strong></p>
                    <p>You agree not to post content that:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Is illegal, harmful, threatening, abusive, or harassing</li>
                        <li>Infringes on intellectual property rights</li>
                        <li>Contains viruses or malicious code</li>
                        <li>Violates any applicable laws or regulations</li>
                        <li>Impersonates another person or entity</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="h2">Privacy Settings</h2>
                <div>
                    <p>
                        You control the visibility of your challenges and activities through privacy settings. Content marked as "public" 
                        will be visible to other users. Please review our <a href="{{ route('privacy.policy') }}" class="text-link">Privacy Policy</a> 
                        for more information on how we handle your data.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Social Features</h2>
                <div>
                    <p>Our service includes social features such as following other users and viewing public activities. When using these features:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Respect other users' privacy and content</li>
                        <li>Do not spam, harass, or abuse the follow/like features</li>
                        <li>Be respectful in all interactions</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="h2">Prohibited Activities</h2>
                <div>
                    <p>You may not:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Use automated systems (bots) to access the service without permission</li>
                        <li>Attempt to gain unauthorized access to any part of the service</li>
                        <li>Interfere with or disrupt the service or servers</li>
                        <li>Use the service for any unlawful purpose</li>
                        <li>Reverse engineer or attempt to extract source code</li>
                        <li>Collect user information without consent</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="h2">Service Availability</h2>
                <div>
                    <p>
                        We strive to provide reliable service, but we do not guarantee that the service will be uninterrupted or error-free. 
                        We may modify, suspend, or discontinue any part of the service at any time with or without notice.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Intellectual Property</h2>
                <div>
                    <p>
                        The service, including its design, functionality, and content (excluding user-generated content), is owned by 
                        {{ config('app.name') }} and is protected by copyright, trademark, and other intellectual property laws.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Termination</h2>
                <div>
                    <p>We may terminate or suspend your account and access to the service immediately, without prior notice, if you:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Breach these Terms of Service</li>
                        <li>Engage in prohibited activities</li>
                        <li>Request account deletion</li>
                    </ul>
                    <p class="mt-4">
                        You may terminate your account at any time through your profile settings. Upon termination, all your data 
                        will be permanently deleted.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Disclaimer of Warranties</h2>
                <div>
                    <p>
                        The service is provided "AS IS" and "AS AVAILABLE" without warranties of any kind, either express or implied. 
                        We do not warrant that the service will be uninterrupted, secure, or error-free.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Limitation of Liability</h2>
                <div>
                    <p>
                        To the maximum extent permitted by law, {{ config('app.name') }} shall not be liable for any indirect, incidental, 
                        special, consequential, or punitive damages resulting from your use of or inability to use the service.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Changes to Terms</h2>
                <div>
                    <p>
                        We reserve the right to modify these terms at any time. We will notify users of any material changes by 
                        posting the new terms and updating the "Last updated" date. Your continued use of the service after 
                        changes constitutes acceptance of the new terms.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Governing Law</h2>
                <div>
                    <p>
                        These Terms shall be governed by and construed in accordance with applicable laws, without regard to 
                        conflict of law provisions.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Contact Information</h2>
                <div>
                    <p>
                        If you have any questions about these Terms of Service, please contact us through your profile settings 
                        or by reaching out to our support team.
                    </p>
                </div>
            </section>

            <section>
                <h2 class="h2">Acknowledgment</h2>
                <div>
                    <p>
                        By using {{ config('app.name') }}, you acknowledge that you have read, understood, and agree to be bound 
                        by these Terms of Service.
                    </p>
                </div>
            </section>
        </div>
    </div>
</x-public-layout>
