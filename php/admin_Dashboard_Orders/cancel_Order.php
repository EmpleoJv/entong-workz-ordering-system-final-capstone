<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

$action = $_GET['action'];
echo $action;

$sql = "UPDATE orders SET PACKAGE_STATUS ='ORDER CANCELED', ACCEPTED_BY ='$tdbAdminId' WHERE ID = $action";

if ($conn->query($sql) === TRUE) {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Order cancel Successfully");
} else {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Order cancel Failed");
}
