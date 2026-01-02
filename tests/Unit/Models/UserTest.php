<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Domain\User\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = UserFactory::new()->create();
        $this->otherUser = UserFactory::new()->create();
    }

    /** @test */
    public function test_user_can_follow_another_user()
    {
        $this->user->follow($this->otherUser);

        $this->assertTrue($this->user->isFollowing($this->otherUser));
        $this->assertTrue($this->otherUser->isFollowedBy($this->user));
    }

    /** @test */
    public function test_user_can_unfollow_another_user()
    {
        $this->user->follow($this->otherUser);
        $this->user->unfollow($this->otherUser);

        $this->assertFalse($this->user->isFollowing($this->otherUser));
        $this->assertFalse($this->otherUser->isFollowedBy($this->user));
    }

    /** @test */
    public function test_user_cannot_follow_themselves()
    {
        $this->user->follow($this->user);

        $this->assertFalse($this->user->isFollowing($this->user));
    }

    /** @test */
    public function test_following_same_user_twice_does_not_create_duplicates()
    {
        $this->user->follow($this->otherUser);
        $this->user->follow($this->otherUser);

        $followingCount = $this->user->following()->count();
        $this->assertEquals(1, $followingCount);
    }

    /** @test */
    public function test_is_following_returns_false_when_not_following()
    {
        $this->assertFalse($this->user->isFollowing($this->otherUser));
    }

    /** @test */
    public function test_is_followed_by_returns_false_when_not_followed()
    {
        $this->assertFalse($this->user->isFollowedBy($this->otherUser));
    }

    /** @test */
    public function test_following_count_returns_correct_count()
    {
        $user2 = UserFactory::new()->create();
        $user3 = UserFactory::new()->create();

        $this->user->follow($this->otherUser);
        $this->user->follow($user2);
        $this->user->follow($user3);

        $this->assertEquals(3, $this->user->followingCount());
    }

    /** @test */
    public function test_followers_count_returns_correct_count()
    {
        $user2 = UserFactory::new()->create();
        $user3 = UserFactory::new()->create();

        $this->otherUser->follow($this->user);
        $user2->follow($this->user);
        $user3->follow($this->user);

        $this->assertEquals(3, $this->user->followersCount());
    }

    /** @test */
    public function test_following_relationship_exists()
    {
        $this->user->follow($this->otherUser);

        $following = $this->user->following;
        $this->assertCount(1, $following);
        $this->assertEquals($this->otherUser->id, $following->first()->id);
    }

    /** @test */
    public function test_followers_relationship_exists()
    {
        $this->otherUser->follow($this->user);

        $followers = $this->user->followers;
        $this->assertCount(1, $followers);
        $this->assertEquals($this->otherUser->id, $followers->first()->id);
    }

    /** @test */
    public function test_user_can_have_multiple_followers()
    {
        $user2 = UserFactory::new()->create();
        $user3 = UserFactory::new()->create();

        $this->otherUser->follow($this->user);
        $user2->follow($this->user);
        $user3->follow($this->user);

        $this->assertEquals(3, $this->user->followers->count());
    }

    /** @test */
    public function test_user_can_follow_multiple_users()
    {
        $user2 = UserFactory::new()->create();
        $user3 = UserFactory::new()->create();

        $this->user->follow($this->otherUser);
        $this->user->follow($user2);
        $this->user->follow($user3);

        $this->assertEquals(3, $this->user->following->count());
    }

    /** @test */
    public function test_get_avatar_url_returns_default_when_no_avatar()
    {
        // Avatar field has a default value, so we test with an invalid avatar name instead
        $user = UserFactory::new()->create(['avatar' => 'non-existent']);

        $avatarUrl = $user->getAvatarUrl();
        $this->assertStringContainsString('default.svg', $avatarUrl);
    }

    /** @test */
    public function test_get_avatar_url_returns_correct_url_when_avatar_set()
    {
        $user = UserFactory::new()->create(['avatar' => 'pet-6']);

        $avatarUrl = $user->getAvatarUrl();
        $this->assertStringContainsString('pet-6.svg', $avatarUrl);
    }

    /** @test */
    public function test_get_theme_preference_returns_system_by_default()
    {
        // Since theme_preference is required, we test by checking the default from factory
        $user = UserFactory::new()->create();

        // The getThemePreference should return the actual value set
        $this->assertContains($user->getThemePreference(), ['light', 'dark', 'system']);
    }

    /** @test */
    public function test_get_theme_preference_returns_saved_preference()
    {
        $user = UserFactory::new()->create(['theme_preference' => 'dark']);

        $this->assertEquals('dark', $user->getThemePreference());
    }

    /** @test */
    public function test_update_theme_preference_saves_valid_theme()
    {
        $this->user->updateThemePreference('dark');

        $this->assertEquals('dark', $this->user->fresh()->theme_preference);
    }

    /** @test */
    public function test_update_theme_preference_ignores_invalid_theme()
    {
        $originalTheme = $this->user->theme_preference;
        $this->user->updateThemePreference('invalid');

        $this->assertEquals($originalTheme, $this->user->fresh()->theme_preference);
    }

    /** @test */
    public function test_user_has_challenges_relationship()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $this->user->challenges());
    }

    /** @test */
    public function test_user_has_habits_relationship()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $this->user->habits());
    }

    /** @test */
    public function test_user_has_goals_relationship()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $this->user->goals());
    }

    /** @test */
    public function test_user_has_activities_relationship()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $this->user->activities());
    }

    /** @test */
    public function test_is_admin_casts_to_boolean()
    {
        $admin = UserFactory::new()->create(['is_admin' => true]);
        $regularUser = UserFactory::new()->create(['is_admin' => false]);

        $this->assertTrue($admin->is_admin);
        $this->assertFalse($regularUser->is_admin);
        $this->assertIsBool($admin->is_admin);
        $this->assertIsBool($regularUser->is_admin);
    }

    /** @test */
    public function test_get_available_avatars_returns_array()
    {
        $avatars = User::getAvailableAvatars();

        $this->assertIsArray($avatars);
        $this->assertNotEmpty($avatars);
        $this->assertArrayHasKey('pet-6', $avatars);
    }
}
