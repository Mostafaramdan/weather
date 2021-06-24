<?php
namespace App\Http\Controllers\Apis\Controllers\getNews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\news;
class getNewsController extends index
{
    public static function api(){
        

        $records=  news::allActive();
        $records=$records->where('periodic','=',self::$request->periodic);
        $records= self::$request->countryId?$records->where("countries_id",self::$request->countryId):$records;
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "news"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"news"),
        ];
    }
    
}