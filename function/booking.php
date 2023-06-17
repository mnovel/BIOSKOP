<?php
include "../koneksi.php";


if (!empty($_POST['jam']) && !empty($_POST['film'])) {

    foreach ($_POST as $post => $value) {
        if ($post != 'jam' && $post != 'film') {
            if (!preg_match("/done/i", $post)) {
                $query = "INSERT INTO BOOKING (ID_JAM_TAYANG, ID_USERS, KURSI) VALUES (:ID_JAM_TAYANG, (SELECT ID FROM USERS WHERE USERNAME = :USERNAME), :KURSI)";
                $parse = oci_parse($con, $query);

                $jam = $_POST['jam'];
                $film = $_POST['film'];
                $username = $_SESSION['login']['username'];

                oci_bind_by_name($parse, ':ID_JAM_TAYANG', $jam);
                oci_bind_by_name($parse, ':USERNAME', $username);
                oci_bind_by_name($parse, ':KURSI', $value);

                $res = oci_execute($parse);

                if (!$res) {
                    setcookie('alert', "error|Gagal booking tiket", time() + 3, '/');
                    header('Location: ' . BASE_URL . 'user/booking?film=' . $film . '&jam=' . $jam);
                    exit;
                }
            }
        }
    }
    setcookie('alert', "success|Berhasil menambahkan film", time() + 3, '/');
    header('Location: ' . BASE_URL . 'user/bayar?film=' . $film . '&jam=' . $jam);
    exit;
} else {
    setcookie('alert', "error|Silahkan pilih film dan jam tayang terlebih dahulu", time() + 3, '/');
    header('Location: ' . BASE_URL . 'user/booking?film=' . $film . '&jam=' . $jam);
    exit;
}

oci_free_statement($stmt);
