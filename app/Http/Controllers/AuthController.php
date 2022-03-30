<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\User;
use App\Models\languages;
use App\Models\Countries;
use App\Models\TranslatorLang;
use App\Models\Translators;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
          $messages = array(
              'name.required' => 'Name cannot be left blank.',
              'name.max' => 'name and surname can be up to 255 characters.',
              'email.required' => 'E-mail cannot be left blank.',
              'email.unique' => 'Email already use.',
              'password.required' => 'Password cannot be left blank.',

          );

          $validator = Validator::make($request->all(),
          [
              "name"=>"required|max:255",
              "email"=>"required|unique:users",
              "password"=>"required",
          ],$messages);

          if ($validator->fails()) {
              $fails=array_values($validator->getMessageBag()->toArray())[0];
              $error = $fails[0];
              return Response::withoutData(true, ''.$error.'');
          }
          $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'phone' => $request->phone,

          ]);
          $token = $user->createToken('auth_token')->plainTextToken;
          return Response::withData(true, 'successfully registered', $token);
    }


/// ÇEVİRMEN KAYIT FORMU

    public function translator_register(Request $request)
      {
        $messages = array(
            'name.required' => 'Name cannot be left blank.',
            'name.max' => 'name and surname can be up to 255 characters.',
            'email.required' => 'E-mail cannot be left blank.',
            'email.unique' => 'Email already use.',
            'password.required' => 'Password cannot be left blank.',

        );

        $validator = Validator::make($request->all(),
        [
            "name"=>"required|max:255",
            "email"=>"required|unique:users",
            "password"=>"required",
        ],$messages);

        if ($validator->fails()) {
            $fails=array_values($validator->getMessageBag()->toArray())[0];
            $error = $fails[0];
            return Response::withoutData(true, ''.$error.'');
        }
        $translator = Translators::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        foreach ($request->lang as $lang) {

          $person = new TranslatorLang;
          $person->translator_id = $translator->id;
          $person->language_id = $lang;
          $person->save();
          }

        $token_translator = $translator->createToken('auth_token')->plainTextToken;
        return Response::withData(true, 'your application has been sent successfully ', $token_translator);

      }




    public function login(Request $request)
    {

          $messages = array(
              'email.required' => 'E-mail cannot be left blank.',
              'password.required' => 'Password cannot be left blank.',
          );

          $validator = Validator::make($request->all(),
          [
              "password"=>"required",
              "email"=>"required",
          ],$messages);

          if ($validator->fails()) {
              $fails=array_values($validator->getMessageBag()->toArray())[0];
              $error = $fails[0];
              return Response::withoutData(false, ''.$error.'');
          }

          if (!Auth::attempt($request->only('email', 'password'))) {
              return Response::withoutData(false, 'email or password incorrect');
          }


          $user = User::where('email', $request->email)->first();
          $token = $user->createToken('auth_token')->plainTextToken;
          return Response::withData(true, 'successfully logged' ,$token);

    }

/// Diller
      public function languages()
      {
         $langs = languages::OrderBy('id','ASC')->get();
         return Response::withData(true,'Languages are came out',$langs);
      }



  /// Ülkeler

        public function countries()
        {
          $country = Countries::OrderBy('id','ASC')->get();
          return Response::withData(true,'Countries are came out',$country);
        }


}
