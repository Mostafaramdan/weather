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
use App\Models\notify;
use App\Models\notifications;
use App\Http\Controllers\Apis\Resources\objects;
use App\Models\testJobs;

class pushNotificationToAllAfterNews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $record, $tries = 10 ,$news, $timeout = 9999999;

    public function __construct($record,$news)
    {
        $this->record= $record;
        $this->news= $news;
    }

    public function handle()
    {
        foreach(users::allActive() as $user){
            if(notify::where('notifications_id',$this->record->id)->where('users_id',$user->id)->count() < 1){
                $notify = notify::createUpdate([
                    "notifications_id"=>$this->record->id,
                    "isSeen"=>0,
                    "news_id"=>$this->news->id,
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
                    "news_id"=>$this->news->id,
                    $visitor->getTable()."_id"=>$visitor->id
                ]);
                helper::sendFCM($notify,"visitor");
            }
        }
    }   
}