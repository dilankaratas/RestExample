<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class translations extends Model
{
    public function topic1_detail(){
        return $this->hasOne(languages::class, 'id','topic_1');
    }



    public function topic2_detail(){
        return $this->hasOne(languages::class, 'id','topic_2');
    }

    public function user_detail()
    {
        return $this->belongsToMany(User::class, 'responses', 'trans_id', 'cevirmen_id');
    }


    public function response_detail()
    {
        return $this->hasOne(TranslateResponse::class,'trans_id','id');
    }


    public function language_detail()
    {
        return $this->hasOne(languages::class,'translations','topic_1','topic_2');
    }



}
