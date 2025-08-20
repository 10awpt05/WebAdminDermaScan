<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class BlogController extends Controller
{
    protected $database;

    public function __construct(FirebaseService $firebase)
    {
        $this->database = $firebase->getDatabase();
    }

    public function index()
    {
        $posts = $this->database->getReference('blogPosts')->getValue();
        return view('blog.index', ['posts' => $posts]);
    }

    public function destroy($postId)
    {
        $this->database->getReference("blogPosts/{$postId}")->remove();
        return redirect()->route('blog.index')->with('success', 'Post deleted successfully!');
    }

    public function edit($postId)
    {
        $post = $this->database->getReference("blogPosts/{$postId}")->getValue();
        return view('blog.edit', compact('post', 'postId'));
    }

    public function update(Request $request, $postId)
    {
        $this->database->getReference("blogPosts/{$postId}")
            ->update(['content' => $request->input('content')]);

        return redirect()->route('blog.index')->with('success', 'Post updated successfully!');
    }
}
