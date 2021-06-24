<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notifications extends GeneralModel
{
    protected $table = 'notifications';

    public static function createUpdate($params){

        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->contentAr =  isset($params['contentAr'])?$params['contentAr']: $record->contentAr;
        $record->contentEn =  isset($params['contentEn'])?$params['contentEn']: $record->contentEn;
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        isset($params['deletedAt'])?:$record->deletedAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    
    public function notify(){
        return $this->hasMany('\App\Models\notify','notifications_id');
    }
}