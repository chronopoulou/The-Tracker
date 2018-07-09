<?php

use Illuminate\Http\Request;

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


Route::get('websites/pixel/{hash}/track.js', 'WebsiteController@pixelCode')->name('api.websites.showPixel');

Route::post('visitor/store', 'VisitorController@store')->name('api.visitor.create');
Route::post('action/store', 'ActionController@store')->name('api.action.create');



/**
 * Adds a contact to mailchimp list
 * Accepts: [api_key, list_id, email]
 * Returns: [id] or Error
 */
Route::post('mailchimp/add', 'MailchimpController@store');
