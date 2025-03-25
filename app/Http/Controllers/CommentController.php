<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function CommentCreate(Request $request, $postId)
    {
        $user_id = $request->header('id');

        // Validate the incoming request
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // Parent comment should exist
        ]);

        $post = Post::findOrFail($postId); // Find the post

        // Create a new comment
        $comment = Comment::create([
            'user_id' => $user_id,
            'post_id' => $post->id,
            'parent_id' => $request->input('parent_id'),
            'content' => $request->input('content'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'data' => $comment
        ]);
    }

    // List comments for a post
    public function CommentList($postId)
    {
        $comments = Comment::with(['user', 'parent'])
            ->where('post_id', $postId)
            ->whereNull('parent_id') // Only top-level comments
            ->orderBy('created_at', 'desc')
            ->get();

        // You may want to load replies (nested comments) here as well
        $comments->each(function ($comment) {
            $comment->replies = $comment->where('parent_id', $comment->id)->orderBy('created_at', 'desc')->get();
        });

        return response()->json($comments);
    }

    // Update a comment
    public function CommentUpdate(Request $request, $commentId)
    {
        $user_id = $request->header('id');
        $comment = Comment::where('id', $commentId)
            ->where('user_id', $user_id)
            ->first();

        if (!$comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found or unauthorized'
            ], 404);
        }

        // Validate the content
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->input('content'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment updated successfully',
            'data' => $comment
        ]);
    }

    // Delete a comment
    public function CommentDelete(Request $request, $commentId)
    {
        $user_id = $request->header('id');
        $comment = Comment::where('id', $commentId)
            ->where('user_id', $user_id)
            ->first();

        if (!$comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found or unauthorized'
            ], 404);
        }

        // Delete the comment (also deletes any replies due to cascading)
        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted successfully'
        ]);
    }
}
