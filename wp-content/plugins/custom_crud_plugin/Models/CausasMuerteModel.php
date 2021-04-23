<?php

namespace App\Models;

use Couchbase\UserSettings;
use \WeDevs\ORM\Eloquent\Model as Model;
use \App\Models\Users;


class CausasMuerteModel extends Model
{
    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'causas_muerte';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'descripcion',
        'abreviatura',
        'activo',
        'fecha_registro'
    ];
    public $timestamps = false;
    public static $snakeAttributes = false;

    public function getColumns()
    {
        $columns = [$this->primaryKey];
        $columns = array_merge($columns, $this->fillable);
        return $columns;
    }

    public function usuarioRegistrador()
    {
        return $this->hasOne(Users::class, 'ID', 'user_id');
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        global $wpdb;
        $this->table =$wpdb->prefix . $this->table;
    }
}