<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class foreCast extends Model
{
    protected $table     = "fore_casts";
    public    $timestaps = false;

    public static function createUpdate($attr_to_create_or_update)
    {

        if ($attr_to_create_or_update["id"] == null) $fore_casts = new self();
        else                        $fore_casts = self::find($attr_to_create_or_update['id']);
        $fore_casts->language     = $attr_to_create_or_update['language'];
        $fore_casts->details      = $attr_to_create_or_update['details'];
        $fore_casts->metric       = $attr_to_create_or_update['metric'];
        $fore_casts->location_key = $attr_to_create_or_update['location_key'];
        $fore_casts->type         = $attr_to_create_or_update['type'];
        $fore_casts->time_type    = $attr_to_create_or_update['time_type'];
        $fore_casts->response     = (string)$attr_to_create_or_update['response'];
        if ($attr_to_create_or_update['id'] == null)
            $fore_casts->created_at = Carbon::now();
        $fore_casts->updated_at  = Carbon::now();
        $fore_casts->next_update = Carbon::now()->addMinutes(self::get_next_update_time());
        $fore_casts->save();

        return $fore_casts;
    }


    public static function get_next_update_time()
    {
        //note that it should get the value from app_setting in the future
        return env('Rassed_UPDATE_PERIOD', '60');
    }


    public static function getItems($now){
    //   return   self::where('next_update', '<=', $now)->get();
      return   self::all();
    }


}
