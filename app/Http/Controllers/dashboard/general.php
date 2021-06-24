<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\categories;

class general extends Controller
{
    public static function categoriesByStore($storeId)
    {
        $records= categories::where("stores_id",$storeId)->get();
        return view('dashboard.products.categoriesByStore',compact('records'));
    }   
    
    public static function searchFor ($model, $col,$search="")
    {
        $model = "\App\Models\\".$model;
        $records= $model::all()->where("isActive",1);   
        $records= $records->filter(function($item) use ($search) {
                if( 
                    stripos(isset($item['name'])   ?$item['name']:".",$search)        !== false || 
                    stripos(isset($item['nameAr']) ?$item['nameAr']:".",$search)      !== false || 
                    stripos(isset($item['nameEn']) ?$item['nameEn']:".",$search)      !== false || 
                    stripos(isset($item['title'])  ?$item['title']:".",$search)       !== false || 
                    stripos(isset($item['titleAr'])?$item['titleAr']:".",$search)     !== false || 
                    stripos(isset($item['titleEn'])?$item['titleEn']:".",$search)     !== false || 
                    stripos(isset($item['phone'])  ?$item['phone']:".",$search) !== false || 
                    stripos(isset($item['email'])  ?$item['email']:".",$search) !== false 
                ) 
                return true;
            return false;
            });
        $records=$records->forPage(1,100);
        return view('dashboard.layouts.searchFor',compact('records','col'));
        
    }
}