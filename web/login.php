<?php

include('server.php');
?> 


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="styleLog.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  </head>

<body>
    <div class="background"></div>
    <div class="container">
        <h2>Login Form</h2>
        <form method="post" action="login.php">
            <?php include('errors.php'); ?>
            <div class="form-item">
                <span class="material-icons-outlined">
                    account_circle
                    </span>
                <input type="text" name="username" id="text" placeholder="username">
            </div>

            <div class="form-item">
                <span class="material-icons-outlined">                   
                    lock
                    </span>
                <input type="password" name="password" id="pass" placeholder="password">

            </div>

            <button type="submit" name="login"> LOGIN </button>
        </form>

    </div>

</body>

</html>