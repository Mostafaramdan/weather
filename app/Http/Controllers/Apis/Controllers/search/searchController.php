<?php

namespace App\Http\Controllers\Apis\Controllers\search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\products;
use App\Models\stores;
use Illuminate\Support\Str;

class searchController extends index
{
    public static $model;
    public static function api()
    {
        $search= self::$request->search;
        if(self::$request->type){
            $model= "App\Models\\".Str::plural(self::$request->type);
            $records=  $model::allActive();
            if(self::$request->search){
                $records= $records->filter(function($item) use ($search) {
                    if( stripos($item['nameAr'],$search) !== false ||  stripos($item['nameEn'],$search) !== false||  stripos($item['name'],$search) !== false)
                        return true;
                    return false;
                });
            }
            
            return [
                "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
                "totalPages"=>ceil($records->count()/self::$itemPerPage),
                Str::plural(self::$request->type)=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),self::$request->type),
            ];        
            
        }else{
            $products=  products::allActive();
            if(self::$request->search){
                $products= $products->filter(function($item) use ($search) {
                    if( stripos($item['nameAr'],$search) !== false ||  stripos($item['nameEn'],$search) !== false)
                        return true;
                    return false;
                });
            }
            $stores=  stores::all();
            if(self::$request->search){
                $stores= $stores->filter(function($item) use ($search) {
                    if( stripos($item['name'],$search) !== false )
                        return true;
                    return false;
                });
            }
            $productsStatus= $products->forPage(self::$request->page+1,$stores?self::$itemPerPage:self::$itemPerPage/2)->count()?1:0;
            $storesStatus= $products->forPage(self::$request->page+1,$products?self::$itemPerPage:self::$itemPerPage/2)->count()?1:0;
            return [
                "status"=>$productsStatus+$storesStatus>0?200:204,
                "totalPages"=>ceil(($products->count()+$stores->count())/self::$itemPerPage),
                "products"=>objects::ArrayOfObjects($products->forPage(self::$request->page+1,self::$itemPerPage),"product"),
                "stores"=>objects::ArrayOfObjects($stores->forPage(self::$request->page+1,self::$itemPerPage),"store"),
            ];        

        }
                    

    }
}

