<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts;
        $populer_posts = $user->posts()
            ->withCount('comments')
            ->withCount('favorite_to_users')
            ->orderBy('view_count', 'desc')
            ->orderBy('comments_count')
            ->orderBy('favorite_to_users_count')
            ->take(5)->get();
        $total_pending_posts = $posts->where('is_appreved', false)->count();
        $all_posts = $posts->sum('view_count');
        return view('author.dashboard', compact(
            'posts',
            'populer_posts',
            'total_pending_posts',
            'all_posts'
        ));
    }
}
