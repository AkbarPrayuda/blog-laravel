<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use App\Models\Posts;
use App\Services\PostsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    protected $postService;

    public function __construct(PostsService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data',
            'data' => $this->postService->getAllPosts()
        ], 200);
    }

    public function store(StorePostsRequest $request)
    {

        if ($post = $this->postService->createPost($request->validated())) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menguplaod data',
                'data' => $post
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menguplaod'
            ], 401);
        }
    }

    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        if ($post > '0') {
            return response()->json([
                'status' => true,
                'message' => 'Data Ditemukan',
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 400);
        }
    }

    public function update(UpdatePostsRequest $request, Posts $post)
    {
        var_dump($post->user_id);
        if ($post->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $post = $this->postService->updatePost($request->validated(), $post);
        if ($post > 0) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengupdate data',
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate Post'
            ], 422);
        }
    }

    public function destroy(Posts $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->postService->deletePost($post);

        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
        ], 200);
    }
}
