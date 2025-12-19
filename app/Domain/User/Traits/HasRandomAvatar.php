<?php

namespace App\Domain\User\Traits;

trait HasRandomAvatar
{
    /**
     * Available avatar files for random selection
     * 
     * @return array
     */
    public static function getAvailableAvatars(): array
    {
        return [
            'pet-6',
            'pet-7',
            'pet-8',
            'pet-9',
            'pet-10',
            'user-11',
            'user-12',
            'user-13',
            'user-14',
            'user-15',
        ];
    }

    /**
     * Get a random avatar from available avatars
     * 
     * @return string
     */
    public static function getRandomAvatar(): string
    {
        $avatars = self::getAvailableAvatars();
        return $avatars[array_rand($avatars)];
    }
}
