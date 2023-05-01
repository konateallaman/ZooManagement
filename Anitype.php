<?php
// start the session
session_start();

// check if user is logged in
if (!isset($_SESSION['CustEmail'])) {
    header("Location: UserLogin.php"); // redirect to login page if user is not logged in
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
   <style>
    .list-group-item:hover {
      background-color: #f5f5f5;
      cursor: pointer;
    }
    footer {
          position: fixed;
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
  </style>

    <title>Animal Types</title>
</head>

<body class="index">

<header style="display: flex; align-items: center; justify-content: center;">
    <div class="logo">
        <img src="./icons/safari.png" alt="Your logo">
    </div>
    <div class="username">
    <?php
        include "./connection/usersession.php";
        ?>
    </div>
    <div class="search-container">
       <?php
        // Return current date from the remote server
        $date = date('d-m-y h:i:s');
        echo 'today:'. $date;
        ?>
    </div>
</header>
<div class="navbar">
    <a href="WelcomePage.php"><i class="fa fa-home"></i> Home</a>


     <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
</div>


<!-- Display animal types -->
<div class="container" style="text-align: center;">
    <br>
    <br>
    <h2>Animal Types</h2>
    <p>Click on an animal type to see more information:</p>
    <ul class="list-group">
        <?php
        // connect to the database
        include_once("./connection/connect.inc.php");
    

        // get all animal types from the database
        $query = "SELECT * FROM animals";
        $result = mysqli_query($conn, $query);

        // display each animal type as a list item
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="list-group-item"><a href="AnitypeDetail.php?animal_id=' . $row['animal_id'] . '">' . $row['name'] . '</a></li>';
        }

        // close database connection
        mysqli_close($conn);
        ?>
    </ul>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2023 - All rights reserved</p>
  </footer>

<!-- JavaScript files -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"
        integrity="sha384-NKK8I7FiFQfCfwPdCKb/ZmykYX47eLU2JcM5F5UhpsU5gImi5hPjwytLzBB+PxiH"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js"
        integrity="sha384-CTjUduFN88mZd6LFp8aUw02UBxtEg0r57/6Kj9RvHbdeG0RUJZ/vQpbGVprjKq3f"
        crossorigin="anonymous"></script>
</body>
</html>
