<?php

namespace App\Http\Controllers\Rassed_api\current_conditions;

use App\Http\Controllers\Controller;
use App\Models\currentCondition;
use App\Models\foreCast;

use Illuminate\Support\Facades\Http;

class currentConditionsController extends Controller
{


    private $base_url       = "";
    private $key            = "currentconditions/v1/";
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
        $attr_to_create_or_update['response']     = $this->response;
        $attr_to_create_or_update['id']           = $id;

        if ($attr_to_create_or_update['details'] == 'true')
                $attr_to_create_or_update['details'] = 1;
        else    $attr_to_create_or_update['details'] = 0;




        $result=currentCondition::createUpdate($attr_to_create_or_update);

        return $result;
    }


    public function prepare_params($params)
    {

        if ($params['details'] == 1) $details = 'true';
        else $details = 'false';

        $this->request_params = [
            'apikey'   => env('Rassed_API_Key', ''),
            'language' =>$params['language'],
            'details'  => $details,
        ];
    }


    public function prepare_url_to_execute($params)
    {
        $this->location_key = $params['location_key'];
        $this->language     = $params['language'];

        $this->base_url = env('Rassed_API_Url', '') . $this->key  . $this->location_key;

    }
}
