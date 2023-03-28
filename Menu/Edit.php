<?php
  global $wpdb;

  $table = $wpdb->prefix . 'meetings';

  $query = $wpdb->prepare(" SELECT * FROM {$table} " );

  $data = $wpdb->get_results($query);

  ?>
  <table>
    <tr>
      <td>Date/Time</td>
      <td>Location</td>
      <td>Meeting Type</td>
      <td>File Type</td>
      <td>Link</td>
    </tr>
    <?php
      foreach($data as $entry){
        echo '<tr>';
        echo '<td>'.$entry->time.'</td>';
        echo '<td>'.$entry->location.'</td>';
        echo '<td>'.$entry->meeting_type.'</td>';
        echo '<td>'.$entry->file_type.'</td>';
        echo '<td><a href="'.$entry->file_path.'" target="_blank">File</a></td>';
        echo '<td><button>Edit</button></td>';
        echo '<td><button>Delete</button></td>';
        echo '</tr>';
      } 
    ?>
</table>



<?php

