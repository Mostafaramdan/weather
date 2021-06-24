<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class location extends Model
{
    // create by fady mounir Rassed API location
    protected $table     = "locations";
    public    $timestaps = false;

    public static function createUpdate($attr_to_create_or_update)
    {

        if ($attr_to_create_or_update["id"] == null) $location = new self();
        else                        $location = self::find($attr_to_create_or_update['id']);
        $location->language     = $attr_to_create_or_update['language'];
        $location->details      = $attr_to_create_or_update['details'];
        $location->location_key = $attr_to_create_or_update['location_key'];
        $location->response     = (string)$attr_to_create_or_update['response'];
        if ($attr_to_create_or_update['id'] == null)
            $location->created_at = Carbon::now();
        $location->updated_at  = Carbon::now();
        $location->next_update = Carbon::now()->addMinutes(self::get_next_update_time());
        $location->save();

        return $location;
    }


    public static function get_next_update_time()
    {
        //note that it should get the value from app_setting in the future
        return env('Rassed_UPDATE_PERIOD', '60');
    }
}
