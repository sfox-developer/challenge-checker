<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Challenge\Models\Goal;
use App\Domain\Goal\Models\GoalLibrary;
use App\Domain\User\Models\User;
use Illuminate\Support\Facades\DB;

class MigrateGoalsToLibrary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'goals:migrate-to-library {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing challenge goals to the goals library';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('Running in DRY RUN mode - no changes will be made');
        }
        
        $this->info('Starting goals migration to library...');
        
        $users = User::all();
        $totalMigrated = 0;
        $totalCreated = 0;
        
        foreach ($users as $user) {
            $this->info("Processing user: {$user->name} (ID: {$user->id})");
            
            // Get all unique goal names for this user
            $goals = Goal::whereHas('challenge', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
            
            // Group by name (case-insensitive)
            $grouped = $goals->groupBy(function ($goal) {
                return strtolower(trim($goal->name));
            });
            
            foreach ($grouped as $goalName => $goalGroup) {
                // Use the first goal as the template
                $firstGoal = $goalGroup->first();
                
                if (!$dryRun) {
                    // Create or find library goal
                    $libraryGoal = GoalLibrary::firstOrCreate(
                        [
                            'user_id' => $user->id,
                            'name' => $firstGoal->name,
                        ],
                        [
                            'description' => $firstGoal->description,
                            'category' => null,
                            'icon' => null,
                        ]
                    );
                    
                    if ($libraryGoal->wasRecentlyCreated) {
                        $totalCreated++;
                        $this->line("  ✓ Created library goal: {$firstGoal->name}");
                    }
                    
                    // Update all goals with this name to reference the library
                    foreach ($goalGroup as $goal) {
                        $goal->update(['goal_library_id' => $libraryGoal->id]);
                        $totalMigrated++;
                    }
                } else {
                    $this->line("  Would create/update: {$firstGoal->name} ({$goalGroup->count()} instances)");
                    $totalMigrated += $goalGroup->count();
                }
            }
        }
        
        $this->newLine();
        $this->info("Migration complete!");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Library goals created', $totalCreated],
                ['Challenge goals linked', $totalMigrated],
            ]
        );
        
        if ($dryRun) {
            $this->warn('This was a DRY RUN. Run without --dry-run to apply changes.');
        }
        
        return Command::SUCCESS;
    }
}

