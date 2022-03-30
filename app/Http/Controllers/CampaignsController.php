<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\Campaigns;


class CampaignsController extends Controller
{



  public function campaigns()
  {
    $campaign = Campaigns::orderBy('id', 'desc')->get();
    return Response::withData(true,'campaigns are arrived',$campaign);
  }



  public function campaign_detail($id)
  {

      $campaign_detail = Campaigns::where('id',$id)->first();
      if ( !$campaign_detail) {
        return Response::withoutData(false,'There is a no campaign for this id');
        }
      return Response::withData(true,'campaigns detail have arrived',$campaign_detail);

  }


}
