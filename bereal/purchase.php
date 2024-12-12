<?php
session_start();
include('connection.php');

if ($_SESSION['role'] == 'seller') {
    header('Location: index-seller.php');
    exit;
}

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$buyerId = $_SESSION['id'];

$query = mysqli_query($conn, "SELECT * FROM purchases 
                                 JOIN seller_post ON purchases.product_id = seller_post.id 
                                 WHERE purchases.buyer_id = '$buyerId'");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$purchases = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchases</title>

    <link rel="stylesheet" href="../Style/style.css">
    <link rel="stylesheet" href="../Style/purchase.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- AF -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

<nav class="nav__wrapper">
    <div class="nav__container">
        <div class="logo">
            <i class="fa-solid fa-link logo__symbol"></i>
            <h1 class="logo__text">SociaPlace</h1>
        </div>

        <button class="menu__button" id="menu-toggle" onclick="toggleMenu()">
            <i class="fa-solid fa-bars" id="burger"></i>
            <i class="fa-solid fa-x" style="display: none;" id="cancel"></i>
        </button>

    </div>
</nav>

<hr>

<div class="index__title">
        <h1 class="title__text">
            Purchase <span>History</span>
        </h1>
    </div>

<div class="link" id="logout" style="display: none;" >
            <form action="auth/logout.php">
                <button>Logout <i class="fa-solid fa-power-off"  ></i></button>
            </form>
            <button onclick="backButton()" >Back <i class="fa-solid fa-rotate-right"></i></button>
        </div>

    <div class="container">
    <div class="purchases__list">
        <?php if (!empty($purchases)) { ?>

            
            <?php foreach ($purchases as $purchase) { ?>
                <div class="purchase-item">
                    <h3><?= htmlspecialchars($purchase['nama']); ?></h3>
                    <h4 style="color: red;" >- $<?= htmlspecialchars($purchase['price']); ?></h4>
                    <h4><?= htmlspecialchars($purchase['purchase_date']); ?></h4>
                    <p>Status: <strong style="color:#6d801e;" ><?= htmlspecialchars($purchase['status']); ?></strong></p>
                </div>
            <?php } ?>
            

        <?php } else { ?>
            <p>No purchases found.</p>
        <?php } ?>
    </div>
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

    function backButton() {
        window.location.href='index.php'
    } 
    </script>
</body>
</html>