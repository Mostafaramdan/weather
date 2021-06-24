<?php
namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\appInfo as model;
use App\Models\emails;
use App\Models\phones;

class appInfo extends Controller
{
public static $model;
function __construct(Request $request)
{
    self::$model=model::class;
}
public static function index()
{
    $record= self::$model::first();
    if(!$record){
        $record =
            self::$model::createUpdate([
                "aboutUsAr"=>"@mail.com",
                "aboutUsEn"=>" . ",
                "policyAr"=>" .",
                "policyEn"=>5,
                "fax"=>5,
                "address"=>5,
                "facebook"=>"facebook.com",
                "twitter"=>"twitter.com",
                "snapshat"=>"snapshat.com",
            ]);
    }
    return view('dashboard.appInfo.index',compact("record"));
}   

public static function indexPageing(Request $request)
{
    $record= self::$model::first();
    $tableInfo= (string) view('dashboard.appInfo.tableInfo',compact('record'));
    return ['paging'=>0,'tableInfo'=>$tableInfo];
}

public static function createUpdate(Request $request){

    $record= self::$model::first();
    self::$model::createUpdate([
        'id'        =>$record->id,
        "aboutUsAr"   =>$request->aboutUsAr,
        "aboutUsEn"   =>$request->aboutUsEn,
        "policyAr"  =>$request->policyAr,
        "policyEn"  =>$request->policyEn,
        "fax"=>$request->fax,
        "address"=>$request->address,
        "fees"      =>$request->fees,
        "facebook"      =>$request->facebook,
        "twitter"=>$request->twitter,
        "snapshat"=>$request->snapshat
    ]);
    if($request->phones){
        phones::where('appInfo_id',$record->id)->delete();
        foreach(explode(",",$request->phones) as $phone){
            phones::createUpdate([
                "phone"=>$phone,
                "appInfo_id"=>$record->id
            ]);
        }
    }
    if($request->emails){
        emails::where('appInfo_id',$record->id)->delete();
        foreach(explode(",",$request->emails) as $email){
            emails::createUpdate([
                "email"=>$email,
                "appInfo_id"=>$record->id
            ]);
        }
    }

    

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

