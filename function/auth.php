<?php
include "../koneksi.php";


if (count($_POST) == 2) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM USERS WHERE USERNAME = :username AND PASSWORD = :password";

    $stmt = oci_parse($con, $query);

    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':password', $password);

    oci_execute($stmt);

    if ($res = oci_fetch_assoc($stmt)) {
        $_SESSION['login']['status'] = true;
        $_SESSION['login']['role'] = $res['ROLE'];
        $_SESSION['login']['username'] = $res['USERNAME'];
        $home = $res['ROLE'] == 1 ? 'admin' : 'user';
        header('Location: ' . BASE_URL . $home . '/dashboard');
        exit;
    } else {
        setcookie('alert', 'error|Username atau password tidak ditemukan', time() + 3, '/');
        header('Location: ' . BASE_URL);
        exit;
    }

    // Clean up
    oci_free_statement($stmt);
    oci_close($con);
} else {
    setcookie('alert', 'error|Username atau password tidak boleh kosong', time() + 3, '/');
    header('Location: ' . BASE_URL);
    exit;
}
