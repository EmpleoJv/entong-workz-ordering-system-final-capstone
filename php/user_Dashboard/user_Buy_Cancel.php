<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (isset($_REQUEST['startCancelation'])) {
    // $quantity = $_POST['quantity'];
    // $itemId = $_POST['itemId'];
    // $orderid = $_POST['orderid'];
    $code = $_POST['code'];
    $reason = $_POST['reason'];

    $sqlz = "UPDATE ordercode SET PACKAGE_STATUS = 'ORDER CANCELED', REASON_FOR_CANCEL = '$reason' WHERE CODE = '$code'";
    if ($conn->query($sqlz) === TRUE) {

        $sql = "SELECT * FROM orders WHERE ORDERCODE = '$code' ORDER BY ID DESC";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $quantity = $row['QUANTITY'];
            $itemid = $row['ITEM_ID'];

            $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY + $quantity WHERE ITEM_ID = $itemid";
            if ($conn->query($sqlsss) === TRUE) {

                echo "good";
                header("Location: user_Buy_Orders.php?addMsg= Cancel Success");
            } else {
                header("Location: user_Buy_Orders.php?addMsg= Update Failed");
                echo "bad";
            }
        }
    } else {
        header("Location: user_Buy_Orders.php?error = Update Success");
    }






    // $sqlz = "UPDATE ordercode SET PACKAGE_STATUS = 'ORDER CANCELED', REASON_FOR_CANCEL = '$reason' WHERE CODE = '$code'";
    // if ($conn->query($sqlz) === TRUE) {
    //     $sql = "UPDATE orders SET PACKAGE_STATUS = 'ORDER CANCELED', REASON_FOR_CANCEL = '$reason' WHERE ID = '$orderid'";
    //     if ($conn->query($sql) === TRUE) {
    //         $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY + $quantity WHERE ITEM_ID = $itemId";
    //         if ($conn->query($sqlsss) === TRUE) {
    //             echo "good";
    //             header("Location: user_Buy_Orders.php?addMsg= Cancel Success");
    //         } else {
    //             header("Location: user_Buy_Orders.php?addMsg= Update Failed");
    //             echo "bad";
    //         }
    //     } else {
    //         // header("Location: user_Buy_Orders.php?error = Update Success");
    //     }
    // } else {
    //     // header("Location: user_Buy_Orders.php?error = Update Success");
    // }
}
