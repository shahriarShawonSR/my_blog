<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $posts = Auth::user()->posts;
        return view('author.comments', compact('posts'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->post->user->id == Auth::id()) {
            $comment->delete();
            Toastr::success('Comment Successfully Deleted', 'Success');
        } else {
            Toastr::success('You are not authorized to delete this comment :(', 'Access denied !!!');
        }
        return redirect()->back();
    }
}
