<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

if (isset($_GET['delivered'])) {

    // echo "pota";

    $code = $_GET['code'];
    $date = date('Y-m-d');

    // Check if a record with the specified QRCODE exists
    // $sqls = "SELECT * FROM orders WHERE QRCODE = '$code', PACKAGE_STATUS = 'ORDER ACCEPTED'";
    $sqls = "SELECT * FROM ordercode WHERE QRCODE = '$code' AND PACKAGE_STATUS = 'ORDER ACCEPTED'";

    $results = $conn->query($sqls);

    if ($results->num_rows > 0) {
        // A record with the specified QRCODE exists
        // You can directly update the record without looping
        while ($row = $results->fetch_assoc()) {
            $sql = "UPDATE ordercode SET DELIVERED_BY = '$tdbAdminId', DELIVERY_DATE = '$date', PACKAGE_STATUS = 'ORDER SUCCESS', TOTAL_PRICE = 0 WHERE QRCODE = '$code'";

            if ($conn->query($sql) === TRUE) {

                // $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - 1 WHERE ITEM_ID = $itemID";

                // if ($conn->query($sqlsss) === TRUE) {
                //     // header("Location: user_Buy_Orders.php?error = Cancel Success");
                //     echo "good";
                // } else {
                //     // header("Location: user_Buy_Orders.php?error = Update Success");
                // }
                echo "Record updated successfully";
                header("Location: ../../logistic_Dashboard.php?error=Recorded Successfully");

                echo $code;
            } else {
                echo "Error updating record: " . $conn->error;
                header("Location: ../../logistic_Dashboard.php?error=Record not found for QRCODE: . $code");
            }
        }
    } else {
        echo "Record not found for QRCODE: " . $code;
        header("Location: ../../logistic_Dashboard.php?error=Record not found to be scaned and deliver: . $code");
    }

    // Rest of your code here
}
