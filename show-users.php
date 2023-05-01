<?php
    require 'users-script.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="./icons/icon.ico">
    <title>Visitors</title>
</head>
<body>
<h1>users</h1>
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <?php echo $deleteMsg??''; ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead><tr><th>ID</th>

                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Bate Of Birth</th>


                    </thead>
                    <tbody>
                    <?php
                    if (isset($fetchData)){
                    if(is_array($fetchData)){
                        $CustID=1;
                        foreach($fetchData as $data){
                            ?>
                            <tr>
                                <td><?php echo $CustID; ?></td>
                                <td><?php echo $data['CustFname']??''; ?></td>
                                <td><?php echo $data['CustLname']??''; ?></td>
                                <td><?php echo $data['CustEmail']??''; ?></td>
                                <td><?php echo $data['password']??''; ?></td>
                                <td><?php echo $data['CustDOB']??''; ?></td>

                            </tr>
                            <?php
                            $CustID++;}}else{ ?>
                    <tr>
                        <td colspan="8">
                            <?php echo $fetchData; ?>
                        </td>
                    <tr>
                        <?php
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
