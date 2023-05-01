<?php
ob_start();
// start the session
session_start();
?>
<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <title>Tickets' report</title>
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   


    <style>
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
            background-color: #f5f5f5;
            padding: 10px;
            text-align: center;
        }

        /* Add custom styles for the buttons */
        .btn-admin {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
            transition: all 0.2s ease-in-out;
        }

        .btn-admin:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }


        /* Define styles for smaller screens */
        @media only screen and (max-width: 768px) {
            .logo {
                display: none;
            }

            .username {
                font-size: 1rem;
            }

            .search-container {
                font-size: 0.8rem;
            }
        }

        html, body {
            height: 110%;
        }
        .table tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
       
    }
    .table tbody tr td {
        transition: all 0.2s ease-in-out;
    }
   


    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="./icons/safari.png" alt="Your logo">
    </div>
    <div class="username">
        <?php
        include "./connection/usersession.php";
        ?>

    </div>
</header>

<div class="navbar">
    <a href="AdminMenu.php"><i class="fa fa-home"></i> Home</a>


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>

<div class="container">
    <h1>Ticket Sales Report</h1>
    <form method="get">
        <label for="filter">Filter by:</label>
        <select name="filter" id="filter">
            <option value="">--Select--</option>
            
           
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
            <option value="customer">Customer Email</option>
        </select>
        <br><br>
        
        <div id="customer-email">
            <label for="cust-email">Customer Email:</label>
            <select name="cust_email" id="cust-email">
                <option value="">--select Email--</option>
                <?php
                require_once "./connection/connect.inc.php"; //database
                // Build SQL query to get distinct customer emails
                $sql = "SELECT DISTINCT(CustEmail) FROM tickets";
                // Execute query and loop through results to populate select options
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['CustEmail'] . '">' . $row['CustEmail'] . '</option>';
                }
                ?>
            </select>
        </div>

        <br><br>
        <input type="submit" value="Apply Filter"  class="btn btn-primary">
    </form>
    <br><br>

    <?php
     if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    if ($filter == 'monthly') {
        // Monthly report
        $sql = "SELECT MONTH(purchase_date), YEAR(purchase_date) as year, COUNT(*) as num_tickets, SUM(ticket_price) as revenue FROM tickets GROUP BY MONTH(purchase_date), YEAR(purchase_date)";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Collect data for chart
            $labels = array();
            $num_tickets = array();
            $revenue = array();
            while ($row = $result->fetch_assoc()) {
                $month_year = date('F Y', strtotime($row['year'] . '-' . $row['MONTH(purchase_date)'] . '-01'));
                $labels[] = $month_year;
                $num_tickets[] = $row['num_tickets'];
                $revenue[] = $row['revenue'];
                
                // Display table
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<thead style="background-color: mediumspringgreen">';
            echo "<tr>";
            echo "<th>Month</th>";
            echo "<th>Year</th>";
            echo "<th>Number of Tickets Sold</th>";
            echo "<th>Revenue</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($labels as $i => $label) {
                echo "<tr>";
                echo "<td>" . $label . "</td>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $num_tickets[$i] . "</td>";
                echo "<td>$" . number_format($revenue[$i], 2) . "</td>";
                echo "</tr>";
            }
            }

            // Create chart
            echo "<h2>Monthly Ticket Sales Report</h2>";
            echo '<canvas id="myChart"></canvas>';
            echo '<script>';
            echo 'var ctx = document.getElementById("myChart").getContext("2d");';
            echo 'var myChart = new Chart(ctx, {';
            echo '    type: "bar",';
            echo '    data: {';
            echo '        labels: ' . json_encode($labels) . ',';
            echo '        datasets: [{';
            echo '            label: "Number of Tickets Sold",';
            echo '            data: ' . json_encode($num_tickets) . ',';
            echo '            backgroundColor: "mediumspringgreen",';
            echo '            borderColor: "mediumspringgreen",';
            echo '            borderWidth: 1';
            echo '        }, {';
            echo '            label: "Revenue",';
            echo '            data: ' . json_encode($revenue) . ',';
            echo '            backgroundColor: "lightblue",';
            echo '            borderColor: "lightblue",';
            echo '            borderWidth: 1';
            echo '        }]';
            echo '    },';
            echo '    options: {';
            echo '        scales: {';
            echo '            yAxes: [{';
            echo '                ticks: {';
            echo '                    beginAtZero: true';
            echo '                }';
            echo '            }]';
            echo '        }';
            echo '    }';
            echo '});';
            echo '</script>';

            
        }
           
        } elseif ($filter == 'daily') {
    // Daily report
        
        $sql = "SELECT purchase_date, COUNT(*) as num_tickets, SUM(ticket_price) as revenue FROM tickets GROUP BY DATE(purchase_date)";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<h2>Daily Ticket Sales Report</h2>";
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<thead style="background-color: mediumspringgreen">';
            echo "<tr>";
            echo "<th>Date</th>";
            echo "<th>Number of Tickets Sold</th>";
            echo "<th>Revenue</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $dates = [];
            $num_tickets = [];
            $revenues = [];
            while ($row = $result->fetch_assoc()) {
                array_push($dates, date('Y-m-d', strtotime($row['purchase_date'])));
                array_push($num_tickets, $row['num_tickets']);
                array_push($revenues, $row['revenue']);
                echo "<tr>";
                date_default_timezone_set('America/New_York'); // Replace 'America/New_York' with the user's timezone

                echo "<td>" . date('Y-m-d', strtotime($row['purchase_date'])) . "</td>";

                echo "<td>" . $row['num_tickets'] . "</td>";
                echo "<td>$" . number_format($row['revenue'], 2) . "</td>";
                echo "</tr>";
            }
            $sql = "SELECT COUNT(*) as total_tickets, SUM(ticket_price) as total_revenue FROM tickets";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_tickets = $row['total_tickets'];
            $total_revenue = $row['total_revenue'];
            echo "<tfoot>";
            echo "<tr>";
            
            echo "</tr>";
            echo "</tfoot>";
            echo "</tbody>";
            echo "</table>";
            echo '</div>';
            echo "<h4><strong>Total :</strong>". $total_tickets . "</h4>";
            echo "<h4><strong>Total Revnue :</strong> $" . number_format($total_revenue, 2) . "</h4>";
            // Create the chart canvas
            echo '<canvas id="myChart" width="400" height="200"></canvas>';
            // Create the chart data in JSON format
            $chart_data = [
                'labels' => $dates,
                'datasets' => [
                    [
                        'label' => 'Number of Tickets Sold',
                        'data' => $num_tickets,
                        'backgroundColor' => 'yellow'
                    ],
                    [
                        'label' => 'Revenue',
                        'data' => $revenues,
                        'backgroundColor' => 'lightgreen'
                    ]
                ]
            ];
            $chart_data_json = json_encode($chart_data);
            // Add the chart script
            echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
            echo '<script

src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
echo '<script>
var ctx = document.getElementById("myChart").getContext("2d");
var myChart = new Chart(ctx, {
type: "line",
data: ' . $chart_data_json . ',
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
echo "<h3>No results found.</h3>";
}


}elseif ($filter == 'weekly') {
    // Weekly report
    $sql = "SELECT YEARWEEK(purchase_date) AS week, COUNT(*) as num_tickets, SUM(ticket_price) as revenue FROM tickets GROUP BY YEARWEEK(purchase_date)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>Weekly Ticket Sales Report</h2>";
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-bordered table-hover">';
        echo '<thead style="background-color: mediumspringgreen">';
        echo "<tr>";
        echo "<th>Week</th>";
        echo "<th>Number of Tickets Sold</th>";
        echo "<th>Revenue</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        $weeks = [];
        $num_tickets = [];
        $revenues = [];
        while ($row = $result->fetch_assoc()) {
            array_push($weeks, $row['week']);
            array_push($num_tickets, $row['num_tickets']);
            array_push($revenues, $row['revenue']);
            echo "<tr>";
            echo "<td>" . $row['week'] . "</td>";
            echo "<td>" . $row['num_tickets'] . "</td>";
            echo "<td>$" . number_format($row['revenue'], 2) . "</td>";
            echo "</tr>";
        }
        $sql = "SELECT COUNT(*) as total_tickets, SUM(ticket_price) as total_revenue FROM tickets";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_tickets = $row['total_tickets'];
        $total_revenue = $row['total_revenue'];
        echo "<tfoot>";
        echo "<tr>";
        echo "<td>Total:</td>";
        echo "<td>" . $total_tickets . "</td>";
        echo "<td>$" . number_format($total_revenue, 2) . "</td>";
        echo "</tr>";
        echo "</tfoot>";
        echo "</tbody>";
        echo "</table>";
        echo '</div>';
        // Create the chart canvas
        echo '<canvas id="myChart" width="400" height="200"></canvas>';
        // Create the chart data in JSON format
        $chart_data = [
            'labels' => $weeks,
            'datasets' => [
                [
                    'label' => 'Number of Tickets Sold',
                    'data' => $num_tickets,
                    'backgroundColor' => 'yellow'
                ],
                [
                    'label' => 'Revenue',
                    'data' => $revenues,
                    'backgroundColor' => 'lightgreen'
                ]
            ]
        ];
        $chart_data_json = json_encode($chart_data);
        // Add the chart script
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo '<script>
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: "line",
                data: ' . $chart_data_json . ',
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
        echo "<h3>No results found.</h3>";
    }
}elseif ($filter == 'yearly') {
    // Yearly report
    $sql = "SELECT YEAR(purchase_date) as year, COUNT(*) as num_tickets, SUM(ticket_price) as revenue FROM tickets GROUP BY YEAR(purchase_date)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<h2>Yearly Ticket Sales Report</h2>";
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-bordered table-hover">';
       echo '<thead style="background-color: mediumspringgreen">';
        echo "<tr>";
        echo "<th>Year</th>";
        echo "<th>Number of Tickets Sold</th>";
        echo "<th>Revenue</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['num_tickets'] . "</td>";
            echo "<td>$" . number_format($row['revenue'], 2) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        $sql = "SELECT COUNT(*) as total_tickets, SUM(ticket_price) as total_revenue FROM tickets";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_tickets = $row['total_tickets'];
        $total_revenue = $row['total_revenue'];
        echo "<tfoot>";
        echo "<tr>";
        echo "<td><strong>Total</strong></td>";
        echo "<td><strong>" . $total_tickets . "</strong></td>";
        echo "<td><strong> $" . number_format($total_revenue, 2) . "</strong></td>";
        echo "</tr>";
        echo "</tfoot>";
        echo "</table>";
        echo '</div>';
    } else {
        echo "No tickets have been sold yet.";
    }
}
 elseif ($filter == 'customer') {
    // Customer report
    if (isset($_GET['cust_email'])) {
        $cust_email = $_GET['cust_email'];
        $sql = "SELECT * FROM tickets WHERE CustEmail='$cust_email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<h2>Ticket Sales Report for Visitor: $cust_email</h2>";
            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-bordered table-hover">';
            echo '<thead style="background-color: mediumspringgreen">';
            echo "<tr>";
            echo "<th>Date</th>";
            //echo "<th>Event Name</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                $date = date('m/d/Y h:i A', strtotime($row['purchase_date']));
                echo "<tr>";
                echo "<td>" . $date . "</td>";
                
                //echo "<td>" . $row['Event'] . "</td>";
                echo "<td>$" . number_format($row['ticket_price'], 2) . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "</tr>";
            }
            $sql = "SELECT SUM(Quantity) AS total_tickets, SUM(ticket_price * Quantity) AS total_revenue FROM tickets WHERE CustEmail = '$cust_email'";

            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $total_tickets = $row['total_tickets'];
            $total_revenue = $row['total_revenue'];
            echo "<tfoot>";
            echo "<tr>";
            echo "<td colspan='2' style='text-align:center;'><strong>Total:</strong> " . $total_tickets . " tickets, $" . number_format($total_revenue, 2) . "</td>";
            echo "</tr>";
            echo "</tfoot>";
            echo "</tbody>";
            echo "</table>";
            echo '</div>';
        } else {
            echo "No tickets sold to customer: $cust_email";
        }
    } else {
        echo "Please select a customer email";
    }
}
}
    ?>

</div>



<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
<?php
// Close database connection
$conn->close();
ob_end_flush();
?>
