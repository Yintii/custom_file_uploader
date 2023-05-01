<?php
    wp_enqueue_style('kh_uploader_upload_styles');

    function upload_doc(){
        require_once( dirname(__FILE__) . '/../../../../wp-load.php' );

        // it allows us to use wp_handle_upload() function
        require_once( ABSPATH . 'wp-admin/includes/file.php' );

        $target_dir = content_url();
        $target_file = $target_dir . basename($_FILES["fileData"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            echo "<br />";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileData"]["size"] > 50_000_000) {
            echo "Sorry, your file is too large.";
            echo "<br />";
            echo "File size: " . $_FILES["fileData"]["size"];
            echo "<br />";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($fileType !== "pdf") {
            if($fileType == null){
            return;
            }else{
            echo "Sorry, docx and pdf files are allowed.";
            echo "<br />";
            $uploadOk = 0;
            }
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            echo "<br />";
        // if everything is ok, try to upload file
        } else {
            $upload = wp_upload_bits($_FILES["fileData"]["name"], null, file_get_contents( $_FILES["fileData"]["tmp_name"]));

            if ($upload) {
                return $upload['url'];
            } else {
                echo "Sorry, there was an error uploading your file.";
                echo "<br />";
                return;
            }
        }
    }

    function writeData(
        $date_time,
        $location,
        $meeting_type,
        $file_type,
        $file_url
    ){
        global $wpdb;

        $table = $wpdb->prefix . 'meetings';

        $data = array(
            'time' => $date_time,
            'location' => $location,
            'meeting_type' => $meeting_type,
            'file_type' => $file_type,
            'file_path' => $file_url
        );

        $format = array(
            '%s', #datetime
            '%s', #location
            '%s', #meeting_type
            '%s', #file_type
            '%s', #file_url
        );

        try {
            $wpdb->insert($table, $data, $format);
        } catch (Exception $e) {
            echo 'Failed to insert the data to the database' . $e->getMessage();
        }

    }

    //if the request is a POST request, 
    //get the url parameters, upload the pdf file,
    //submit contents to database
    if(isset($_POST['submit'])){
        $dt = $_POST['datetime'];
        $loc = $_POST['location'];
        $mt = $_POST['meeting_type'];
        $ft = $_POST['file_type'];
        $upload_url = upload_doc($_FILES['fileData']);
        writeData($dt, $loc, $mt, $ft, $upload_url);
    }
?>

    <div class="kh-menu-header">
        <h1>Meeting managment tool</h1>
        <hr />
        <span>From Innovision Marketing Group</span>
    </div>
<form id="kh_meeting_upload_form" action="" method="POST" enctype="multipart/form-data">
    <input type="datetime-local" name="datetime" required/>
    <select name="location" required>
        <option value="" disabled selected hidden>Select Location</option>
        <option>2185 Citracado Pkwy, 1st Floor Conference Room</option>
        <option>2125 Citracado Parkway, Suite 300</option>
        <option>2125 Citracado Parkway, Suite 300/Virtual</option>
        <option>Fairmount Scottsdale Princess, Scottsdale AZ</option>
        <option>Virtual</option>
    </select>
    <select name="meeting_type" required>
        <option value="" disabled selected hidden>Select Meeting Type</option>
        <option>Finance Committee</option>
        <option>Notice of Attendance</option>
        <option>Board of Directors Special Session</option>
        <option>Board of Directors Special Closed Session</option>
        <option>Board of Directors Special Finance Session</option>
        <option>Board of Directors Regular Session</option>
        <option>Board Governance Committee</option>
        <option>Board Community Relations Committee</option>
        <option>Strategic & Facilities Planning</option>
        <option>Board Quality Review Meeting</option>
        <option>Human Resources Committee</option>
        <option>Quality Review – Notice of Cancellation</option>
        <option>Board Audit & Compliance Session</option>
        <option>Leadership Conference</option>
    </select>
    <select name="file_type" required>
        <option value="" disabled selected hidden>Select File Type</option>
        <option>Agenda</option>
        <option>Information Packet</option>
        <option>Minutes</option>
        <option>Notice - General</option>
        <option>Notice - Date Change</option>
        <option>Notice - Location Change</option>
        <option>Notice - Cancellation</option>
        <option>Notice - Attendance</option>
    </select>
    <input type="file" name="fileData" accept=".pdf" required/>
    <input type="submit" name="submit" value="Submit" />
    <?php
        if(isset($_POST['submit'])){
            echo '<span class="kh-success-msg">Success!</span>';
        }
    ?>
</form>