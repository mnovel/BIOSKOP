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
    header('Location: ' . BASE_URL . 'user/tiket');
    exit;
}


$foto = upFiile($_FILES['foto']);
$jam = $_POST['jam'];
$username = $_SESSION['login']['username'];


$query = "UPDATE BOOKING SET STATUS = 2, FOTO = :FOTO WHERE ID_JAM_TAYANG = :ID_JAM_TAYANG AND ID_USERS = (SELECT ID FROM USERS WHERE USERNAME =:USERNAME)";
$parse = oci_parse($con, $query);
oci_bind_by_name($parse, ':ID_JAM_TAYANG', $jam);
oci_bind_by_name($parse, ':USERNAME', $username);
oci_bind_by_name($parse, ':FOTO', $foto);

$res = oci_execute($parse);
if ($res) {
    setcookie('alert', "success|Berhasil melakukan pembayaran", time() + 3, '/');
    header('Location: ' . BASE_URL . 'user/tiket');
    exit;
} else {
    setcookie('alert', "error|Gagal melakukan pembayaran", time() + 3, '/');
    header('Location: ' . BASE_URL . 'user/tiket');
    exit;
}

oci_free_statement($stmt);
