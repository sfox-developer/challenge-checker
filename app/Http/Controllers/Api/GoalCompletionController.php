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
            'source_type' => 'nullable|in:challenge,habit,standalone',
            'source_id' => 'nullable|integer',
            'notes' => 'sometimes|string|max:500',
            'duration_minutes' => 'sometimes|integer|min:1|max:1440',
            'mood' => 'sometimes|string|in:energetic,happy,neutral,tired,stressed',
        ]);
        
        $date = $request->input('date', Carbon::today()->toDateString());
        
        // Build query for existing completion
        $existingQuery = GoalCompletion::forUser($user->id)
            ->forGoal($goal->id)
            ->whereDate('date', $date);
        
        // Filter by source if provided (to allow same goal in multiple sources)
        if ($request->filled('source_type')) {
            $existingQuery->where('source_type', $request->input('source_type'));
            
            if ($request->has('source_id')) {
                if ($request->input('source_id') === null) {
                    $existingQuery->whereNull('source_id');
                } else {
                    $existingQuery->where('source_id', $request->input('source_id'));
                }
            }
        }
        
        $existingCompletion = $existingQuery->first();
            
        if ($existingCompletion) {
            return response()->json([
                'message' => 'Goal is already completed for this date',
                'already_completed' => true
            ], 422);
        }
        
        // Validate source ownership (only if source is provided)
        if ($request->filled('source_type') && $request->filled('source_id')) {
            $this->validateSourceOwnership($user, $request->input('source_type'), $request->input('source_id'));
        }
        
        // Create the completion record
        $completionData = [
            'user_id' => $user->id,
            'goal_id' => $goal->id,
            'date' => $date,
            'completed_at' => now(),
            'source_type' => $request->input('source_type'),
            'source_id' => $request->input('source_id'),
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
        $query = GoalCompletion::forUser($user->id)
            ->forGoal($goal->id)
            ->whereDate('date', $parsedDate);
        
        // If source_type and source_id are provided, filter by them to handle
        // cases where the same goal is used in multiple sources (challenge + habit)
        if ($request->filled('source_type')) {
            $query->where('source_type', $request->input('source_type'));
            
            // For source_id, handle both null and integer values
            if ($request->has('source_id')) {
                if ($request->input('source_id') === null) {
                    $query->whereNull('source_id');
                } else {
                    $query->where('source_id', $request->input('source_id'));
                }
            }
        }
        
        $completion = $query->first();
            
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
     * Validate that the user owns the source (challenge, habit, or goal)
     */
    private function validateSourceOwnership($user, string $sourceType, int $sourceId): void
    {
        $isValid = false;
        
        switch ($sourceType) {
            case 'challenge':
                $isValid = $user->challenges()
                    ->where('id', $sourceId)
                    ->exists();
                break;
                
            case 'habit':
                $isValid = $user->habits()
                    ->where('id', $sourceId)
                    ->exists();
                break;
                
            case 'standalone':
                $isValid = $user->goals()
                    ->where('id', $sourceId)
                    ->exists();
                break;
        }
        
        if (!$isValid) {
            throw ValidationException::withMessages([
                'source' => 'You do not have permission to complete this goal from this source.'
            ]);
        }
    }
    
    /**
     * Create activity feed entry for goal completion
     */
    private function createActivityEntry($user, $goal, $completion): void
    {
        // Only create activity for certain types or public goals
        // This can be expanded based on business requirements
        
        $sourceType = $completion->source_type;
        
        // For now, create activity for challenge completions
        if ($sourceType === 'challenge') {
            // You might want to check if challenge is public first
            // and create appropriate activity type
            
            // Activity creation would go here
            // This is a placeholder for future activity system integration
        }
    }
}