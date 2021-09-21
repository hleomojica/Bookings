<?php

use App\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Ui\Presets\React;
use PhpParser\Builder\Function_;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route:: get('bookables', function(Request $request){
    return Bookable::all();
});

Route :: get('bookables/{id}' , function(Request $request, $id){
    return Bookable::findOrFail($id);
});
