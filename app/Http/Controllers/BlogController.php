<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class BlogController extends Controller
{
    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('dermascanai-2d7a1-firebase-adminsdk-fbsvc-be9d626095.json'))
            ->withDatabaseUri('https://dermascanai-2d7a1-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->database = $factory->createDatabase();
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
