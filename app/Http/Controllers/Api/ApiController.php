<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    protected  function respond($data, $code = 200){
        return response(["data" => $data] , $code);
    }

    protected function respondError($error){
        return response(["error" => $error], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function callAction($method, $parameters)
    {
        try {
            return parent::callAction($method, $parameters);
        }catch(\Exception $e){
            return $this->respondError( $e->getMessage() );
        }
    }
}
