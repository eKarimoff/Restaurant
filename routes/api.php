<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController\RestaurantController;
use App\Http\Controllers\ApiController\WarehouseController;
use App\Http\Controllers\ApiController\DetailController;
use App\Http\Controllers\ApiController\UserController;
use App\Http\Controllers\ApiController\KitchenController;
use App\Http\Controllers\ApiController\PreparedFoodController;
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


Auth::routes();
Route::post('login', [UserController::class, 'login']);

    Route::group(['middleware'=>'auth:sanctum'], function(){
    
    Route::group(['middleware'=>['role:chef']], function(){

        Route::get('/menu', [RestaurantController::class,'menu']);
        
        Route::get('/orders',[RestaurantController::class,'orderedFood']);
        
        Route::post('/foods/store',[RestaurantController::class,'addFood']);
        
        Route::post('/orders/store',[RestaurantController::class,'orderStore']);
    
        Route::get('/edit/Warehouse/{id?}',[WarehouseController::class,'editWarehouse']);
    
        Route::post('/update/Warehouse/Products/{id?}',[WarehouseController::class,'updateWare']);
    
        Route::get('/warehouse', [WarehouseController::class,'ombor']);
    
        Route::post('/add/product',[WarehouseController::class,'insertProduct']);
    
        Route::get('/orders/detail/{id?}',[DetailController::class,'orderDetail']);
    
        Route::get('/statistics',[DetailController::class,'statistic']);
    
        Route::get('/foods/ingredient/{id?}',[DetailController::class,'ingredient']);
    
        Route::get('/users',[UserController::class,'users']);
    
        Route::get('/fridge', [KitchenController::class,'getDays']);
    
        Route::get('/product/days/{day}',[KitchenController::class,'getDateFromKitchen']);
    
        Route::post('/storeToFridge',[KitchenController::class,'storeToFridge']);
    
        Route::post('/return/product',[KitchenController::class,'returnProduct']);
    
        Route::post('/cook/food',[PreparedFoodController::class,'cookFood']);
    
        Route::get('/ready/food',[PreparedFoodController::class,'makeFood']);
  
    });
    Route::group(['middleware'=> ['role:waiter|chef']], function (){
        Route::get('/', [RestaurantController::class,'menu']);
        Route::get('/menu', [RestaurantController::class,'menu']);
        Route::post('/orders/store',[RestaurantController::class,'orderStore']);
        Route::get('/foods/ingredient/{id?}',[DetailController::class,'ingredient']);
        Route::delete('/logout',[UserController::class,'logout']);
        Route::get('/users',[UserController::class,'users']);

    });
    
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
