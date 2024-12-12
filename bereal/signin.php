<?php
require('connection.php'); 

include('function.php');

if(isset($_POST['register'])) {
    register($_POST);
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
            <a href="login.php" class="login" id="login">Login</a>
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
                    <label for="">USERNAME</label>
                    <input type="input" name="username" id="email" required>
                </li>
                <li>
                    <label for="password">PASSWORD</label>
                    <input type="password" name="pw" id="password" required>
                </li>
            <li>
                <label for="password">CONFIRM PASSWORD</label>
                <input type="password" name="pw2" id="password2" required>
            </li>
            <li>
                <select name="role" class="role">
                    <option value="buyer">Customer</option>
                    <option value="seller">Seller</option>
                </select>
            </li>
        </ul>
        <div class="buttonsubmit">
            <button class="submit" type="submit" name="register">Confirm!</button>
        </div>
    </form>    
    </div>
</main>
</body>
</html>