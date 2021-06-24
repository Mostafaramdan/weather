<?php
namespace App\Http\Controllers\Apis\Controllers\newVisitor;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class newVisitorRules extends index
{
    public static function rules (){
        
        $rules=[
            "fireBaseToken"   =>"required",
            "deviceId"   =>"required",

        ];

        $messages=[
            "fireBaseToken.required"     =>400,
            "fireBaseToken.exists"       =>405,

            "deviceId.required"     =>400,
        ];

        $messagesAr=[   
            "fireBaseToken.required"     =>"يجب ادخال الفيربيز توكن",
            "fireBaseToken.exists"       =>"فير بيز توكن غير موجود",

            "deviceId.required"     =>"يجب ادخال رقم الجهاز",
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        return helper::validateAccount()??null;
    }
}
