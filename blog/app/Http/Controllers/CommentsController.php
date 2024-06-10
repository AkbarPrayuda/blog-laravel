<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Http\Requests\StoreCommentsRequest;
use App\Http\Requests\UpdateCommentsRequest;
use App\Models\Posts;
use App\Services\CommentsService;

class CommentsController extends Controller
{
    protected $commentsService;

    public function __construct(CommentsService $commentsService)
    {
        $this->commentsService = $commentsService;
    }

    public function store(StoreCommentsRequest $request, Posts $post)
    {
        $data = $this->commentsService->createComment($request->only('user_id', 'content'), $post);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil membuat komentar',
            'data' => $data
        ], 200);
    }

    public function destroy(Comments $comments)
    {
        $this->commentsService->deleteComment($comments);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus komentar'
        ], 200);
    }
}
