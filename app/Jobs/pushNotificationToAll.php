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
use Illuminate\Support\Str;

class pushNotificationToAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public   $record, $checkType, $users_type ;
    public    $timeout = 9999999;

    public function __construct($record, $checkType,$users_type)
    {
        $this->record= $record;
        $this->checkType= $checkType;
        $this->users_type= $users_type;
    }

    public function handle()
    {
        if( $this->checkType) {
            foreach(users::allActive() as $user){
                 $notify = notify::createUpdate([
                    "notifications_id"=>$this->record->id,
                    "isSeen"=>0,
                    $user->getTable()."_id"=>$user->id
                 ]);
                 helper::sendFCM($notify,"user");
            } 
            foreach(visitors::all() as $visitor){
                 $notify = notify::createUpdate([
                    "notifications_id"=>$this->record->id,
                    "isSeen"=>0,
                    $visitor->getTable()."_id"=>$visitor->id
                ]);
                helper::sendFCM($notify,"visitor");
            }
        }else{
            $model= "\App\Models\\".$this->users_type;
            foreach($model::all() as $user){
                 $notify = notify::createUpdate([
                    "notifications_id"=>$this->record->id,
                    "isSeen"=>0,
                    $user->getTable()."_id"=>$user->id
                ]);
                helper::sendFCM($notify,Str::singular($this->users_type));
            }
        }
    }
}