<?php
namespace App\Http\Controllers\Apis\Resources;

use App\Http\Controllers\Apis\Helper\helper ;
use  App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Controller;
use App\Models\phones;
use App\Models\emails;
use App\Models\views;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\appInfo;

class objects extends index
{
    public static function account ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['apiToken'] = $record->apiToken;
        $object['name'] = $record->name;
        $object['phone'] = Str::replaceFirst('00', '+', $record->phone);
        $object['email'] = $record->email;
        $object['type'] =Str::singular($record->getTable());
        $object[Str::singular($record->getTable())] =self::{Str::singular($record->getTable())}($record);
        return $object;
    } 

    public static function user ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id'] = $record->id;
        $object['name'] = $record->name;
        $object['phone'] = Str::replaceFirst('00', '+', $record->phone);
        $record->image==null?:$object['image'] =request()->root() . $record->image;   
        return $object;
    } 

    public static function notification  ($record)
    {
        // this object take record from notify table ;
        if($record == null  || $record->notification == null) {return null;}
        $object['id'] = $record->id;
        $object['content'] = $record->notification->contentAr;
        $object['isSeen'] = $record->isSeen == 1 ? true : false ;
        $object['createdAt'] = Carbon::parse($record->createdAt)->timestamp;
        return $object;
    }


    public static function news  ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['periodic']=$record->periodic;
        $object['countryName']=$record->country->name??"";
        $object['title']=$record['titleAr'];
        $object['content']=$record['contentAr'];
        $record->image==null?:$object['image'] =request()->root() . $record->image;   
        $record->video==null?:$object['video'] =request()->root() . $record->video;   
        $record->admin==null?:$object['publisher'] = $record->admin->name;   
        $object['views']=(int)$record->views;
        $object['createdAt'] = Carbon::parse($record->createdAt)->timestamp;
        return $object;
    }    

    public static function warning  ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['content']=$record['contentAr'];
        $object['startDate']=$record->startDate;
        $object['endDate']=$record->endDate;
        $object['createdDate']= Carbon::parse($record->createdAt)->timestamp;
        return $object;
    }    
    
    public static function horoscope  ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['name']=$record['name'.self::$lang];
        $object['title']=$record['title'.self::$lang];
        $object['description']=$record['description'.self::$lang];
        $object['noOfDays']=$record->noOfDays;
        $object['date']=$record->date;
        $record->image==null?:$object['image'] =request()->root() . $record->image;   
        return $object;
    }    
    public static function country  ($record)
    {
        if($record == null  ) {return null;} 
        $object = [];
        $object['id']=$record->id;
        $object['name']=$record['name'.self::$lang];
        $object['alpha2']=$record->alpha2;
        // $object['alpha3']=$record->alpha3;
        // $object['numeric']=$record->numeric;
        // $object['currency']=$record->currencies->pluck("name")->toArray();
        return $object;
    }    

    public static function appInfo ($record)
    {
        
        if($record == null) {return null;}
        $object = [];
        $object['email']   =$record->emails->pluck('email')->toArray();
        $object['phones']   =$record->phones->pluck('phone')->toArray();
        $object['fax'] = $record->fax;
        $object['aboutUs']=$record['aboutUs'.self::$lang];
        $object['policy']=$record['policy'.self::$lang];
        $object['address'] = $record->address;
        $object['facebook'] = $record->facebook;
        $object['twitter'] = $record->twitter;
        $object['snapshot'] = $record->snapshat;
        return $object;
    }

    public static function ArrayOfObjects ($Items, $objectname) 
    { 

        if(count($Items)==0) return $Items;
        
        $Array = [];
        foreach ($Items as $Item) {
             $Array[] = self::$objectname($Item);
        }
        $final_Array=[];
        
        foreach($Array as $A)
           if($A==null)
                continue;
           else
                array_push($final_Array,$A);
        return $final_Array;
    } 
}
