<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialAuthController extends Controller
{
    /**
     * Supported OAuth providers
     */
    private const SUPPORTED_PROVIDERS = ['google', 'facebook'];

    /**
     * Apply rate limiting to prevent abuse
     */
    public function __construct()
    {
        $this->middleware(['throttle:10,1']);
    }

    /**
     * Redirect to provider's OAuth page
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)
            ->redirect();
    }

    /**
     * Handle callback from provider
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            Log::warning('Social auth failed: Invalid state', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('register')
                ->with('error', 'Authentication failed. Please try again.');
        } catch (\Exception $e) {
            Log::error('Social auth error', [
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('register')
                ->with('error', 'An error occurred during authentication. Please try again.');
        }

        // Find or create user
        $user = $this->findOrCreateUser($socialUser, $provider);

        // Log the user in
        Auth::login($user, remember: true);

        // Redirect to dashboard
        return redirect()->route('dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Validate provider is supported
     */
    private function validateProvider(string $provider): void
    {
        if (!in_array($provider, self::SUPPORTED_PROVIDERS)) {
            abort(404, 'Invalid authentication provider');
        }
    }

    /**
     * Find existing user or create new one
     */
    private function findOrCreateUser($socialUser, string $provider): User
    {
        // 1. Check if user exists with this provider + provider_id
        if ($user = User::where('provider', $provider)
                         ->where('provider_id', $socialUser->getId())
                         ->first()) {
            return $this->updateSocialData($user, $socialUser, $provider);
        }

        // 2. Check if user exists with this email
        if ($user = User::where('email', $socialUser->getEmail())->first()) {
            // Link social account to existing email account
            return $this->linkSocialAccount($user, $socialUser, $provider);
        }

        // 3. Create new user
        return $this->createNewUser($socialUser, $provider);
    }

    /**
     * Update existing user's social data
     */
    private function updateSocialData(User $user, $socialUser, string $provider): User
    {
        $user->update([
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken,
            'avatar_url' => $socialUser->getAvatar(),
        ]);

        return $user;
    }

    /**
     * Link social account to existing email user
     */
    private function linkSocialAccount(User $user, $socialUser, string $provider): User
    {
        // Only link if user doesn't already have a different provider
        if ($user->provider && $user->provider !== $provider) {
            abort(409, 'This email is already linked to a different authentication method.');
        }

        $user->update([
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken,
            'avatar_url' => $socialUser->getAvatar() ?? $user->avatar_url,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ]);

        return $user;
    }

    /**
     * Create new user from social authentication
     */
    private function createNewUser($socialUser, string $provider): User
    {
        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken,
            'avatar_url' => $socialUser->getAvatar(),
            'email_verified_at' => now(), // Auto-verify for social auth
            'password' => null, // No password for social-only accounts
        ]);
    }
}
