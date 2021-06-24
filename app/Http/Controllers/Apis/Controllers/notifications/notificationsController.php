<?php

namespace App\Http\Controllers\Apis\Controllers\notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper ;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\notify;
use App\Models\visitors;

class notificationsController extends index
{
    public static function api()
    {
        // if(self::$request->fireBaseToken){
            $visitor = visitors::where('fireBaseToken',self::$request->fireBaseToken)->first();
            $records = notify::orderBy('id','DESC')
                            ->where('visitors_id',$visitor->id)
                            ->forPage(self::$request->page+1,self::$itemPerPage)
                            ->get();
        // }
        foreach($records as $record)
           notify::createUpdate([
                'id'=>$record->id,
                'isSeen'=>1
            ]);
        // return objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"notification");
        return [
            "status"=>$records->forPage(self::$request->page+1,self::$itemPerPage)->count()?200:204,
            "totalPages"=>ceil($records->count()/self::$itemPerPage),
            "notifications"=>objects::ArrayOfObjects($records->forPage(self::$request->page+1,self::$itemPerPage),"notification"),
        ];
                    

    }
}

