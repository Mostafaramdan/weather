<?php

namespace App\Http\Controllers\Apis\Controllers\muteNotifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\visitors;

class muteNotificationsController extends index
{
    public static function api(){

        $record=  visitors::where('fireBaseToken',self::$request->fireBaseToken)->first();
        $record->mute_notifications = $record->mute_notifications?0 : 1;
        $record->save();
        return [
            "status"=>200,
            'mute_notifications'=>$record->mute_notifications
        ];
                    

    }
}

