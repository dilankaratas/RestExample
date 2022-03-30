<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\translations;
use App\Models\TranslateResponse;
use App\Models\languages;
use App\Models\Setting;
use App\Models\User;
use App\Models\Packet;
use Auth;

class TranslationsController extends Controller
{


    public function create_translations(Request $request)
    {
        $user = User::where('id', auth('sanctum')->user()->id)->first();
        $characterSetting = User::where('id',auth('sanctum')->user()->id)->first();
        $settings = Settings::where('id',1)->first();

        if($user->translation_request < ceil($request->characterCount / $settings->chracters)){
          return Response::withoutData(false, 'Çeviri hakkınız yetersiz!');
        }
        $user_update = User::where('id',$id)->update([
          'translation_request' => $user->translation_request - ceil($request->characterCount / $settings->characters),
        ]);


        if ($request->hasFile('file')) {
            $file = time().'.'.$request->file->extension();
            $request->file->move(public_path('uploads/translations'), $file);
            $translations= new translations;
            $translations->user_id =auth('sanctum')->user()->id;
            $translations->topic_1 = $request->topic_1;
            $translations->topic_2 = $request->topic_2;
            $translations->email = auth('sanctum')->user()->email;
            $translations->content = $request->content;
            $translations->files = $file;
            $translations->name = auth('sanctum')->user()->name;
            $translations->status = 0;
            $translations->characterCount = $request->characterCount;
            if ($translations->save()) {
                return Response::withoutData(true, 'translations created successfully');
            } else {
                return Response::withoutData(false, 'unkown error occured');
            }
        } else {
            $translations= new translations;
            $translations->user_id =auth('sanctum')->user()->id;
            $translations->topic_1 = $request->topic_1;
            $translations->topic_2 = $request->topic_2;
            $translations->email = auth('sanctum')->user()->email;
            $translations->content = $request->content;
            $translations->name = auth('sanctum')->user()->name;
            $translations->status = 0;
            $translations->characterCount = $request->characterCount;
            if ($translations->save()) {
                return Response::withoutData(true, 'translations created successfully');
            } else {
                return Response::withoutData(false, 'unkown error occured');
            }


        }



        public function translations_request_buy(Request $request)
        {
          $packets = Packet::where('id',auth('sanctum')->user()->id)->first();
          $packet_update = User::where('id',$id)->update([
            'translation_request' => $user->translation_request)
          ]);
        }
    }


    public function payment_options()
    {
      $options = Packet::OrderBy('id','ASC')->get();
      return Response::withData(true,'Payment Option listed',$options);
    }








   // ÇEVİRİ CEVAPLA

    public function answer_translations(Request $request)
    {
      $translation_control = translations::where('id',$request->trans_id)->first();
      if ($translation_control->status==1) {
        return Response::withoutData(false,'this translation has been answered');
      }
      if($request->hasFile('file')){
        $file = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/translations'),$file);
        $answer_translation= new TranslateResponse;
        $answer_translation->cevirmen_id = auth('sanctum')->user()->id;
        $answer_translation->trans_id = $request->trans_id;
        $answer_translation->new_content = $request->new_content;
        $answer_translation->file = $file;
        if($answer_translation->save()){
          return Response::withoutData(true,'translations answered successfully');
        } else{
          return Response::withoutData(false,'translations not answered');
        }
      }else{
        $answer_translation= new TranslateResponse;
        $answer_translation->cevirmen_id = auth('sanctum')->user()->id;
        $answer_translation->trans_id = auth('sanctum')->user()->id;
        $answer_translation->new_content = $request->new_content;
        $answer_translation->file = $file;
        if ($answer_translation->save()) {
            return Response::withoutData(true, 'translations answered successfully');
        } else {
            return Response::withoutData(false, 'translations not answered');
        }
      }
    }


// GÖNDERİLEN ÇEVİRİ İSTEKLERİ

      public function requests_translations()
      {

         $translation_request = translations::where('user_id', auth('sanctum')->user()->id)->get();
          return Response::withData(true,'translations requests came out',$translation_request);
      }

// KABUL EDİLEN ÇEVİRİ İSTEKLERİ

      public function accepted_translations()
      {

        $accepted_translations = translations::where('status', 1)->where('user_id', auth('sanctum')->user()->id)->get();
        return Response::withData(true,'accepted translations have arrived',$accepted_translations);
      }

// BEKLEYEN ÇEVİRİLER

      public function pending_translations()
      {
        $incomplete_translations = translations::where('status',0)->where('user_id',auth('sanctum')->user()->id)->get();
        return Response::withData(true,'incomplete translations have arrived',$incomplete_translations);
      }

// ÇEVİRİ DETAYLARI

      public function translation_detail($id)
      {
        $detail_translation = translations::where('user_id', auth('sanctum')->user()->id)->where('id', $id)->with('response_detail')->first();
        if (!$detail_translation) {
          return Response::withoutData(false,'This translate not have belongs to you');
        }
        return Response::withData(true,'translation detail have arrived',$detail_translation);
      }



}
