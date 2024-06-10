<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\User;
use App\Services\PostsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostsServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PostsService $postsService;

    public function setup(): void
    {
        parent::setUp();

        $this->postsService = $this->app->make(PostsService::class);
        Storage::fake('public');

        $user = User::create([
            'name' => 'Akbar Prayuda',
            'email' => 'akbar@gmail.com',
            'password' => 'password'
        ]);
        $this->actingAs($user);
    }

    public function testCreatePost()
    {
        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $post = $this->postsService->createPost($data);

        $this->assertDatabaseHas('posts', ['id' => '10', 'title' => 'Test Post']);
    }

    public function testUpdatePost()
    {
        $dataPost = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $post = $this->postsService->createPost($dataPost);

        $data = [
            'title' => 'Updated Post Title',
            'content' => 'Updated content.',
            'image' => UploadedFile::fake()->image('updated.jpg'),
        ];

        $updatedPost = $this->postsService->updatePost($post, $data);

        $this->assertDatabaseHas('posts', ['title' => 'Updated Post Title']);
    }

    public function testDeletePost()
    {
        $dataPost = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $post = $this->postsService->createPost($dataPost);

        $result = $this->postsService->deletePost($post);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function testGetPostById()
    {
        $dataPost = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $post = $this->postsService->createPost($dataPost);

        $retrievedPost = $this->postsService->getPostById($post->id);

        $this->assertEquals($post->id, $retrievedPost->id);
    }

    public function testGetAllPost()
    {
        $dataPost = [
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $this->postsService->createPost($dataPost);

        $posts = $this->postsService->getAllPosts();

        $this->assertCount(1, $posts);
    }
}
