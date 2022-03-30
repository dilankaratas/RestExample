<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TranslationsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\PaymentController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function() {
  return response()->json([
    'status' => true,
    'message' => 'Welcome to Speedil API',
    'version' => 'v1'
  ]);
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/translator-register',[AuthController::class,'translator_register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/languages',[AuthController::class,'languages']);
Route::get('/countries',[AuthController::class,'countries']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user-detail', [UserController::class, 'user_detail']);
    Route::post('/create-translation',[TranslationsController::class,'create_translations']);
    Route::get('/my-translation-requests',[TranslationsController::class,'requests_translations']);
    Route::get('/my-completed-translations',[TranslationsController::class,'pending_translations']);
    Route::get('/my-accepted-translations',[TranslationsController::class,'accepted_translations']);
    Route::get('/my-translation-detail/{id}',[TranslationsController::class,'translation_detail']);
    Route::get('/notifications',[NotificationsController::class,'notifications']);
    Route::get('/blogs',[BlogsController::class,'blogs']);
    Route::get('/blog-detail/{id}',[BlogsController::class,'blog_detail']);
    Route::get('/about-us',[PagesController::class,'pages']);
    Route::post('/my-informations-update',[UserController::class,'user_detail_update']);
    Route::get('/campaigns',[CampaignsController::class,'campaigns']);
    Route::get('/campaign-detail/{id}',[CampaignsController::class,'campaign_detail']);
    Route::post('/profilephoto-upload',[UserController::class,'image_upload']);
    Route::post('/password-change',[PasswordChangeController::class,'password_change']);
    Route::get('/cards',[CardsController::class,'cards']);
    Route::get('/payment-options',[TranslationsController::class,'payment_options']);
    Route::post('/translation-request-buy',[TranslationsController::class,'translations_request_buy']);



});

Route::middleware(['auth:sanctum', 'translator'])->group(function () {
Route::post('/answer-translation', [TranslationsController::class, 'answer_translations']);
Route::get('/payments',[PaymentController::class,'latest_payment']);


});
