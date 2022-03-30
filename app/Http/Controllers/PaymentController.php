<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Models\User;
use App\Models\Payment;
use App\Models\Month;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;



class PaymentController extends Controller
{


    public function latest_payment()
    {
        setlocale(LC_TIME, 'tr_TR.UTF-8');
        $months= [];
        for($i = 0; $i<=11;$i++){
          $months[$i] = new \stdClass;
          $months[$i]->date = Carbon::now()->subMonth($i)->isoFormat('Do.MM.YYYY');
          $months[$i]->text = Carbon::now()->subMonth($i)->isoFormat('Do MMM YYYY');
          $payments = Payment::where('user_id', auth('sanctum')->user()->id)
            ->whereBetween('created_at', [Carbon::now()->subMonth($i + 1), Carbon::now()->subMonth($i)])
            ->get();
          $months[$i]->payments = $payments;
        }
        return Response::withData(true,'months are arrived',$months);
    }

}
