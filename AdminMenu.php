<?php
// start the session
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/user.css">
    <title>Zoo Admin Page</title>
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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


    <a href="user-logout-script.php" style="padding-left: 1px"><i class="fa fa-user-minus"></i> Sign out</a>
</div>
<div class="container mt-5">
    <h1 class="mb-4">Admin Page</h1>
    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="manage-animals.php" class="btn btn-admin btn-block">
                <i class="fas fa-paw mr-2"></i>Manage Animals
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="manage-visitors.php" class="btn btn-admin btn-block">
                <i class="fas fa-users mr-2"></i>Manage Visitors
            </a>
        </div>
         <div class="col-md-4 mb-4">
            <a href="image-upload-form.php" class="btn btn-admin btn-block">
                <i class="fas fa-upload mr-2"></i>Upload
            </a>
        </div>
       <div class="col-md-4 mb-4">
    <a href="assign_role.php" class="btn btn-admin btn-block">
        <i class="fas fa-user-tie mr-2"></i>Manage Staff
    </a>
</div>
       
    </div>
    <div class="row">
       
        <div class="col-md-4 mb-4">
            <a href="AdminGallery.php" class="btn btn-admin btn-block">
                <i class="fas fa-images mr-2"></i>Gallery
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="View_Total_Paid_Tickets.php" class="btn btn-admin btn-block">
                <i class="fas fa-ticket-alt mr-2"></i>Manage visitors' Tickets
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="New_Tickets.php" class="btn btn-admin btn-block">
                <i class="fas fa-ticket-alt mr-2"></i>Manage Tickets for Sale
            </a>
        </div>
    </div>
</div>
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <p>Discover the beauty of the wild with our fantastic exhibits and diverse range of animals.</p>
            <img src="./Images/lion.jpg" class="img-fluid">
        </div>
        <div class="col-sm-4">
            <p>Our mission is to educate and entertain visitors about the importance of wildlife conservation and protection.</p>
            <img src="./Images/visitors.jpg" class="img-fluid">
        </div>
        <div class="col-sm-4">
            <p>With over 200 species of animals, we provide an immersive and unforgettable experience for all ages.</p>
            <img src="./Images/staff.jpg" class="img-fluid">
        </div>
    </div>
</div>
<br><br>
<footer>
    <p>&copy; 2023 - All rights reserved</p>
  </footer>

<!-- Add Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
