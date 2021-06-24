<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\warnings as model;
use App\Models\notifications;
use App\Models\notify;
use App\Models\users;
use App\Models\visitors;
use  App\Jobs\pushNotificationToAllAfterWarnings;

class warnings extends Controller
  {
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index(Request $request)
    {
        $records= self::$model::all()->sortByDesc('id');
        if($request->id){
            $records= $records->where('id',$request->id);
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.warnings.index',compact("records","totalPages",'currentPage'));
    }   
    
    public static function indexPageing(Request $request)
    {
      $sort=$request->sortType??'sortByDesc';
      $records= self::$model::all()->$sort($request->sortBy??"id",);    
      if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    return stripos($item['contentAr'],$search) !== false;
                });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage??1;
        $records=$records->forpage($currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.warnings.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }
    
    public static function createUpdate(Request $request){
        $rules=[
            "contentAr"     =>"required|min:3",
            // "contentEn"     =>"required|min:3",
            "startDate"     =>"required",
            "endDate"      =>"required"
        ];
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "contentAr.required"   =>"يجب ادخال المحتوي بالعربي وبالانجليزية",
            "contentAr.min"        =>"يجب ان لا يقل المحتوي  عن 3 حروف ",
            
            "contentEn.required"   =>"يجب ادخال المحتوي بالعربي وبالانجليزية",
            "contentEn.min"        =>"يجب ان لا يقل المحتوي  عن 3 حروف ",
            
            "startDate"           =>"يجب ادخال تاريخ البداية",
            
            "endDate"           =>"يجب ادخال تاريخ النهاية",
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $warning= self::$model::createUpdate([
            "id"    =>$request->id,
            'contentAr'=>$request->contentAr,
            'contentEn'=>$request->contentEn,
            'startDate'=>$request->startDate,
            'endDate'=>$request->endDate,
        ]);
        if($request->sendNotification){

            $record= new notifications();
            $record->contentAr= str_replace("&nbsp;", ' ',  strip_tags(htmlspecialchars_decode($warning->contentAr)) ) ;
            $record->contentEn=$request->contentEn;
            $record->createdAt=date("Y-m-d H:i:s");
            $record->save();
            if(!$request->id){
                notify::where('warnings_id',$record->id)->delete();
            }
            pushNotificationToAllAfterWarnings::dispatch($record,$warning);
        }

        $message=$request->id?"edited successfully":'added successfully';
        
        return response()->json(['status'=>200,'message'=>$message]);
    }
    
    public static function getRecord($id)
    {
        return  self::$model::findOrFail($id);
    }
    public static function check($type, $id)
    {
        $record= self::$model::find($id);
        if($record->$type){
            $action="false";
            $record->$type=0;
        }else{
            $action="true";
            $record->$type=1;
        }
        $record->save();
        return response()->json(['status',200,'action'=>$action]);
    }
    public static function delete($id)
    {
        $record= self::$model::find($id);
        $record->delete();
        return response()->json(['status'=>200]);
    }
  }

