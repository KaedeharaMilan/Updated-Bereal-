<?php
session_start();
include('connection.php');

if ($_SESSION['role'] == 'seller') {
    header('Location: index-seller.php');
    exit;
}

if (!isset($_SESSION['id'])) {
    echo "<script>
            alert('Please login to view the marketplace.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM seller_post ORDER BY id DESC");

if (!$query) {
    die("Error fetching products: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $buyerId = $_SESSION['id'];

    if (empty($buyerId) || empty($productId)) {
        echo "Invalid Buyer or Product ID!";
        exit;
    }

    $purchaseQuery = "INSERT INTO purchases (product_id, buyer_id, status, purchase_date) 
                      VALUES ('$productId', '$buyerId', 'purchased', NOW())";

    if (mysqli_query($conn, $purchaseQuery)) {
        $sellerQuery = "SELECT seller_id, nama FROM seller_post WHERE id = '$productId'";
$sellerResult = mysqli_query($conn, $sellerQuery);
$sellerData = mysqli_fetch_assoc($sellerResult);

if ($sellerData) {
    $sellerId = $sellerData['seller_id'];
    $productName = $sellerData['nama'];

    $message = "Your product '$productName' has been purchased.";
    $messageEscaped = mysqli_real_escape_string($conn, $message);

    $notificationQuery = "INSERT INTO notifications (buyer_id, seller_id, product_id, message, created_at) 
                          VALUES ('$buyerId', '$sellerId', '$productId', '$messageEscaped', NOW())";

} else {
    echo "Seller not found for this product.";
}

    } else {
        echo "Error in Purchase: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace | Sociaplace</title>

      <!-- Main CSS -->
      <link rel="stylesheet" href="../Style/style.css">
      <link rel="stylesheet" href="../Style/market.css">

    <!-- Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Open Sans -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&amp;display=swap">

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

<div class="link" id="logout" style="display: none;" >
            <form action="auth/logout.php">
                <button>Logout <i class="fa-solid fa-power-off"  ></i></button>
            </form>
            <button onclick="backButton()" >Back <i class="fa-solid fa-rotate-right"></i></button>
        </div>  

   <section class="black__market">
   <div class="market__display">
    <?php while ($post = mysqli_fetch_assoc($query)) {
        $imageName = $post['preview']; ?>

        <div class="wrapper__post">
            <div class="product-card">
                <div class="product-image">
                    <img src="Image<?=$imageName;?>" alt="<?php echo $post['nama']; ?>">
                </div>
                <div class="product-details">
                    <h3 class="product-name"><?= $post['nama'] ?></h3>
                    <h4 class="product-price">$ <?= $post['price'] ?></h4>
                    <p class="product-desc"><?= $post['mini_desc'] ?></p>
                </div>
                <a class="detail__btn" href="detail.php?id=<?= $post['id']?>">Detail</a>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?= $post['id'] ?>">
                    <button type="submit" class="buy-button">Buy</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>
   </section>


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