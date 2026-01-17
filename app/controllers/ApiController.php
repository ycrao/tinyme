<?php

namespace app\controllers;

use flight\Engine;

class ApiController
{
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }


    private function respJson($data, $code = 200, $message = 'ok')
    {
        // 只处理 2xx 与 4xx 之类的 code， 其它 code 一律返回 500 httpCode
        if ($code >= 200 && $code < 300) {
            $httpCode = $code;
        } else if ($code >= 400 && $code < 500) {
            if (in_array($code, [401, 403, 404])) {
                $httpCode = $code;
            } else {
                $httpCode = 200;
            }
        } else {
            $httpCode = 500;
            $message = 'internal server error!';
            $data = null;
        }
        $this->app->json([
            'code' => $code,
            'msg' => $message,
            'data' => $data
        ], $httpCode);
    }

    public function redirect($url, $code = 302)
    {
        $this->app->response()->status($code);
        $this->app->response()->header('Location', $url);
    }

    public function return200($data = null, $message = 'ok')
    {
        $this->respJson($data, 200, $message);
    }

    public function return201($data = null, $message = 'created!')
    {
        $this->respJson($data, 201, $message);
    }

    public function return400($message = 'bad request!')
    {
        $this->respJson(null, 400, $message);
    }

    public function return401($message = 'unauthorized!')
    {
        $this->respJson(null, 401, $message);
    }

    public function return403($message = 'forbidden!')
    {
        $this->respJson(null, 403, $message);
    }

    public function return404($message = 'not found!')
    {
        $this->respJson(null, 404, $message);
    }

    public function return422($data = null, $message = 'unprocessable entity!')
    {
        $this->respJson($data, 422, $message);
    }
}