<?php

namespace App\Http\Controllers\Apis\Controllers\Rassed_api\current_conditions;

use App\Http\Controllers\Controller;
use App\Models\currentCondition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\general_api_response;
use App\Http\Controllers\Rassed_api\current_conditions\currentConditionsController as Rassed_api_current_conditions;

class currentConditionsController extends Controller
{

    use general_api_response;

    public function currentConditions(Request $request)
    {

        $validator = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if ($validator->fails())
            return $this->return_error(400, $validator->errors());


        //check if the data is exist so we ust return it else call the api and return the result
        $result = $this->get_chk_if_current_conditions_exist($request);


        if ($result) {

            if ($result->is_active == 0)
                     return $this->return_error(410, 'this Location IS not In Activation Mode');

            $response =  $this->return_response($result);
        }
        else {
            $rassed   = new Rassed_api_current_conditions($this->prepare_request_to_send($request));
            $response = $this->return_response($rassed->create_update_fore_casts());
        }


        return $this->return_full_response($response);

    }


    public function getRules()
    {
        return [
            'details'      => 'required|in:1,0',
            'location_key' => 'required',
            'language'     => 'required|in:ar,en',
        ];
    }


    public function getMessages()
    {
        return [
            'details.required'      => 'Details is Required',
            'details.boolean'       => 'Details is boolean',
            'location_key.required' => 'location_key is Required',
            'language.required'     => 'language is Required',
            'language.in'           => 'please choose the suitable language'
        ];
    }


    public function get_chk_if_current_conditions_exist($request)
    {
        $currentCondition = currentCondition::where('details', $request->details)
            ->where('location_key', $request->location_key)
            ->where('language', '=', $request->language)
            ->first();

        return $currentCondition;
    }

    public function prepare_request_to_send($request)
    {
        return [
            'location_key'=>$request->location_key,
            'language'=>$request->language,
            'details'=>$request->details
        ];
    }


    public function return_response($result){

       return json_decode($result->response);
       /**
        return [
                'updated_at' => strtotime($result->updated_at),
                'next_update'=>strtotime($result->next_update),
                'data' =>json_decode($result->response)
        ];
        * **/
    }







}
