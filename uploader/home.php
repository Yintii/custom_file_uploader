<?php 
    wp_enqueue_style('kh_uploader_home_styles')
?>


<div id="kh-home-menu">
    <div class="kh-menu-header">
        <h1>Meeting managment tool</h1>
        <hr />
        <span>From Innovision Marketing Group</span>
    </div>
  
    <div class="kh-menu-wrap">
        <div class="kh-menu-content">
            <div class="kh-bubble-content">
                <h2>Upload new meetings</h2>
                <a href="/wp-admin/admin.php?page=kh_meeting_uploader_upload">Upload</a>
            </div>
            <div class="kh-bubble-content">
                <h2>Manage exisiting meetings</h2>
                <a href="/wp-admin/admin.php?page=kh_meeting_uploader_edit" >Manage</a>
            </div>
        </div>
    </div>
</div>
