<?php

function eld_delete_options() {
    delete_option('eld_zone_by_registrator_enabled_option');
    delete_option('eld_zone_by_registrator_login_option');
    delete_option('eld_zone_by_registrator_password_option');
}

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
    
eld_delete_options();