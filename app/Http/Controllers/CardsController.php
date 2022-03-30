<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\Card;


class CardsController extends Controller
{


  public function cards()
  {
     $pages = Card::OrderBy('created_at','ASC')->get();
     return Response::withData(true,'cards are came out',$pages);
  }


}
