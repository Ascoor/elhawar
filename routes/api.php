<?php


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

use Froiden\RestAPI\Facades\ApiRoute;
use Illuminate\Support\Facades\Route;

ApiRoute::group(['namespace' => 'App\Http\Controllers\Front'], function () {
    ApiRoute::get('purchased-module', ['as' => 'api.purchasedModule', 'uses' => 'HomeController@installedModule']);
});

Route::post('/api/fawry-payment-callback', ['as' => 'fawry-payment-callback', 'uses' => 'FawryPayWebHookController@fawryCallback']);

Route::resource('notice', 'MobileNoticeController');

Route::resource('sports', 'MobileSportsController');



