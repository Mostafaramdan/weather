<?php

namespace App\Models;
use App\Http\Controllers\Apis\Controllers\index;
use Illuminate\Database\Eloquent\Model;

class notify extends GeneralModel
{
    protected $table = 'notify',
    $appends=["target_user"];
   
    public static function createUpdate($params){

        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->notifications_id = isset($params['notifications_id'])? $params['notifications_id']: $record->notifications_id;
        $record->isSeen = isset($params['isSeen'])? $params['isSeen']: $record->isSeen;
        $record->users_id = isset($params['users_id']) ? $params['users_id']: $record->users_id;
        $record->warnings_id = isset($params['warnings_id']) ? $params['warnings_id']: $record->warnings_id;
        $record->news_id = isset($params['news_id']) ? $params['news_id']: $record->news_id;
        $record->visitors_id = isset($params['visitors_id']) ? $params['visitors_id']: $record->visitors_id;
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }

    public function notification (){
        return $this->belongsTo(notifications::class,'notifications_id');
    }
    public function news (){
        return $this->belongsTo(news::class,'news_id');
    }
    public function warning (){
        return $this->belongsTo(warnings::class,'warnings_id');
    }

    public function user (){
        return $this->belongsTo(users::class,'users_id');
    }
    public function visitor (){
        return $this->belongsTo(visitors::class,'visitors_id');
    }
    function GetTargetUserAttribute(){
        if ($this->user)
            return $this->user;
        else
            return $this->visitor;

    }
}