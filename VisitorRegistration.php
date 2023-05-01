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


    <title>visitor Registration</title>
</head>
<body id="body">
<div class="header">

    <ul>
        <li style="margin-left: 5px"><a href="UsersWelcome.php"><i class="fa fa-home-lg"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-toolbox"></i> Help</a></li>
        <a href="UserLogin.php" style="float:right;margin-right: 20px;"><i class="fa fa-sign-in"></i> Login</a>

    </ul>


</div>

<h2><i class="fa fa-plus-square "></i> Registration</h2>
<div class="container3">
    <form action="VisitorRegistration.php" method="post">
        <table>

            <tr>
                <td>
                    <label for="Id">First Name: </label>
                </td>
                <td>
                    <input type="text" name="CustFname" placeholder="First Name"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Id">Last Name: </label>
                </td>
                <td>
                    <input type="text" name="CustLname" placeholder="name"/>
                </td>
            </tr>

            <tr>
                <td><label for="Id">Visitor Email: </label></td>
                <td><input type="text" name="CustEmail" placeholder="CustEmail"/></td>
            </tr>
            <tr>
                <td><label for="Id">Password: </label></td>
                <td><input type="password" name="password" placeholder="password"/></td>
            </tr>
            <tr>
                <td>
                    <label for="Id">Date Of Birth: </label>
                </td>
                <td>
                    <input type="date" name="CustDOB"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Id">Visit Date: </label>
                </td>
                <td>
                    <input type="date" name="visit_date"/>
                </td>
            </tr>


            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <br>
                <td>

                    <button type="submit" name="Visitor_registration">submit</button>
                </td>
                <td>

                    <button type="reset" name="Cancel"> Cancel</button>
                </td>
            </tr>
        </table>
        <div>
            <?php
            include './connection/fieldcheck.php';
            ?>
        </div>
    </form>
</div>

</body>
</html>
