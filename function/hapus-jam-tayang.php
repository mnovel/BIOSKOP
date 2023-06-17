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

function getIdStudio($id)
{
    global $con;
    $query = "SELECT ID_STUDIO FROM JAM_TAYANG WHERE ID = :ID";
    $parse = oci_parse($con, $query);
    oci_bind_by_name($parse, ':ID', $id);
    oci_execute($parse);
    $res = oci_fetch_assoc($parse);
    oci_free_statement($parse);

    return $res['ID_STUDIO'];
}

$id = (int)$_GET['id'];
$idStudio = getIdStudio($id);

$query = "DELETE FROM JAM_TAYANG WHERE ID = :ID";
$parse = oci_parse($con, $query);
oci_bind_by_name($parse, ':ID', $id);
$res = oci_execute($parse);

if ($res) {
    setcookie('alert', "success|Berhasil menghapus jam tayang", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang?studio=' . $idStudio);
    exit;
} else {
    setcookie('alert', "error|Gagal menghapus jam tayang", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang?studio=' . $idStudio);
    exit;
}

oci_free_statement($stmt);
