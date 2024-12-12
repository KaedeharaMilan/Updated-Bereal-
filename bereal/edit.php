<?php
session_start();
// Include connection to the database
include('../connect.php');

if ($_SESSION['role'] !== 'buyer') {
    header('Location: index-seller.php');
    exit;
}

// Fetch the product data based on the `id` parameter
$id = $_GET['id'];
$queryData = "SELECT * FROM seller_post WHERE id = $id";
$result = mysqli_query($connect, $queryData);

// Fetch the product data into `$data`
$data = mysqli_fetch_assoc($result);

// Handle form submission when the "Update" button is clicked
if (isset($_POST['btn'])) {
    // Initialize variables from the form
    $name = $_POST['nama'];
    $price = $_POST['price'];
    $miniDesc = $_POST['mini_desc'];
    $detailDesc = $_POST['detail_desc'];

    // Check if an image is uploaded
    if ($_FILES["image"]["error"] == 4) {
        // No image uploaded, so retain the current image name
        $preview = $data['preview']; // Use the existing image from the database
    } else {
        // Image file was uploaded
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        // Valid image extensions
        $validImageExtensions = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // MIME type validation only if file exists
        if (file_exists($tmpName)) {
            $allowedMimeTypes = ['image/jpeg', 'image/png'];
            $fileMimeType = mime_content_type($tmpName);

            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "<script> alert('Invalid Image Extension'); </script>";
            } elseif ($fileSize > 1000000) { // Check if file size is too large
                echo "<script> alert('Image Size Is Too Large'); </script>";
            } elseif (!in_array($fileMimeType, $allowedMimeTypes)) {
                echo "<script> alert('Invalid Image MIME Type'); </script>";
            } else {
                // Generate a unique name for the image
                $newImageName = uniqid() . '.' . $imageExtension;
                $uploadPath = '../Image/' . $newImageName;

                // Update preview image filename
                $preview = $newImageName;
            }
        }
    }

    // Update the product data in the database
    $query = mysqli_query($connect, 
        "UPDATE seller_post SET
            preview = '$preview',
            nama = '$name',
            price = '$price',
            mini_desc = '$miniDesc',
            detail_desc = '$detailDesc'
         WHERE id = $id"
    );

    if ($query) {
        // If the update is successful, upload the image if it's a new one
        if (isset($newImageName)) {
            if (move_uploaded_file($tmpName, $uploadPath)) {
                echo "<script>
                        alert('Product Updated Successfully');
                        window.location.href = 'my-product.php'; // Redirect to another page (data.php)
                      </script>";
            } else {
                echo "<script> alert('Failed to Upload Image'); </script>";
            }
        } else {
            echo "<script>
                    alert('Product Updated Successfully (No Image Change)');
                    window.location.href = 'my-product.php'; // Redirect to another page
                  </script>";
        }
    } else {
        echo "<script> alert('Failed to Update Product'); </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Edit Product | Sociaplace</title>

      <link rel="stylesheet" href="../../Style/style.css">
      <link rel="stylesheet" href="../../Style/add.css">

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
            <form action="../../Auth/logout.php">
                <button>Logout <i class="fa-solid fa-power-off"  ></i></button>
            </form>
            <button onclick="backButton()" >Back <i class="fa-solid fa-rotate-right"></i></button>
        </div>

        <div class="index__title">
        <h1 class="title__text">
            Edit <span>Your</span> Product
        </h1>
    </div>

    <div class="container">
        <div class="wrapper edit">
                <form action="" method="POST" enctype="multipart/form-data">
                <!-- Image upload -->
                <div>
                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image">
                    <?php
                        // Show the current image preview if exists
                        if (isset($data['preview'])) {
                            echo "<p>Current Image: <img src='../../Image/{$data['preview']}' alt='Image Preview' width='100'></p>";
                        }
                    ?>
                </div>

                <!-- Product name -->
                <div class="border">
                    <label for="nama">Product Name:</label>
                    <input type="text" name="nama" id="nama" value="<?=$data['nama']?>" required>
                </div>

                <!-- Product price -->
                <div class="border">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" value="<?=$data['price']?>" required>
                </div>

                <!-- Mini description -->
                <div class="border">
                    <label for="mini_desc">Short Description:</label>
                    <input type="text" name="mini_desc" id="mini_desc" value="<?=$data['mini_desc']?>" required>
                </div>

                <!-- Detailed description -->
                <div class="border">
                    <label for="detail_desc">Detailed Description:</label>
                    <input type="text" name="detail_desc" id="detail_desc" value="<?=$data['detail_desc']?>" required>
                </div>

                <!-- Submit button -->
                <button type="submit" name="btn">Update Product</button>
            </form>
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
        window.location.href='../../'
    }
    </script>
</body>
</html>
