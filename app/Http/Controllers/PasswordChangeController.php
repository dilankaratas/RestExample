<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;



class PasswordChangeController extends Controller
{



    public function password_change(Request $request)
    {
        $user = User::where('id', auth('sanctum')->user()->id)->first();
        if(Hash::check($request->old_password, $user->password)) {
          $user = User::where('id',auth('sanctum')->user()->id)->update([
                 'password' =>bcrypt($request->new_password)
          ]);
        } else {
            return Response::withoutData(false, 'Eski şifre hatalı!');
        }
        return Response::withoutData(true,'Şifre Güncellendi');
    }
  }
