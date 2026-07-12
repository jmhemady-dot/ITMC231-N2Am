<?php

$host = "sql12.freesqldatabase.com";
$user = "sql12832861";
$password = "JcHRkhzQgl";
$database = "sql12832861";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>