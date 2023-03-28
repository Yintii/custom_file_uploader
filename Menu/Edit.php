<?php
  wp_enqueue_style('kh_uploader_edit_styles');

  global $wpdb;

  $table = $wpdb->prefix . 'meetings';

  $query = $wpdb->prepare(" SELECT * FROM {$table} " );

  $data = $wpdb->get_results($query);

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
        echo '<input type="text" name="edit" value="edit" hidden />';
        echo '<input type="submit" name="submit" value="edit" />';
        echo '</form></td>';
        echo '<td><form action="" method="DELETE">';
        echo '<input type="submit" name="submit" value="Delete" />';
        echo '</form></td>';
        echo '</tr>';
      } 
    

          ?>
        </table>
      </div>



<?php

