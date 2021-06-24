<?php
namespace App\Http\Controllers\Apis\Controllers\newVisitorTest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\visitors1 as visitors;

class newVisitorTestController extends index
{
    public static function api(){

        visitors::where("fireBaseToken",self::$request->fireBaseToken)->delete();
        visitors::where("deviceId",self::$request->deviceId)->delete();
        $visitors = visitors::where("deviceId",self::$request->deviceId)->first();
        visitors::createUpdate([
            'id'=>$visitors->id??null,
            "fireBaseToken"=>self::$request->fireBaseToken,
            "deviceId"=>self::$request->deviceId
        ]);
        return [
            "status"=>200,
        ];

    }
}

