<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class Response extends Controller
{
    public $status;
    public $message;
    public $data;

    public static function withData($status, $message, $data)
    {
      return response()->json([
        'status' => $status,
        'message' => $message,
        'data' => $data
      ]);
    }

    public static function withoutData($status, $message)
    {
        return response()->json([
          'status' => $status,
          'message' => $message,
          'data' => []
        ]);
    }
}
