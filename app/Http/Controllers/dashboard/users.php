<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Apis\Helper\helper ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\users as user;
use App\Models\roles ;
use App\Models\logs ;
use Auth;

class users extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=user::class;
    }

    public static function index()
    {
        $records=  self::$model::all()->map(function ($item, $key) {
                    return $item->only(['id','name','phone','email','createdAt','isActive']) ;
                });
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.users.index',compact('records','totalPages','currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $records= self::$model::orderBy($request->sortBy??"id",$request->sortType??'asc')->get()->each->setAppends(['region_name']);
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                    if( stripos($item['name'],$search) !== false || stripos($item['phone'],$search)!== false || stripos($item['email'],$search) !== false  )
                    return true;
                });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage;
        $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.users.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request){
        
        $rules=[
            "name"      =>"required|min:3",
            "email"     =>"nullable|required_if:phone,|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email,".$request->id,
            "phone"     =>"nullable|bail|required_if:email,|numeric|between:1000000000,99999999999999999999|unique:users,phone,".$request->id,
            "password"  =>"required_if:id,|nullable|min:6",
        ];

        $messages=[
        ];

        $messagesAr=[

            "name.required"     =>"يجب ادخال الاسم",
            "name.min"          =>"يجب ان لا يقل الاسم عن 3 حروف ",

            "email.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتوني",
            "email.regex"       =>"يجب ادخال البريد الالكتروني بشكل صحيح",
            "email.min"         =>"يجب ان لا يقل البريد الالكتروني عن 5 حروف ",
            "email.unique"      =>"هذا البريد مسجل مسبقا",

            "phone.required_if" =>"يجب ادخال رقم التليفون او البريد الالكتروني",
            "phone.nemeric"     =>"يجب ادخال رقم التليفون بشكل صحيح ",
            "phone.between"     =>"يجب ان لا يقل رقم التليفون عن 11 ارقام ولا يزيد عن 15 رقم ",
            "phone.unique"      =>"هذا الهاتف مسجل مسبقا",
            
            "password.required_if" =>"يجب ادخال الرقم السري",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",
        ]; 

        $messagesEn=[
            
        ];
        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }   
        if($request->has('image') && $request->id){
            helper::deleteFile(self::$model::find($request->id)->image);
        }
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>$request->password??null,
            'image'=>$request->image,  
        ]);
        $message=$request->id?"تم التعديل بنجاح":'تم الحفظ بنجاح';
        
        return response()->json(['status'=>200,'message'=>$message]);
    }

    public static function getRecord($id)
    {
       return  self::$model::find($id);
    }
    public static function check($type,$id)
    {
        $record= self::$model::find($id);
        if($record->$type){
            $action="true";
            $record->$type=0;
        }else{
            $action="false";
            $record->$type=1;
        }
        $record->save();
        return response()->json(['status',200,'action'=>$action]);
    }
    public static function delete($id)
    {
        $record= self::$model::find($id);
        helper::deleteFile($record->image);
        $record->delete();
        return response()->json(['status'=>200]);
    }
    public static function getLogs($id)
    {
        $records = logs::where('users_id',$id)->orderBy("id",'DESC')->get();
        $currentBalance= self::$model::find($id)->balance;
        return view('dashboard.users.balanceTableInfo',compact('records','currentBalance'));
    }
}
