<?php
require "0conn.php";

session_start();

if(isset($_POST['title']) && isset($_POST['content'])){
    $title = $_POST['title'];
    $content = $_POST['content'];

    $studID = $_SESSION['studID'];

    $targetDir = "images/"; 
    $uploadOk = 1;

    $postImage = "";
 
        $files = $_FILES['images'];
        $uploadPath = 'images/';
        $fileNames = array();
    
    // Check if any files were uploaded
    if (!empty($files['tmp_name'][0])) {
        foreach($files['tmp_name'] as $key => $tmp_name){
            $fileName = $files['name'][$key];
            $fileTmpName = $files['tmp_name'][$key];
            $fileType = $files['type'][$key];
            $fileSize = $files['size'][$key];
    
            $filePath = $uploadPath . $fileName;
    
            // // Check file size (500 KB)
            // if ($fileSize > 500000) {
            //     echo "Error: Sorry, your file " . $fileName . " is too large.";
            //     $uploadOk = 0;
            //     continue; // Skip this file
            // }
    
            // Check file type
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowedTypes)) {
                echo "Error: Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                $uploadOk = 0;
                continue; // Skip this file
            }
    
            // Move the file if all checks pass
            if(move_uploaded_file($fileTmpName, $filePath)){
                $fileNames[] = $filePath;
            } 
            // else {
            //     echo "Error: Sorry, there was an error uploading your file " . $fileName . ".";
            //     $uploadOk = 0;
            // }
        }
    } else {
        // No files were uploaded, proceed with creating the post
    }
    
    if ($uploadOk == 1 || empty($files['tmp_name'][0])) {
        $filePathsStr = implode(',', $fileNames);
        $query = "INSERT INTO posts (title, content, file_path, studID) VALUES ('$title','$content', '$filePathsStr', '$studID')";
        if(mysqli_query($conn,$query)){
            echo "Post created successfully";
        } else {
            echo "Error creating post: " . mysqli_error($conn);
        }
    } else {
        echo " One or more files failed to upload. Post creation aborted.";
    }
    
    

} else {
    echo "Invalid request";
}
?>
