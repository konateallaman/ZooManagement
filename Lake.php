<?php
require "./header/header.php";
?>
    <title>New Visitor Registration</title></head>
<body class="Nani ">
<div class="header">

    <ul>
        <li style="margin-left: 5px"><a href="UsersWelcome.php"><i class="fa fa-home-lg"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-toolbox"></i> Help</a></li>
        <a href="UserLogin.php" style="float:right;margin-right: 20px;"><i class="fa fa-sign-in"></i> Login</a>

    </ul>


</div>
<p>
<h2> Add New Visitor</h2></p>
<div class="container">
    <form method="post" action="AdminLogin.php">
        <table>
            <tr>
                <td><label for="Id">Visitor Id: </label></td>
                <td><input type="text" name="Id" placeholder=" Id"/></td>
            </tr>
            <tr>
                <td><label for="Id">Visitor First Name: </label></td>
                <td><input type="text" name="name" placeholder="name"/></td>
            </tr>
            <tr>
                <td><label for="Id">Visitor Last Name: </label></td>
                <td><input type="text" name="name" placeholder="name"/></td>
            </tr>
            <tr>
                <td><label for="Id">Visitor Date Of Birth: </label></td>
                <td><input type="date" name="DOB"/></td>
            </tr>
            <tr>
                <td><label for="Id">Visitor Email: </label></td>
                <td><input type="text" name="name" placeholder="name"/></td>
            </tr>
            <tr>
                <td><label for="imported"> Ticket Type: </label></td>
                <td style="text-align: left">

                    <input type="radio" id="" name="TicType" value="Ride Pass">Ride Pass<br>
                    <input type="radio" id="" name="TicType" value="Unlimited">Unlimited<br>
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
            <tr><br>
                <td><button type="submit"  name="Save">Save</button></td>
                <td><button type="reset"  name="Cancel">Cancel</button></td>
            </tr>
        </table>
</div>
</form></body>
</html>
