<?php

/**
 * TokenModel
 */
class TokenModel extends Model
{

    /**
     * tokens table name
     * 
     * @var string
     */
    protected $_table = 'tm_tokens';

    /**
     * getTokenByToken
     * 
     * @param  string $id
     * @return array
     */
    public function getTokenByToken($token)
    {
        return $this->_db->get($this->_table, '*', [
            'token' => $token
        ]);
    }

    /**
     * insertToken
     * 
     * @param  int $uid
     * @param  string $token
     * @param  int $expire_at
     * @return int Returns token id
     */
    public function insertToken($uid, $token, $expire_at)
    {
        $now = date('Y-m-d H:i:s');
        // medoo 1.6.x Return: [PDOStatement] The PDOStatement object
        $data = $this->_db->insert($this->_table, [
            'uid'        => $uid,
            'token'      => $token,
            'expire_at'  => $expire_at,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        return $this->_db->id();
    }


    /**
     * tokenIsExpired
     * 
     * @param  string $token
     * @return bool if token existed and not expired return true, else return false
     */
    public function checkToken($token)
    {
        $token = $this->getTokenByToken($token);
        if ($token) {
            // token already expired
            if ($token['expire_at'] < time()) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}