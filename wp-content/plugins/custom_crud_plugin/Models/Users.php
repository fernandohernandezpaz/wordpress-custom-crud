<?php

namespace App\Models;

use Couchbase\UserSettings;
use \WeDevs\ORM\Eloquent\Model as Model;


class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'ID';
    protected $timestamp = false;

    protected $hidden = [
        'user_pass',
        'user_activation_key',
        'user_registered',
        'user_url',
    ];

    public function getTable()
    {
        // In this example, it's set, but this is better in an abstract class
        if (isset($this->table)) {
            $prefix = $this->getConnection()->db->prefix;

            return $prefix . $this->table;
        }

        return parent::getTable();
    }
}