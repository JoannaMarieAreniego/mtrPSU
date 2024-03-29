<?php
include("0conn.php");

ob_clean();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studID = $_POST["studID"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE studID = '$studID' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        echo json_encode(array("status" => "success"));
        session_start();
        $_SESSION['studID'] = $studID;
    } else {
        echo json_encode(array("status" => "error"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}
?>
