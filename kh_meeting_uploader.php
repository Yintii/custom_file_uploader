<?php
/**
 * Plugin Name: Innovision custom meeting/upload plugin
 *
 * Plugin URI: https://teaminnovision.com/
 *
 * Description: This is an in house plugin created by Innovision. Please be advised that it is not advised to alter anything relating to this plugin. If you are seeking extended functionality, please reach out to Team Innovision directly through your established channel.
 *
 * Version: 1.0.0
 *
 * Author: Innovision - Kele Heart
 *
 * License: UNLICENSED
 *
 * Text Domain teaminnovision
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



 function kh_plugin_enqueue_scripts_and_styles(){
    wp_register_style('kh_uploader_home_styles',    '/wp-content/plugins/kh_meeting_uploader/styles/home.css');
    wp_register_style('kh_uploader_upload_styles',  '/wp-content/plugins/kh_meeting_uploader/styles/upload.css');
    wp_register_style('kh_uploader_edit_styles',    '/wp-content/plugins/kh_meeting_uploader/styles/edit.css');
    wp_register_script('kh_uploader_delete_script', '/wp-content/plugins/kh_meeting_uploader/js/delete.js');

    wp_enqueue_style('kh_uploader_upload_styles');
    wp_enqueue_style('kh_uploader_edit_styles');
    wp_enqueue_style('kh_uploader_home_styles');
    wp_enqueue_script('kh_uploader_delete_script');
 }

 add_action('wp_enqueue_scripts', 'kh_plugin_enqueue_scripts_and_styles');




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


function render_kh_meetings(){
    global $wpdb;
    $table = $wpdb->prefix . 'meetings';

    $page = isset($_GET['page_num']) ? intval($_GET['page_num']) : 1;
    $perPage = 10;
    $offset = ($page - 1) * $perPage;
    if ($offset < 0) {
    $offset = 0;
    $page = 1;
    }
    $query = $wpdb->prepare("SELECT * FROM {$table} ORDER BY time DESC LIMIT %d OFFSET %d", $perPage, $offset);
    $data = $wpdb->get_results($query);

    $meetings = '
      <div class="kh-table-wrap">
        <table>
        <tr>
            <td>Date/Time</td>
            <td>Location</td>
            <td>Meeting Type</td>
            <td>File Type</td>
            <td>Link</td>
        </tr>';
      //need to hook up the buttons here to actually do things';
      foreach($data as $entry){
        $row = '';
        $row .= '<tr><td>'.$entry->time.'</td>';
        $row .= '<td>'.$entry->location.'</td>';
        $row .= '<td>'.$entry->meeting_type.'</td>';
        $row .= '<td>'.$entry->file_type.'</td>';
        $row .= '<td><a href="'.$entry->file_path.'" target="_blank">File</a></td></tr>';
        $meetings .= $row;
        }
        $meetings .= '</table></div>';




        $numEntries = $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
        $numPages = ceil($numEntries / $perPage);
        $currentUrl = $_SERVER['REQUEST_URI'];

        $meetings .= '<div class="kh-pagination">';
        for ($i = 1; $i <= $numPages; $i++) {
            $url = add_query_arg('page_num', $i, $currentUrl);
            $active = ($i === $page) ? ' active' : '';
            $meetings .= "<a href=\"{$url}\" class=\"{$active}\">{$i}</a>";
        }
        $meetings .= '</div>';

        return $meetings;
}
add_shortcode('kh_meetings', 'render_kh_meetings');

