<?php


namespace App\Models;

use Couchbase\UserSettings;
use \WeDevs\ORM\Eloquent\Model as Model;

class GeneroModel extends Model
{
    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'genero';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'activo',
    ];
    public $timestamps = false;
    public static $snakeAttributes = false;

    public function getColumns()
    {
        $columns = [$this->primaryKey];
        $columns = array_merge($columns, $this->fillable);
        return $columns;
    }

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        global $wpdb;
        $this->table = $wpdb->prefix . $this->table;
    }
}