<!-- groupCreate.php -->
<?php
require "0conn.php";

session_start();
if(isset($_SESSION['studID']) && isset($_POST['groupID'])){
    if(isset($_POST['title']) && isset($_POST['content'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $groupID = $_POST['groupID'];
        $studID = $_SESSION['studID'];

    $targetDir = "images/"; 
    $uploadOk = 1;

    $postImage = "";
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
    
    $filePathsStr = implode(',', $fileNames);

    $query = "INSERT INTO group_posts (groupID, title, content, studID, file_path) VALUES ('$groupID', '$title', '$content', '$studID', '$filePathsStr')";
        if(mysqli_query($conn, $query)){
            echo "Post created successfully";
        } else {
            echo "Error creating post: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request: Missing title or content";
    }
} else {
    echo "Invalid request: User not logged in or groupID not set";
}
?>
