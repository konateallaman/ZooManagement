
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title>New Animal</title>
    <style>
        .form-group {
            background-color: lightgray;
            text-align: center;
        }
       body {
        min-height: 100vh;
    }
        
    </style>
</head>
<body >
<header>
    <div class="logo">
        <img src="./icons/safari.png" alt="Your logo">
    </div>
    <div class="username">
       
    </div>
</header>
<div class="navbar">
    <a href="AdminMenu.php"><i class="fa fa-home"></i> Home</a>


     <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>
<br><br>
<div class="container"> 
<form method="POST">
    <label>Filter by:</label>
    <select name="filter">
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        
    </select>
    <input type="submit" value="Filter" class="btn btn-primary">
</form>
<?php
// Connect to the database
require_once "./connection/connect.inc.php";

// Get the filter option selected by the user
$filter = isset($_POST['filter']) ? $_POST['filter'] : 'daily';



// Display the results as a chart
if ($filter == 'daily') {
    $sql = "SELECT date_created, COUNT(*) as num_visitors FROM visitors GROUP BY DATE(date_created)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>Daily visitor's Report</h2>";
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<thead style="background-color: mediumspringgreen">';
        echo "<tr>";
        echo "<th>Date</th>";
        echo "<th>Number of Visitors</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $dates = [];
        $num_visitors = [];
        while ($row = $result->fetch_assoc()) {
            array_push($dates, date('Y-m-d', strtotime($row['date_created'])));
            array_push($num_visitors, $row['num_visitors']);
            echo "<tr>";
            date_default_timezone_set('America/New_York'); // Replace 'America/New_York' with the user's timezone
            echo "<td>" . date('Y-m-d', strtotime($row['date_created'])) . "</td>";
            echo "<td>" . $row['num_visitors'] . "</td>";
            echo "</tr>";
        }
        $sql = "SELECT COUNT(*) as total_visitors FROM visitors";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_visitors = $row['total_visitors'];
        echo "<tfoot>";
        echo "<tr>";
        echo "<td><b>Total:</b></td>";
        echo "<td><b>$total_visitors</b></td>";
        echo "</tr>";
        echo "</tfoot>";
        echo "</tbody>";
        echo "</table>";
        echo '</div>';
        // Create the daily chart canvas
        echo '<canvas id="dailyChart" width="400" height="200"></canvas>';
        // Create the daily chart data in JSON format
        $daily_chart_data = [
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => 'Number of Visitors',
                    'data' => $num_visitors,
                    'backgroundColor' => 'yellow'
                ]
            ]
        ];
        $daily_chart_data_json = json_encode($daily_chart_data);
        // Add the daily chart script
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo '<script>
        var ctx = document.getElementById("dailyChart").getContext("2d");
        var dailyChart = new Chart(ctx, {
            type: "line",
            data: ' . $daily_chart_data_json . ',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
},
plugins: {
title: {
display: true,
text: "Daily Visitors"
}
}
});
</script>';
} else {
echo "<p>No data to display.</p>";
}

}elseif ($filter == 'weekly') {
$sql = "SELECT YEAR(date_created) as year, WEEK(date_created) as week, COUNT(*) as num_visitors FROM visitors GROUP BY YEAR(date_created), WEEK(date_created)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// Display the weekly chart
echo "<h2>Weekly visitor's Report</h2>";
echo '<div class="table-responsive">';
echo '<table class="table table-striped table-bordered table-hover">';
echo '<thead style="background-color: mediumspringgreen">';
echo "<tr>";
echo "<th>Year</th>";
echo "<th>Week</th>";
echo "<th>Number of Visitors</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$weeks = [];
$num_visitors = [];
while ($row = $result->fetch_assoc()) {
$week = 'Week ' . $row['week'] . ', ' . $row['year'];
array_push($weeks, $week);
array_push($num_visitors, $row['num_visitors']);
echo "<tr>";
echo "<td>" . $row['year'] . "</td>";
echo "<td>" . $week . "</td>";
echo "<td>" . $row['num_visitors'] . "</td>";
echo "</tr>";
}
$sql = "SELECT COUNT() as total_visitors FROM visitors";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_visitors = $row['total_visitors'];
echo "<tfoot>";
echo "<tr>";
echo "<td colspan='2'><b>Total:</b></td>";
echo "<td><b>$total_visitors</b></td>";
echo "</tr>";
echo "</tfoot>";
echo "</tbody>";
echo "</table>";
echo '</div>';
// Create the weekly chart canvas
echo '<canvas id="weeklyChart" width="400" height="200"></canvas>';
// Create the weekly chart data in JSON format
$weekly_chart_data = [
'labels' => $weeks,
'datasets' => [
[
'label' => 'Number of Visitors',
'data' => $num_visitors,
'backgroundColor' => 'yellow'
]
]
];
$weekly_chart_data_json = json_encode($weekly_chart_data);
// Add the weekly chart script
echo '<script>
var ctx = document.getElementById("weeklyChart").getContext("2d");
var weeklyChart = new Chart(ctx, {
type: "line",
data: ' . $weekly_chart_data_json . ',
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});
</script>';
} else {
echo "No weekly visitors found";
}
}
$conn->close();
?>
</div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>