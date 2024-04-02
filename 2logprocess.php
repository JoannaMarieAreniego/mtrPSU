<?php
include("0conn.php");

ob_clean();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studID = $_POST["studID"];
    $password = $_POST["password"];

    if ($studID === "admin" && $password === "admin123") {
        session_start();
        $_SESSION['studID'] = $studID;
        echo json_encode(array("status" => "success", "type" => "admin"));
        exit; // Stop further execution
    }

    $query = "SELECT * FROM users WHERE studID = '$studID' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        echo json_encode(array("status" => "success", "type" => "customer"));
        session_start();
        $_SESSION['studID'] = $studID;
    } else {
        echo json_encode(array("status" => "error"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
