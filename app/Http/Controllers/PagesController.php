<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\Pages;


class PagesController extends Controller
{



  public function pages()
  {
     $pages = Pages::where('type',0)->first();
     return Response::withData(true,'pages are came out',$pages);
  }


}
