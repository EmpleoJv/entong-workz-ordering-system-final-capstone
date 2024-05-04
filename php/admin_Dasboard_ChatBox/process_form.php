<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
error_reporting(E_ERROR | E_PARSE);

// Get the form data
$mess = $_POST['message'];
$a = $_GET['a'];


//Create a insert query
$sql = "INSERT INTO support (NAME, MESSAGE, CODE, REPLY_BY, REPLY_ID)
VALUES ('$tdbAdminFirstname', '$mess', '$a', '$tdbAdminFirstname', '$tdbAdminId')";

if (mysqli_query($conn, $sql)) {
    echo "Message Sent";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// echo "Hello, $name! Your email is $email. $ous";
