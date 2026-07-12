<?php

$host = "sql111.infinityfree.com";
$user = "if0_42386269";
$password = "NI3MOWvVqrl";
$database = "if0_42386269_adnuprints";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>