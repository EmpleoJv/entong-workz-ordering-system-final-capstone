<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (isset($_REQUEST['reset_Payment'])) {

    $total_price = $_POST['total_price'];
    $id = $_POST['id'];

    $sql = "UPDATE orders SET TO_PAY ='$total_price' WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../admin_Dashboard_Orders.php?errorss= Payment of order number . $id . updated");
    } else {
        header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
    }
}
