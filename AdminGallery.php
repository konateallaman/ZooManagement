<?php

require('image-gallery-script.php');
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./css/style.css">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="./css/main.css">
<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.css">
<link rel="stylesheet" type="text/css" href="./fontawesome/js/all.js">
<link rel="icon" type="image/x-icon" href="./icons/icon.ico">
<title> Gallery</title>

<body>
<div class="header">

    <ul>
        <li style="margin-left: 5px"><a href="AdminMenu.php"><i class="fa fa-home-lg"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-toolbox"></i> Help</a></li>


    </ul>


</div>

<!--======image gallery ========-->
<br>
<div class="row">

    <?php

    if (!empty($fetchImage)) {
        $sn = 1;
        foreach ($fetchImage as $img) {

            ?>

            <div class="column">
                <img src="./gallery/
<?php
                echo $img['image_name'];
                ?>
" style="width:100%" onclick="openModal(); currentSlide(
                <?php
                echo $sn;
                ?>
                    )" class="hover-shadow cursor">
            </div>
            <?php

            $sn++;
        }
    } else {
        echo "No Image is saved in database";
    }
    ?>

</div>
<!--======image gallery ========-->


<div id="galleryModal" class="modal">
    <span class="close cursor" onclick="closeModal()">&times;</span>

    <!--======image gallery modal========-->
    <div class="modal-content">

        <?php

        if (!empty($fetchImage)) {
            $sn = 1;
            foreach ($fetchImage as $img) {

                ?>
                <div class="gallerySlides">
                    <div class="numbertext"> <?php
                        echo $img['image_name'];
                        ?></div>
                    <img src="./gallery/
<?php
                    echo $img['image_name'];
                    ?>
" style="width:100%">
                </div>
                <?php

                $sn++;
            }
        } else {
            echo "No Image is saved in database";
        }
        ?>


        <!--======image gallery model========-->

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <div class="caption-container">
            <p id="caption"></p>
        </div>
    </div>
</div>

<script type="text/javascript" src="./Javascript/gallery-script.js"></script>

</body>
</html>

