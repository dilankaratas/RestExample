<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\Notifications;


class NotificationsController extends Controller
{


public function notifications()
{
  $data = [];
  $notifications = Notifications::where('user_id',auth('sanctum')->user()->id)->orWhere('user_id', null)->get();
  return Response::withData(true,'Notifications are  arrived',$notifications);
}



}
