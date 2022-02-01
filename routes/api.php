<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [\App\Http\Controllers\UserController::class, 'logIn']);
Route::post('refresh', [\App\Http\Controllers\UserController::class, 'refresh']);
Route::delete('logout', [\App\Http\Controllers\UserController::class, 'logOut']);
Route::post('campaign', [\App\Http\Controllers\CampaignController::class, 'create']);
Route::get('campaign', [\App\Http\Controllers\CampaignController::class, 'read']);
Route::put('campaign/{id}', [\App\Http\Controllers\CampaignController::class, 'update']);
Route::delete('campaign/{id}', [\App\Http\Controllers\CampaignController::class, 'delete']);
Route::post('category', [\App\Http\Controllers\CategoryController::class, 'create']);
Route::delete('category/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);
Route::put('category/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
Route::get('category', [\App\Http\Controllers\CategoryController::class, 'read']);
Route::post('subCategory', [\App\Http\Controllers\SubCategoryController::class, 'create']);
Route::delete('subCategory/{id}', [\App\Http\Controllers\SubCategoryController::class, 'delete']);
Route::put('subCategory/{id}', [\App\Http\Controllers\SubCategoryController::class, 'update']);
Route::get('subCategory', [\App\Http\Controllers\SubCategoryController::class, 'read']);
Route::post('comment', [\App\Http\Controllers\CommentController::class, 'create']);
Route::get('comment', [\App\Http\Controllers\CommentController::class, 'read']);
Route::put('comment/{id}', [\App\Http\Controllers\CommentController::class, 'update']);
Route::delete('comment/{id}', [\App\Http\Controllers\CommentController::class, 'delete']);
Route::get('departamentos', [\App\Http\Controllers\DepartamentosController::class, 'read']);
Route::get('distritos', [\App\Http\Controllers\DistritosController::class, 'read']);
Route::get('distritosAll', [\App\Http\Controllers\DistritosController::class, 'readAll']);
Route::get('genders', [\App\Http\Controllers\GenderController::class, 'read']);
Route::get('hoursSubasta', [\App\Http\Controllers\HoraSubastaController::class, 'read']);
Route::post('locationSubasta', [\App\Http\Controllers\LocationSubastaController::class, 'create']);
Route::get('locationSubasta', [\App\Http\Controllers\LocationSubastaController::class, 'read']);
Route::post('mediaSubasta', [\App\Http\Controllers\MediaSubastaController::class, 'create']);
Route::get('mediaSubasta', [\App\Http\Controllers\MediaSubastaController::class, 'read']);
Route::post('message', [\App\Http\Controllers\MessageController::class, 'create']);
Route::get('message', [\App\Http\Controllers\MessageController::class, 'read']);
Route::put('message/{id}', [\App\Http\Controllers\MessageController::class, 'updateState']);
Route::delete('message/{id}', [\App\Http\Controllers\MessageController::class, 'delete']);
Route::post('page', [\App\Http\Controllers\PageController::class, 'create']);
Route::get('page', [\App\Http\Controllers\PageController::class, 'read']);
Route::put('page/{id}', [\App\Http\Controllers\PageController::class, 'update']);
Route::delete('page/{id}', [\App\Http\Controllers\PageController::class, 'delete']);
Route::post('pay', [\App\Http\Controllers\PayController::class, 'create']);
Route::get('pay', [\App\Http\Controllers\PayController::class, 'read']);
Route::put('pay/{id}', [\App\Http\Controllers\PayController::class, 'update']);
Route::get('miPay', [\App\Http\Controllers\PayController::class, 'readForUser']);
Route::get('provincias', [\App\Http\Controllers\ProvinciasController::class, 'read']);
Route::get('roles', [\App\Http\Controllers\RoleController::class, 'read']);
Route::get('statesSubasta', [\App\Http\Controllers\StateSubastaController::class, 'read']);
Route::post('subasta', [\App\Http\Controllers\SubastaController::class, 'create']);
Route::get('subasta', [\App\Http\Controllers\SubastaController::class, 'read']);
Route::get('subastaPendiente', [\App\Http\Controllers\SubastaController::class, 'readPendientes']);
Route::get('subastaAprobada', [\App\Http\Controllers\SubastaController::class, 'readAprobadas']);
Route::get('subastaBloqueada', [\App\Http\Controllers\SubastaController::class, 'readBloqueadas']);
Route::get('misubasta', [\App\Http\Controllers\SubastaController::class, 'readForUser']);
Route::get('subastaUser', [\App\Http\Controllers\SubastaController::class, 'readForUserId']);
Route::get('misubastaPendiente', [\App\Http\Controllers\SubastaController::class, 'readForUserPendientes']);
Route::get('miSubastaId', [\App\Http\Controllers\SubastaController::class, 'readForId']);
Route::put('subastaState/{id}', [\App\Http\Controllers\SubastaController::class, 'updateState']);
Route::get('typePay', [\App\Http\Controllers\TypePayController::class, 'read']);
Route::get('typeSubasta', [\App\Http\Controllers\TypeSubastaController::class, 'read']);
Route::post('user', [\App\Http\Controllers\UserController::class, 'create']);
Route::post('userFull', [\App\Http\Controllers\UserController::class, 'createFull']);
Route::get('user', [\App\Http\Controllers\UserController::class, 'read']);
Route::get('userAdmin', [\App\Http\Controllers\UserController::class, 'readAdmin']);
Route::get('userId', [\App\Http\Controllers\UserController::class, 'readId']);
Route::put('user/{id}', [\App\Http\Controllers\UserController::class, 'update']);
Route::delete('user/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
Route::post('vendedorSubasta', [\App\Http\Controllers\VendedorSubastaController::class, 'create']);
Route::get('vendedorSubasta', [\App\Http\Controllers\VendedorSubastaController::class, 'read']);
Route::get('favoritaSubasta', [\App\Http\Controllers\FavoritaSubastaController::class, 'read']);
Route::post('favoritaSubasta', [\App\Http\Controllers\FavoritaSubastaController::class, 'create']);
Route::delete('favoritaSubasta/{id}', [\App\Http\Controllers\FavoritaSubastaController::class, 'delete']);
Route::get('historialSubasta', [\App\Http\Controllers\HistorialSubastaController::class, 'read']);
Route::post('historialSubasta', [\App\Http\Controllers\HistorialSubastaController::class, 'create']);



