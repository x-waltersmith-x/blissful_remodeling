<?php 

add_filter( 'site_transient_update_plugins', function($transient) {
    if ( isset( $transient->response ) && is_array( $transient->response ) ) {
        // Replace 'all-in-one-wp-migration/wp-migration.php' with the correct path to the plugin
        unset( $transient->response['all-in-one-wp-migration/all-in-one-wp-migration.php'] );
        unset( $transient->response['all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php'] );
    }
    return $transient;
});
