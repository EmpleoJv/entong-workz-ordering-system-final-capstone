<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

// Get the form data
$mess = $_POST['message'];


//Create a insert query

$sql = "INSERT INTO support (NAME, MESSAGE, CODE)
VALUES ('$tdbAdminFirstname', '$mess', '$tdbAdminId')";

if (mysqli_query($conn, $sql)) {
    echo "Message Sent";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// echo "Hello, $name! Your email is $email. $ous";
