<?php

use App\Models\Posts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::create([
            'name' => 'akbar',
            'email' => 'akbar@gmail.com',
            'password' => 'password',
        ]);
        $this->token = $this->user->createToken('API Token')->plainTextToken;
    }

    public function testGetAllPosts()
    {
        $post = Posts::create([
            'title' => 'Original Title',
            'content' => 'Original content.',
            'user_id' => $this->user->id,
        ]);

        $this->withheaders([
            'Authorization' => 'Bearer' . $this->token
        ])->getJson('api/posts')
            ->assertJsonCount(1);
    }

    public function test_user_can_create_post()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'image' => UploadedFile::fake()->image('test.jpg'),
            'user_id' => $this->user->id
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'content', 'user_id', 'created_at', 'updated_at']);
    }

    public function testShow()
    {
        $post = Posts::create([
            'title' => 'Original Title',
            'content' => 'Original content.',
            'user_id' => $this->user->id,
        ]);


        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/posts/' . $post->id)
            ->assertJson([
                'content' => 'Original content.'
            ]);
    }

    public function testUpdate()
    {
        // Membuat postingan manual yang dimiliki oleh pengguna
        $post = Posts::create([
            'title' => 'Original Title',
            'content' => 'Original content.',
            'user_id' => $this->user->id,
        ]);

        // Data yang akan digunakan untuk memperbarui postingan
        $updateData = [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ];

        // Mengirimkan permintaan untuk memperbarui postingan
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/posts/' . $post->id, $updateData);

        // Menampilkan respons jika terjadi kesalahan validasi

        // Memastikan data di database telah diperbarui
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    }

    public function testDelete()
    {
        // Membuat postingan manual yang dimiliki oleh pengguna
        $post = Posts::create([
            'title' => 'Original Title',
            'content' => 'Original content.',
            'user_id' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/posts/' . $post->id);

        $this->assertDatabaseEmpty('posts');
    }
}
