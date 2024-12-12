<?php

session_start(); // -> Harus ditambahkan ketika menggunakan session

// Redirect user yang sudah login ke index.php
if(isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

include('function.php');

if(isset($_POST['login'])) {
    login($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- css links for sign in page below👇 -->
     <link rel="stylesheet" href="style/signin.css">
         <!-- Bricolage Grotesque Fonts Links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap" rel="stylesheet">
    <!-- Great Vibes Fonts Links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Great+Vibes&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="navbar">
        <div class="logo">
            <h1 class="blogo">B</h1>
            <h1 class="ereallogo">ereal™</h1>
        </div>

        <div class="navmenu">
            <a href="#">Dashboard</a>
            <a href="#">Info</a>
            <a href="#">Feedback</a>
            <a href="#">Contact</a>
        </div>

        <div class="loginregister">
            <a href="signin.php" class="register" id="register">Sign In</a>
            <a href="#" class="login" id="login">Login</a>
        </div> 
    </div>
    </header>
<main>
    <div class="getstartframe">
        <h1 class="letsgetstarted">Let's Get Started</h1>
        
        <form action="" method="POST">
            <ul>
                <li>
                    <label for="email">EMAIL</label>
                    <input type="email" name="email" id="email" required>
                </li>
                <li>
                    <label for="password">PASSWORD</label>
                    <input type="password" name="pw" id="password" required>
                </li>
        </ul>
        <div class="buttonsubmit">
            <button class="submit" type="submit" name="login">Get In</button>
        </div>
    </form>    
    </div>
</main>
</body>
</html>