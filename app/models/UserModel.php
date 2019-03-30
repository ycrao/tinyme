<?php

/**
 * UserModel
 */
class UserModel extends Model
{

    /**
     * users table name
     * 
     * @var string
     */
    protected $_table = 'tm_users';

    /**
     * getUserById
     * 
     * @param  int $id 
     * @return array Returns result
     */
    public function getUserById($id)
    {
        return $this->_db->get($this->_table, '*', [
            'id' => $id
        ]);
    }

    /**
     * loginByCredentials
     * 
     * @param  string $email email
     * @param  string $password password
     * @return int Passed return user id, else return zero (0)
     */
    public function loginByCredentials($email, $password)
    {
        $user = $this->_db->get($this->_table, '*', [
            'AND' => [
                'email'    => $email,
                'password' => encrypt_password($password)
            ]
        ]);
        if ($user) {
            return $user['id'];
        } else {
            return 0;
        }
    }

}