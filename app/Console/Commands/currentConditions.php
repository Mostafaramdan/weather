<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\currentCondition;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Rassed_api\current_conditions\currentConditionsController as Rassed_api_current_conditions;
use App\Http\Controllers\Apis\Controllers\Rassed_api\current_conditions\currentConditionsController;
use App\Jobs\updateCurrentConditions;
use Illuminate\Support\Facades\Log;

class currentConditions extends Command
{
    protected $signature = 'currentConditions:update';
    protected $description = 'this command to update Rassed API dataBase';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
	Log::info('Starting currentConditions Command');

        // updateCurrentConditions::dispatch();
        $now     = Carbon::now();
        $getItems = currentCondition::all();
	Log::info('Got all the current conditions');
        foreach ($getItems as $item) {
	    Log::info('Processing an item and getting conditions');
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
