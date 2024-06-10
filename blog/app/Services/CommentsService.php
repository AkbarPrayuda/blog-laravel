<?php

namespace App\Services;

use App\Models\Comments;
use App\Models\Posts;

class CommentsService
{
    public function createComment(array $data, Posts $post)
    {
        $data['posts_id'] = $post->id;

        return Comments::create($data);
    }

    public function deleteComment(Comments $comment)
    {
        return $comment->delete();
    }
}
