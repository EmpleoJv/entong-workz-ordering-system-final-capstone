<?php
include('../connection/dbConnection.php');

$id = $_GET['id']; //this is from adminAddUser.php
$sql = "UPDATE items SET ITEM_STATUS='HIDE' WHERE ITEM_ID = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: ../../staff_Dashboard_Inventory.php?msg=Hide Item Successfully!!");
} else {
    header("Location: ../../staff_Dashboard_Inventory.php?msg=Hide Item Failed!!");
}
