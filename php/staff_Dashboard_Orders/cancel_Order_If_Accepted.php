<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

$action = $_GET['action'];
$iditem = $_GET['iditem'];
$much = $_GET['much'];

echo $action;

$sql = "UPDATE orders SET PACKAGE_STATUS ='ORDER CANCELED', ACCEPTED_BY ='$tdbAdminId' WHERE ID = $action";

if ($conn->query($sql) === TRUE) {
    $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY + $much WHERE ITEM_ID = $iditem";

    if ($conn->query($sqlsss) === TRUE) {
        header("Location: ../../admin_Dashboard_Orders.php?errorss= Order cancel Successfully");
        echo "good";
    } else {
        header("Location: ../../admin_Dashboard_Orders.php?errorss= Order cancel Failed");
        echo "bad";
    }
} else {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
}
