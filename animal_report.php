<!DOCTYPE html>
<html>
<head>
    <title>Animal Report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
</head>
<body>
    
    <div class="container">
        <br><br>
    <a href="manage-animals.php" class="btn btn-primary"><i class="bi bi-plus-arrow"></i>Go to manage animals</a>
       <br><br>
        <h1>Animal Report</h1>
        <hr>
        <h2>Animals Added Daily</h2>
        <canvas id="daily-chart"></canvas>
        <hr>
        <h2>Animals Added Monthly</h2>
        <canvas id="monthly-chart"></canvas>
        <hr>
        <h2>Animal List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Species</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Weight</th>
                    <th>Habitat</th>
                    <th>Date Created</th>
                   
                   
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the database
                require './connection/connect.inc.php';
                
                // Get the daily and monthly count of animals
                $daily_count = array();
                $monthly_count = array();
                $sql = "SELECT DATE(date_created) AS date, COUNT(*) AS count FROM animals GROUP BY DATE(date_created)";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $daily_count[$row['date']] = $row['count'];
                }
                $sql = "SELECT DATE_FORMAT(date_created, '%Y-%m') AS date, COUNT(*) AS count FROM animals GROUP BY DATE_FORMAT(date_created, '%Y-%m')";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $monthly_count[$row['date']] = $row['count'];
                }

                // Display the animals in a table
                $sql = "SELECT animals.animal_id, animals.name, animals.species, animals.age, animals.gender, animals.weight, habitats.name AS habitat_name, animals.date_created AS date_created, animals.date_updated AS date_updated FROM animals
                    INNER JOIN habitats ON animals.habitat_id=habitats.habitat_id
                    ORDER BY animals.animal_id ASC";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['animal_id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['species'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['weight'] . "</td>";
                    echo "<td>" . $row['habitat_name'] . "</td>";
                    echo "<td>" . $row['date_created'] . "</td>";
                   
                   
echo "</tr>";
}
            // Close the database connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>
<script>
    // Set up the daily chart
    var dailyChart = new Chart(document.getElementById("daily-chart"), {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($daily_count)); ?>,
            datasets: [{
                label: 'Animals Added',
                data: <?php echo json_encode(array_values($daily_count)); ?>,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'day'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // Set up the monthly chart
    var monthlyChart = new Chart(document.getElementById("monthly-chart"), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($monthly_count)); ?>,
            datasets: [{
                label: 'Animals Added',
                data: <?php echo json_encode(array_values($monthly_count)); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'month'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
</body>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
