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
.comments-container {
  display: none;
}

.show-comments {
  display: block !important;
}
</style>
<script>
function toggleComments() {
  var commentsContainer = document.querySelector('.comments-container');
  var button = document.querySelector('.toggle-comments-button');
  commentsContainer.classList.toggle('show-comments');
  if (commentsContainer.classList.contains('show-comments')) {
    button.innerText = 'Hide Comments';
  } else {
    button.innerText = 'Show Comments';
  }
}


function likeComment(commentId) {
    // make an AJAX call to the server to increment the likes count
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "?like=" + commentId, true);
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // update the likes count on the page
            var likesCountElement = document.getElementById("likes-count-" + commentId);
            likesCountElement.textContent = parseInt(likesCountElement.textContent) + 1;
        }
    };
    xhr.send();
}
</script>
<style>
    .animate-text {
        animation: slide-up 3s ease infinite;
    }
    
    @keyframes slide-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<title>User Welcome</title>

</head>

<body class="index">



<header>
    <div class="logo">
        <img src="./icons/safari.png" alt="Your logo">
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
    <a href="index.php" style="padding-left: 2px;"><i class="fa fa-home"></i> Home</a>
    
   
   
   <a href="UserLogin.php" style="padding-right: 0px;"><i class="fa fa-sign-in"></i> Login</a>
<a href="VisitorRegistration.php" style="padding-left: 1px;"><i class="fa fa-user-plus"></i> Sign Up</a>

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
                    <li><img src="./Images/ticket.jpg" alt="ATm"
                             title="Buy ticket" id="wows1_3"/></li>
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
        <div class="col-sm-4">
            <p class="animate-text">Discover the beauty of the wild with our fantastic exhibits and diverse range of animals.</p>
            <img src="./Images/lion.jpg" class="img-fluid">
        </div>
        <div class="col-sm-4">
            <p class="animate-text">Our mission is to educate and entertain visitors about the importance of wildlife conservation and protection.</p>
            <img src="./Images/elephant.jpg" class="img-fluid">
        </div>
        <div class="col-sm-4">
            <p class="animate-text">With over 200 species of animals, we provide an immersive and unforgettable experience for all ages.</p>
            <img src="./Images/background.jpg" class="img-fluid">
        </div>
    </div>

    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-4">
            <form method="POST">
                <h3>Add a Comment</h3>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-sm-2 col-form-label">Comment:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
        	<p><p>
        	<button onclick="toggleComments()" class="btn btn-success toggle-comments-button">Show Comments</button>

<div class="comments-container">
  <?php
    include "./connection/submit-comment.php";
  ?>
</div>
        </div>
    </div>
</div>

 </div>










<div class="footer">
    <div class="footerin">

        <p> <h6>About:</h6>
        company<br>
        team

        </p>

    </div>
    <div class="footerin">
        <p> <h6>Support:</h6>
        Help
      
    </div>
    <div class="footerin">
        <p> <h6>Legal:</h6>
        
        All right reserved &copy;

        </p>

    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>

