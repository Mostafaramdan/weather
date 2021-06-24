<?php

namespace App\Http\Controllers\Apis\Controllers\getWarnings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\warnings;
use Carbon\Carbon;
class getWarningsController extends index
{
    public static function api(){
        $now=Carbon::now()->format("Y-m-d");
      
        $records=  warnings::allActive()->where('startDate',"<=",$now)->where('endDate',">=",$now);
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "warnings"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"warning"),
        ];
    }
}