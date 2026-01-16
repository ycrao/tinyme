<?php

namespace app\controllers;

use app\models\User;

class AuthController extends ApiController
{

    public function login()
    {
        $email = $this->app->request()->data->email ?? '';
        $password = $this->app->request()->data->password ?? '';

        if (empty($email) || empty($password)) {
            $this->return400('Email and password are required');
            return;
        }
        $userModel = new User($this->app->db());
        $user = $userModel->authenticate($email, $password);
        $this->app->logger()->info('user login', ['email' => $email]);

        if (!$user) {
            $this->return403('illegal or incorrect credentials');
            return;
        }

        $tokenData = $userModel->createToken($user['id']);
        $this->app->cache()->set($tokenData['token'], $user['id'], 60 * 60);
        $this->return200($tokenData);
    }
}
