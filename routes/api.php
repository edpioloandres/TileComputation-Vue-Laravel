<?php

use App\Http\Controllers\ShioController;
use App\Http\Controllers\TileDataController;
use App\Http\Controllers\GaihekiController;
use App\Http\Controllers\UnitDemadoController;
use App\Http\Controllers\BalconyController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\JikugumiController;
use App\Http\Controllers\WakugumiController;
use App\Http\Controllers\SpecialComputationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/getPlanNumber', [ShioController::class, 'getPlanNumber']);
Route::post('/getShioData', [ShioController::class, 'getShioData']);

Route::get('/getMaster', [TileDataController::class, 'getMaster']);
Route::post('/getDemadoMaster', [TileDataController::class, 'getDemadoMaster']);
Route::post('/getTilePoints', [TileDataController::class, 'getTilePoints']);
Route::post('/getAllData', [TileDataController::class, 'getAllData']);
Route::post('/saveTotalPoints', [TileDataController::class, 'saveTotalPoints']);

/*=====================================================*/
/*				      Gaiheki Area                     */
/*=====================================================*/

Route::post('/getGaihekiData', [GaihekiController::class, 'getGaihekiData']);
Route::post('/saveGaihekiArea', [GaihekiController::class, 'saveGaihekiArea']);
Route::post('/saveSash', [GaihekiController::class, 'saveSash']);
Route::post('/saveEntrance', [GaihekiController::class, 'saveEntrance']);


/*=====================================================*/
/*				      Unit Demado                      */
/*=====================================================*/

Route::post('/getUnitDemado', [UnitDemadoController::class, 'getUnitDemado']);
Route::post('/saveUnitDemado', [UnitDemadoController::class, 'saveUnitDemado']);


/*=====================================================*/
/*				      Balcony                          */
/*=====================================================*/

Route::post('/getBalcony', [BalconyController::class, 'getBalcony']);
Route::post('/saveBalcony', [BalconyController::class, 'saveBalcony']);


/*=====================================================*/
/*				      Columns                          */
/*=====================================================*/

Route::post('/getColumn', [ColumnController::class, 'getColumn']);
Route::post('/saveColumn', [ColumnController::class, 'saveColumn']);

/*=====================================================*/
/*				      2F Jikugumi                      */
/*=====================================================*/

Route::post('/getJikugumiData', [JikugumiController::class, 'getJikugumiData']);
Route::post('/saveJikugumiData', [JikugumiController::class, 'saveJikugumiData']);

/*=====================================================*/
/*				      2F Wakugumi                      */
/*=====================================================*/

Route::post('/getWakugumiData', [WakugumiController::class, 'getWakugumiData']);
Route::post('/saveWakugumiData', [WakugumiController::class, 'saveWakugumiData']);

/*=====================================================*/
/*				     Special Computations              */
/*=====================================================*/

Route::post('/getSpecialComputations', [SpecialComputationController::class, 'getSpecialComputations']);
Route::post('/saveSpecialComputations', [SpecialComputationController::class, 'saveSpecialComputations']);