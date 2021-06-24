<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\foreCast;
use Carbon\Carbon;
use App\Http\Controllers\Rassed_api\fore_casts\foreCastsController as Rassed_api_fore_casts;
use App\Http\Controllers\Apis\Controllers\Rassed_api\fore_casts\foreCastsController;
use Symfony\Component\HttpFoundation\Request;

class updateForeCasts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $now = Carbon::now();

        $getItems = foreCast::getItems($now);
        foreach ($getItems as $item) {
    
            $request               = new Request();
            $request->location_key = $item->location_key;
            $request->type         = $item->type;
            $request->time_type    = $item->time_type;
            $request->language     = $item->language;
            $request->metric       = $item->metric;
            $request->details      = $item->details;
            $fore_casts_api = new foreCastsController();
            $rassed         = new Rassed_api_fore_casts($fore_casts_api->prepare_request_to_send($request));
            $rassed->create_update_fore_casts($item->id);
        }
    }
}
