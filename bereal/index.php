<?php
session_start();

    include('connection.php');
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php'); 
    exit;
}

if ($_SESSION['role'] !== 'buyer') {
    header('Location: index-seller.php');
    exit;
}

$userId = $_SESSION['id'];
$query = mysqli_query($conn,"SELECT username FROM client WHERE id='$userId'");
$fetchData = mysqli_fetch_assoc($query);
$username = $fetchData['username']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Main Page | Sociaplace</title>

    <!-- Main CSS -->
    <link rel="stylesheet" href="Style/style.css">
    <link rel="stylesheet" href="Style/responsive.css">
    <link rel="stylesheet" href="Style/card.css">

    <!-- Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- AF -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    
<nav class="nav__wrapper">
    <div class="nav__container">
        <!-- Logo -->
        <div class="logo">
            <i class="fa-solid fa-link logo__symbol"></i>
            <h1 class="logo__text">SociaPlace</h1>
        </div>

        <!-- Menu Button -->
        <button class="menu__button" id="menu-toggle" onclick="toggleMenu()">
            <i class="fa-solid fa-bars" id="burger"></i>
            <i class="fa-solid fa-x" style="display: none;" id="cancel"></i>
        </button>

        <!-- Navigation Links -->

    </div>
</nav>

<hr>

<div class="index__title">
    <h1 class="title__text" >Welcome <span><?=$username?>,</span> Happy Shopping</h1>
</div>

<div class="link" id="logout" style="display: none;" >
            <form action="auth/logout.php">
                <button>Logout <i class="fa-solid fa-power-off"  ></i></button>
            </form>
        </div> 

<div class="hero">
    <button class="wrapper__btn" onclick="pindahPage()" >
        <div class="card">
            <div class="icon-container">
                <i class="fa-solid fa-store"></i>
            </div>
            <div class="card-content">
                <h2>Marketplace</h2>
            </div>
        </div>
    </button>
    <button class="wrapper__btn" onclick="pindahPage1()" >
        <div class="card">
            <div class="icon-container">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="card-content">
                <h2>Purchase History</h2>
            </div>
        </div>
    </button>    
</div>
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
        window.location.href='marketplace.php'
    }
    function pindahPage1() {
        window.location.href='purchase.php'
    }
    </script>
</body>
</html>