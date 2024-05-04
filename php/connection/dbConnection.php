<?php
$dbServerName = "127.0.0.1:3306";
$dbUser = "u730193550_root";
$dbPass = "123empleoPL";
$dbName = "u730193550_capstone";

$conn = mysqli_connect($dbServerName, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
