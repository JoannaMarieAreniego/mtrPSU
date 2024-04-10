<?php
include("0conn.php");

$query = "SELECT * FROM reports";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Post ID</th><th>Reporter ID</th><th>Reason</th><th>report_created_at</th><th>Status</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['postID'] . "</td>";
        echo "<td>" . $row['reporterID'] . "</td>";
        echo "<td>" . $row['reason'] . "</td>";
        echo "<td>" . $row['report_created_at'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>
            <button class='btnd' onclick='acceptPost(" . $row['postID'] . ")'>Accept</button>
            <button class='btnd' onclick='rejectPost(" . $row['postID'] . ")'>Reject</button></td>";


        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}
?>
