<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\PreparedFoodController;
use App\Http\Controllers\HomeController;

Route::get('/', function(){
   
});
Auth::routes();
Route::group(['middleware'=>'auth:sanctum'], function(){
    Route::group(['middleware' => ['role:chef']], function () {

    Route::post('/addFood',[RestaurantController::class,'addFood'])->name('addFood');
    
    Route::get('/order',[RestaurantController::class,'orderedFood'])->name('order');
    
    Route::post('/orderStore',[RestaurantController::class,'orderStore']);
    
    Route::get('/home', [RestaurantController::class, 'menu'])->name('menu');
    
    Route::get('/menu/{id?}',[RestaurantController::class,'menu'])->name('menu');

    Route::get('/search',[RestaurantController::class,'search']);

    Route::get('/editWare/{id}',[WarehouseController::class,'editWare'])->name('editWare');
    
    Route::post('/updateWare/{id}',[WarehouseController::class,'updateWare'])->name('updateWare');
    
    Route::get('/warehouse', [WarehouseController::class,'ombor'])->name('warehouse');
    
    Route::post('/insertProduct',[WarehouseController::class,'insertProduct'])->name('insertProduct');
    
    Route::get('/orderDeatil/{id}',[DetailController::class,'orderDeatil'])->name('orderDeatil');
    
    Route::get('/statistic',[DetailController::class,'statistic'])->name('statistic');
    
    Route::get('/ingredient/{id}',[DetailController::class,'ingredient'])->name('ingredient');

    Route::get('/fridge', [KitchenController::class,'getDays'])->name('fridge');

    Route::get('/makeFood/{day}',[KitchenController::class,'getDateFromKitchen'])->name('makeFood');

    Route::post('/storeToFridge',[KitchenController::class,'storeToFridge']);

    Route::post('/returnProduct',[KitchenController::class,'returnProduct'])->name('returnProduct');

    Route::post('/cookFood',[PreparedFoodController::class,'cookFood']);

    Route::get('/readyFood',[PreparedFoodController::class,'readyFood'])->name('readyFood');

    Route::get('/editPrice/{id}',[RestaurantController::class,'editPrice'])->name('editPrice');

    Route::post('/updatePrice/{id}',[RestaurantController::class,'updateFoodPrice']);

    Route::get('/table',[RestaurantController::class,'tables'])->name('table');

});
    Route::group(['middleware'=> ['role:waiter|chef']], function (){
    Route::get('/editPrice/{id}',[RestaurantController::class,'editPrice'])->name('editPrice');
    Route::post('updatePrice/{id}',[RestaurantController::class,'updateFoodPrice']);
    Route::get('/', [RestaurantController::class,'menu'])->name('menu');
    Route::get('/menu/{id?}', [RestaurantController::class,'menu'])->name('menu');
    Route::post('/orderStore',[RestaurantController::class,'orderStore']);
    Route::get('/ingredient/{id}',[DetailController::class,'ingredient'])->name('ingredient');
    Route::get('/home', [RestaurantController::class, 'menu'])->name('menu');
    Route::post('/bookTable',[RestaurantController::class,'bookTable']);
});
});


