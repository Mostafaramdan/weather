<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
route::get('/',function(){
      return redirect(route("dashboard.login"));
});
route::view('/template-dashboard','template');
route::get('/test',function(){
      // App\Jobs\pushNotificationToAllAfterWarnings::dispatch(null,null);
      // App\Jobs\pushNotificationToAllAfterWarnings::dispatch1();
});

