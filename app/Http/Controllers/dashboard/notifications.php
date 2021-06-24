<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\notifications as model;
use App\Models\notify  ;
use App\Models\users  ;
use App\Models\visitors1 as visitors;
use Illuminate\Support\Str;
use  App\Jobs\pushNotificationToAll ;

class notifications extends Controller
{
public static $model;
function __construct(Request $request)
{
    self::$model=model::class;
}
public static function index()
{
    $records= self::$model::all()->sortByDesc('id');
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= 1;
    $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
    return view('dashboard.notifications.index',compact("records","totalPages",'currentPage'));
}   

public static function indexPageing(Request $request)
{
    $records= self::$model::orderBy($request->sortBy??"id",$request->sortType??'asc')->get();
    if($request->search){
        $search= $request->search;
        $records= $records->filter(function($item) use ($search) {
                return stripos($item['content'],$search) !== false;
            });
    }
    $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
    $currentPage= $request->currentPage;
    $records=$records->forpage($request->currentPage??1,config('helperDashboard.itemPerPage'));
    $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
    $tableInfo= (string) view('dashboard.notifications.tableInfo',compact('records'));
    return ['paging'=>$paging,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){
    $rules=[
        "contentAr"     =>"required|min:3",
        // "contentEn"     =>"required|min:3",
    ];

    $messages=[
    ];

    $messagesAr=[

        "contentAr.required"     =>"يجب ادخال المحتوي بالعربي",
        "contentAr.min"          =>"يجب ان لا يقل المحتوي بالعربي عن 3 حروف ",

        "contentEn.required"     =>"يجب ادخال المحتوي بالانجليزي",
        "contentEn.min"          =>"يجب ان لا يقل المحتوي بالانجليزي عن 3 حروف ",
    ];

    $messagesEn=[
        
    ];
    $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
    $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
    if ($Validation !== null) {    return $Validation;    }    
    
    //create Notification 
    $record=self::$model::createUpdate([ 
        'id'=>$request->id,
        'contentAr'=>$request->contentAr,
        'contentEn'=>$request->contentEn,
        ]);
    if($request->id){
        notify::where('notifications_id',$record->id)->delete();
    }
    pushNotificationToAll::dispatch($record,$request->checkType,'visitors');

    $message=$request->id?"edited successfully":'added successfully';
    
    return response()->json(['status'=>200,'message'=>$message]);
}

public static function getRecord($id)
{
    return  self::$model::find($id);
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

