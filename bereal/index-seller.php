<?php
session_start();

include('connection.php');
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: auth/login.php');
    exit;
}

if ($_SESSION['role'] !== 'seller') {
    header('Location: index.php');
    exit;
}

$userId = $_SESSION['id'];
$query = mysqli_query($conn,"SELECT username FROM client WHERE id='$userId'");
$fetchData = mysqli_fetch_assoc($query);
$username = $fetchData['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Main Page | Sociaplace</title>
    <!-- style sheet under -->
    <link rel="stylesheet" href="style/index-seller.css">
    <!-- Bricolage Grotesque Fonts Links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap" rel="stylesheet">
    <!-- Great Vibes Fonts Links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Great+Vibes&display=swap" rel="stylesheet">

    <!-- AF -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body>

    
    
<header>
    <div class="navbar">
        <div class="logo">
            <h1 class="blogo">B</h1>
            <h1 class="ereallogo">ereal™</h1>
        </div>

        <div class="navmenu">
            <a href="index-seller.php">Dashboard</a>
            <a href="#">Info</a>
            <a href="#">Feedback</a>
            <a href="#">Contact</a>
        </div>

        <!-- Menu Button -->
        <button class="menu__button" id="menu-toggle" onclick="toggleMenu()">
            <i class="fa-solid fa-bars" id="burger"></i>
            <i class="fa-solid fa-x" style="display: none;" id="cancel"></i>
        </button>
    </div>
    <div class="link" id="logout" style="display: none;" >
            <form action="auth/logout.php">
                <button class="logoutbtn">Logout <i class="fa-solid fa-power-off"  ></i></button>
            </form>
        </div>  
</header>

<main>

    <div class="index__title">
        <h1 class="title__text" >Any NeedS? <span><?=$username?>,</span> go ahead and get the big <span>Bucks</span></h1>
    </div>


    
<div class="hero">
    <button class="wrapper__btn" onclick="pindahPage()" >
        <div class="card add__card">
            <div class="icon-container">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div class="card-content">
                <h2>Add Product</h2>
            </div>
        </div>
    </button>
    <button class="wrapper__btn" onclick="pindahPage2()" >
        <div class="card">
            <div class="icon-container">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="card-content">
                <h2>My Product</h2>
            </div>
        </div>
    </button>
</div>
</main>


    <script>
function toggleMenu() {
    const burgerIcon = document.getElementById('burger');
    const cancelIcon = document.getElementById('cancel');
    const logout = document.getElementById('logout');

    if (burgerIcon.style.display === 'none') {
        burgerIcon.style.display = 'inline-block';
        cancelIcon.style.display = 'none';
        logout.style.display = 'none';
    } else {
        burgerIcon.style.display = 'none';
        cancelIcon.style.display = 'inline-block';
        logout.style.display = 'block';
    }
}

    function pindahPage() {
        window.location.href='add-product.php'
    }

    function pindahPage1() {
        window.location.href='Main/marketplace.php'
    }

    function pindahPage2() {
        window.location.href='my-product.php'
    }

    function pindahPage3() {
        window.location.href='Main/Seller/notification.php'
    }

    function pindahPage5() {
        window.location.href='Main/purchase.php'
    }
</script>
</body>
</html>