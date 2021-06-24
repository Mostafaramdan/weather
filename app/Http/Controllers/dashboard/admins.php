<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\admins as model;
use Auth;
use Illuminate\Support\Arr;

class admins extends Controller
{
    public static $model;
    function __construct(Request $request)
    {
        self::$model=model::class;
    }
    public static function index()
    {
        $records= self::$model::all();
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= 1;
        $records=$records->forpage(1,config('helperDashboard.itemPerPage'));
        return view('dashboard.admins.index',compact("records","totalPages",'currentPage'));
    }   

    public static function indexPageing(Request $request)
    {
        $sort=$request->sortType??'sortBy';
        $records= self::$model::all()->$sort($request->sortBy??"id",);  
        if($request->search){
            $search= $request->search;
            $records= $records->filter(function($item) use ($search) {
                if( stripos($item['name'],$search) !== false  || stripos($item['email'],$search) !== false )
                    return true;
                return false;
            });
        }
        $totalPages= ceil($records->count()/config('helperDashboard.itemPerPage'));
        $currentPage= $request->currentPage;
        $records=$records->forpage($request->currentPage,config('helperDashboard.itemPerPage'));
        $paging= (string) view('dashboard.layouts.paging',compact('totalPages','currentPage'));
        $tableInfo= (string) view('dashboard.admins.tableInfo',compact('records'));
        return ['paging'=>$paging,'tableInfo'=>$tableInfo];
    }

    public static function createUpdate(Request $request){

        $rules=[
            "name"     =>"required|min:3",
            "email"    =>"required|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:admins,email,".$request->id,
            "password" =>"nullable|required_if:id,|min:6|confirmed",
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

            "password.required_if" =>"يجب ادخال الرقم السري",
            "password.confirmed" =>"الرقم السري غير متطابق",
            "password.min"      =>"يجب ان لا يقل الرقم السري عن 6 ارقام او حروف",

        ];

        $messagesEn=[
            
        ];

        $ValidationFunction=$request->showAllErrors==1?'showAllErrors':'Validator';
        $Validation = helper::{$ValidationFunction}($request->all(), $rules, $messages,$messagesAr);
        if ($Validation !== null) {    return $Validation;    }  
        $configPermissions =  config('helperDashboard.permission');
        $permission=[];
        foreach($configPermissions as $key => $value){
            $permission[$key] = [
                "view" => $request->has($key."_view")?1:0,
                "add" => $request->has($key."_add")?1:0,
                "edit" => $request->has($key."_edit")?1:0,
                "delete" => $request->has($key."_delete")?1:0,
            ];
        }
        $record= self::$model::createUpdate([
            'id'=>$request->id,
            'name'=>$request->name,
            'isSuperAdmin'=>$request->isSuperAdmin===null ? 0:1,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>$request->password,
            'permissions'=>json_encode($permission),
            'image'=>$request->image,  
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
            if(!$record->permissions){
                $record->permissions='{"statistics":{"view":1,"add":0,"edit":0,"delete":0},"users":{"view":1,"add":1,"edit":1,"delete":1},"notifications":{"view":1,"add":1,"edit":1,"delete":1},"contacts":{"view":1,"add":0,"edit":0,"delete":1},"price_list":{"view":1,"add":1,"edit":1,"delete":1},"categories":{"view":1,"add":1,"edit":1,"delete":1},"stores":{"view":1,"add":1,"edit":1,"delete":1},"regions":{"view":1,"add":1,"edit":1,"delete":1},"ads":{"view":1,"add":1,"edit":1,"delete":1},"codes":{"view":1,"add":1,"edit":1,"delete":1},"recharges":{"view":1,"add":1,"edit":1,"delete":1},"send_to_my_emails":{"view":1,"add":1,"edit":1,"delete":1},"withdraw_requests":{"view":1,"add":1,"edit":1,"delete":1},"bank_accounts":{"view":1,"add":1,"edit":1,"delete":1},"orders":{"view":1,"add":1,"edit":1,"delete":1},"vehicles":{"view":1,"add":1,"edit":1,"delete":1},"admins":{"view":0,"add":0,"edit":0,"delete":0},"appInfo":{"view":1,"add":0,"edit":1,"delete":0}}';
            }
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

