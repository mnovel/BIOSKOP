<?php
include "../koneksi.php";

$alert = "";
foreach ($_GET as $name => $val) {
    if (empty($_GET[$name])) {
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

$id = (int)$_GET['id'];

$query = "DELETE FROM STUDIO WHERE ID = :ID";
$parse = oci_parse($con, $query);
oci_bind_by_name($parse, ':ID', $id);
$res = oci_execute($parse);

if ($res) {
    setcookie('alert', "success|Berhasil menghapus studio", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/studio');
    exit;
} else {
    setcookie('alert', "error|Gagal menghapus studio", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/studio');
    exit;
}

oci_free_statement($stmt);
