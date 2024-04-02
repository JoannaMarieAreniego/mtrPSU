<?php
include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studID = $_POST["studID"];

    $query = "DELETE FROM users WHERE studID = '$studID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method"));
}

?>
