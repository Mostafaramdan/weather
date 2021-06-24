<?php

namespace App\Http\Controllers\Apis\Controllers\views;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\views;

class viewsController extends index
{
    public static function api(){

        if(views::where('device_id',self::$request->deviceId)->where('news_id',self::$request->newsId)->count() == 0){
            $record= views::createUpdate([
                'device_id'=>self::$request->deviceId,
                'news_id'=>self::$request->newsId,
            ]);
        }
        return [
            "status"=>200
        ];
    }
}