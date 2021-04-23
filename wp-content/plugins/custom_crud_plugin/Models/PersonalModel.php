<?php

namespace App\Models;

use Couchbase\UserSettings;
use \WeDevs\ORM\Eloquent\Model as Model;


class PersonalModel extends Model
{
    /**
     * Name for table without prefix
     *
     * @var string
     */
    protected $table = 'personas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'genero_id',
        'nombre_completo',
        'edad',
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
        $this->table =$wpdb->prefix . $this->table;
    }

    public function causasMuerte()
    {
        global $wpdb;
        return $this->belongsToMany(
            CausasMuerteModel::class,
            $wpdb->prefix .'persona_causas_muerte',
            'causas_muerte_id',
            'persona_id'
        );
    }
}