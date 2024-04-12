<?php
require("0conn.php");

$query = "SELECT * FROM accept_reports";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    $filename = "accept_reports.csv";
    $fp = fopen('php://output', 'w');
    if ($fp && $result) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        fputcsv($fp, array('acceptID', 'reportID', 'postID', 'reporterID', 'reason', 'report_created_at', 'status', 'accepted_date'));
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        exit;
    }
} else {
    echo "0 results";
}
mysqli_close($conn);
?>
