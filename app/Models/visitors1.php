<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visitors1 extends GeneralModel
{
    protected $table = 'visitors1';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->fireBaseToken = isset($params["fireBaseToken"])? $params["fireBaseToken"]: $record->fireBaseToken;
        $record->deviceId = isset($params["deviceId"])? $params["deviceId"]: $record->deviceId;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        // $record->save();
        return $record;
    }

}