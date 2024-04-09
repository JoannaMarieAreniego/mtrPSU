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
    // $postImage2 = "";
    // $postImage3 = "";
    // $postImage4 = "";
    // $postImage5 = "";

    // if(isset($_FILES['image1']) && $_FILES['image1']['size'] > 0) {
    //     $imageFileType = strtolower(pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION));
    //     $targetFile = $targetDir . basename($_FILES["image1"]["name"]);

    //     if ($_FILES["image1"]["size"] > 500000) {
    //         echo "Sorry, your file is too large.";
    //         $uploadOk = 0;
    //     }

    //     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif" ) {
    //         echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //         $uploadOk = 0;
    //     }

    //     if ($uploadOk == 1) {
    //         if (move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile)) {
    //             $postImage = $targetFile;
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //         }
    //     }
    // }

    // if(isset($_FILES['image2']) && $_FILES['image2']['size'] > 0) {
    //     $imageFileType = strtolower(pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION));
    //     $targetFile = $targetDir . basename($_FILES["image2"]["name"]);

    //     if ($_FILES["image2"]["size"] > 500000) {
    //         echo "Sorry, your file is too large.";
    //         $uploadOk = 0;
    //     }

    //     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif" ) {
    //         echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //         $uploadOk = 0;
    //     }

    //     if ($uploadOk == 1) {
    //         if (move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile)) {
    //             $postImage2 = $targetFile;
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //         }
    //     }
    // }

    // if(isset($_FILES['image3']) && $_FILES['image3']['size'] > 0) {
    //     $imageFileType = strtolower(pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION));
    //     $targetFile = $targetDir . basename($_FILES["image3"]["name"]);

    //     if ($_FILES["image3"]["size"] > 500000) {
    //         echo "Sorry, your file is too large.";
    //         $uploadOk = 0;
    //     }

    //     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif" ) {
    //         echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //         $uploadOk = 0;
    //     }

    //     if ($uploadOk == 1) {
    //         if (move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile)) {
    //             $postImage3 = $targetFile;
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //         }
    //     }
    // }

    // if(isset($_FILES['image4']) && $_FILES['image4']['size'] > 0) {
    //     $imageFileType = strtolower(pathinfo($_FILES['image4']['name'], PATHINFO_EXTENSION));
    //     $targetFile = $targetDir . basename($_FILES["image4"]["name"]);

    //     if ($_FILES["image4"]["size"] > 500000) {
    //         echo "Sorry, your file is too large.";
    //         $uploadOk = 0;
    //     }

    //     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif" ) {
    //         echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //         $uploadOk = 0;
    //     }

    //     if ($uploadOk == 1) {
    //         if (move_uploaded_file($_FILES["image4"]["tmp_name"], $targetFile)) {
    //             $postImage4 = $targetFile;
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //         }
    //     }
    // }

    // if(isset($_FILES['image5']) && $_FILES['image5']['size'] > 0) {
    //     $imageFileType = strtolower(pathinfo($_FILES['image5']['name'], PATHINFO_EXTENSION));
    //     $targetFile = $targetDir . basename($_FILES["image5"]["name"]);

    //     if ($_FILES["image5"]["size"] > 500000) {
    //         echo "Sorry, your file is too large.";
    //         $uploadOk = 0;
    //     }

    //     if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif" ) {
    //         echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    //         $uploadOk = 0;
    //     }

    //     if ($uploadOk == 1) {
    //         if (move_uploaded_file($_FILES["image5"]["tmp_name"], $targetFile)) {
    //             $postImage5 = $targetFile;
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //         }
    //     }
    // }

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
