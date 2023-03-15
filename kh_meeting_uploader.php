<?php
/**
 * Plugin Name: Meeting uploader plugin
 */

 register_activation_hook(
    '/wp-content/plugins/kh_meeting_uploader/kh_meeting_uploader.php',
    kh_create_meetings_table()
 );

 add_menu_page(
    'Meeting Uploader',
    'Meeting Uploader',
    'manage_options',
    'kh_meeting_uploader/Menu/Menu.php',
    '',
    '',
    6
 );

function kh_create_meetings_table(){
    global $wpdb;

    $table_name =  $wpdb->prefix . "meetings";
    
    $sql = "CREATE TABLE $table_name(
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
