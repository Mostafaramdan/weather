<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class horoscopes extends GeneralModel
{
    protected $table = 'horoscopes';

    public static function createUpdate($params){

        $record                 = isset($params["id"])           ? self::find($params["id"]) : new self();
        $record->nameAr         = isset($params["nameAr"])       ? $params["nameAr"]         : $record->nameAr;
        $record->nameEn         = isset($params["nameEn"])       ? $params["nameEn"]         : $record->nameEn;
        $record->titleAr        = isset($params["titleAr"])      ? $params["titleAr"]        : $record->titleAr;
        $record->titleEn        = isset($params["titleEn"])      ? $params["titleEn"]        : $record->titleEn;
        $record->descriptionAr  = isset($params["descriptionAr"])? $params["descriptionAr"]  : $record->descriptionAr;
        $record->descriptionEn  = isset($params["descriptionEn"])? $params["descriptionEn"]  : $record->descriptionEn;
        $record->date           = isset($params["date"])         ? $params["date"]           : $record->date;
        $record->noOfDays       = isset($params["noOfDays"])     ? $params["noOfDays"]       : $record->noOfDays;
        $record->image          = isset($params["image"])        ? helper::base64_image( $params["image"],'horoscopes'): $record->image;
        $record->save();
        
        return $record;
    }
}