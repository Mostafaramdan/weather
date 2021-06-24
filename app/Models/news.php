<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class news extends GeneralModel
{
    protected $table = 'news',$appends=["countryName","periodicName",'views','notify_count'];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->titleAr = isset($params["titleAr"])? $params["titleAr"]: $record->titleAr;
        $record->titleEn = isset($params["titleEn"])? $params["titleEn"]: $record->titleAr;
        $record->contentAr = isset($params["contentAr"])? $params["contentAr"]: $record->contentAr;
        $record->contentEn = isset($params["contentEn"])? $params["contentEn"]: $record->contentEn;
        $record->periodic = isset($params["periodic"])? $params["periodic"]: $record->periodic;
        $record->countries_id = isset($params["countries_id"])? $params["countries_id"]: $record->countries_id;
        $record->admins_id = \Auth::guard('dashboard')->user()->id;
        $record->image = isset($params["image"])?helper::base64_image( $params["image"],'news'): $record->image;
        $record->video = isset($params["video"])?helper::base64_video( $params["video"],'news'): $record->video;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function admin(){
        return $this->belongsTo(admins::class,"admins_id");
    }
    public function notify(){
        return $this->hasMany(notify::class);
    }
    public function country(){
        return $this->belongsTo(countries::class,"countries_id");
    }
    function GetCountryNameAttribute(){
        return $this->country->name??"";
    }
    function GetPeriodicNameAttribute(){
        return $this->periodic=="daily"? "يومي": "اسبوعي";
    }
    function GetViewsAttribute(){
        return views::where('news_id',$this->id)->count();
    }
    function GetNotifyCountAttribute(){
        return notify::where('news_id',$this->id)->count();
    }
}