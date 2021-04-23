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

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        global $wpdb;
        $this->table =$wpdb->prefix . $this->table;
    }
}