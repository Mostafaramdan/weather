<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ads extends GeneralModel
{
    protected $table = 'ads', $appends=['screenAr',"itemScreen","actionAr","itemAction"];

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->titleAr = isset($params["titleAr"])? $params["titleAr"]: $record->titleAr;
        $record->titleEn = isset($params["titleEn"])? $params["titleEn"]: $record->titleEn;
        $record->startAt = isset($params["startAt"])? $params["startAt"]: $record->startAt;
        $record->endAt = isset($params["endAt"])? $params["endAt"]: $record->endAt;
        $record->screen = isset($params["screen"])? $params["screen"]: $record->screen;
        $record->link = isset($params["link"])? $params["link"]: $record->link;
        $record->action_stores_id = isset($params["action_stores_id"])? $params["action_stores_id"]: $record->action_stores_id;
        $record->action_products_id = isset($params["action_products_id"])? $params["action_products_id"]: $record->action_products_id;
        $record->action_categories_id = isset($params["action_categories_id"])? $params["action_categories_id"]: $record->action_categories_id;
        $record->image =isset($params['image'])?helper::uploadPhoto( $params['image'],'ads'): $record->image;
        $record->video =isset($params['video'])?helper::uploadPhoto( $params['video'],'ads'): $record->video;
        $record->deletedAt = isset($params["deletedAt"])? date("Y-m-d H:i:s"):null;
        isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function product()
    {
        return $this->belongsTo(products::class, 'products_id');
    }
    public function store()
    {
        return $this->belongsTo(stores::class, 'stores_id');
    }
    public function category()
    {
        return $this->belongsTo(categories::class, 'categories_id');
    }
    public function actionProduct()
    {
        return $this->belongsTo(products::class, 'action_products_id');
    }
    public function actionStore()
    {
        return $this->belongsTo(stores::class, 'action_stores_id');
    }
    public function actionCategory()
    {
        return $this->belongsTo(categories::class, 'action_categories_id');
    }
    public function offer()
    {
        return $this->belongsTo(offers::class, 'offers_id');
    }
    function GetScreenArAttribute()
    {
        $screen=[
            "welcome"=>"الشاشة الرئيسية",
            "offer"=>"شاشة العروض",
            "categories"=>"شاشة الاقسام",
            "stores"  =>"شاشة المتاجر"
        ];
        return $screen[$this->screen];
    }
    function GetItemScreenAttribute()
    {
        if($this->categories_id){
            return $this->category->nameAr;
        }
        if($this->stores_id){
            return $this->store->name;
        }
        else 
            return null;
    }
    function GetActionArAttribute()
    {
        $action=[
            "link"=>"مصدر خارجي ",
            "products"=>"شاشة منتج",
            "categories"=>"شاشة قسم فرعي",
            "stores"  =>"شاشة متجر"
        ];
        return $action[$this->action];
    }
    function GetItemActionAttribute()
    {
        if($this->action_categories_id){
            return $this->actionCategory->nameAr;
        }
        if($this->action_stores_id){
            return $this->actionStore->name;
        }
        if($this->action_products_id){
            return $this->actionProduct->nameAr;
        }
        else 
            return $this->link;
    }
}
