<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\User;
use App\Services\CommentsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile as HttpUploadedFile;
use Tests\TestCase;

class CommentsServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    protected $commentsService;

    public function setUp(): void
    {
        parent::setUp();

        $this->commentsService = $this->app->make(CommentsService::class);
    }

    public function testCreateComment()
    {
        $user = User::create([
            'name' => 'akbar',
            'email' => 'akbar@gmail.com',
            'password' => 'password'
        ]);
        $post = Posts::create([
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => HttpUploadedFile::fake()->image('test.jpg'),
            'user_id' => $user->id,
        ]);

        $data = [
            'user_id' => $user->id,
            'content' => 'try comment'
        ];
        $this->commentsService->createComment($data, $post);

        $this->assertInstanceOf(CommentsService::class, $this->commentsService);
        $this->assertDatabaseHas('comments', ['content' => 'try comment', 'post_id' => '3']);
    }

    public function testDeleteComment()
    {
        $user = User::create([
            'name' => 'akbar',
            'email' => 'akbar@gmail.com',
            'password' => 'password'
        ]);
        $post = Posts::create([
            'title' => 'Test Post',
            'content' => 'This is a test post content.',
            'image' => HttpUploadedFile::fake()->image('test.jpg'),
            'user_id' => $user->id,
        ]);

        $data = [
            'user_id' => $user->id,
            'content' => 'try comment'
        ];
        $comments = $this->commentsService->createComment($data, $post);
        $this->commentsService->deleteComment($comments);
        $this->assertDatabaseEmpty('comments');
    }
}
