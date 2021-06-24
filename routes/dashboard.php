<?php
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

route::post('/login','authentication@login')->name('dashboard.login');
route::get('/login','authentication@index')->name('dashboard.login.index');
route::get('/logout','authentication@logout')->name('dashboard.logout');

Route::group(['middleware' => ['dashboard']], function () 
{
       route::get('categoriesByStore/{id}','general@categoriesByStore')->name('dashboard.categoriesByStore.index');
       route::get('searchFor/{model}/{col}/{search}','general@searchFor')->name('dashboard.searchFor.search');
       route::get('searchFor/{model}/{col}/','general@searchFor')->name('dashboard.searchFor.search');

       route::get('statistics','statistics@index')->name('dashboard.statistics.index');
       route::post('statistics/getByDateRange','statistics@getByDateRange')->name('dashboard.statistics.getByDateRange');
       route::post('statistics','statistics@indexPageing')->name('dashboard.statistics.indexPageing');

       route::get('users','users@index')->name('dashboard.users.index');
       route::post('users/createUpdate','users@createUpdate')->name('dashboard.users.createUpdate');
       route::post('users','users@indexPageing')->name('dashboard.users.indexPageing');
       route::get('users/delete/{id}','users@delete')->name('dashboard.users.delete');
       route::get('users/check/{type}/{id}','users@check')->name('dashboard.users.check');
       route::get('users/getRecord/{id}','users@getRecord')->name('dashboard.users.getRecord');
       route::get('users/getLogs/{id}','users@getLogs')->name('dashboard.users.getLogs');

       route::get('notifications','notifications@index')->name('dashboard.notifications.index');
       route::post('notifications/createUpdate','notifications@createUpdate')->name('dashboard.notifications.createUpdate');
       route::post('notifications','notifications@indexPageing')->name('dashboard.notifications.indexPageing');
       route::get('notifications/delete/{id}','notifications@delete')->name('dashboard.notifications.delete');
       route::get('notifications/check/{type}/{id}','notifications@check')->name('dashboard.notifications.check');
       route::get('notifications/getRecord/{id}','notifications@getRecord')->name('dashboard.notifications.getRecord');


       route::get('admins','admins@index')->name('dashboard.admins.index');
       route::post('admins/createUpdate','admins@createUpdate')->name('dashboard.admins.createUpdate');
       route::post('admins','admins@indexPageing')->name('dashboard.admins.indexPageing');
       route::get('admins/delete/{id}','admins@delete')->name('dashboard.admins.delete');
       route::get('admins/check/{type}/{id}','admins@check')->name('dashboard.admins.check');
       route::get('admins/getRecord/{id}','admins@getRecord')->name('dashboard.admins.getRecord');

       route::get('appInfo','appInfo@index')->name('dashboard.appInfo.index');
       route::post('appInfo/createUpdate','appInfo@createUpdate')->name('dashboard.appInfo.createUpdate');
       route::post('appInfo','appInfo@indexPageing')->name('dashboard.appInfo.indexPageing');
       route::get('appInfo/delete/{id}','appInfo@delete')->name('dashboard.appInfo.delete');
       route::get('appInfo/check/{type}/{id}','appInfo@check')->name('dashboard.appInfo.check');
       route::get('appInfo/getRecord/{id}','appInfo@getRecord')->name('dashboard.appInfo.getRecord');

       route::get('news','news@index')->name('dashboard.news.index');
       route::post('news/createUpdate','news@createUpdate')->name('dashboard.news.createUpdate');
       route::post('news','news@indexPageing')->name('dashboard.news.indexPageing');
       route::get('news/indexPageing','news@indexPageing')->name('dashboard.news.indexPageing.get');
       route::get('news/delete/{id}','news@delete')->name('dashboard.news.delete');
       route::get('news/check/{check}/{id}','news@check')->name('dashboard.news.check');
       route::get('news/getRecord/{id}','news@getRecord')->name('dashboard.news.getRecord');

       route::get('horoscopes','horoscopes@index')->name('dashboard.horoscopes.index');
       route::post('horoscopes/createUpdate','horoscopes@createUpdate')->name('dashboard.horoscopes.createUpdate');
       route::post('horoscopes','horoscopes@indexPageing')->name('dashboard.horoscopes.indexPageing');
       route::get('horoscopes/delete/{id}','horoscopes@delete')->name('dashboard.horoscopes.delete');
       route::get('horoscopes/check/{check}/{id}','horoscopes@check')->name('dashboard.horoscopes.check');
       route::get('horoscopes/getRecord/{id}','horoscopes@getRecord')->name('dashboard.horoscopes.getRecord');

       route::get('warnings','warnings@index')->name('dashboard.warnings.index');
       route::post('warnings/createUpdate','warnings@createUpdate')->name('dashboard.warnings.createUpdate');
       route::post('warnings','warnings@indexPageing')->name('dashboard.warnings.indexPageing');
       route::get('warnings/indexPageing','warnings@indexPageing')->name('dashboard.warnings.indexPageing.get');
       route::get('warnings/delete/{id}','warnings@delete')->name('dashboard.warnings.delete');
       route::get('warnings/check/{check}/{id}','warnings@check')->name('dashboard.warnings.check');
       route::get('warnings/getRecord/{id}','warnings@getRecord')->name('dashboard.warnings.getRecord');

       route::get('countries','countries@index')->name('dashboard.countries.index');
       route::post('countries/createUpdate','countries@createUpdate')->name('dashboard.countries.createUpdate');
       route::post('countries','countries@indexPageing')->name('dashboard.countries.indexPageing');
       route::get('countries/delete/{id}','countries@delete')->name('dashboard.countries.delete');
       route::get('countries/check/{check}/{id}','countries@check')->name('dashboard.countries.check');
       route::get('countries/getRecord/{id}','countries@getRecord')->name('dashboard.countries.getRecord');
       
       route::get('stadiums','stadiums@index')->name('dashboard.stadiums.index');
       route::post('stadiums/createUpdate','stadiums@createUpdate')->name('dashboard.stadiums.createUpdate');
       route::post('stadiums','stadiums@indexPageing')->name('dashboard.stadiums.indexPageing');
       route::get('stadiums/delete/{id}','stadiums@delete')->name('dashboard.stadiums.delete');
       route::get('stadiums/check/{check}/{id}','stadiums@check')->name('dashboard.stadiums.check');
       route::get('stadiums/getRecord/{id}','stadiums@getRecord')->name('dashboard.stadiums.getRecord');
});

 
