<?php
include("0conn.php");

$query = "SELECT * FROM rejectedReports";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Report ID</th><th>Post ID</th><th>Reporter ID</th><th>Reason</th><th>report_created_at</th><th>Status</th><th>rejected_at</th><th>action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['reportID'] . "</td>";
        echo "<td>" . $row['postID'] . "</td>";
        echo "<td>" . $row['reporterID'] . "</td>";
        echo "<td>" . $row['reason'] . "</td>";
        echo "<td>" . $row['report_created_at'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['rejected_date'] . "</td>";
        echo "<td><button class='btnd'>Accept</button></td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}
?>
