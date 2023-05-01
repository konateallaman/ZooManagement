
     <?php
        
        // check if user is logged in
        if (isset($_SESSION['CustEmail'])) {
            $CustEmail = $_SESSION['CustEmail'];
            echo '<div class="alert alert-success"><strong><h4 >Hi, </h4></strong>' . $CustEmail . '!</div>'; // print the logged-in user's email
        }
        ?>