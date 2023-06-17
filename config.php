<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
// define('BASE_URL', 'https://dies.serveo.net/stok/');\
$domain = $_SERVER['SERVER_NAME'];
define('BASE_URL', "http://" . $domain . "/bioskop/");


function convertToTime($menit)
{
    $jam = floor($menit / 60);
    $sisaMenit = $menit % 60;

    return sprintf("%2d Jam%2d Menit", $jam, $sisaMenit);
}

function formatRupiah($angka)
{
    $rupiah = "Rp. " . number_format($angka, 0, ",", ".");
    return $rupiah;
}

function getDetailFilm($id)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.themoviedb.org/3/movie/$id?language=en-US",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIxNDgwODhhODQzYWFjZjg3ODQzNjZlOTBiNGE1OTM4ZCIsInN1YiI6IjYwYzg2ODY3MTg4NjRiMDA2ZTJjYmQ1ZiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.L3wY_ELyTYpGOuSP_UC3YYATnX6UUWhofp0dwmA3CSc',
            'accept: application/json',
        ],
    ]);
    $response = json_decode(curl_exec($curl));
    curl_close($curl);

    return $response;
}

function upFiile($foto)
{
    $dir = "../upload/";
    $imageFileType = strtolower(pathinfo(basename($foto["name"]), PATHINFO_EXTENSION));
    $name = date('YmdHis', strtotime(time())) . rand(30, 100) . '.' . $imageFileType;
    $target_file = $dir . $name;

    $check = getimagesize($foto["tmp_name"]);
    if ($check == false) {
        setcookie('alert', "warning|Hanya file gambar yang diizinkan", time() + 3, '/');
        header('Location: ' . BASE_URL . 'admin/produk');
        exit;
    }
    if (!preg_match('/(jpg|png|jpeg)/i', $imageFileType)) {
        setcookie('alert', "warning|Ekstensi file harus berformat foto", time() + 3, '/');
        header('Location: ' . BASE_URL . 'admin/produk');
        exit;
    }
    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        return $name;
    } else {
        setcookie('alert', "warning|Terjadi error ketika menyimpan foto", time() + 3, '/');
        header('Location: ' . BASE_URL . 'admin/produk');
        exit;
    }
}
