<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');
$mainIDs = $_GET['id'];
echo $mainIDs;

$sql = "UPDATE onlinepayment SET STATUS ='ON PROCESS' WHERE ID = $mainIDs";

if ($conn->query($sql) === TRUE) {

    header("Location: ../../admin_Dashboard_Orders.php?errorss= Payment received Successfully");
    echo "good";
} else {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Payment received Failed");
    echo "bad";
}
