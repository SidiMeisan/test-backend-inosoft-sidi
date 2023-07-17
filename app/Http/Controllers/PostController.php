<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function show($slug)
    {
        $data = Post::where('slug', '=', $slug)->first();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $post = new Post;

        $post->title = $request->title;
        $post->body = $request->body;
        $post->slug = $request->slug;

        $post->save();

        $data = Post::all();
        return response()->json(["result" => "ok", "data" => $data], 201);
    }
}
