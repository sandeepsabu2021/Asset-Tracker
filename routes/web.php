<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Main;
use App\Http\Middleware\Loginsession;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::middleware([Loginsession::class])->group(function () {
    Route::get('/test', function () {
        return "Session available";
    });

    Route::get('/home', [Main::class, 'home']);
    Route::get('/master', [Main::class, 'master']);

    Route::get('/dashboard', [Main::class, 'dashboard']);

    Route::get('/asset-type', [Main::class, 'assetType']);
    Route::get('/add-asset-type', [Main::class, 'addAssetType']);
    Route::post('/assettypevalid', [Main::class, 'assetTypeValid']);
    Route::delete('/deletetype', [Main::class, 'deltype']);
    Route::get('/edit-asset-type-{id}', [Main::class, 'edittype']);
    Route::post('/editassettypevalid', [Main::class, 'editTypeValid']);
    Route::get('/downloadcsv', [Main::class, 'downloadCSV']);

    Route::get('/asset{id?}', [Main::class, 'asset']);
    Route::get('/add-asset', [Main::class, 'addAsset']);
    Route::post('/assetvalid', [Main::class, 'assetValid']);
    Route::delete('/deleteasset', [Main::class, 'delasset']);
    Route::get('/edit-asset-{id}', [Main::class, 'editasset']);
    Route::post('/editassetvalid', [Main::class, 'editAssetValid']);

    Route::get('view-asset-{id}', [Main::class, 'view']);

    Route::get('/logout', [Main::class, 'logout']);
});
