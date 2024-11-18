
<?php

require  'config/database.php';

//GET BACK FORM DATA INCASE OF REGISTRATION ERROR
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

//delete the signupdata session
unset($_SESSION['signup-data']);


?>




<!DOCTYPE php>
<php lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>That One Time</title>
    <!-- CUSTOM STYLESHEET-->
    <link rel = "stylesheet" href="/Blog/css/style.css">
    <!--ICONSCOUT CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--GOOGLE FONT (MONTSERRAT)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
       
    </nav>
    <section class="form__section">
        <div class="container form__section-container">
            <h2> Sign Up</h2>
        <?php if(isset($_SESSION['signup'])):?> 
                <div class="alert__message error">
            <p>
                 <?= $_SESSION['signup'];
                 unset( $_SESSION['signup']);
                 ?>
                
            </p>
                </div>
        
        <?php endif ?>
        
        <form  action="signup-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="firstname" value ="<?= $firstname?>" placeholder="First Name">
            <input type="text" name="lastname" value ="<?= $lastname?>" placeholder="Last Name">
            <input type="text" name="username" value ="<?= $username?>"placeholder="Username">
            <input type="email" name="email" value ="<?= $email?>"placeholder="Email">
            <input type="password" name="createpassword" value ="<?= $createpassword?>"placeholder="Create Password">
            <input type="password" name="confirmpassword" value ="<?= $confirmpassword?>"placeholder="Confirm Password">
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar"id = "avatar"> 
            </div>
            <button type="submit" name="submit"class="btn"> Sign Up</button>
            <small>Already have an account? <a href="signin.php">Sign In</a></small>

        </form>
    </section>
</body>
</html>