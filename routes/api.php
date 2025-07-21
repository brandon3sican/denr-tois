<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\OfficialStationController;

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

// Public routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Region API Routes
Route::prefix('regions')->group(function () {
    Route::get('/', [RegionController::class, 'index']);
    Route::get('/{region}', [RegionController::class, 'show']);
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [RegionController::class, 'store']);
        Route::put('/{region}', [RegionController::class, 'update']);
        Route::delete('/{region}', [RegionController::class, 'destroy']);
        
        // Get official stations for a region
        Route::get('/{region}/stations', [OfficialStationController::class, 'getByRegion']);
    });
});

// Official Station API Routes
Route::prefix('official-stations')->group(function () {
    Route::get('/', [OfficialStationController::class, 'index']);
    Route::get('/{officialStation}', [OfficialStationController::class, 'show']);
    
    // Protected routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [OfficialStationController::class, 'store']);
        Route::put('/{officialStation}', [OfficialStationController::class, 'update']);
        Route::delete('/{officialStation}', [OfficialStationController::class, 'destroy']);
    });
});
