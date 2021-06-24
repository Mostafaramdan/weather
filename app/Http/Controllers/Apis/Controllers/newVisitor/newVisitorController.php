<?php
namespace App\Http\Controllers\Apis\Controllers\newVisitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\visitors;

class newVisitorController extends index
{
    public static function api(){

        // visitors::where("fireBaseToken",self::$request->fireBaseToken)->delete();
        // visitors::where("deviceId",self::$request->deviceId)->delete();
       
        $visitor = visitors::where("fireBaseToken",self::$request->fireBaseToken)
                            ->Where('deviceId',self::$request->deviceId)
                            ->first();
        if(!$visitor){
            $visitor = visitors::where("fireBaseToken",self::$request->fireBaseToken)->first();
            if(!$visitor){
                $visitor = visitors::where("deviceId",self::$request->deviceId)->first();
            }else{

            }
        }
        $recrod = visitors::createUpdate([
            'id'=>$visitor->id??null,
            "fireBaseToken"=>self::$request->fireBaseToken,
            "deviceId"=>self::$request->deviceId
        ]);
        return [
            "status"=>200,
            'recrod'=>$recrod
        ];

    }
}

