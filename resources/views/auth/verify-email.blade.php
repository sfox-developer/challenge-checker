<x-public-layout>
    <div class="section">
        <div class="container max-w-xl">
            <!-- Header -->
            <div class="text-center mb-8 animate animate-hidden-fade-up" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <h1>
                    Verify your email
                </h1>
                <p class="subtitle">
                    Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="registration-success-box mb-6 animate animate-hidden-fade-up animate-delay-100"
                     x-data="{}"
                     x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="space-y-4 animate animate-hidden-fade-up animate-delay-100" 
                 x-data="{}" 
                 x-init="setTimeout(() => { $el.classList.remove('animate-hidden-fade-up') }, 100)">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block">
                        Resend verification email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="link-muted">
                        Log out
                    </button>
                </form>

                <p class="registration-footer mt-4">
                    <a href="{{ route('login') }}" class="registration-footer-link">
                        Back to login
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-public-layout>
