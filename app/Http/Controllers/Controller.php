<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
 public $errorCode;
    public $errorMessage;
    public $message;
    public $status;
    public $httpCode;
    public $value;
    public static function sendSucess($value, $message, $status=200)
    {
        $res = new Controller();
        $res->value = $value;
        $res->message = $message;
        $res->status = $status;
        return response()->json($res);
    }

    public static function sendFailure($message, $status=400)
    {
        $res = new Controller();
        $res->errorMessage = $message;
        $res->status = $status;
        return response()->json($res);
    }

}
