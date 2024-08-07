<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\AutocompleteController;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ViewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/apartment/{lat}/{lon}/address', [ApartmentController::class, 'getAddressFromCoordinates']);
Route::put('/apartments/{slug}/update-coordinates', [ApartmentController::class, 'updateCoordinates']);
Route::get('/getCoord', [ApartmentController::class, 'getCoordinatesForAddress']);
Route::get('/autocomplete', [AutocompleteController::class, 'search'])->name('autocomplete.search');
Route::get('/apartment/{slug}/apartment-details', [ApartmentController::class, "showApartment"]);

Route::get('/filter', [SearchController::class, 'getFilteredData']);
Route::get('/search', [SearchController::class, "searchApartments"]);
Route::post('/radius{radius}', [SearchController::class, "apartmentRadius"]);
Route::get('/featured', [SearchController::class, "fetchSponsored"]);
Route::get('/featured-mobile', [SearchController::class, "fetchSponsoredAll"]);

Route::post('/view', [ViewController::class, 'store']);

Route::post('/leads', [LeadController::class, 'store']);