<?php
function register($request) {
    global $conn;
    // AMBIL EMAIL LALU SIMPAN DI VARIABLE
    // Sanitasi email agar huruf kecil semua dan tidak ada spasi di awal dan akhir
    $email = strtolower(trim($request['email'])); 

    // CEK APAKAH EMAIL SUDAH SESUAI DENGAN FORMAT
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        echo "<script>
            alert('Format email tidak sesuai!');
        </script>";
        return;
    }

    // CEK APAKAH EMAIL SUDAH ADA DI DATABASE
    $resultCheckEmail = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
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
    $result = mysqli_query($conn, "INSERT INTO users(email, pw) VALUES('$email', '$pw')");
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
    $email = trim($request['email']);
    $pw = $request['pw'];

    // QUERY EMAIL YANG SAM DENGAN $email
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    // CEK EMAIL ADA DI DATABASE ATAU TIDAK
    if (mysqli_num_rows($result) === 1) {
        // CEK PW APAKAH SAMA DENGAN PW YANG ADA DI DATABASE
        $dataFetch = mysqli_fetch_assoc($result);
        if (password_verify($pw, $dataFetch['pw'])) {

            // Set sesi
            $_SESSION['login'] = true;
            header('location: ../index.php');
            exit;
        } else {
            echo "<script>
                alert('Password salah!');
            </script>";
            return;
        }
    } else {
        echo "<script>
            alert('Email tidak sesuai!');
        </script>";
        return;
    }
}
?>