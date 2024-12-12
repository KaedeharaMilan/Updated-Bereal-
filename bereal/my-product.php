<?php
session_start();
include('connection.php');

if ($_SESSION['role'] == 'buyer') {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['id'])) {
    echo "<script>
            alert('Please login to view your products.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

$seller_id = $_SESSION['id'];
$result = mysqli_query($conn, "SELECT * FROM seller_post WHERE seller_id = '$seller_id'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Products | Sociaplace</title>

    <link rel="stylesheet" href="../../Style/nav.css">
    <link rel="stylesheet" href="../../Style/product.css">

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

    <div class="index__title">
        <h1 class="title__text" >Your <span>Products</span></h1>
    </div>

    <div class="wrapper__post">
<?php
if (mysqli_num_rows($result) > 0) {
    while ($post = mysqli_fetch_assoc($result)) {
        $imageName = $post['preview'];
        ?>
            <div class="container__post">
                <div class="preview">
                    <img src="Image<?php echo $imageName; ?>" width="300px">
                </div>
                <div class="title">
                    <h3 class="text__title"><?= htmlspecialchars($post['nama']); ?></h3>
                </div>
                <div class="price">
                    <h4 class="price__text">$ <?= htmlspecialchars($post['price']); ?></h4>
                </div>
                <div class="mini__desc">
                    <h4 class="mini__text"><?= htmlspecialchars($post['mini_desc']); ?></h4>
                </div>
                <div>
                    <button id="btn" type="button" name="btn"><a href="edit.php?id=<?= $post['id']; ?>">Edit</a></button>
                    <form action="delete.php" method="post">
                        <input type="hidden" name="delete-id" value="<?= $post['id']; ?>" readonly>
                        <button type="submit" name="delete" class="del" >Delete</button>
                    </form>
                </div>
            </div>
            <?php
    }
} else {
    echo "<p>No products found. Start adding products now!</p>";
}
?>
</div>

<script src="../Style/app.js"></script>
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
        window.location.href='index-seller.php'
    }

    </script>
</body>
</html>