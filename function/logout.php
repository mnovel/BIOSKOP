<?php
include "../config.php";

session_destroy();
setcookie('alert', 'success|Berhasil keluar', time() + 3, '/');
header('Location: ' . BASE_URL);
exit;
