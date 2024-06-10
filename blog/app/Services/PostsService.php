<?php

namespace App\Services;

use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsService
{

    public function createPost(array $data)
    {
        $data['user_id'] = Auth::id();

        if (isset($data['image'])) {
            $data['image_path'] = $this->uploadImage($data['image']);
        }

        return Posts::create($data);
    }

    public function updatePost(array $data, Posts $post)
    {
        if (isset($data['image'])) {
            $data['image_path'] = $this->uploadImage($data['image']);

            if ($post->image_path) {
                Storage::delete($post->image_path);
            }
        }

        return $post->update($data);
    }

    public function deletePost(Posts $post)
    {
        if ($post->image_path) {
            Storage::delete($post->image_path);
        }

        return $post->delete();
    }

    public function getPostById($id)
    {
        return Posts::with('comments.user')->findOrFail($id);
    }

    public function getAllPosts()
    {
        return Posts::orderBy('created_at', 'desc')->with('user', 'comments')->get();
    }

    public function getUserPosts()
    {
        $user = Auth::user();

        return $user->posts;
    }

    private function uploadImage($image)
    {
        $path = $image->store('images', 'public');
        return $path;
    }
}
