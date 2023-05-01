<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp"
          crossorigin="anonymous">
    <title>Reset Password</title>
</head>
<body id="body">
<div class="header">
    <ul>
        <li style="margin-left: 5px"><a href="UsersWelcome.php"><i class="fa fa-home-lg"></i> Home</a></li>
        <li><a href="#">Help</a></li>
    </ul>
</div>
<br><br>
<p>
<h2 class="user"><i class="fa fa-user"></i></h2>
</p>
<div class="container d-flex justify-content-center">
   
    <form class="w-50" method="post" action="reset-password-script.php">
        <table class="table">
            <tr>
                <td>
                    <label for="Id">Username: </label>
                </td>
                <td>
                    <input type="text" name="CustEmail" placeholder="Your Email" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Id">New Password: </label>
                </td>
                <td>
                    <input type="password" name="newPassword" placeholder="New Password" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Id">Confirm New Password: </label>
                </td>
                <td>
                    <input type="password" name="confirmNewPassword" placeholder="Confirm New Password" class="form-control"/>
                </td>
            </tr>
            <tr>
                <br>
                <td>
                    <button type="reset" name="Cancel" class="btn btn-danger">Cancel</button>

                </td>
                <td>
                    <button type="submit" name="resetPassword" class="btn btn-success">Reset Password</button>


                </td>

            </tr>

        </table>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>
