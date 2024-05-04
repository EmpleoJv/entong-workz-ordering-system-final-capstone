<?php
include('../connection/dbConnection.php');

if (isset($_REQUEST['signup_Submit'])) {

    $firstname = $_POST['regFirstname'];
    $lastaname = $_POST['regLastname'];
    $email = $_POST['regEmail'];
    $password = $_POST['regPassword'];
    $age = $_POST['regAge'];
    $gender = $_POST['regGender'];

    $sql = "INSERT INTO userlogin (FIRSTNAME, LASTNAME, EMAIL, PASSWORD, AGE, GENDER)
    VALUES ('$firstname', '$lastaname', '$email', '$password', '$age', '$gender');";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error";
    }
}
