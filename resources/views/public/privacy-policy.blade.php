<x-public-layout>
    <x-slot name="title">Privacy Policy - {{ config('app.name') }}</x-slot>
    
    <div class="section">
        <div class="container max-w-3xl">
            
            <h1 class="h1 animate animate-hidden-fade-up" 
                x-data="{}" 
                x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">Privacy Policy</h1>
            <p class="subtitle mb-10 animate animate-hidden-fade-up animate-delay-100" 
               x-data="{}" 
               x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">Last updated: December 5, 2025</p>

            <div class="space-y-10">
            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Introduction</h2>
                <div>
                    <p>
                        Welcome to {{ config('app.name') }}. We respect your privacy and are committed to protecting your personal data. 
                        This privacy policy will inform you about how we look after your personal data and tell you about your privacy rights.
                    </p>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Information We Collect</h2>
                <div>
                    <p><strong>Personal Information:</strong></p>
                    <p>We collect the following personal information when you use our service:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li><strong>Account Information:</strong> Name, email address, and password (encrypted)</li>
                        <li><strong>Profile Information:</strong> Avatar image, theme preferences</li>
                        <li><strong>Usage Data:</strong> Challenges, goals, habits, and activity logs you create</li>
                    </ul>
                    
                    <p class="mt-4"><strong>Automatically Collected Information:</strong></p>
                    <p>We automatically collect certain information when you use our service:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Browser type and version</li>
                        <li>IP address</li>
                        <li>Session data</li>
                        <li>Usage patterns and preferences</li>
                    </ul>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">How We Use Your Information</h2>
                <div>
                    <p>We use your personal data for the following purposes:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>To provide and maintain our service</li>
                        <li>To manage your account and provide customer support</li>
                        <li>To enable social features (following users, viewing public challenges)</li>
                        <li>To improve our service and develop new features</li>
                        <li>To send you important updates about the service</li>
                        <li>To ensure security and prevent fraud</li>
                    </ul>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Data Sharing and Disclosure</h2>
                <div>
                    <p>We do not sell your personal data. We may share your information in the following situations:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li><strong>Public Information:</strong> Challenges and activities you mark as public are visible to other users</li>
                        <li><strong>Social Features:</strong> Your profile information is visible to users you follow and who follow you</li>
                        <li><strong>Legal Requirements:</strong> We may disclose your data if required by law or to protect our rights</li>
                    </ul>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Data Security</h2>
                <div>
                    <p>
                        We implement appropriate technical and organizational security measures to protect your personal data. 
                        Your password is encrypted using industry-standard hashing algorithms. However, no method of transmission 
                        over the internet is 100% secure.
                    </p>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Your Privacy Rights</h2>
                <div>
                    <p>You have the following rights regarding your personal data:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li><strong>Access:</strong> Request a copy of your personal data</li>
                        <li><strong>Correction:</strong> Update your personal information in your profile settings</li>
                        <li><strong>Deletion:</strong> Delete your account and all associated data</li>
                        <li><strong>Data Portability:</strong> Request your data in a portable format</li>
                        <li><strong>Withdrawal of Consent:</strong> Withdraw consent for data processing at any time</li>
                    </ul>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Data Retention</h2>
                <div>
                    <p>
                        We retain your personal data for as long as your account is active or as needed to provide you services. 
                        When you delete your account, all your personal data and associated content will be permanently deleted.
                    </p>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Cookies and Tracking</h2>
                <div>
                    <p>
                        We use session cookies to maintain your login state and remember your preferences (like theme selection). 
                        These cookies are essential for the service to function properly.
                    </p>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Children's Privacy</h2>
                <div>
                    <p>
                        Our service is not intended for children under 13 years of age. We do not knowingly collect personal 
                        information from children under 13.
                    </p>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Changes to This Policy</h2>
                <div>
                    <p>
                        We may update this privacy policy from time to time. We will notify you of any changes by posting the 
                        new privacy policy on this page and updating the "Last updated" date.
                    </p>
                </div>
            </section>

            <section class="animate animate-hidden-fade-up" 
                     x-data="{}" 
                     x-intersect="$el.classList.remove('animate-hidden-fade-up')">
                <h2 class="h2">Contact Us</h2>
                <div>
                    <p>
                        If you have any questions about this privacy policy or our privacy practices, please contact us through 
                        your profile settings or by reaching out to our support team.
                    </p>
                </div>
            </section>
        </div>
    </div>
</x-public-layout>
