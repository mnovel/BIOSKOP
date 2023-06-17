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

$jam = $_POST['jam'] . ':00';
$film = $_POST['film'];
$studio = $_POST['studio'];
$harga = (int)$_POST['harga'];
$idJamTayang = (int)$_POST['id'];
$idStudio = (int)$_POST['idStudio'];

$query = "UPDATE JAM_TAYANG SET JAM = TO_DATE(:JAM, 'YYYY-MM-DD HH24:MI:SS'), ID_FILM = :ID_FILM, ID_STUDIO = :ID_STUDIO, HARGA = :HARGA WHERE ID = :ID";
$parse = oci_parse($con, $query);

oci_bind_by_name($parse, ':JAM', $jam);
oci_bind_by_name($parse, ':ID_FILM', $film);
oci_bind_by_name($parse, ':ID_STUDIO', $studio);
oci_bind_by_name($parse, ':HARGA', $harga);
oci_bind_by_name($parse, ':ID', $idJamTayang);

$res = oci_execute($parse);

if ($res) {
    setcookie('alert', "success|Berhasil mengedit jam tayang", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang?studio=' . $idStudio);
    exit;
} else {
    setcookie('alert', "error|Gagal mengedit jam tayang", time() + 3, '/');
    header('Location: ' . BASE_URL . 'admin/jam-tayang?studio=' . $idStudio . '&jam_tayang=' . $idJamTayang);
    exit;
}

oci_free_statement($stmt);
