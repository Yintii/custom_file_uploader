<?php
  wp_enqueue_style('kh_uploader_edit_styles');
  wp_enqueue_script('kh_uploader_delete_script');

  $abspath = $_SERVER['DOCUMENT_ROOT'];

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

if(isset($_POST['delete']) && isset($_POST['id']) && isset($_POST['file_path'])){
  try {
    $wpdb->delete(
      $wpdb->prefix . 'meetings',
      ['id' => $_POST['id']],
      ['%d'],
    );

    $url = 'localhost' . $_POST['file_path'];
    $path = parse_url($url, PHP_URL_PATH);
    unlink($abspath . $path);

    wp_redirect('/wp-admin/admin.php?page=kh_meeting_uploader_edit');
  } catch (Exception $e) {
    echo 'There was an error deleting the entry: ' . $e-getMessage();
  }

}


if(!isset($_POST['submit'])){
  ?>
  <div class="kh-menu-header">
      <h1>Meeting managment tool</h1>
      <hr />
      <span>From Innovision Marketing Group</span>
  </div>
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
          echo '<input type="text" name="file_path" value="' . $entry->file_path . '" hidden />';
          echo '<input type="submit" name="delete" value="delete" onclick="deleteEntry(event)" />';
          echo '</form></td>';
          echo '</tr>';
        }
}

?>
    </table>
  </div>
<?php

$numEntries = $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
$numPages = ceil($numEntries / $perPage);
$currentUrl = $_SERVER['REQUEST_URI'];

echo '<div class="kh-pagination">';
for ($i = 1; $i <= $numPages; $i++) {
  $url = add_query_arg('page_num', $i, $currentUrl);
  $active = ($i === $page) ? ' active' : '';
  echo "<a href=\"{$url}\" class=\"{$active}\">{$i}</a>";
}
echo '</div>';
