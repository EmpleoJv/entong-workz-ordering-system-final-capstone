<?php
include('../connection/dbConnection.php');

$id = $_GET['id']; //this is from adminAddUser.php
$sql = "UPDATE items SET ITEM_STATUS='SHOW' WHERE ITEM_ID = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin_Dashboard_Inventory.php?msg=Show Item Successfully!!");
} else {
    header("Location: ../../admin_Dashboard_Inventory.php?msg=Show Item Failed!!");
}
