<form id="imageUploadForm" action="hatdog.php" method="post" enctype="multipart/form-data">
    <input type="file" name="images[]" id="images" multiple>
    <input type="submit" value="Upload Images" name="submit">


    <!-- Display uploaded images -->
<div id="uploadedImages">
    <?php
    require '0conn.php';
    $result = mysqli_query($conn, "SELECT * FROM images");
    while ($row = mysqli_fetch_assoc($result)) {
        $filePaths = explode(',', $row['file_path']);
        foreach ($filePaths as $filePath) {
            echo '<img src="' . $filePath . '" alt="Uploaded Image">';
        }
    }
    ?>
</div>

</form>
<?php

require '0conn.php';

if(isset($_POST['submit'])){
    $files = $_FILES['images'];
    $uploadPath = 'images/';
    $fileNames = array();

    foreach($files['tmp_name'] as $key => $tmp_name){
        $fileName = $files['name'][$key];
        $fileTmpName = $files['tmp_name'][$key];
        $fileType = $files['type'][$key];

        $filePath = $uploadPath . $fileName;

        if(move_uploaded_file($fileTmpName, $filePath)){
            $fileNames[] = $filePath;

            
        }
    }

    // Save $fileNames to database
    $filePathsStr = implode(',', $fileNames);
    $query = "INSERT INTO images (file_path) VALUES ('$filePathsStr')";

    mysqli_query($conn, $query);
}
?>
