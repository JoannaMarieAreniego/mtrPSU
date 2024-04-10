<?php
include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postID']) && isset($_POST['status'])) {
    $postID = $_POST['postID'];
    $status = $_POST['status'];

    $query = "UPDATE reports SET status = '$status' WHERE postID = '$postID'";
    $result = mysqli_query($conn, $query);

    $queryPost = "UPDATE posts SET report = '$status' WHERE postID = '$postID'";
    $results = mysqli_query($conn, $queryPost);

    if ($result) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postID']) && isset($_POST['status'])) {
    $postID = $_POST['postID'];
    $status = $_POST['status'];

    if ($status === 'Rejected') {
        // Insert the rejected post into the rejectedReports table
        $query = "INSERT INTO rejectedreports (reportID, postID, reporterID, reason, report_created_at) 
                  SELECT reportID, postID, reporterID, reason, report_created_at 
                  FROM reports WHERE postID = '$postID'";
        $result = mysqli_query($conn, $query);

        // Delete the rejected post from the reports table
        $deleteQuery = "DELETE FROM reports WHERE postID = '$postID'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($result && $deleteResult) {
            echo "Post rejected and moved to rejectedReports table successfully.";
        } else {
            echo "Error rejecting post: " . mysqli_error($conn);
        }
    } else if ($status === 'Approved') {
        // Insert the accepted post into the acceptReports table
        $query = "INSERT INTO accept_reports (reportID, postID, reporterID, reason, report_created_at) 
                  SELECT reportID, postID, reporterID, reason, report_created_at 
                  FROM reports WHERE postID = '$postID'";
        $result = mysqli_query($conn, $query);

        // Delete the accepted post from the reports table
        $deleteQuery = "DELETE FROM reports WHERE postID = '$postID'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($result && $deleteResult) {
            echo "Post accepted and moved to acceptReports table successfully.";
        } else {
            echo "Error accepting post: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid status.";
    }
} else {
    echo "Invalid request.";
}
?>
