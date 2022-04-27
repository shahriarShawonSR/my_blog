<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {

        $favoritePost = Auth::user()->favoritePosts;
        return view('admin.favorite', compact('favoritePost'));
    }
}
