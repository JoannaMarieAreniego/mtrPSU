<?php
include("0conn.php");

$query = "SELECT * FROM users WHERE studID != 'admin'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Student ID</th><th>Firstname</th><th>Lastname</th><th>Username</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['studID'] . "</td>";
        echo "<td>" . $row['firstname'] . "</td>";
        echo "<td>" . $row['lastname'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td><button class='btnd' onclick=\"deleteUser('" . $row['studID'] . "')\">Delete</button></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}
?>
