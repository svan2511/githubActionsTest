<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    private $policy;
    private $user;
    private $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PostPolicy();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_user_can_update_their_own_post()
    {
        $response = $this->policy->update($this->user, $this->post);
        $this->assertTrue($response->allowed());
    }

    public function test_user_cannot_update_other_users_post()
    {
        $otherUser = User::factory()->create();
        $response = $this->policy->update($otherUser, $this->post);
        $this->assertFalse($response->allowed());
    }

    public function test_user_can_delete_their_own_post()
    {
        $response = $this->policy->delete($this->user, $this->post);
        $this->assertTrue($response->allowed());
    }

    public function test_user_cannot_delete_other_users_post()
    {
        $otherUser = User::factory()->create();
        $response = $this->policy->delete($otherUser, $this->post);
        $this->assertFalse($response->allowed());
    }
} 