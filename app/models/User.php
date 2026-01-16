<?php

namespace app\models;

use app\utils\Helper;

class User extends Model
{
    public function authenticate($email, $password)
    {
        $db = $this->db;
        $passwordHash = Helper::encryptPassword($password);
        
        $user = $db->get('tm_users', ['id', 'email', 'nickname'], [
            'email' => $email,
            'password' => $passwordHash
        ]);

        return $user;
    }

    public function createToken($uid)
    {
        $db = $this->db;
        $token = Helper::generateToken();
        $expireTime = time() + intval(Helper::env('API_TIME_EXPIRE', 3600));
        
        $db->insert('tm_tokens', [
            'uid' => $uid,
            'token' => $token,
            'expire_at' => $expireTime,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return [
            'uid' => $uid,
            'token' => $token,
            'expire_at' => $expireTime
        ];
    }
}
