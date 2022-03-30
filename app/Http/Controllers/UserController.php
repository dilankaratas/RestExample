<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\User;

class UserController extends Controller
{


    public function user_detail()
    {
      $user = User::where('id', auth('sanctum')->user()->id)->first();
      return Response::withData(true,'User details arrived',$user);

    }


    public function user_detail_update(Request $request)
    {
      $email_control = User::where('email', $request->email)->first();
      $tc_control = User::where('tc', $request->tc)->first();
        if ($email_control && $tc_control) {
            $updated_user = User::where('id', auth('sanctum')->user()->id)->first();
            if ($updated_user->email == $email_control->email) {
                $user = User::where('id', auth('sanctum')->user()->id)->update([
                    'tc' =>$request->tc,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'country' => $request->country,

                ]);
            } else {
                return Response::withoutData(false,'This email is used by someone else');
            }
        } else {
            $user = User::where('id', auth('sanctum')->user()->id)->update([
                'tc' => $request->tc,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,

            ]);
        }
        return Response::withoutData(true,'User information updated');
    }



 public function image_upload(Request $request)
 {
     if($request->hasFile('image')){
       $image = time().'.'.$request->image->extension();
       $request->image->move(public_path('uploads/profile'),$image);
       $update = User::where('id', auth('sanctum')->user()->id)->update([
         'image' => 'uploads/profile/'.$image
       ]);
       if ($update) {
         return Response::withoutData(true, 'Fotoğraf başarılı bir şekilde güncellendi!');
       } else {
         return Response::withoutData(false, 'Fotoğraf yüklenemedi!');
       }
     } else {
       return Response::withoutData(false, 'Fotoğraf yüklemelisiniz!');
     }
 }


}
