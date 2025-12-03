<?php

namespace App\Domain\Habit\Enums;

enum FrequencyType: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match($this) {
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
        };
    }

    /**
     * Get the period description with count.
     */
    public function description(int $count = 1): string
    {
        if ($count === 1) {
            return match($this) {
                self::DAILY => 'Every day',
                self::WEEKLY => 'Once per week',
                self::MONTHLY => 'Once per month',
                self::YEARLY => 'Once per year',
            };
        }

        return match($this) {
            self::DAILY => "{$count} times per day",
            self::WEEKLY => "{$count} times per week",
            self::MONTHLY => "{$count} times per month",
            self::YEARLY => "{$count} times per year",
        };
    }

    /**
     * Get all available frequency types.
     */
    public static function options(): array
    {
        return array_map(
            fn($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ],
            self::cases()
        );
    }

    /**
     * Get the start of the current period.
     */
    public function periodStart(\DateTime $date = null): \DateTime
    {
        $date = $date ?? new \DateTime();
        
        return match($this) {
            self::DAILY => (clone $date)->setTime(0, 0, 0),
            self::WEEKLY => (clone $date)->modify('monday this week')->setTime(0, 0, 0),
            self::MONTHLY => (clone $date)->modify('first day of this month')->setTime(0, 0, 0),
            self::YEARLY => (clone $date)->modify('first day of january this year')->setTime(0, 0, 0),
        };
    }

    /**
     * Get the end of the current period.
     */
    public function periodEnd(\DateTime $date = null): \DateTime
    {
        $date = $date ?? new \DateTime();
        
        return match($this) {
            self::DAILY => (clone $date)->setTime(23, 59, 59),
            self::WEEKLY => (clone $date)->modify('sunday this week')->setTime(23, 59, 59),
            self::MONTHLY => (clone $date)->modify('last day of this month')->setTime(23, 59, 59),
            self::YEARLY => (clone $date)->modify('last day of december this year')->setTime(23, 59, 59),
        };
    }

    /**
     * Check if we're in a new period compared to a previous date.
     */
    public function isNewPeriod(\DateTime $previousDate, \DateTime $currentDate = null): bool
    {
        $currentDate = $currentDate ?? new \DateTime();
        
        $previousPeriodStart = $this->periodStart($previousDate);
        $currentPeriodStart = $this->periodStart($currentDate);
        
        return $previousPeriodStart < $currentPeriodStart;
    }
}
