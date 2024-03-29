<?php
include("0conn.php");

ob_clean();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $studID = $_POST["studID"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpass = $_POST["confirmpass"];

    $check_query = "SELECT * FROM users WHERE studID = '$studID'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(array("status" => "error", "message" => "User with the same Student ID already exists"));
    } else {
        $query = "INSERT INTO users (firstname, lastname, studID, username, password) 
                  VALUES ('$firstname', '$lastname', '$studID', '$username', '$password')";
    
        $result = mysqli_query($conn, $query);
    
        if ($result) {
            echo json_encode(array("status" => "success", "message" => "User added successfully!"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error adding user to the database: " . mysqli_error($conn)));
        }
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
