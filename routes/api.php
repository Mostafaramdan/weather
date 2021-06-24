<?php
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

Route::post('getRegions','index@index');
Route::post('registerAsVisitor','index@index');
Route::post('register','index@index');
Route::post('validateCode','index@index');
Route::post('login','index@index');
Route::post('forgetPassword','index@index');
Route::post('changePassword','index@index');
Route::post('resetPassword','index@index');
Route::post('updatePassword','index@index');
Route::post('updateUserProfile','index@index');
Route::post('resendCode','index@index');
Route::post('logout','index@index');
Route::ANY('appInfo','index@index');
Route::post('contacts','index@index');
Route::post('unseenNotifications','index@index');
Route::post('setFireBaseToken','index@index');
Route::ANY('notifications','index@index');
Route::post('unseenNotificationCount','index@index');
Route::post('deleteNotification','index@index');
Route::any('reports','index@index');
route::post('search','index@index');
route::post('getNews','index@index');
route::post('getWarnings','index@index');
route::post('getHoroscopes','index@index');
route::post('newVisitor','index@index');
route::post('newVisitorTest','index@index');
route::ANY('getCountries','index@index');
route::post('views','index@index');
route::post('muteNotifications','index@index');
route::post('getNotificationStatus','index@index');
route::post('getNotificationStatus','index@index');



//start   Rassed API 

Route::get('/foreCasts','Rassed_api\fore_casts\foreCastsController@foreCasts');
Route::get('/foreCastsV2','Rassed_api\fore_casts\foreCastsController@foreCasts');


Route::get('/currentConditions','Rassed_api\current_conditions\currentConditionsController@currentConditions');
Route::get('/locations','Rassed_api\locations\locationsController@locations');


//end Rassed API
route::post('getsuggest','index@index');