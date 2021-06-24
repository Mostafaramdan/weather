<?php

namespace App\Console\Commands;



use Illuminate\Console\Command;
use Symfony\Component\HttpFoundation\Request;
use App\Models\foreCast;
use Carbon\Carbon;
use App\Http\Controllers\Rassed_api\fore_casts\foreCastsController as Rassed_api_fore_casts;
use App\Http\Controllers\Apis\Controllers\Rassed_api\fore_casts\foreCastsController;
use  App\Jobs\updateForeCasts ;

class foreCasts extends Command
{
    protected $signature = 'foreCasts:update';
    protected $description = 'this command to update Rassed API dataBase';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        updateForeCasts::dispatch();
    }
}
