<?php
  wp_enqueue_style('kh_uploader_edit_styles');

  global $wpdb;
  $table = $wpdb->prefix . 'meetings';
  $query = $wpdb->prepare(" SELECT * FROM {$table} " );
  $data = $wpdb->get_results($query);

  $locations_array = array(
    'L#1',
    'L#2',
    'L#3',
    'L#4',
    'L#5',
  );

  $meeting_types_array = array(
    'MT#1',
    'MT#2',
    'MT#3',
    'MT#4',
    'MT#5',
  );

  $file_types_array = array(
    'FT#1',
    'FT#2',
    'FT#3',
    'FT#4',
    'FT#5',
  );



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
          //hidden form pre-filled with each items information so when 
          //edit is chosen only these variables are passed to be edited
          echo '<td><form action="" method="POST">';
          echo '<input type="text"   name="id"           value="' . $entry->id           . '"  hidden />';
          echo '<input type="text"   name="datetime"     value="' . $entry->time         . '"  hidden />';
          echo '<input type="text"   name="location"     value="' . $entry->location     . '"  hidden />';
          echo '<input type="text"   name="meeting_type" value="' . $entry->meeting_type . '"  hidden />';
          echo '<input type="text"   name="file_type"    value="' . $entry->file_type    . '"  hidden />';
          echo '<input type="text"   name="file_url"     value="' . $entry->file_path    . '"  hidden />';
          echo '<input type="text"   name="edit"         value="edit"                          hidden />';
          echo '<input type="submit" name="submit"       value="edit" />';
          echo '</form></td>';
          echo '<td><form action="" method="POST">';
          echo '<input type="number" name="id" value="'. $entry->id .'" hidden />';
          echo '<input type="submit" name="delete" value="delete" />';
          echo '</form></td>';
          echo '</tr>';
        }
}

if(isset($_POST['edit'])){
  ?>
  <div class="kh-table-wrap">
    <form>
    <input type="number"         name="id"       value="<?php echo $_POST['id']; ?>"       hidden required/>
    <input type="datetime-local" name="datetime" value="<?php echo $_POST['datetime']; ?>"        required/>

    <select name="location" required>
        <?php 
          foreach($locations_array as $location){
            if($_POST['location'] == $location){
              echo '<option selected>' . $location . '</option>';
            }else{
              echo '<option>' . $location .  '</option>';
            }
          }
        ?>
    </select>
    <select name="meeting_type" required>
          <?php 
            foreach($meeting_types_array as $meeting_type){
              if($_POST['meeting_type'] == $meeting_type){
                echo '<option selected>' . $meeting_type . '</option>';
              }else{
                echo '<option>' . $meeting_type . '</option>';
              }
            }
          ?>
    </select>
    <select name="file_type" required>
          <?php 
            foreach($file_types_array as $file_type){
              if($_POST['file_type'] == $file_type){
                echo '<option selected>' . $file_type . '</option>';
              }else{
                echo '<option>' . $file_type . '</option>';
              }
            }
          ?>
    </select>
    <input type="file" name="fileData" accept=".pdf" required/>
    <input type="submit" name="submit" value="submit" />
    </form>
  </div>

<?php
}





if(isset($_POST['delete']) && isset($_POST['id'])){
  try {
    $wpdb->delete(
      $wpdb->prefix . 'meetings',
      ['id' => $_POST['id']],
      ['%d'],
    );
    echo 'Successfully deleted entry';
  } catch (Exception $e) {
    echo 'There was an error deleting the entry: ' . $e-getMessage();
  }

}

?>
    </table>
  </div>

<?php

