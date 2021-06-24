<?php

namespace App\Traits;

trait general_api_response
{

    public function return_error($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg'    => $msg
        ]);
    }


    public function return_success_message($msg = "", $errNum = "S000")
    {
        return [
            'status' => true,
            'errNum' => $errNum,
            'msg'    => $msg
        ];
    }

    public function return_data($extra = [],$msg = "")
    {

        return response()->json(array_merge([
            'status' => true,
            'msg'    => $msg
        ], $extra));
    }


    public function return_validation_error($code = "400", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    public function return_code_according_to_input($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code   = $this->getErrorCode($inputs[0]);
        return $code;
    }



    public function return_full_response($response){
              return response()->json($response);
    }


}
