<?php
namespace App\Http\Controllers;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class BlogController extends Controller
{
    public function index(Request $request)
    {
        try {
            //$blogs = Blog::orderBy('id', 'DESC')->get();
                $query=Blog::query();
                if($request->search!=null)
                {
                    $query=$query->where('title',$request->search);
                }
                $blogs=$query->orderBy('id', 'DESC')->get();
            return view('blog.index', compact('blogs'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function create()
    {
        try {
            return view('blog.create');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;
            $fileName = time().'.'.$request->file->extension();
            Storage::putFileAs('public/uploads', $request->file, $fileName);
            storage_path() . '/app/public/uploads' . '/' . $fileName;
            $data['file']=$fileName;
            $insert = Blog::create($data);
            session()->flash('success','data inserted successfully');
            return redirect('blogs');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = (int) $id;
             $value = Blog::query()->find($id);
             if ($value != null) {
                $comments = Comment::query()->where('blog_id', $id)->orderBy('id', 'DESC')->paginate(3);
                 return view('blog.details', compact('value', 'comments'));
             } else {
                 return back();
             }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        try {
            $id = (int) $id;
            $value = Blog::query()->find($id);
            if ($value != null) {
                return view('blog.edit', compact('value'));
            } else {
                return back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $id = (int) $id;
            $value = Blog::query()->find($id);
            if ($value != null) {
                $data = $request->all();
                if($value->file !=null){
                unlink(storage_path() . '/app/public/uploads' . '/' . $value->file);
                }
             
                $fileName = time().'.'.$request->file->extension();
                Storage::putFileAs('public/uploads', $request->file, $fileName);
                storage_path() . '/app/public/uploads' . '/' . $fileName;
                $data['file']=$fileName;
                $value->fill($data);
                $value->save();
                return redirect('blogs');
            } else {
                return back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = (int) $id;
            $value = Blog::query()->find($id);
            if ($value != null) {
                $value->delete();
                unlink(storage_path() . '/app/public/uploads' . '/' . $value->file);
                return redirect('blogs');
            } else {
                session()->flash('success','data deleted successfully');
                return back();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function statusUpdate($id)
    {
    $value = Blog::select('status')
        ->where('id', '=', $id)
        ->first();
        if ($value->status == '1') {
            $value = '0';
        } else {
            $value = '1';
        }
        Blog::where('id', $id)->update(['status' => $value]);
        return back()->with('success', 'Status Updated successfully!');
}

    public function upvote($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->increment('upvotes');
        return redirect()->back();
    }

    public function downvote($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->increment('downvotes');
        return redirect()->back();
    }
}