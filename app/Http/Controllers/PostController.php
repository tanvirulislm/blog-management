<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function CreatePost(Request $request)
    {
        $user_id = $request->header('id');

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'visibility' => 'required|in:public,private',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $imagePath = 'uploads/' . $imageName;
        }

        Post::create([
            'user_id' => $user_id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $imagePath,
            'visibility' => $request->input('visibility'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully'
        ]);
    }

    public function PostList(Request $request)
    {
        $user_id = $request->header('id');

        $posts = Post::where('user_id', $user_id)
            ->orWhere('visibility', 'public')
            ->orderBy('created_at', 'desc')
            ->get();

        $posts->transform(function ($post) {
            if ($post->image) {
                $post->image = asset($post->image);
            }
            return $post;
        });

        return $posts;
    }

    public function PostById(Request $request)
    {
        $user_id = $request->header('id');

        $post = Post::where('id', $request->id)->where('user_id', $user_id)->first();

        return $post;
    }

    public function PostUpdate(Request $request)
    {
        $user_id = $request->header('id');
        $id = $request->input('id');


        $post = Post::where('id', $id)->where('user_id', $user_id)->first();

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found or unauthorized'
            ], 404);
        }


        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }


            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $post->image = 'uploads/' . $imageName;
        }


        $post->update([
            'title' => $request->input('title', $post->title),
            'content' => $request->input('content', $post->content),
            'visibility' => $request->input('visibility', $post->visibility),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    public function PostDelete(Request $request, $id)
    {
        $user_id = $request->header('id'); // Get user ID from the request header

        if (!$user_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: User ID missing'
            ], 401);
        }

        // Find the post belonging to the user
        $post = Post::where('user_id', $user_id)->where('id', $id)->first();

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found or unauthorized'
            ], 404);
        }

        // Check if the post has an image and delete it
        if (!empty($post->image) && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }

        // Delete the post from the database
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ]);
    }

    public function PublicPosts()
    {
        $posts = Post::where('visibility', 'public')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }
}
