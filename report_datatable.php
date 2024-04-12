<!-- report_databale.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Reports Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php
require("0conn.php");

$query = "SELECT * FROM accept_reports";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
?>
    <table>
        <tr>
            <th>acceptID</th>
            <th>reportID</th>
            <th>postID</th>
            <th>reporterID</th>
            <th>reason</th>
            <th>report_created_at</th>
            <th>status</th>
            <th>accepted_date</th>
        </tr>
    <?php
        while($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <td><?= $row['acceptID'] ?></td>
            <td><?= $row['reportID'] ?></td>
            <td><?= $row['postID'] ?></td>
            <td><?= $row['reporterID'] ?></td>
            <td><?= $row['reason'] ?></td>
            <td><?= $row['report_created_at'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['accepted_date'] ?></td>
        </tr>
    <?php
        }
    ?>
    </table>
    <form method="post" action="export.php">
        <button type="submit">Export to CSV</button>
    </form>
    
<?php
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

</body>
</html>
