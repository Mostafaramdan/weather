<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class countries extends GeneralModel
{
    protected $table = 'countries';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->nameAr = isset($params["nameAr"])? $params["nameAr"]: $record->nameAr;
        $record->nameEn = isset($params["nameEn"])? $params["nameEn"]: $record->nameEn;
        $record->alpha2 = isset($params["alpha2"])? $params["alpha2"]: $record->alpha2;
        $record->alpha3 = isset($params["alpha3"])? $params["alpha3"]: $record->alpha3;
        $record->numeric = isset($params["numeric"])? $params["numeric"]: $record->numeric;
        $record->save();
        return $record;
    }
    public function currencies(){
        return $this->hasMany(currencies::class, "countries_id");
    }
}