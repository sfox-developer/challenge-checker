<?php

namespace App\Domain\Challenge\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChallengeGoal extends Pivot
{
    protected $table = 'challenge_goals';

    protected $fillable = [
        'challenge_id',
        'goal_id',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public $incrementing = true;
}
