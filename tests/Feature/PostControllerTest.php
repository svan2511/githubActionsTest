<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_create_post_page()
    {
        $response = $this->get(route('posts.create'));
        $response->assertRedirect('/login');
    }

    public function test_user_can_access_create_post_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('posts.create'));
        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    public function test_user_can_create_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('posts.store'), [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Title',
            'content' => 'Test Content',
            'user_id' => $user->id
        ]);
    }

    public function test_user_can_view_their_own_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('posts.show', $post));
        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertViewHas('post', $post);
    }

    public function test_user_can_edit_their_own_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('posts.edit', $post));
        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
        $response->assertViewHas('post', $post);
    }

    public function test_user_can_update_their_own_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);
    }

    public function test_user_can_delete_their_own_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('posts.destroy', $post));
        $response->assertRedirect(route('home'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_user_cannot_edit_other_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->get(route('posts.edit', $post));
        $response->assertStatus(403);
    }

    public function test_user_cannot_update_other_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_delete_other_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->delete(route('posts.destroy', $post));
        $response->assertStatus(403);
    }
} 