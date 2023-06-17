<?php
include "../koneksi.php";



$alert = "";
foreach ($_POST as $name => $val) {
    if (empty($_POST[$name])) {
        $alert .= "$name, ";
    }
}

if (!empty($alert)) {
    $len = strlen($alert);
    $tr = substr($alert, 0, $len - 2);
    setcookie('alert', "error|" . ucfirst($tr) . " tidak boleh kosong", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang');
    exit;
}


$query = "INSERT INTO JAM_TAYANG (JAM, ID_FILM, ID_STUDIO, HARGA) VALUES (TO_DATE(:JAM, 'YYYY-MM-DD HH24:MI:SS'), :ID_FILM, :ID_STUDIO, :HARGA)";
$parse = oci_parse($con, $query);

$jam = $_POST['jam'] . ':00';
$film = $_POST['film'];
$studio = $_POST['studio'];
$harga = (int)$_POST['harga'];

oci_bind_by_name($parse, ':JAM', $jam);
oci_bind_by_name($parse, ':ID_FILM', $film);
oci_bind_by_name($parse, ':ID_STUDIO', $studio);
oci_bind_by_name($parse, ':HARGA', $harga);

$res = oci_execute($parse);

if ($res) {
    setcookie('alert', "success|Berhasil menambahkan film", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang');
    exit;
} else {
    setcookie('alert', "error|Film sudah ada", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang');
    exit;
}

oci_free_statement($stmt);
