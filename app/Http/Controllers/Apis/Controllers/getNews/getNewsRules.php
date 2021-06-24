<?php
namespace App\Http\Controllers\Apis\Controllers\getNews;

use App\Http\Controllers\Apis\Controllers\index;
use App\Http\Controllers\Apis\Resources\objects;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Apis\Helper\helper;

class getNewsRules extends index
{
    public static function rules (){
        
        $rules=[
            "countryId"  =>"exists:countries,id",
            "periodic"=>"required|in:daily,weakly",
            "page"      =>"required|numeric",
        ];

        $messages=[
            "countryId.exists"      =>405,
            "page.required"         =>400,
            "page.numeric"          =>405,
            "periodic.required"     =>400,
            "periodic.in"           =>405
        ];

        $messagesAr=[   
            "countryId.exists"         =>"رقم الدولة غير موجود",
            "page.required"         =>"يجب ادخال رقم الصفحة",
            "page.numeric"          =>"يجب ادخال رقم الصفحة بشكل صحيح",
            "periodic.required"     =>"يجب ادخال نوع الاخبار سواة كانت يومية او اسبوعية ",
            "periodic.in"           =>"برجاء التاكد من النوع المدخل سواة يومي او اسبوعي"
        ];

        $messagesEn=[
        ];
        $ValidationFunction=self::$request->showAllErrors==1?"showAllErrors":"Validator";
        $Validation = helper::{$ValidationFunction}(self::$request->all(), $rules, $messages,self::$lang=="Ar"?$messagesAr:$messagesEn);
        if ($Validation !== null) {    return $Validation;    }

        // return helper::validateAccount()??null;
    }
}
