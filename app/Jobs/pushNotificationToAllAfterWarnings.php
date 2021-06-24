<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\users;
use App\Http\Controllers\Apis\Helper\helper;
use App\Models\visitors;
use App\Models\testJobs;
use App\Models\notify;
use App\Models\notifications;

class pushNotificationToAllAfterWarnings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $record, $tries = 1 ,$warnings, $timeout = 9999999;
    public function __construct($record,$warnings)
    {
        $this->record= $record;
        $this->warnings= $warnings;
    }

    public function handle()
    {
        foreach(users::allActive() as $user){
            if(notify::where('notifications_id',$this->record->id)->where('users_id',$user->id)->count() < 1){
                $notify = notify::createUpdate([
                    "notifications_id"=>$this->record->id,
                    "isSeen"=>0,
                    "warnings_id"=>$this->warnings->id,
                    $user->getTable()."_id"=>$user->id
                ]);
                helper::sendFCM($notify,"user");
            }
        } 
        foreach(visitors::all() as $visitor){
            if(notify::where('notifications_id',$this->record->id)->where('visitors_id',$visitor->id)->count() < 1){
                $notify = notify::createUpdate([
                    "notifications_id"=>$this->record->id,
                    "isSeen"=>0,
                    "warnings_id"=>$this->warnings->id,
                    $visitor->getTable()."_id"=>$visitor->id
                ]);
                helper::sendFCM($notify,"visitor");
            }
        }
    }
}