<?php
/*
Plugin Name: Editable Contextual Help Manager
Description: This plugin helps you to add, edit and save information in tabs into contextual help panel of Wordpress.
Version: 1.0
Author: Dmitriy Derkach
*/




function main_identification_superadmin() {

    $check_user = wp_get_current_user();

    if(is_super_admin( $check_user )){
        //require_once(ABSPATH . 'wp-includes/pluggable.php');
        require __DIR__.'/functions.php';
        require __DIR__.'/uc-editable-hm-modal.php';
        require __DIR__.'/uc-editable-hm-modal-exist.php';

        add_action('admin_enqueue_scripts', 'uc_editable_hm_scripts');

        add_thickbox();

        add_action( 'in_admin_header', 'new_tabs_creating_window');
        add_action( 'in_admin_header', 'exist_tabs_editing_window');
        add_action( 'wp_ajax_add_help_tabs_to_db', 'add_help_tabs_to_db' );
        add_action( 'wp_ajax_add_help_tabs_sidebar_to_db', 'add_help_tabs_sidebar_to_db' );
        add_action( 'wp_ajax_editing_existed_help_tabs_from_db', 'editing_existed_help_tabs_from_db' );

        wp_enqueue_editor();


    }
}

add_action( 'plugins_loaded', 'main_identification_superadmin' );

