<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domain\Goal\Models\Goal;
use App\Domain\Goal\Models\GoalCompletion;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GoalCompletionController extends Controller
{
    /**
     * Complete a goal for a specific date (typically today)
     */
    public function store(Request $request, Goal $goal): JsonResponse
    {
        $user = auth()->user();
        
        $request->validate([
            'date' => 'sometimes|date',
            'notes' => 'sometimes|string|max:500',
            'duration_minutes' => 'sometimes|integer|min:1|max:1440',
            'mood' => 'sometimes|string|in:energetic,happy,neutral,tired,stressed',
        ]);
        
        $date = $request->input('date', Carbon::today()->toDateString());
        
        // Check for existing completion
        $existingCompletion = GoalCompletion::forUser($user->id)
            ->forGoal($goal->id)
            ->whereDate('date', $date)
            ->first();
            
        if ($existingCompletion) {
            return response()->json([
                'message' => 'Goal is already completed for this date',
                'already_completed' => true
            ], 422);
        }
        
        // Create the completion record
        $completionData = [
            'user_id' => $user->id,
            'goal_id' => $goal->id,
            'date' => $date,
            'completed_at' => now(),
            'notes' => $request->input('notes'),
            'duration_minutes' => $request->input('duration_minutes'),
            'mood' => $request->input('mood'),
            'metadata' => $request->input('metadata', [])
        ];
        
        $completion = GoalCompletion::create($completionData);
        
        // Create activity feed entry (if applicable)
        $this->createActivityEntry($user, $goal, $completion);
        
        return response()->json([
            'message' => "Goal '{$goal->name}' completed successfully!",
            'completion' => [
                'id' => $completion->id,
                'date' => $completion->date->toDateString(),
                'completed_at' => $completion->completed_at->toISOString(),
                'notes' => $completion->notes,
            ]
        ]);
    }
    
    /**
     * Remove a goal completion for a specific date
     */
    public function destroy(Request $request, Goal $goal, string $date): JsonResponse
    {
        $user = auth()->user();
        
        // Validate date format
        try {
            $parsedDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid date format. Use YYYY-MM-DD.'
            ], 400);
        }
        
        // Build query for the completion record
        $completion = GoalCompletion::forUser($user->id)
            ->forGoal($goal->id)
            ->whereDate('date', $parsedDate)
            ->first();
            
        if (!$completion) {
            return response()->json([
                'message' => 'No completion found for this goal on this date'
            ], 404);
        }
        
        $completion->delete();
        
        return response()->json([
            'message' => "Goal completion for '{$goal->name}' has been removed",
            'undone' => true
        ]);
    }
    
    /**
     * Create activity feed entry for goal completion
     */
    private function createActivityEntry($user, $goal, $completion): void
    {
        // Activity creation placeholder
        // This can be expanded based on business requirements
    }
}