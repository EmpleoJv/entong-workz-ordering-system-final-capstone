<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

if (isset($_GET['delivered'])) {
    $code = $_GET['code'];
    $date = date('Y-m-d');

    $sqls = "SELECT * FROM returnitem WHERE QRCODE = '$code' AND STATUS = 'REPLACEMENT ACCEPTED'";
    $results = $conn->query($sqls);
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $orderId = $row['ORDERID'];

            $sql = "UPDATE returnitem SET DELIVER_BY = '$tdbAdminId', DELIVERY_EST = '$date', STATUS = 'REPLACEMENT SUCCESS' WHERE QRCODE = '$code'";
            if ($conn->query($sql) === TRUE) {

                $sqlss = "UPDATE orders SET PACKAGE_STATUS = 'REPLACEMENT SUCCESS', DATE_DELIVERED= '$date' WHERE ID = '$orderId'";
                if ($conn->query($sqlss) === TRUE) {

                    echo "Record updated successfully";
                    header("Location: ../../replacementDeliver.php?error=Recorded Successfully");
                    echo $code;
                } else {
                    echo "Error updating record: " . $conn->error;
                    header("Location: ../../replacementDeliver.php?error=Record not found for QRCODE: . $code");
                }
            } else {
                echo "Error updating record: " . $conn->error;
                header("Location: ../../replacementDeliver.php?error=Record not found for QRCODE: . $code");
            }
        }
    } else {
        echo "Record not found for QRCODE: " . $code;
        header("Location: ../../replacementDeliver.php?error=Record not found to be scaned and deliver: $code");
    }
}
