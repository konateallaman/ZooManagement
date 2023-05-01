<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    
    <title>User Login</title>
    
    <style>
        /* Custom CSS */
        .form-label {
  color: white;
}

        
        
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #fff;
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        
        .button-container button {
            margin: 0 10px;
        }
      


    </style>
</head>
<body id="body">
<div class="header">

    <ul>
        <li style="margin-left: 5px"><a href="UsersWelcome.php"><i class="fa fa-home-lg"></i> Home</a></li>
        <li><a href="#">Help</a></li>
    </ul>
</div>



    <div class="container2">
     
        <div class="fade-in">
            <form method="post" action="userlogincheck.php">
                <div class="mb-3 mt-4">
                    <label for="Email" class="form-label">Username:</label>
                    <input type="text" class="form-control" name="CustEmail" placeholder="Your Email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label" >Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="login" class="form-label">Login as:</label>
                        <select name="loginAs" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                </div>
                <div class="button-container">
                    <button type="reset" name="Cancel" class="btn btn-danger">Cancel</button>
                    <button type="submit" name="login" class="btn btn-success">login</button>
                </div>
                <br>
                <p style="color:white;">
                    Forgot password? <a href="VisitorsForgetPassword.php" target="_blank">Click here</a>
                    <br>
                    Don't have an account? <a href="VisitorRegistration.php" >Create Account</a>
                </p>
            </form>
        </div>
    
    </div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
