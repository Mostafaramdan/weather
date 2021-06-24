<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class warnings extends GeneralModel
{
    protected $table = 'warnings';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->contentAr = isset($params["contentAr"])? $params["contentAr"]: $record->contentAr;
        $record->contentEn = isset($params["contentEn"])? $params["contentEn"]: $record->contentEn;
        $record->startDate = isset($params["startDate"])? $params["startDate"]: $record->startDate;
        $record->endDate = isset($params["endDate"])? $params["endDate"]: $record->endDate;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function notify(){
        return $this->hasMany(notify::class);
    }

}