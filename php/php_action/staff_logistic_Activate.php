<?php
include('../connection/dbConnection.php');

$id = $_GET['id']; //this is from adminAddUser.php
$sql = "UPDATE companylogin SET STATUS='active' WHERE ID = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../admin_Dashboard_User/deactivated.php?msg= Activate User Successfully!!");
} else {
    header("Location: ../admin_Dashboard_User/deactivated.php?msg= Activate User Failed!!");
}
