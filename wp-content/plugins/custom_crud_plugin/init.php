<?php
/*
Plugin Name: Custom crud plugin
Description: Plugin para crear nuevas tablas en la base de datos y crear un crud de estas.
Version: 1.0.0
Author: Fernando Hernández Paz
Author URI: -
*/
namespace App;

// definiendo directorio en base al archivo init
define('ROOTDIR', plugin_dir_path(__FILE__));

// agregando nuevas funciones
require_once(ROOTDIR . 'Modulos/causas_muerte/CausasMuerte.php');
require_once(ROOTDIR . 'Modulos/genero/Genero.php');

// agregando apis
require_once(ROOTDIR . 'Modulos/causas_muerte/Api.php');

// if you want to check in debug log
require_once(ROOTDIR . 'write_in_log.php');

// creando nuevas tablas en base de datos
function creating_news_tables()
{
    global $wpdb;
    $path = ROOTDIR . '/script.sql';
    $file = fopen($path, 'r');
    $sql_file = fread($file, filesize($path));
    fclose($file);
    $sql = str_replace('{prefix}', $wpdb->prefix, $sql_file);
    write_log($sql);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// ejecute los scripts de instalación tras la activación del complemento
register_activation_hook(__FILE__, 'App\creating_news_tables');

// indexando
require_once(ROOTDIR . 'index_menu.php');