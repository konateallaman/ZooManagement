
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./fontawesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="./fontawesome/js/all.js">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title>Upload Image</title>
</head>
<body>
<div class="header">

    <ul>
        <li style="margin-left: 5px"><a href="AdminMenu.php"><i class="fa fa-home-lg"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-toolbox"></i> Help</a></li>


        <li style="float: right;padding-right: 25px;"><a href="./includes/logout.php"><i class="fa fa-sign-out"
                                                                                         style="padding-right: 2px"></i>
                Logout</a></li>

    </ul>


</div>
<div>
<h2 style="text-align: center;margin-top: 20px;">Upload Your New Image Here</h2>
</div>
<div class="container4">

<form  method="post" enctype="multipart/form-data" >
    <input type="file" name="image_gallery[]" multiple ><br>
    <input type="submit" value="Upload Now" name="submit" >
</form>

</div>

    <?php
    include('image-upload-script.php');
    ?>

</body>
</html>
