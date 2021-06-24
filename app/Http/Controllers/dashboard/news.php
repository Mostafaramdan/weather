<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\news as model;
use App\Models\users;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\visitors;
use App\Models\notify;
use App\Models\notifications;
use  App\Jobs\pushNotificationToAllAfterNews;

class news extends Controller
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
        return view('dashboard.news.index',compact("records","totalPages",'currentPage'));
    }   
    
    public static function indexPageing(Request $request)
    {
      $sort=$request->sortType??'sortByDesc';
      $records= self::$model::all()->$sort($request->sortBy??"id",);    
      if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    return stripos($item['name'],$search) !== false;
                });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage;
        $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.news.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }
    
    public static function createUpdate(Request $request)
    {
        // if($request->sendNotification){
        //     return 'yes';
        // }else{
        //     return 'no';
        // }
        // dd();
        $rules=[
            "titleAr"     =>"required|min:3",
            // "titleEn"     =>"required|min:3",
            "contentAr"   =>"required_if:id,|nullable|min:3",
            // "contentEn"   =>"required|min:3",
            'image'       =>"nullable",
            "video"       =>"nullable",
        ];
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "titleAr.required"     =>"يجب ادخال عنوان الخبر بالعربي وا بالانجليزي",
            "titleAr.min"          =>"يجب ان لا يقل عنوان الخبر عن 3 حروف ",

            "titleEn.required"     =>"يجب ادخال عنوان الخبر بالعربي وا بالانجليزي",
            "titleEn.min"          =>"يجب ان لا يقل عنوان الخبر عن 3 حروف ",
    
            "contentAr.required"   =>"يجب ادخال محتوي الخبر بالعربي وا بالانجليزي",
            "contentAr.min"        =>"يجب ان لا يقل محتوي الخبر عن 3 حروف ",

            "contentEn.required"   =>"يجب ادخال عنوان الخبر بالعربي وا بالانجليزي",
            "contentEn.min"        =>"يجب ان لا يقل عنوان الخبر عن 3 حروف ",
    
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $news= self::$model::createUpdate([
            "id"    =>$request->id,
            'titleAr'=>$request->titleAr,
            'titleEn'=>$request->titleEn,
            'contentAr'=>$request->contentAr,
            'contentEn'=>$request->contentEn,
            'image'=>$request->image,  
            'video'=>$request->video,  
            'periodic'=>$request->periodic,  
            'countries_id'=>$request->countries_id,  
        ]);
        if($request->sendNotification){
            $record= new notifications();
            $record->contentAr= str_replace("&nbsp;", ' ',  strip_tags(htmlspecialchars_decode($news->titleAr)) ) ;
            $record->contentEn= str_replace("&nbsp;", ' ',  strip_tags(htmlspecialchars_decode($news->titleAr)) ) ;
            $record->createdAt=date("Y-m-d H:i:s");
            $record->save();
            if(!$request->id){
                notify::where('news_id',$record->id)->delete();
            }
            pushNotificationToAllAfterNews::dispatch($record,$news);
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

