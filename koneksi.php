<?php
include "config.php";

$username = "BIOSKOP";
$password = "BIOSKOP";
$database = "localhost/xe";

$con = oci_connect($username, $password, $database);
if (!$con) {
    $m = oci_error();
    trigger_error('Could not connect to database: ' . $m['message'], E_USER_ERROR);
}
