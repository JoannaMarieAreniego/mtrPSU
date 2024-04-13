<?php
include "0conn.php";
session_start();
if (empty($_SESSION["studID"])) {
    header("Location: logintry.php");
    exit();
}

$studID = $_SESSION["studID"];

// Fetching data for Pie Chart 1 (Report About)
$reportAboutData = [];
$reportAboutQuery = "SELECT reason as reportAbout, COUNT(*) as count FROM accept_reports WHERE reason <> '' GROUP BY reason";
$reportAboutResult = $conn->query($reportAboutQuery);

if ($reportAboutResult->num_rows > 0) {
    while ($row = $reportAboutResult->fetch_assoc()) {
        $reportAboutData[] = [$row['reportAbout'], (int)$row['count']];
    }
}

// Fetching data for Pie Chart 2 (Status)
$statusData = [];
$statusQuery = "SELECT report, COUNT(*) as count FROM posts WHERE report <> '' GROUP BY report";
$statusResult = $conn->query($statusQuery);

if ($statusResult->num_rows > 0) {
    while ($row = $statusResult->fetch_assoc()) {
        $statusData[] = [$row['report'], (int)$row['count']];
    }
}

// Fetching data for Line Chart (Registered Users Over Time)
$registeredUsersData = [];
$registeredUsersQuery = "SELECT DATE_FORMAT(date_registered, '%Y-%m-%d') AS registration_date, COUNT(*) AS count FROM users GROUP BY registration_date";
$registeredUsersResult = $conn->query($registeredUsersQuery);

if ($registeredUsersResult->num_rows > 0) {
  while ($row = $registeredUsersResult->fetch_assoc()) {
    $registeredUsersData[] = [$row['registration_date'], (int)$row['count']];
  }
}

// Fetching data for Pie Chart (Users by Course)
$usersByCourseData = [];
$usersByCourseQuery = "SELECT course, COUNT(*) AS count FROM users WHERE studID != 'admin' GROUP BY course";
$usersByCourseResult = $conn->query($usersByCourseQuery);

if ($usersByCourseResult->num_rows > 0) {
    while ($row = $usersByCourseResult->fetch_assoc()) {
        $usersByCourseData[] = [$row['course'], (int)$row['count']];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart() {
            var reportAboutData = <?php echo json_encode($reportAboutData); ?>;
            var data = google.visualization.arrayToDataTable([
                ['Post Reports', 'Count'],
                <?php
                foreach ($reportAboutData as $data) {
                    echo "['" . $data[0] . "', " . $data[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Report About',
                backgroundColor: '#f8f9fa', 
                titleTextStyle: { color: '#343a40', fontSize: 24 },
                legendTextStyle: { color: '#343a40' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }

        function drawChart2() {
            var statusData = <?php echo json_encode($statusData); ?>;
            var data = google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                <?php
                foreach ($statusData as $data) {
                    echo "['" . $data[0] . "', " . $data[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Status',
                backgroundColor: '#f8f9fa',
                titleTextStyle: { color: '#343a40', fontSize: 24 }, 
                legendTextStyle: { color: '#343a40' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart.draw(data, options);
        }

        google.charts.setOnLoadCallback(drawChart3);

        function drawChart3() {
            var registeredUsersData = <?php echo json_encode($registeredUsersData); ?>;
            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Date');
            data.addColumn('number', 'Registered Users');

            registeredUsersData.forEach(function(user) {
                user[0] = new Date(user[0].split('-')[0], user[0].split('-')[1] - 1, user[0].split('-')[2]);
            });

            data.addRows(registeredUsersData);

            var options = {
                title: 'Registered Users Over Time',
                backgroundColor: '#f8f9fa',
                titleTextStyle: { color: '#343a40', fontSize: 24 }, 
                legendTextStyle: { color: '#343a40' },
                hAxis: {
                    title: 'Date',
                    format: 'MMM dd yyyy'
                },
                vAxis: {
                    title: 'Number of Users'
                },
                width: '100%',
                height: 400
            };

            var chart = new google.visualization.LineChart(document.getElementById('linechart'));
            chart.draw(data, options);
        }

        google.charts.setOnLoadCallback(drawChart4);

        function drawChart4() {
            var usersByCourseData = <?php echo json_encode($usersByCourseData); ?>;
            var data = google.visualization.arrayToDataTable([
                ['Course', 'Number of Users'],
                <?php
                foreach ($usersByCourseData as $data) {
                    echo "['" . $data[0] . "', " . $data[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Users by Course',
                backgroundColor: '#f8f9fa',
                titleTextStyle: { color: '#343a40', fontSize: 24 },
                legendTextStyle: { color: '#343a40' },
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart3'));
            chart.draw(data, options);
        }

    </script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container {
            flex: 1;
            padding: 20px;
            min-width: 1200px;
            margin: 80px auto 20px;
            width: 90%;
            max-width: 1600px; 
        }

        footer {
            background-color: #0927D8;
            color: #f8f9fa;
            padding: 20px;
            width: 100%;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .names {
            text-align: center;
        }

        .left-content {
            flex: 1;
            text-align: left;
        }

        .right-content {
            text-align: right;
        }

        .left-content p,
        .right-content p {
            margin: 0;
        }

        footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 0 10px;
            }
        }

        .btn.active {
            background-color: yellow;
            color: black
        }

        .btn:hover {
            background-color: #0056b3;
        }
        footer {
            background-color: #0927D8;
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            left: 0;
            bottom: 0;
            width: 100%;
        }
        .content-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0 auto;
        }

        .analytics-card {
            margin-top: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff; 
            width: 100%;
            max-width: 1000px;
        }

        .analytics-card h1 {
            margin-bottom: 20px;
            color: #0927D8;
        }

        .piechart-container {
            width: 50%;
            float: left;
        }

        #piechart, #piechart2 {
            width: 100%;
            height: 750px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-content .logo {
            margin-right: auto; 
        }

        .header-content h1 {
            margin-left: auto; 
        }

    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="images/psuLOGO.png" alt="">
            </div>
            <h1>PSUnian Space</h1>
        </div>
        <nav>
            <a href="dashboard.php" class="btn active">Dashboard</a>
            <a href="admin_newsfeed.php" class="btn">Newsfeed</a>
            <a href="reportedPost.php" class="btn">Reports</a>
            <a href="manageAccount.php" class="btn">Manage Accounts</a>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </header>
    <div class="container" id="postsContainer">
        <main class="content">
            <div class="content-container">
                <div class="analytics-card">
                    <div class="analytics-card">
                        <h1>Registered Users Over Time</h1>
                        <div id="linechart"></div>
                    </div>
                    <h1>Report Data Analytics</h1>
                    <div class="piechart-container">
                        <div id="piechart"></div>
                    </div>
                    <div class="piechart-container">
                        <div id="piechart2"></div>
                    </div>
                    <div class="piechart-container">
                        <div id="piechart3"></div>
                    </div>
                    <br><br>
                </div>
            </div>
        </main>
    </div>
    <footer>
        <div class="footer-content">
            <div class="left-content">
                <p>Pangasinan State University</p>
            </div>
            <div class="right-content">
                <p id="copyright"></p>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var currentYear = new Date().getFullYear();
                        document.getElementById('copyright').innerText = '© ' + currentYear + ' PSUnian Space';
                    });
                </script>
            </div>
        </div>
        <div class="names">
            <p>Janela Tamayo and Joanna Marie Areniego</p>
        </div>
    </footer>
</body>
</html>
