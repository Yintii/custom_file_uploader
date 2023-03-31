<?php
/**
 * Plugin Name: Meeting uploader plugin
 */



 //code to create the database table
 //needed to use the plugin
 register_activation_hook(
    '/wp-content/plugins/kh_meeting_uploader/kh_meeting_uploader.php',
    kh_create_meetings_table()
 );

function kh_create_meetings_table(){
    global $wpdb;

    $table_name =  $wpdb->prefix . "meetings";
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name(
        id int NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        location text NOT NULL,
        meeting_type text NOT NULL,
        file_type text NOT NULL,
        file_path text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta( $sql );
}



 wp_register_style('kh_uploader_home_styles', '/wp-content/plugins/kh_meeting_uploader/styles/home.css');
 wp_register_style('kh_uploader_upload_styles', '/wp-content/plugins/kh_meeting_uploader/styles/upload.css');
 wp_register_style('kh_uploader_edit_styles', '/wp-content/plugins/kh_meeting_uploader/styles/edit.css');

 wp_register_script('kh_uploader_delete_script', '/wp-content/plugins/kh_meeting_uploader/js/delete.js');

 add_menu_page(
    'Meetings',
    'Meetings',
    'manage_options',
    'kh_meeting_uploader/uploader/home.php',
    '',
    '',
    6
 );

function kh_upload_submenu(){
    add_submenu_page(
        'kh_meeting_uploader/uploader/home.php',
        'Meeting Upload Form',
        'Upload Form',
        'manage_options',
        'kh_meeting_uploader_upload',
        'kh_upload_submenu_callback'
    );
}

add_action('admin_menu', 'kh_upload_submenu');

function kh_upload_submenu_callback(){
    include_once(plugin_dir_path(__FILE__) . '/Menu/Upload.php');
}

function kh_edit_submenu(){
    add_submenu_page(
        'kh_meeting_uploader/uploader/home.php',
        'Meeting Upload Form',
        'Edit Uploads',
        'manage_options',
        'kh_meeting_uploader_edit',
        'kh_edit_submenu_callback'
    );
}

add_action('admin_menu', 'kh_edit_submenu');

function kh_edit_submenu_callback(){
    include_once(plugin_dir_path(__FILE__) . '/Menu/Edit.php');
}
