<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (isset($_REQUEST['startCancelation'])) {
    $id = $_POST['id'];
    $orderid = $_POST['orderid'];
    $reason = $_POST['reason'];
    $num = $_POST['num'];

    $sql = "UPDATE orders SET PACKAGE_STATUS = 'REPLACEMENT DECLINED' WHERE ID = $orderid";
    if ($conn->query($sql) === TRUE) {
        $sqls = "UPDATE returnitem SET STATUS = 'REPLACEMENT DECLINED', MESSAGE = '$reason' WHERE ID = $id";
        if ($conn->query($sqls) === TRUE) {
            $ch = curl_init();
            $parameters = array(
                'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
                'number' => $num,
                'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
                Your Order Replacement has been declined 
                Reason : $reason",
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
            header("Location: ../../admin_Dashboard_Orders.php?errorss= Replace Decline message Success");
        } else {
            header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
            echo "bad";
            // header("Location: user_Buy_Orders.php?error = Update Success");
        }
    } else {
        header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
        echo "bad";
        // header("Location: user_Buy_Orders.php?error = Update Success");
    }
} else {
    header("Location: ../../admin_Dashbaord_Orders.php?errorss= Update Failed");
    echo "bad";
    // header("Location: user_Buy_Orders.php?error = Update Success");
}
