<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Translators extends Model
{

    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'password',

    ];

    public function lang_id()
    {
        return $this->belongsToMany(languages::class, 'translator_langs', 'translator_id', 'language_id');
    }


}
