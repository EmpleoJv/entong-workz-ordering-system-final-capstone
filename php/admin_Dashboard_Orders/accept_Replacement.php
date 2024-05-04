<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

$id = $_GET['id'];
$currentDate = date('Y-m-d');
$orderid = $_GET['orderid'];
$num = $_GET['num'];
$ordercode = $_GET['ordercode'];

// Add 7 days
$newDate = date('Y-m-d', strtotime($currentDate . ' + 7 days'));
$sql = "UPDATE returnitem SET STATUS ='REPLACEMENT ACCEPTED', DELIVERY_EST = '$newDate', ACCEPTED_BY = '$tdbAdminId', QRCODE = '$ordercode$orderid' WHERE ID = $id";

if ($conn->query($sql) === TRUE) {
    $sqls = "UPDATE orders SET PACKAGE_STATUS ='REPLACEMENT ACCEPTED', DATE_DELIVERED = '$newDate' WHERE ID = $orderid";

    if ($conn->query($sqls) === TRUE) {
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
            'number' => $num,
            'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
            Your Order Replacement has been ACCEPTED
            ESTIMATED DELIVERY: $newDate",
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        //Send the parameters set above with the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        // Receive response from server
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        // curl_close($ch);
        //Show the server response
        echo $output;
        header("Location: ../../admin_Dashboard_Orders.php?errorss= REPLACEMENT ACCEPTED Successfully");
        echo "good";
    } else {
        header("Location: ../../admin_Dashboard_Orders.php?errorss= REPLACEMENT ACCEPTED Failed");
        echo "bad";
    }
} else {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= REPLACEMENT ACCEPTED Failed");
    echo "bad";
}

$newDate = date('Y-m-d', strtotime($currentDate . ' + 7 days'));
