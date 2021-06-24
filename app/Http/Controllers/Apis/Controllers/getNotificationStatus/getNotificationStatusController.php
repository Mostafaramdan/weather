<?php

namespace App\Http\Controllers\Apis\Controllers\getNotificationStatus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\visitors;

class getNotificationStatusController extends index
{
    public static function api(){

        $record=  visitors::where('fireBaseToken',self::$request->fireBaseToken)->first();
        return [
            "status"=>200,
            'mute_notifications'=> $record->mute_notifications
        ];
    }
}
