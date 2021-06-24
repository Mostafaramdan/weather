<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

    class admins extends Authenticatable
{
    protected $table = 'admins';
    use Notifiable;
    public $timestamps=false;
    public static function createUpdate($params){

      $record= isset($params["id"])? self::find($params["id"]) :new self();
      $record->name = isset($params["name"])? $params["name"]: $record->name;
      $record->email = isset($params["email"])? $params["email"]: $record->email;
      $record->permissions = isset($params["permissions"])? $params["permissions"]: $record->permissions;
      $record->isSuperAdmin = $params["isSuperAdmin"];
      $record->password = isset($params['password'])?helper::HashPassword( $params['password']): $record->password;
      isset($params["id"])?:$record->createdAt = date("Y-m-d H:i:s");
      $record->save();
      return $record;
  }
   
    public function setAttribute($key, $value)
    {
        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
        if (!$isRememberTokenAttribute)
        {
        parent::setAttribute($key, $value);
        }
    }

}
