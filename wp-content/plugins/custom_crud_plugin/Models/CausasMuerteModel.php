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

    /**
     * Overide parent method to make sure prefixing is correct.
     *
     * @return string
     */
    public function getTable()
    {
        // In this example, it's set, but this is better in an abstract class
        if (isset($this->table)) {
            $prefix = $this->getConnection()->db->prefix;

            return $prefix . $this->table;
        }

        return parent::getTable();
    }

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
}