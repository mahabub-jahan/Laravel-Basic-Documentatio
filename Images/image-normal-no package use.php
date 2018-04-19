<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
  
    public function index()
    {
        $blogs = Blog::all();
        return view('blog.index',compact('blogs'));
    }

   
    public function create()
    {
        return view('blog.create');
    }

 
    public function store(Request $request)
    {

//        $this->validate($request,[
//            'blog_title' => 'required',
//            'blog_image' =>
//                'required|image',
//
//        ]);

        $blogImage = $request->file('blog_image');
        $imageName = substr(md5(time()),'0','10');
        $imageName = $imageName.'.'.$blogImage->getClientOriginalExtension();
        $directory = 'front-end/images/';
        $blogImage->move($directory,$imageName);
        $imageUrl = $directory.$imageName;


        $blog = new Blog();
        $blog->blog_title = $request->blog_title;
        $blog->category_name = $request->category_name;
        $blog->blog_description = $request->blog_description;
        $blog->blog_image = $imageUrl;
        $blog->publication_status = $request->publication_status;
        $blog->save();
        session()->flash('message','Data Updated Successfully');

        return redirect ('/blog');
    }


    public function show(Blog $blog)
    {

        return view('blog.show',compact('blog'));

    }


    public function edit($id)
    {

        $blog = Blog::find($id);
        return view('blog.edit',compact('blog'));
    }

 
    public function update(Request $request, $id)
    {


        if (!empty($blogImage = $request->file('blog_image'))){
           // return $request;
            $blog = Blog::find($id);
            $oldImage = $blog->blog_image;

            unlink($oldImage);

            $blogImage = $request->file('blog_image');
            $imageName = substr(md5(time()),'0','10');
            $imageName = $imageName.'.'.$blogImage->getClientOriginalExtension();
            $directory = 'front-end/images/';
            $blogImage->move($directory,$imageName);
            $imageUrl = $directory.$imageName;


            $blog->blog_title = $request->blog_title;
            $blog->category_name = $request->category_name;
            $blog->blog_description = $request->blog_description;
            $blog->blog_image = $imageUrl;
            $blog->publication_status = $request->publication_status;

            $blog->save();



        }

        $blog = Blog::find($id);
        $image = $blog->blog_image;
        $blog->blog_title = $request->blog_title;
        $blog->category_name = $request->category_name;
        $blog->blog_description = $request->blog_description;
        $blog->blog_image = $image;
        $blog->publication_status = $request->publication_status;

        $blog->save();

        session()->flash('message','Data Updated Successfully');
        return redirect ('/blog');


    }

   
    public function destroy($id)
    {



//       if ($blog_image==''){
//        }
        $blog = Blog::find($id);
        $blog = $blog->blog_image;
        if(isset($blog)){
            unlink($blog);
        }
        Blog::destroy($id);

        session()->flash('destroy','Data Deleted Successfully');
        return redirect ('/blog');



    }
}
