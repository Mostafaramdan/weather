<?php

namespace App\Http\Controllers\Rassed_api\fore_casts;

use App\Http\Controllers\Controller;
use App\Models\foreCast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class foreCastsController extends Controller
{


    private $type;
    private $time_type;
    private $base_url       = "";
    private $key            = "forecasts/v1/";
    private $location_key   = "";
    private $request_params = [];
    private $response;

    public function __construct($params)
    {


        $this->prepare_url_to_execute($params);
        $this->prepare_params($params);
    }


    public function create_update_fore_casts($id = null)
    {
        //call the api and save it on the database



        $this->response = Http::get($this->base_url, $this->request_params);



        // save the response in foreCasts
        $attr_to_create_or_update                 = $this->request_params;
        $attr_to_create_or_update['location_key'] = $this->location_key;
        $attr_to_create_or_update['type']         = $this->type;
        $attr_to_create_or_update['time_type']    = $this->time_type;
        $attr_to_create_or_update['response']     = $this->response;
        $attr_to_create_or_update['id']           = $id;

        if ($attr_to_create_or_update['details'] == 'true')
                $attr_to_create_or_update['details'] = 1;
        else    $attr_to_create_or_update['details'] = 0;


        if ($attr_to_create_or_update['metric'] == 'true')
                $attr_to_create_or_update['metric'] = 1;
        else    $attr_to_create_or_update['metric'] = 0;

        $result=foreCast::createUpdate($attr_to_create_or_update);

        return $result;
    }


    public function prepare_params($params)
    {

        if ($params['metric'] == 1) $metric = 'true';
        else $metric = 'false';
        if ($params['details'] == 1) $details = 'true';
        else $details = 'false';

        $this->request_params = [
            'apikey'   => env('Rassed_API_Key', ''),
            'language' =>$params['language'],
            'details'  => $details,
            'metric'   => $metric
        ];
    }


    public function prepare_url_to_execute($params)
    {
        $this->location_key = $params['location_key'];
        $this->type         = $params['type'];
        $this->time_type    = $params['time_type'];
        $this->language     = $params['language'];

        $this->base_url = env('Rassed_API_Url', '') . $this->key . $this->type . "/" . $this->time_type . "/" . $this->location_key;

    }
}
