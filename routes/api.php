<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\Admin\RegisterRequest;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Api\DiagnosisController;
use App\Http\Controllers\Api\Agent\MainController;


use App\Http\Controllers\Api\Client\WalletController;
use App\Http\Controllers\Api\Agent\ApprovalController;
use App\Http\Controllers\Api\Client\RequestController;
use App\Http\Controllers\Api\Provider\IndexController;


use App\Http\Controllers\Api\Client\FeedbackController;
use App\Http\Controllers\Api\Client\RegisterController;
use App\Http\Controllers\Api\Provider\RatingController;
use App\Http\Controllers\Api\Client\BreakdownController;
use App\Http\Controllers\Api\Provider\ProfileController;
use App\Http\Controllers\Api\Agent\AgentRegisterController;
use App\Http\Controllers\Api\ProfileController as ApiProfileController;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\MainController as AdminMainController;
use App\Http\Controllers\Api\Agent\ProfileController as AgentProfileController;
use App\Http\Controllers\Api\Admin\RegisterController as AdminRegisterController;
use App\Http\Controllers\Api\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Api\Provider\RegisterController as ProviderRegisterController;
use App\Http\Controllers\Api\Provider\ServiceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Client Register
Route::post('client/register', [RegisterController::class, 'register']);

//Service Provider Register
Route::post('provider/register', [ProviderRegisterController::class, 'register']);

//Agent Auth
Route::post('agent/register', [AgentRegisterController::class, 'register']);

//Admin Auth
Route::post('admin/register', [AdminRegisterController::class, 'register']);

//Accept/Decline Endpoint
Route::post('artisan/request/status/{id}', [RequestController::class, 'requestSP']);
Route::get('status/type/{id}', [RequestController::class, 'statustype']);
Route::get('sp/data/status/{id}', [RequestController::class, 'spdata']);


//Profile
Route::get('user/profile', [ApiProfileController::class, 'getProfile'])->middleware('auth:sanctum');




//Authentication Route
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/reset/password', [AuthController::class, 'reset'])->name('password.reset');
Route::post('/forgot/password', [AuthController::class, 'forgot']);



// //Admin Auth
// Route::prefix('admin')->group(function () {
//     Route::controller(AdminAuthController::class)->group(function () {
//         //Public Route
//          Route::post('register', 'register');
//          //Protected Route
//             Route::middleware('auth:sanctum')->group(function () {
//                 Route::post('/logout','logout');
//             }
//             );
//     }
//     );
// });

//Agent middleware
Route::middleware(['auth:sanctum', 'auth.agent'])->group(function () {
    Route::get('agent/dashboard', [MainController::class, 'dashboard']);
    Route::get('agent/approved/providers', [MainController::class, 'viewApproved']);
    Route::post('agent/update/profile', [MainController::class, 'update']);
    Route::post('agent/change/password', [MainController::class, 'changePassword']);
    Route::post('agent/approve/artisan/{id}', [ApprovalController::class, 'artisanstore']);
    // Route::post('agent/approve/driver/{id}', [ApprovalController::class, 'driverstore']);
     //Profile
    Route::get('agent/profile', [AgentProfileController::class, 'getProfile']);
     //Update Profile
    Route::post('agent/updateProfile', [AgentProfileController::class, 'updateProfile']);
    

});

//Provider middleware
Route::middleware(['auth:sanctum', 'auth.provider'])->group(function () {
    Route::get('provider/rating', [RatingController::class, 'ProviderAvgRating']);
    
    Route::get('index', [IndexController::class, 'index']);
    //Profile
     //Update Profile
    Route::post('provider/updateProfile', [ProfileController::class, 'updateProfile']);
    
    //NotificationController
    Route::post('provider/push-notifications', [NotificationController::class, 'providersendNotification']);
    
    //Service
    Route::get('history/service/rendered', [ServiceController::class, 'historyService']); 
    
    //Service Charge
   Route::post('provider/cost/{breakdown_id}', [DiagnosisController::class, 'calculateChargeAmount']);

});


//Client Midddleware
Route::middleware(['auth:sanctum', 'auth.client'])->group(function () {
   Route::post('pay', [PaymentController::class, 'initiatePayment'])->name('pay');

   
    Route::get('client/view/transaction', [WalletController::class, 'viewtransaction']);
   //Register breakdown service
    Route::post('client/breakdown/artisan', [BreakdownController::class, 'artisan_breakdown']);
    Route::post('client/breakdown/towtruck', [BreakdownController::class, 'towtruckBreakdown']);
    Route::post('client/breakdown/cabdriver', [BreakdownController::class, 'driverBreakdown']);
    //Feedback
    Route::post('client/review/{id}', [FeedbackController::class, 'feedback']);
    //Profile
    Route::get('client/profile', [ClientProfileController::class, 'getProfile']);
    //Update Profile
    Route::post('client/updateProfile', [ClientProfileController::class, 'updateProfile']);
    
    //Details
    Route::get('provider/details/{id}', [BreakdownController::class, 'detailsProvider']);
    Route::post('store/artisan/request', [RequestController::class, 'storeRequest']);
    
    //Requested Provider Details
    Route::get('provider/info/{id}', [ClientProfileController::class, 'providerdetails']);

    //breakdown history
    Route::get('client/history', [RequestController::class, 'clienthistory']);
    
    //charges
    Route::get('client/charges/{breakdown_id}', [DiagnosisController::class, 'hasBeenCharged']);

    //Deduct Money
    Route::get('artisan/payment/{breakdownid}', [DiagnosisController::class, 'storeartisan']);
    Route::get('driver/payment/{breakdownid}', [DiagnosisController::class, 'storedriver']);


});

//Admin Midddleware
Route::middleware(['auth:sanctum', 'auth.admin'])->group(function () {
      Route::get('/all/transaction', [AdminMainController::class, 'transaction']);
      Route::patch('deactivate/user/{user}', [AdminMainController::class, 'deactivateUser']);
      Route::patch('activate/user/{user}', [AdminMainController::class, 'activateUser']);
      Route::get('active/client', [AdminMainController::class, 'activeClient']);
      Route::get('active/agent', [AdminMainController::class, 'activeAgent']);
      Route::get('active/provider', [AdminMainController::class, 'activeProvider']);
      Route::get('deactive/client', [AdminMainController::class, 'deactiveClient']);
      Route::get('deactive/agent', [AdminMainController::class, 'deactiveAgent']);
      Route::get('deactive/provider', [AdminMainController::class, 'deactiveProvider']);
      Route::get('count/client', [AdminMainController::class, 'countClient']);
      Route::get('count/agent', [AdminMainController::class, 'countAgent']);
      Route::get('count/provider', [AdminMainController::class, 'countProvider']);
      

      //Route::post('register', [AgentAuthController::class,'register' ]);

});