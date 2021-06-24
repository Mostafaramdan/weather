<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Apis\Helper\helper ;

class currencies extends GeneralModel
{
    protected $table = 'currencies';

    public static function createUpdate($params){

        $record= isset($params["id"])? self::find($params["id"]) :new self();
        $record->name = isset($params["name"])? $params["name"]: $record->name;
        $record->countries_id = isset($params["countries_id"])? $params["countries_id"]: $record->countries_id;
        $record->save();
        return $record;
    }
}