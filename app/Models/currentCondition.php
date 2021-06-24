<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class currentCondition extends Model
{

    protected $table     = "current_conditions";
    public    $timestaps = false;

    public static function createUpdate($attr_to_create_or_update)
    {

        if ($attr_to_create_or_update["id"] == null) $currentCondition = new self();
        else                        $currentCondition = self::find($attr_to_create_or_update['id']);
        $currentCondition->language     = $attr_to_create_or_update['language'];
        $currentCondition->details      = $attr_to_create_or_update['details'];
        $currentCondition->location_key = $attr_to_create_or_update['location_key'];
        $currentCondition->response     = (string)$attr_to_create_or_update['response'];
        if ($attr_to_create_or_update['id'] == null)
            $currentCondition->created_at = Carbon::now();
        $currentCondition->updated_at  = Carbon::now();
        $currentCondition->next_update = Carbon::now()->addMinutes(self::get_next_update_time());
        $currentCondition->save();

        return $currentCondition;
    }


    public static function get_next_update_time()
    {
        //note that it should get the value from app_setting in the future
        return env('Rassed_UPDATE_PERIOD', '60');
    }
}
