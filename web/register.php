<?php
include('server.php');

if(isset($_POST['submit'])){
    
    $name=$mysqli->real_escape_string($_POST['name']);
    $user=$mysqli->real_escape_string($_POST['user']);
    $pass=$mysqli->real_escape_string($_POST['password']);

    $command = 'python ../scripts/newUser.py $name $user $pass';
    echo $command;
    // header('location:tables.php?obj=auth');
    // exit;

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website scholarly</title>
    <link rel="stylesheet" href="styleRegister.css">
  </head>
<body>
<div class="nav">
    <?php
    if(isset($_SESSION['username'])){
        $name = $_SESSION['username'];
        echo "<a href='logout.php'>Logout</a>";
      
        echo "<a href='adminPage.php'>$name</a>";
    } ?>
</div>
    <div class="background"></div>
    <div class="container">
    <h2>Registration</h2>
    <form method="post" action="register.php" >
    
			<div class="form-item">
                
                <input type="text" name="name"  id="text" placeholder="Author name">
            </div>
            <div class="form-item">
                
                <input type="text" name="user"  id="text" placeholder="Username">
            </div>

            <div class="form-item">
    
                <input type="password" name="password" id="text" placeholder="Password">

            </div>
        

            <button type="submit" action="index.php" name="submit" value="Upload"> Submit </button>
      
    </form>
</body>
</html>