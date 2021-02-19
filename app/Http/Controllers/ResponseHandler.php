<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;

class ResponseHandler extends Controller
{
    protected function respondError($error) {
        $ret = new \stdClass();
        if ($error instanceof CustomException) {
            $ret->errors = $error->getAllErrors();
            $ret->error_code = $error->getErrorCode();
            $ret->message = $error->getMessage();
            $ret->exception = $error;
        } else { 
            $msgError = $error->getMessage();
            if(isset($error->errorInfo) && count($error->errorInfo) > 0){
                $msgError = $error->errorInfo[2];
            }
            $ret->message = $msgError;
            $ret->errors = [];
            $ret->error_code= $error->getCode();
            //$ret->exception = $error;
            $ret->system_message = $error->getMessage(); 
        }
        return response()->json($ret, 400);
    }

    protected function respondSuccess($data) { //$extra = [],
        return response()->json($data, 200);
    }

    protected function queryRespondError($filter) {
        $error_code = new Status();
        $ret = new \stdClass();
        $ret->message = $filter;
        $ret->error_code = $error_code->query();
        return response()->json($ret, 400);
    }
 
    public static function showSuccess($data){
        return response()->json($data, 200);
    }

    public static function customException($error){
        return response()->json([
            "message" => $error->getMessage(),
            'system_message' => "",
            "error_code"=> $error->getErrorCode(),
            "error_line" => null,
            "error_trace" => null
        ], 400); 
    }

    public static function clientError($msg){
        return response()->json([
            "message" => $msg,
            'system_message' => "",
            "error_code"=> "GENERAL ERROR",
            "error_line" => null,
            "error_trace" => null
        ], 400);
    }

    public static function internalServerError($exception, $msg = "Internal Server Issue!"){
        return response()->json([
            "message" => $msg,
            'system_message' => $exception->getMessage(),
            "error_code"=> $exception->getCode(),
            "error_line" => $exception->getLine(),
            "error_trace" => $exception->getTrace()
        ], 500);
    }

    public static function notFountException($exception, $msg){
        return response()->json([
            "message" => $msg,
            'system_message' => $exception->getMessage(),
            "error_code"=> $exception->getCode(),
            "error_line" => $exception->getLine(),
            //    "error_trace" => $exception->getTrace()
        ], 404);
    }

    public static function unauth($exception){
        return response()->json([
            "message" => $exception->getMessage(),
            'system_message' => $exception->getMessage(),
            "error_code"=> $exception->getCode(),
            "error_line" => $exception->getLine(),
            //    "error_trace" => $exception->getTrace()
        ], 401);
    }
}
