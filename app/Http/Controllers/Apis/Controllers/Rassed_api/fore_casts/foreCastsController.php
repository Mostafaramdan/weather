<?php

namespace App\Http\Controllers\Apis\Controllers\Rassed_api\fore_casts;


use App\Http\Controllers\Controller;
use App\Models\foreCast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\general_api_response;
use App\Http\Controllers\Rassed_api\fore_casts\foreCastsController as Rassed_api_fore_casts;

class foreCastsController extends Controller
{

    use general_api_response;

    public function foreCasts(Request $request)
    {

        $validator = Validator::make($request->all(), $this->getRules(), $this->getMessages());

        if ($validator->fails())
            return $this->return_error(400, $validator->errors());


        //check if the data is exist so we ust return it else call the api and return the result
        $result = $this->get_chk_if_fore_cast_exist($request);


        if ($result) {

            if ($result->is_active == 0)
                     return $this->return_error(410, 'this Location IS not In Activation Mode');

            $response =  $this->return_response($result);
        }
        else {
            $rassed   = new Rassed_api_fore_casts($this->prepare_request_to_send($request));
            $response = $this->return_response($rassed->create_update_fore_casts());
        }


        return $this->return_full_response($response);

    }


    public function getRules()
    {
        return [
            'details'      => 'required|in:1,0',
            'metric'       => 'required|in:1,0',
            'location_key' => 'required',
            'type'         => 'required|in:daily,hourly',
            'time_type'    => 'required|in:5day,1day,12hour',
            'language'     => 'required|in:ar,en',
        ];
    }


    public function getMessages()
    {
        return [
            'details.required'      => 'Details is Required',
            'details.boolean'       => 'Details is boolean',
            'metric.required'       => 'metric is Required',
            'metric.boolean'        => 'metric is boolean',
            'location_key.required' => 'location_key is Required',
            'type.required'         => 'type is Required',
            'time_type.required'    => 'time_type is Required',
            'language.required'     => 'language is Required',
            'language.in'           => 'please choose the suitable language'
        ];
    }


    public function get_chk_if_fore_cast_exist($request)
    {
        $fore_cast = foreCast::where('details', $request->details)
            ->where('metric', $request->metric)
            ->where('location_key', $request->location_key)
            ->where('type', $request->type)
            ->where('time_type', $request->time_type)
            ->where('language', '=', $request->language)
            ->first();

        return $fore_cast;
    }

    public function prepare_request_to_send($request)
    {
        return [
            'location_key'=>$request->location_key,
            'type'=>$request->type,
            'time_type'=>$request->time_type,
            'language'=>$request->language,
            'metric'=>$request->metric,
            'details'=>$request->details
        ];
    }


    public function return_response($result){

        return json_decode($result->response);

        /**   return [
                'updated_at' => strtotime($result->updated_at),
                'next_update'=>strtotime($result->next_update),
                'data' =>json_decode($result->response)
        ];**/
    }







}
