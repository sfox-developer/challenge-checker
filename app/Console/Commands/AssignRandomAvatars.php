<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\User\Models\User;

class AssignRandomAvatars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-random-avatars 
                            {--force : Force update all users, not just those without avatars}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign random avatars to users who don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Assigning random avatars to users...');

        // Get list of valid avatars
        $validAvatars = User::getAvailableAvatars();

        // Query users based on force flag
        $query = User::query();
        
        if (!$this->option('force')) {
            // Only update users with no avatar, default avatar, or invalid avatar
            $query->where(function ($q) use ($validAvatars) {
                $q->whereNull('avatar')
                  ->orWhere('avatar', 'default')
                  ->orWhere('avatar', 'pet-6') // Old default
                  ->orWhereNotIn('avatar', $validAvatars); // Invalid avatars like 'avatar-1'
            });
        }

        $users = $query->get();

        if ($users->isEmpty()) {
            $this->info('No users found to update.');
            return self::SUCCESS;
        }

        $this->info("Found {$users->count()} user(s) to update.");

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        $updated = 0;
        foreach ($users as $user) {
            // Skip if user has avatar_url (social auth avatar)
            if ($user->avatar_url) {
                $bar->advance();
                continue;
            }

            $randomAvatar = User::getRandomAvatar();
            $user->update(['avatar' => $randomAvatar]);
            $updated++;
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Successfully updated {$updated} user(s) with random avatars.");

        return self::SUCCESS;
    }
}
