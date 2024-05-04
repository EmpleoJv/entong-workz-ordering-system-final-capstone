<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (isset($_REQUEST['startCancelation'])) {
    // $quantity = $_POST['quantity'];
    // $itemId = $_POST['itemId'];
    $orderid = $_POST['orderid'];
    $reason = $_POST['reason'];
    $num = $_POST['num'];

    // $sql = "UPDATE orders SET PACKAGE_STATUS = 'ORDER CANCELED', REASON_FOR_CANCEL = '$reason' WHERE ID = $orderid";
    // if ($conn->query($sql) === TRUE) {
    //     $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY + $quantity WHERE ITEM_ID = $itemId";
    //     if ($conn->query($sqlsss) === TRUE) {
    //         echo "good";
    //         $ch = curl_init();
    //         $parameters = array(
    //             'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
    //             'number' => $num,
    //             'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
    //             Dear Customer,
    //             Your order has been canceled by the 
    //             staff members because of the following,
    //             $reason",
    //             'sendername' => 'SEMAPHORE'
    //         );
    //         curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         //Send the parameters set above with the request
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
    //         // Receive response from server
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $output = curl_exec($ch);
    //         // curl_close($ch);
    //         //Show the server response
    //         echo $output;

    //         header("Location: ../../admin_Dashboard_Orders.php?errorss= Cancel Success");
    //     } else {
    //         header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
    //         echo "bad";
    //     }
    // } else {
    //     // header("Location: user_Buy_Orders.php?error = Update Success");
    // }



    $sqlz = "UPDATE ordercode SET PACKAGE_STATUS = 'ORDER CANCELED', REASON_FOR_CANCEL = '$reason' WHERE CODE = '$orderid'";
    if ($conn->query($sqlz) === TRUE) {

        $sql = "SELECT * FROM orders WHERE ORDERCODE = '$orderid' ORDER BY ID DESC";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_array($result)) {
            $quantity = $row['QUANTITY'];
            $itemid = $row['ITEM_ID'];

            $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY + $quantity WHERE ITEM_ID = $itemid";
            if ($conn->query($sqlsss) === TRUE) {
                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
                    'number' => $num,
                    'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
                    Dear Customer,
                    Your order has been canceled by the 
                    staff members because of the following,
                    $reason",
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
                echo "good";

                header("Location: ../../admin_Dashboard_Orders.php?errorss= Cancel Success");
            } else {
                header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
                echo "bad";
            }
        }
    } else {
        header("Location: user_Buy_Orders.php?error = Update Success");
    }
}
