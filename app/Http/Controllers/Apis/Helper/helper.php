<?php

namespace App\Http\Controllers\Apis\Helper;
 use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Apis\Controllers\index;
use App\Models\admins; 
use App\Models\ads;
use App\Models\app_settings;
use App\Models\contacts;
use App\Models\logs;
use App\Models\notifications;
use App\Models\notify;
use App\Models\users;
use App\Models\points;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
use Validator;
use DB;
use GuzzleHttp\Client;

class helper extends generalHelp
{
	public static function validateAccount(){
		
		if(index::$account == null ){
			if(index::$request->has('phone')){
				$code=415;
 			}elseif(index::$request->has('email')){
				$code=416;
			}elseif(index::$request->has('tmpToken')){
				$code=417;
			}elseif(index::$request->has('apiToken')){
				$code=403;
			}else{
				return null;
			}
		}else{
			if(index::$account->deletedAt!= null){
				$code= 418;
			}elseif(index::$account->isActive == 0){
				$code=402;
		   }elseif(index::$account->isVerified == 0){
			   $code=419;
		   }else{
			   return null;
		   } 
		}		
		return [
			'status'=>$code,
			'message'=>self::$messages['validateAccount']["{$code}"]
		];   
	}

	public static function newNotify($targets, $message_ar, $message_en, $orderId=null, $type=null, $notificationId=null, $titleAr=null, $titleEn=null)
	{
		if(!$notificationId){
			$notification   =   notifications::createUpdate([
									'contentAr'=>$message_ar,
									'contentEn'=>$message_en,
									'titleAr'=>$titleAr,
									'titleEn'=>$titleEn,
									'type'    =>$type
								]);
				
		}else{
			$notification =notifications::find($notificationId);
		}
		foreach($targets as $user){
			$notify =   notify::createUpdate([
							'notifications_id'=>$notificationId??$notification->id,
							$user->getTable()."_id" =>$user->id,
							'orders_id'      =>$orderId,
							'isSeen'         =>0,
							'type'           =>$type
						]);
						
			self::sendFCM( $notify ,'target_user');
			 
		}
		return $notificationId??$notification->id;           
	}
	
	public static function SocketUser($userId, $type, $data )
	{
		$curl = curl_init("http://127.0.0.1:7779/user/".$userId);
		curl_setopt( $curl,CURLOPT_POST, true );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl,CURLOPT_POSTFIELDS,
			json_encode([
				'type'=>$type,
				'data'=>$data,
			])
		);
		$ret = curl_exec($curl);
		curl_close($curl);
		return $ret;
	}
	public static function SocketDriver($userId, $type, $data )
	{
		$curl = curl_init("http://127.0.0.1:7779/driver/".$userId);
		curl_setopt( $curl,CURLOPT_POST, true );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl,CURLOPT_POSTFIELDS,
			json_encode([
				'type'=>$type,
				'data'=>$data,
			])
		);
		$ret = curl_exec($curl);
		curl_close($curl);
		return $ret;
	}
	public static function SocketStore($userId, $type, $data )
	{
		$curl = curl_init("http://127.0.0.1:7779/store/".$userId);
		curl_setopt( $curl,CURLOPT_POST, true );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $curl,CURLOPT_POSTFIELDS,
			json_encode([
				'type'=>$type,
				'data'=>$data,
			])
		);
		$ret = curl_exec($curl);
		curl_close($curl);
		return $ret;
	}
	
	public static function sendSMS($phone, $msg)
	{
		$phone = Str::substr($phone, 2, 70); 
		$url='https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=trolleyapi&Password=M@654321&MobileNo='.$phone.'&Message='.$msg.'&PushDateTime='.date('m/d/Y H:i:s').'&Lang=0';
		$url = preg_replace("/ /", "%20", $url);
		file_get_contents($url);
    }
	public static function converPointsToBalance($pointsToBeConverted){
		$points=points::orderBy("numberOfPoints","ASC")->get();
		$check=false;
		$pointRturned=0;
		foreach($points as $point){
			if($point->numberOfPoints <= $pointsToBeConverted){
				$check=true;
				$pointRturned= $point;
				continue;
			}
			
		}
		if ($pointRturned)
			return $pointRturned  ;
		else{
			return points::orderBy("numberOfPoints","DESC")->first();
		}
	}    
}