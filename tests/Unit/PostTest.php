<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_belongs_to_user()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $post->user);
        $this->assertEquals($user->id, $post->user->id);
    }

    public function test_post_has_title()
    {
        $post = Post::factory()->create(['title' => 'Test Title']);

        $this->assertEquals('Test Title', $post->title);
    }

    public function test_post_has_content()
    {
        $post = Post::factory()->create(['content' => 'Test Content']);

        $this->assertEquals('Test Content', $post->content);
    }

    public function test_post_can_be_created()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'user_id' => $user->id,
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);
    }
} 