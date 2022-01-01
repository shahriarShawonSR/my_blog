<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
// use Brian2694\Toastr\Facades\Toastr;
use Brian2694\Toastr\Facades\Toastr;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            // View name = validation
            'tag_name' => 'required'
        ]);
        $tag = new Tag();
        $tag->name = $request->tag_name;
        $tag->slug = str_slug($request->tag_name);
        $tag->save();
        Toastr::success('Tag successfully Saved :)', 'Success');
        return redirect()->route('admin.tag.index');
        // return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // call Model class name Tag
        $tag = Tag::find($id);
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // View name = validation
            'tag_name' => 'required'
        ]);
        $tag = Tag::find($id);
        $tag->name = $request->tag_name;
        $tag->slug = str_slug($request->tag_name);
        $tag->save();
        Toastr::success('Tag Successfully Updated :)', 'Success');
        return redirect()->route('admin.tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::find($id)->delete();
        Toastr::success('Tag Successfully Deleted :)', 'Success');
        return redirect()->back();
    }
}
