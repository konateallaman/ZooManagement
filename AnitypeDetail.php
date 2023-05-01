<?php
// start the session
session_start();

// check if user is logged in
if (!isset($_SESSION['CustEmail'])) {
    header("Location: UserLogin.php"); // redirect to login page if user is not logged in
}

// retrieve the selected animal type ID from the URL parameter
if (isset($_GET['animal_id'])) {
    $animal_id = $_GET['animal_id'];
} else {
    header("Location: Anitype.php"); // redirect to animal types page if type ID is not provided
}

require "./connection/connect.inc.php";
// retrieve the animal type details from the database
$sql = "SELECT * FROM animals WHERE animal_id='$animal_id'";
$result = mysqli_query($conn, $sql);

// check if any rows were returned
if (mysqli_num_rows($result) == 0) {
    header("Location: Anitype.php"); // redirect to animal types page if type ID is not valid
} else {
    $row = mysqli_fetch_assoc($result);
}

// close the database connection
mysqli_close($conn);
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
    <style>
    .animal-details {
        display: flex;
        align-items: center;
    }

    .details {
        margin-left: 20px;
    }
</style>
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title><?php echo $row['name']; ?></title>
</head>

<body >

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

<div>
    <div> <br><br>
   <button onclick="location.href='Anitype.php'" class="btn btn-primary" style="margin-left:40px;">
      <i class="fa fa-narrow-left"></i>Previous Page
    </button>
    <br><br>
<div class="container" >
 
<div class="animal-details">
    <img src="./pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['name']; ?>" style="width:50%;height:50%">
    <div class="details">
        <h3>Name: <?php echo $row['name']; ?></h3>
        <p><h3>Species: <?php echo $row['species']; ?></h3></p>
        <p><h3>Age: <?php echo $row['age']; ?></h3></p>
        <p><h3>Gender: <?php echo $row['gender']; ?></h3></p>
    </div>
</div>
</div>
</div>
<!-- Footer -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                <h5 class="text-uppercase">Address</h5>
                <p class="lead mb-0">123 somewhere in</p>
                <p class="lead mb-0">Houston, Tx 77082</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5 class="text-uppercase">Phone</h5>
                <p class="lead mb-0">+1 (xxx) xxx-xxxx</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5 class="text-uppercase">Email</h5>
                <p class="lead mb-0">allamankonate@gmail.com</p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>