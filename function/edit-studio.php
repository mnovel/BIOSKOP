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
    header('Location: ' . BASE_URL . 'admin/studio');
    exit;
}

$query = "UPDATE STUDIO SET NAMA = :NAMA, KELAS = :KELAS WHERE ID = :ID";
$parse = oci_parse($con, $query);

$nama = ucwords($_POST['nama']);
$kelas = $_POST['kelas'];
$id = (int)$_POST['id'];

oci_bind_by_name($parse, ':NAMA', $nama);
oci_bind_by_name($parse, ':KELAS', $kelas);
oci_bind_by_name($parse, ':ID', $id);

$res = oci_execute($parse);

if ($res) {
    setcookie('alert', "success|Berhasil mengedit studio", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/studio');
    exit;
} else {
    setcookie('alert', "error|Gagal mengedit studio", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/studio');
    exit;
}

oci_free_statement($stmt);
