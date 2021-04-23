<?php
use App\Models\CausasMuerteModel;

require_once(ROOTDIR . 'vendor/autoload.php');

/**
 * Grab latest post title by an author!
 *
 * @return array.
 */
function causasMuerteResponse() {
    return CausasMuerteModel::where('activo', true)->get();
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'v2', 'causas_muerte', array(
        'methods' => 'GET',
        'callback' => 'causasMuerteResponse',
    ) );
} );
