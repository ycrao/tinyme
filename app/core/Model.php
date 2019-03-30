<?php

use Medoo\Medoo;

/**
 * TinyMe Model class
 * based on `catfan/medoo` , official website: https://github.com/catfan/medoo .
 *
 * @author raoyc <raoyc2009@gmail.com>
 */
class Model
{

    protected $_error;
    protected $_db;

    public function getError() {
        return $this->_error;
    }

    public function setDb(Medoo $db) {
        $this->_db = $db;
    }
}
