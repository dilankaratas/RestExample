<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\Blogs;


class BlogsController extends Controller
{




    public function blogs()
    {

      $blogs = Blogs::where('user_id', auth('sanctum')->user()->id)->get();
      Return Response::withData(true,'Blogs are arrived',$blogs);

    }


    public function blog_detail($id)
    {

      $blog_detail = Blogs::where('id',$id)->first();
      if ( !$blog_detail) {
        return Response::withoutData(false,'There is a no blog for this id');
      }
      return Response::withData(true,'translation detail have arrived',$blog_detail);

    }





}
