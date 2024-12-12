<?php 
include('../connect.php');

if ($_SESSION['role'] !== 'buyer') {
    header('Location: index-seller.php');
    exit;
}

if (isset($_POST['delete-id']) && !empty($_POST['delete-id'])) {
    $id = $_POST['delete-id'];

    // Delete related rows from the purchases table first
    $deletePurchases = mysqli_query($connect, "DELETE FROM purchases WHERE product_id = $id");

    if ($deletePurchases) {
        // Then delete related rows from the notifications table
        $deleteNotifications = mysqli_query($connect, "DELETE FROM notifications WHERE product_id = $id");

        if ($deleteNotifications) {
            // Finally, delete the product from seller_post
            $result = mysqli_query($connect, "DELETE FROM seller_post WHERE id = $id");

            if ($result) {
                echo "<script>
                alert('Produk Berhasil Dihapus');
                window.location.replace('my-product.php');
                </script>";
            } else {
                echo "<script>
                alert('Produk Gagal Dihapus');
                window.location.replace('my-product.php');
                </script>";
            }
        } else {
            echo "<script>
            alert('Gagal Menghapus Notifikasi Terkait');
            window.location.replace('my-product.php');
            </script>";
        }
    } else {
        echo "<script>
        alert('Gagal Menghapus Pembelian Terkait');
        window.location.replace('my-product.php');
        </script>";
    }
}
?>
