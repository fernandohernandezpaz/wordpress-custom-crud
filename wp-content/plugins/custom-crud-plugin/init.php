<?php
/*
Plugin Name: Custom crud plugin
Description: Plugin para crear nuevas tablas en la base de datos y crear un crud de estas.
Version: 1.0.0
Author: Fernando Hernández Paz
Author URI: -
*/

// if you want to check in debug log
// require_once(ROOTDIR . 'write_in_log.php');

// function to create the DB / Options / Defaults
function creating_news_tables()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $path = ABSPATH . 'wp-content/plugins/custom-crud-plugin/script.sql';
    $file = fopen($path, 'r');
    $sql_file = fread($file, filesize($path));
    fclose($file);
    $sql = str_replace('{prefix}', $wpdb->prefix, $sql_file);
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'creating_news_tables');
