<?php
namespace app\models;

use Medoo\Medoo;

class Model
{
    protected Medoo $db;

    public function __construct($db) {
        $this->db = $db;
    }
}