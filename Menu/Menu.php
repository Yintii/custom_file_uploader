<?php
    if(isset($_POST['submit'])){
        echo "Submit detected!";
        print_r($_POST);
        print_r($_FILES);
    }
?>


<form id="kh_meeting_upload_form" action="" method="POST" enctype="multipart/form-data">
    <input type="datetime-local" name="datetime" />
    <select name="location" >
        <option value="none" disabled selected hidden>Select Location</option>
        <option>L#1</option>
        <option>L#2</option>
        <option>L#3</option>
        <option>L#4</option>
        <option>L#5</option>
    </select>
    <select name="meeting_type" >
        <option value="none" disabled selected hidden>Select Meeting Type</option>
        <option>MT#1</option>
        <option>MT#2</option>
        <option>MT#3</option>
        <option>MT#4</option>
        <option>MT#5</option>
    </select>
    <select name="file_type" >
        <option value="none" disabled selected hidden>Select File Type</option>
        <option>FT#1</option>
        <option>FT#2</option>
        <option>FT#3</option>
        <option>FT#4</option>
        <option>FT#5</option>
    </select>
    <input type="file" name="fileData" accept=".pdf"/>
    <input type="submit" name="submit" value="submit" />

</form>

<style>
    #kh_meeting_upload_form{
        display: flex;
        flex-flow: column nowrap;
        margin: 1rem auto;
    }
    #kh_meeting_upload_form input, #kh_meeting_upload_form select{
        width: 400px;
        margin: 1rem auto;
    }
</style>