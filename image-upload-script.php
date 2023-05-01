<?php

require './connection/connect.inc.php';

if (isset($conn)) {
    $db=$conn;
} // Enter your Connection variable;
$tableName='gallery'; // Enter your table Name;


// upload image on submit
if(isset($_POST['submit'])){
    echo upload_image($tableName);
}

function upload_image($tableName){

    $uploadTo = "./gallery/";
    $allowedImageType = array('jpg','png','jpeg','gif');
    $imageName = array_filter($_FILES['image_gallery']['name']);
    $imageTempName=$_FILES["image_gallery"]["tmp_name"];

    $tableName= trim($tableName);


    if(empty($imageName)){
        $error='<div class="alert alert-warning" ><strong><h4 style="text-align: center;">Please select image...</h4></strong></div>';
        return $error;
    } else if(empty($tableName)){
        $error='<div class="alert alert-warning" ><strong><h4 style="text-align: center;">You must declare table name</h4></strong></div>';
        return $error;
    }else{
        $error=$savedImageBasename='';
        foreach($imageName as $index=>$file){

            $imageBasename = basename($imageName[$index]);
            $imagePath = $uploadTo.$imageBasename;
            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);

            if(in_array($imageType, $allowedImageType)){

                // Upload image to server
                if(move_uploaded_file($imageTempName[$index],$imagePath)){

                    // Store image into database table
                    $savedImageBasename .= "('".$imageBasename."'),";
                }else{
                    $error = '<div class="alert alert-danger" ><strong><h4 style="text-align: center;">File Not uploaded ! try again</strong></div>';
                }
            }else{
                $error .= $_FILES['file_name']['name'][$index].'<div class="alert alert-warning" ><strong><h4 style="text-align: center;"> - file extensions not allowed</h4></strong></div><br> ';
            }
        }
        save_image($savedImageBasename, $tableName);
    }
    return $error;
}
// File upload configuration
function save_image($savedImageBasename, $tableName){

    global $db;
    if(!empty($savedImageBasename))
    {
        $value = trim($savedImageBasename, ',');

        // Check if the image already exists in the database
        $checkDuplicate = "SELECT * FROM ".$tableName." WHERE image_name IN (".$value.")";
        $result = $db->query($checkDuplicate);

        if($result->num_rows > 0){
            // If the image already exists, display an error message
            echo '<div class="alert alert-danger"><strong><h4 style="text-align: center;">This image already exist in the database</strong></div>';
        }else{
            // If the image doesn't exist, insert it into the database
            $saveImage="INSERT INTO ".$tableName." (image_name) VALUES".$value;
            $exec= $db->query($saveImage);
            if($exec){
                echo '<div class="alert alert-success" ><strong><h4 style="text-align: center;">Image successfully uploaded </strong></div>';
            }else{
                echo  "Error: " .  $saveImage . "<br>" . $db->error;
            }
        }
    }
}


?>