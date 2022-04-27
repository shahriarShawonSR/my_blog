<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostDetailsController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('posts', compact('posts'));
    }

    public function details($slug)
    {
        // $post = Post::where('slug', $slug)->approved()->published()->first();
        $post = Post::where('slug', $slug)->first();
        $blogkey = 'blog_' . $post->id;
        if (!Session::has($blogkey)) {
            $post->increment('view_count');
            Session::put($blogkey, 1);
        }
        $randomPosts = Post::approved()->published()->take(3)->inRandomOrder()->get();
        return view('post_details', compact('post', 'randomPosts'));
    }
    // Show all post by category
    public function postByCategory($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->approved()->published()->get();
        return view('category_posts', compact('category', 'posts'));
    }
    // Show all post by tag
    public function postByTag($slug)
    {
        $tag = Category::where('slug', $slug)->first();
        $posts = $tag->posts()->approved()->published()->get();
        return view('tag_posts', compact('tag', 'posts'));
    }
}
