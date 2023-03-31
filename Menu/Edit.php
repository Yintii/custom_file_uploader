<?php
  wp_enqueue_style('kh_uploader_edit_styles');
  wp_enqueue_script('kh_uploader_delete_script');

  global $wpdb;
  $table = $wpdb->prefix . 'meetings';
  $query = $wpdb->prepare("SELECT * FROM {$table}");
  $data = $wpdb->get_results($query);


if(isset($_POST['delete']) && isset($_POST['id'])){
  try {
    $wpdb->delete(
      $wpdb->prefix . 'meetings',
      ['id' => $_POST['id']],
      ['%d'],
    );
    wp_redirect('/wp-admin/admin.php?page=kh_meeting_uploader_edit');
  } catch (Exception $e) {
    echo 'There was an error deleting the entry: ' . $e-getMessage();
  }

}


if(!isset($_POST['submit'])){
  ?>
  <div class="kh-table-wrap">
    <table>
      <tr>
        <td>Date/Time</td>
        <td>Location</td>
        <td>Meeting Type</td>
        <td>File Type</td>
        <td>Link</td>
      </tr>

      <?php
      //need to hook up the buttons here to actually do things
      foreach($data as $entry){
          echo '<tr>';
          echo '<td>'.$entry->time.'</td>';
          echo '<td>'.$entry->location.'</td>';
          echo '<td>'.$entry->meeting_type.'</td>';
          echo '<td>'.$entry->file_type.'</td>';
          echo '<td><a href="'.$entry->file_path.'" target="_blank">File</a></td>';
          echo '<td><form action="" method="POST">';
          echo '<input type="number" name="id" value="'. $entry->id .'" hidden />';
          echo '<input type="submit" name="delete" value="delete" onclick="deleteEntry()" />';
          echo '</form></td>';
          echo '</tr>';
        }
}

?>
    </table>
  </div>
<?php

