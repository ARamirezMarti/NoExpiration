<?php

use App\Http\Controllers\companyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\inventoryController;
use App\Http\Controllers\productController;
use App\Http\Controllers\prodtypeController;

use Illuminate\Support\Facades\Route;

Route::post('register',[UserController::class,'register']);
Route::get('login',[UserController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::post('inventory/create',[inventoryController::class,'createInventory']);    
    Route::post('inventory/delete',[inventoryController::class,'deleteInventory']);    
    Route::get('inventory',[inventoryController::class,'getInventory']);    
    
    Route::post('product/create',[productController::class,'createProduct']);    
    Route::post('product/delete',[productController::class,'deleteProduct']);  
    Route::post('product/update',[productController::class,'updateProduct']);    
    Route::get('product/one',[productController::class,'getOneProduct']);    
    Route::get('product/all',[productController::class,'getAllProduct']);
    
    
    Route::get('types',[prodtypeController::class,'getTypes']);    


    Route::get('product/companies/all',[companyController::class,'getAllCompanyByUser']);
    


});