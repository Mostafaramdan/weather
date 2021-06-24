<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\currentCondition;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Rassed_api\current_conditions\currentConditionsController as Rassed_api_current_conditions;
use App\Http\Controllers\Apis\Controllers\Rassed_api\current_conditions\currentConditionsController;

class updateCurrentConditions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $now     = Carbon::now();
        $getItems = currentCondition::all();
        foreach ($getItems as $item) {
            $request               = new Request();
            $request->location_key = $item->location_key;
            $request->language     = $item->language;
            $request->details      = $item->details;
            $current_conditions_api = new currentConditionsController();
            $rassed         = new Rassed_api_current_conditions($current_conditions_api->prepare_request_to_send($request));
            $rassed->create_update_fore_casts($item->id);
        }
    }
}
