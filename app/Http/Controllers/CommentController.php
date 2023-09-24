<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {

        try {
            $blog = Blog::find($request->blog_id);
            if ($blog) {

                $data = $request->all();
                $data['commented_by'] = Auth::user()->id;
                $insert = Comment::create($data);
            }
            session()->flash('msg', 'Product status has been updated successfully.');

            return back();

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $id = (int) $id;
            $comments = Comment::query()->find($id);
            if ($comments != null) {
                return view('blog.details', compact('comments'));
            } else {
                return back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::where('id', $id)->first();
            $comment->delete();

            return redirect()->back()->with('success', 'Record inserted successfully');

        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }
}
