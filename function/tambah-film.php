<?php
include "../koneksi.php";


if (!empty($_POST['id'])) {

    $query = "INSERT INTO FILM (UUID) VALUES (:UUID)";
    $parse = oci_parse($con, $query);

    $id = (int)$_POST['id'];
    oci_bind_by_name($parse, ':UUID', $id);

    $res = oci_execute($parse);


    if ($res) {
        setcookie('alert', "success|Berhasil menambahkan film", time() + 3, '/');
        header('Location: ' . BASE_URL . 'admin/list-film');
        exit;
    } else {
        setcookie('alert', "error|Film sudah ada", time() + 3, '/');
        header('Location: ' . BASE_URL . 'admin/tambah-film');
        exit;
    }
} else {
    setcookie('alert', "error|Id film tidak boleh kosong", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/tambah-film');
    exit;
}

oci_free_statement($stmt);
