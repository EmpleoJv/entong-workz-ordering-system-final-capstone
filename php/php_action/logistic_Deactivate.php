<?php
include('../connection/dbConnection.php');

$id = $_GET['id']; //this is from adminAddUser.php
$sql = "UPDATE companylogin SET STATUS='deactivate' WHERE ID = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../admin_Dashboard_User/logistic.php?msg= Deactivate User Successfully!!");
} else {
    header("Location: ../admin_Dashboard_User/logistic.php?msg= Deactivate User Failed!!");
}
