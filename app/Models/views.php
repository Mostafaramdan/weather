<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class views extends GeneralModel
{
    protected $table = 'views';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->device_id = isset($params["device_id"])? $params["device_id"]: $record->device_id;
        $record->news_id = isset($params["news_id"])? $params["news_id"]: $record->news_id;
        $record->save();
        return $record;
    }
    public function new(){
        return $this->belongsTo(news::class,'news_id');
    }
}