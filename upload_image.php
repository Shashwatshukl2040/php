<?php
// Check if image file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["screenshot"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["screenshot"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"]);


    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["screenshot"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
