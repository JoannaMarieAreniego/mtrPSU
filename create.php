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
    $postImage2 = "";
    $postImage3 = "";
    $postImage4 = "";
    $postImage5 = "";

    if(isset($_FILES['image1']) && $_FILES['image1']['size'] > 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($_FILES["image1"]["name"]);

        if ($_FILES["image1"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile)) {
                $postImage = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if(isset($_FILES['image2']) && $_FILES['image2']['size'] > 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($_FILES["image2"]["name"]);

        if ($_FILES["image2"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile)) {
                $postImage2 = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if(isset($_FILES['image3']) && $_FILES['image3']['size'] > 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image3']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($_FILES["image3"]["name"]);

        if ($_FILES["image3"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile)) {
                $postImage3 = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if(isset($_FILES['image4']) && $_FILES['image4']['size'] > 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image4']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($_FILES["image4"]["name"]);

        if ($_FILES["image4"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image4"]["tmp_name"], $targetFile)) {
                $postImage4 = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if(isset($_FILES['image5']) && $_FILES['image5']['size'] > 0) {
        $imageFileType = strtolower(pathinfo($_FILES['image5']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . basename($_FILES["image5"]["name"]);

        if ($_FILES["image5"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image5"]["tmp_name"], $targetFile)) {
                $postImage5 = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    $query = "INSERT INTO posts (title, content, postImage, postImage2, postImage3, postImage4, postImage5, studID) VALUES ('$title','$content', '$postImage', '$postImage2', '$postImage3', '$postImage4', '$postImage5', '$studID')";
    if(mysqli_query($conn,$query)){
        echo "Post created successfully";
    } else {
        echo "Error creating post: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request";
}
?>
