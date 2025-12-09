<x-guest-layout>
    <!-- Header -->
    <div class="auth-header">
        <h1 class="auth-title">
            Verify your email
        </h1>
        <p class="auth-subtitle">
            Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 text-success">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-submit">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="link-muted">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
