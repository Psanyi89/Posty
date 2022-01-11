<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(20);
        return view(
            'posts.index',
            [
                'posts' => $posts
            ]
        );
    }

    public function post(Request $request)
    {

        $filter = [
            'body' => ['required']
        ];

        $this->validate($request, $filter);

        $request->user()->posts()->create([
            'body' => $request->body
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
