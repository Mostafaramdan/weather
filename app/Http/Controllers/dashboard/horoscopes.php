<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\horoscopes as model;

class horoscopes extends Controller
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
        return view('dashboard.horoscopes.index',compact("records","totalPages",'currentPage'));
    }   
    
    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);   
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    if( stripos($item['nameAr'],$search) !== false ||  stripos($item['nameEn'],$search) !== false)
                        return true;
                    return false;
                });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage>0?$request->currentPage:1;
        $records=$records->forpage($currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.horoscopes.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }
    
    public static function createUpdate(Request $request){
        $rules=[
            "nameAr"        =>"required|min:3",
            "titleAr"     =>"required|min:3",
            // "titleEn"     =>"required|min:3",
            // "nameEn"        =>"required|min:3",
            "descriptionAr" =>"required|min:3",
            // "descriptionEn" =>"required|min:3",
            "noOfDays"      =>"required|min:3",
            "date"          =>"required",
            "noOfDays"     =>"required"
        ];
    
        $messages=[
        ];
    
        $messagesAr=[
    
            "nameAr.required"     =>"يجب ادخال الاسم بالعربي و بالانجليزية",
            "nameAr.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",
    
            "nameEn.required"     =>"يجب ادخال الاسم بالعربي و بالانجليزية",
            "nameEn.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",
    
            "titleAr.required"     =>"يجب ادخال العنوان  بالعربي وبالانجليزية",
            "titleAr.min"          =>"يجب ان لا يقل العنوان عن 3 حروف ",

            "titleEn.required"     =>"يجب ادخال عنوان الخبر بالعربي وا بالانجليزي",
            "titleEn.min"          =>"يجب ان لا يقل عنوان الخبر عن 3 حروف ",
    
            "descriptionAr.required"     =>"يجب ادخال الوصف  بالعربي وا بالانجليزي",
            "descriptionAr.min"          =>"يجب ان لا يقل الوصف عن 3 حروف ",

            "descriptionEn.required"     =>"يجب ادخال الوصف  بالعربي وا بالانجليزي",
            "descriptionEn.min"          =>"يجب ان لا يقل الوصف عن 3 حروف ",
    
            "date"                      =>"يجب إدخال التاريخ",

            "noOfDays"                  =>"يجب إدخال عدد الايام",
        ];
    
        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,'en'?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }    
        $record= self::$model::createUpdate([
            "id"    =>$request->id,
            'nameAr'=>$request->nameAr,
            'nameEn'=>$request->nameEn,
            'titleAr'=>$request->titleAr,
            'titleEn'=>$request->titleEn,
            'descriptionAr'=>$request->descriptionAr,
            'descriptionEn'=>$request->descriptionEn,
            'date'=>$request->date,
            'noOfDays'=>$request->noOfDays,
            "image"=>$request->image
        ]);
    
        $message=$request->id?"edited successfully":'added successfully';
        
        return response()->json(['status'=>200,'message'=>$message,'record'=>$record]);
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

