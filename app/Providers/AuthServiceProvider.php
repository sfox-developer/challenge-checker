<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Domain\Challenge\Models\Challenge;
use App\Domain\Goal\Models\Goal;
use App\Domain\Habit\Models\Habit;
use App\Policies\ChallengePolicy;
use App\Policies\GoalPolicy;
use App\Policies\HabitPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Challenge::class => ChallengePolicy::class,
        Goal::class => GoalPolicy::class,
        Habit::class => HabitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}