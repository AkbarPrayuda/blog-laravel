<?php

namespace Tests\Feature;

use App\Models\Posts;
use App\Models\User;
use App\Services\CommentsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CommentServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $commentService;
    protected $user;
    protected $token;
    protected $posts;

    public function setUp(): void
    {
        parent::setUp();

        $this->commentService = $this->app->make(CommentsService::class);

        $this->user = User::create([
            'name' => 'akbar',
            'email' => 'akbar@gmail.com',
            'password' => 'password'
        ]);

        $this->posts = Posts::create([
            'title' => 'test',
            'content' => 'test poset',
            'user_id' => $this->user->id,
            'image' => UploadedFile::fake()->image('test.jpg')
        ]);

        $this->token = $this->user->createToken('API Token')->plainTextToken;
        $this->actingAs($this->user);
    }

    public function testCreate()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
        ])->postJson('/api/comment/ ' . $this->posts->id, [
            'user_id' => $this->user->id,
            'content' => 'test comment',
        ])->assertJsonCount(3)->assertStatus(200);
    }

    public function testDelete()
    {
        $response1 = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
        ])->postJson('/api/comment/ ' . $this->posts->id, [
            'user_id' => $this->user->id,
            'content' => 'test comment',
        ])->assertJsonCount(3)->assertStatus(200);

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer' . $this->token,
        ])->deleteJson('/api/comment/ ' . $this->posts->id . '/delete')->assertStatus(200);

        var_dump($response2['message']);
    }
}
