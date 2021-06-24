<?php
namespace App\Models;

use App\Models\friends;
use App\Models\followers;
use App\Models\roles;
use App\Models\verified_request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\Apis\Controllers\index;
use Carbon\Carbon;
use App\Http\Controllers\Apis\Helper\helper ;
use Illuminate\Support\Str;
use App\Models\locations;
 
class users extends GeneralModel
{
    protected $table = 'users',$appends=['session'];

    public static function createUpdate($params){
        $record= isset($params['id'])? self::find($params['id']) :new self();
        $record->name =isset($params['name'])?$params['name']: $record->name;
        $record->image =isset($params['image'])?helper::base64_image( $params['image'],'users'): $record->image;
        $record->apiToken = isset($params['id'])?$record->apiToken: helper::UniqueRandomXChar(69,'apiToken');
        $record->phone =isset($params['phone'])?$params['phone']: $record->phone;
        $record->email =isset($params['email'])?$params['email']: $record->email;
        $record->password = isset($params['password'])?helper::HashPassword( $params['password']): $record->password;
        $record->firebaseToken =isset($params['firebaseToken'])?$params['firebaseToken']: $record->firebaseToken;
        $record->language =isset($params['language'])?$params['language']: $record->language??"Ar";
        isset($params['id'])?:$record->createdAt = date("Y-m-d H:i:s");
        $record->save();
        return $record;
    }
    public function sessions(){
        return $this->hasMany('\App\Models\sessions','users_id');
    }
    function GetSessionAttribute(){
        return $this->sessions->first()??null;
    }
}