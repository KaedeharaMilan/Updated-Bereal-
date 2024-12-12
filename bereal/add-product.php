<?php
session_start();
    // Include koneksi database
    include('connection.php');

    if ($_SESSION['role'] == 'buyer') {
        header('Location: index.php');
        exit;
    }

    if (isset($_POST['btn'])) {
        // Initialize variables from form
        $name = $_POST['nama'];
        $price = $_POST['price'];
        $miniDesc = $_POST['mini_desc'];
        $detailDesc = $_POST['detail_desc'];

        // Check if image file is uploaded
        if ($_FILES["image"]["error"] == 4) {
            echo "<script> alert('Image Does Not Exist'); </script>";
        } else {
            // Get the uploaded file's name, size, and temporary name
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            // Valid image extensions
            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            // Get the file extension
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Check if the file extension is valid
            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "<script> alert('Invalid Image Extension'); </script>";
            } elseif ($fileSize > 1000000) {  // Check if file size is too large
                echo "<script> alert('Image Size Is Too Large'); </script>";
            } else {
                // Generate a unique name for the image
                $newImageName = uniqid() . '.' . $imageExtension;
                // Folder to store the image
                $uploadPath = 'Image' . $newImageName;

                // Insert product data into the database
                $seller_id = $_SESSION['id'];
$query = mysqli_query($conn, 
    "INSERT INTO seller_post (preview, nama, price, mini_desc, detail_desc, seller_id) 
     VALUES ('$newImageName', '$name', '$price', '$miniDesc', '$detailDesc', '$seller_id')");


                if ($query) {
                    // Move the uploaded file to the 'Image' folder
                    if (move_uploaded_file($tmpName, $uploadPath)) {
                        echo "<script>
                                alert('Product Added Successfully');
                                window.location.href = 'my-product.php'; // Redirect to another page (data.php)
                              </script>";
                    } else {
                        echo "<script> alert('Failed to Upload Image'); </script>";
                    }
                } else {
                    echo "<script> alert('Failed to Add Product to Database'); </script>";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Bereal</title>

      <link rel="stylesheet" href="style/add-product.css">
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


    <main>
        <div class="index__title">
    <h1 class="title__text">
        Add <span>Your</span> Product
    </h1>
</div>
    <div class="container">
        <div class="wrapper">
            <form action="add-product.php" method="POST" enctype="multipart/form-data" onsubmit="return konfirmasi();">
            <!-- Image upload -->
             <ul> 
                 <li class="preview" >
                     <label for="image">Preview Image:</label>
                     <input type="file" name="image" id="image" required>
                    </li>
                    
                    <!-- Product name -->
                    <li class="border" > 
                        <input type="text" name="nama" id="nama" placeholder="Product Name" required>
                    </li>
                    
                    <!-- Product price -->
                    <li class="price border" >
                        <label for="price">Price (Dollar Currency Max $65 )</label>
                        <input type="number" name="price" id="price" placeholder="$54.5" max="65" min="1" required>
                    </li>
                    
                    <!-- Mini description -->
                    <li class="border" >
                        <input type="text" name="mini_desc" id="mini_desc" placeholder="Preview Description (Max 100 Char) " maxlength="100" required>
                    </li>
                    
                    <!-- Detailed description -->
                    <li class="detail border">
                        <input type="text" name="detail_desc" id="detail_desc" 
                        placeholder="Detailed Description (Max 1000 Char)" 
                        maxlength="1000" required>
                    </li>
                    
                    <!-- Submit button -->
                    <button type="submit" name="btn">Post</button>
                </ul>
        </form>
        </div>
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

    function backButton() {
        window.location.href='index-seller.php'
    }

    function konfirmasi() {
        var confirmation = confirm("Are you sure you want to post this product?");
        if (confirmation) {
            return true;
        } else {
            return false;
        }
    }

    </script>
</body>
</html>
