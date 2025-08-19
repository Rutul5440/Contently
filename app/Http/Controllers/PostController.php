<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(!auth()->user()->can('post.view'), 403);

        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!auth()->user()->can('post.add'), 403);

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('post.add'), 403);

        $request->validate([
            'title' => 'required|unique:posts,title',
            'image' => 'nullable|image',
            'description' => 'nullable',
            'excerpt' => 'nullable|string|max:255',
            'status' => 'nullable|in:Draft,Published,Unpublished',
        ]);

        $data = $request->only(['title', 'description', 'excerpt', 'status']);
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        abort_if(!auth()->user()->can('post.view'), 403);

        return response()->json($post->load('user')); // includes author info
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        abort_if(!auth()->user()->can('post.update'), 403);

        return view('posts.create', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        abort_if(!auth()->user()->can('post.update'), 403);

        $request->validate([
            'title' => 'required|unique:posts,title,' . $post->id,
            'image' => 'nullable|image',
            'description' => 'required',
            'excerpt' => 'nullable|string|max:255',
            'status' => 'required|in:Draft,Published,Unpublished',
        ]);

        $data = $request->only(['title', 'description', 'excerpt', 'status']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }
        $post->update($data);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if(!auth()->user()->can('post.delete'), 403);

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
