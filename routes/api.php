<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Message\MessageController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\FriendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


/*
 * Routes API user 
 */

Route::prefix('user')->group(function () {
    Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
    Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('search-user', [App\Http\Controllers\Api\User\UserController::class, 'searchUser']);
        Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
        Route::get('info', [App\Http\Controllers\Api\User\UserController::class, 'info'])->name('info');
        Route::put('update-info', [App\Http\Controllers\Api\User\UserController::class, 'updateInfo'])->name('updateInfo');
        /*
 * Routes Api Message 
 */
        Route::prefix('chat')->group(function () {
            Route::get('/{conversationId}/messages', [MessageController::class, 'listMessage']);
            Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('sendMessage');
            Route::get('/list-conversations', [MessageController::class, 'listConversation']);
        });

        Route::prefix('friend')->group(function () {
            Route::post('/add/{id}', [FriendController::class, 'addFriend']);
            Route::get('/friend-pending', [FriendController::class, 'friendPending']);
            Route::post('/accept-friendship/{id}', [FriendController::class, 'acceptFriendship']);
        });
    });
});

Route::prefix('admin')->middleware(['auth:admin_api', 'admin'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/create', [UserController::class, 'create'])->name('userCreate');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('userEdit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('userUpdate');
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
    });
});

Route::get('get-provinces', [AddressController::class, 'getProvinces'])->name('getProvinces');
Route::get('get-districts', [AddressController::class, 'getDistrictByProvince'])->name('getDistricts');
Route::get('get-communes', [AddressController::class, 'getCommuneByDistrict'])->name('getCommunes');

Route::middleware('auth:api')->post('/broadcasting/auth', function (Request $request) {
    $channel_name = $request->channel_name;
    Log::info($channel_name);
    Log::info($request);
    $user = auth()->user();
    if (!$user) {
        Log::error('Người dùng chưa xác thực');
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    return ['id' => $user->id, 'full_name' => $user->full_name, 'avatar' =>$user->avatar];
});