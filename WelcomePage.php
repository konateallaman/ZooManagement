<?php
 // start the session
    session_start();
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
    <!-- Start WOWSlider.com HEAD section -->
    <link rel="stylesheet" type="text/css" href="./Javascript/engine1/style.css"/>
    <script type="text/javascript" src="./Javascript/engine1/jquery.js"></script>
    <!-- End WOWSlider.com HEAD section -->
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    
    <style>
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
    </style>
    

    <title>User Welcome</title>
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
    echo 'today:'.$date;
    ?>


    </div>
</header>







<div class="navbar">
    <a href="WelcomePage.php"><i class="fa fa-home"></i> Home</a>
    <div class="subnav">
        <button class="subnavbtn">About <i class="fa fa-caret-down"></i></button>
        <div class="subnav-content">
            <a href="image-gallery.php">Gallery</a>
            <a href="ContactUs2.php">Contacts Us</a>
        </div>
    </div>
    <div class="subnav">
        <button class="subnavbtn"><a href="Anitype.php">Animals In Our Zoo</a></button>
       
   </div>
    <a href="user-logout-script.php" style="padding-left: 1px"><i class="bi bi-box-arrow-right"></i> Sign out</a>
    </div>

</div>
<br><br><br>
<div class="main">

    <section>
        <!-- Start WOWSlider.com BODY section -->
        <div id="wowslider-container1">
            <div class="ws_images">
                <ul>
                    <li><a href="#"><img src="./Images/exhibi.jpg"
                                         alt="Animal Exhibitions" title="Animal Exhibitions " id="wows1_0"/></a></li>
                    <li><img src="./Images/elephants.jpg" alt="safe tour"
                             title="safe tour" id="wows1_1"/></li>
                    <li><a href="#"><img src="./Images/restaurant.jpg"
                                         alt="bootstrap image slider" title="Restaurants " id="wows1_2"/></a></li>
                    <li><a href="buy_Ticket.php"><img src="./Images/ticket.jpg" alt="ATm"
                             title="Buy ticket" id="wows1_3"/></a></li>
                </ul>
            </div>

            <div class="ws_shadow"></div>
        </div>
        <script type="text/javascript" src="./Javascript/engine1/wowslider.js"></script>
        <script type="text/javascript" src="./Javascript/engine1/script.js"></script>
        <!-- End WOWSlider.com BODY section -->
    </section>
    <br><br>
    
    <div class="container">
  <div class="row">
    <div class="col-sm-12 text-center">
      <a href="upcoming_events.php" class="btn btn-primary btn-lg">See Upcoming Events</a>
    </div>
  </div>
</div>
    
<br>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <p>Discover the beauty of the wild with our fantastic exhibits and diverse range of animals.</p>
                <img src="./Images/lion.jpg" class="img-fluid">
            </div>
            <div class="col-sm-4">
                <p>Our mission is to educate and entertain visitors about the importance of wildlife conservation and protection.</p>
                <img src="./Images/elephant.jpg" class="img-fluid">
            </div>
            <div class="col-sm-4">
                <p>With over 200 species of animals, we provide an immersive and unforgettable experience for all ages.</p>
                <img src="./Images/background.jpg" class="img-fluid">
            </div>
        </div>
    </div>






<div class="footer">
    <div class="footerin">

        <p> <h6>About:</h6>
        company<br>
        team<br>
        

        </p>

    </div>
    <div class="footerin">
        <p> <h6>Support:</h6>
        Help<br>
        ticket help
    </div>
    <div class="footerin">
        <p> <h6>Legal:</h6>
        Term<br>
        privacy<br>
        All right reserved &copy;

        </p>

    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>

