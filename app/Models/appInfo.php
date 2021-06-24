<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class appInfo extends GeneralModel
{
    protected $table = 'appInfo';

    public static function createUpdate($params){
        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->aboutUsAr = isset($params["aboutUsAr"])? $params["aboutUsAr"]: $record->aboutUsAr;
        $record->aboutUsEn = isset($params["aboutUsEn"])? $params["aboutUsEn"]: $record->aboutUsEn;
        $record->policyAr = isset($params["policyAr"])? $params["policyAr"]: $record->policyAr;
        $record->policyEn = isset($params["policyEn"])? $params["policyEn"]: $record->policyEn;
        $record->fax = isset($params["fax"])? $params["fax"]: $record->fax;
        $record->address = isset($params["address"])? $params["address"]: $record->address;
        $record->facebook = isset($params["facebook"])? $params["facebook"]: $record->facebook;
        $record->twitter = isset($params["twitter"])? $params["twitter"]: $record->twitter;
        $record->snapshat = isset($params["snapshat"])? $params["snapshat"]: $record->snapshat;
        $record->save();
        return $record;
    }
    public function phones(){
        return $this->hasMany(phones::class,'appInfo_id');
    }
    public function emails(){
        return $this->hasMany(emails::class,'appInfo_id');
    }
}