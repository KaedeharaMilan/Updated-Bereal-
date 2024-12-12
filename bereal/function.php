<?php
    include('connection.php');

function register($request) {
    global $conn;
    // AMBIL EMAIL LALU SIMPAN DI VARIABLE
    // Sanitasi email agar huruf kecil semua dan tidak ada spasi di awal dan akhir

    $email = strtolower(trim($request['email'])); 
    $role = $request['role'];
    $username = $request['username'];


    // CEK APAKAH EMAIL SUDAH SESUAI DENGAN FORMAT
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        echo "<script>
            alert('Format email tidak sesuai!');
        </script>";
        return;
    }

    // CEK APAKAH EMAIL SUDAH ADA DI DATABASE
    $resultCheckEmail = mysqli_query($conn, "SELECT email FROM client WHERE email = '$email'");
    //cek hasil result lebih dari 0 -> email sudah digunakan
    if (mysqli_num_rows($resultCheckEmail) > 0) { 
        echo "<script>
            alert('Email sudah dipakai! Ganti dengan email lain!');
        </script>";
        return;
    }

    // AMBIL PW LALU SIMPAN DI VARIABLE
    $pw = mysqli_real_escape_string($conn, $request['pw']);
    $pw2 = mysqli_real_escape_string($conn, $request['pw2']);

    // CEK PW1 === PW2 ?
    if ($pw !== $pw2) {
        echo "<script>
            alert('Password tidak sama!');
        </script>";
        return;
    }

    // HASH PW -> mengacak pw
    $pw = password_hash($pw, PASSWORD_DEFAULT);
    $pw2 = password_hash($pw2, PASSWORD_DEFAULT);

    // SIMPAN EMAIL DAN PW
    $result = mysqli_query($conn, "INSERT INTO client(email, pw, username, role) VALUES('$email', '$pw', '$username', '$role')");
    if ($result) {
        echo "<script>
                alert('Berhasil membuat akun! Silakan login ulang');
                window.location.replace('login.php');
            </script>";
    }
}

function login($request) {
    global $conn;
    // AMBIL EMAIL & PASSWORD LALU SIMPAN DI VARIABLE
    $email = $request['email'];
    $pw = $request['pw'];

    // QUERY EMAIL YANG SAM DENGAN $email
    $result = mysqli_query($conn, "SELECT * FROM client WHERE email = '$email'");
    // CEK EMAIL ADA DI DATABASE ATAU TIDAK
    if (mysqli_num_rows($result) === 1) {
        // CEK PW APAKAH SAMA DENGAN PW YANG ADA DI DATABASE
        $dataFetch = mysqli_fetch_assoc($result);
        if (password_verify($pw, $dataFetch['pw'])) {

            // Set sesi
            $_SESSION['login'] = true;
            $_SESSION['id'] = $dataFetch['id'];
            $_SESSION['role'] = $dataFetch['role']; // Simpan role ke session

            // Redirect berdasarkan role
            if ($_SESSION['role'] === 'seller') {
                echo "<script>
                localStorage.removeItem('loginFormData');
                </script>";
                header('Location: index-seller.php');  // Jika seller, arahkan ke index-seller.php
            } else {
                echo "<script>
                localStorage.removeItem('loginFormData');
                </script>";
                header('Location: index.php');  // Jika buyer, arahkan ke index.php
            }
            exit;
        } else {
            // Jika password salah
            echo "<script>
                    alert('Password is Incorrect!');
                    window.location.replace('login.php');
                  </script>"; 
            return;
        }
    } else {
        // Jika username tidak ditemukan
        echo "<script>
                alert('Username Not Found!');
                window.location.replace('login.php');
              </script>";
        return;
    }
}
?>