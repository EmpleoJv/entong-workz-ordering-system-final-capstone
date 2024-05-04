<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

$action = $_GET['action'];
// $code = $_GET['qrCode'];
// $iditem = $_GET['iditem'];
// $much = $_GET['much'];
$num = $_GET['num'];

echo $action . "<br>";
echo $code . "<br>";
echo $tdbAdminId;

// $min = 10000;  // Minimum value
// $max = 99999;  // Maximum value

// $randomNumber = random_int($min, $max);

$sql = "UPDATE ordercode SET PACKAGE_STATUS = 'ORDER ACCEPTED', QRCODE = '$action$tdbAdminId', ACCEPTED_BY='$tdbAdminId'WHERE CODE= '$action'";
if ($conn->query($sql) === TRUE) {

    $sqlss = "SELECT * FROM orders WHERE ORDERCODE = '$action';";
    $resultss = $conn->query($sqlss);

    if ($resultss->num_rows > 0) {
        while ($rowss = $resultss->fetch_assoc()) {
            $oi = $rowss['ORDERED_ITEM'];
            $pr = $rowss['ITEM_PRICE'];
            $qu = $rowss['QUANTITY'];
            $tp = $rowss['TOTAL_PRICE'];

            $message .= "
            Item Name: $oi
            Item Price: ₱$pr.00
            Item Quantity: x$qu
            Item Total Price: ₱$tp
            ";
        }
    } else {
        echo "0 results";
    }


    $sqlss = "SELECT * FROM ordercode WHERE CODE = '$action';";
    $resultss = $conn->query($sqlss);

    if ($resultss->num_rows > 0) {
        while ($rowss = $resultss->fetch_assoc()) {
            $ois = $rowss['TOTAL_PRICE'];
            $prs = $rowss['TO_PAY_ONLINE'];
            $op = $rowss['PAYMENT_OPTION'];

            $messageTotal .= "
            To Pay Online: ₱$prs
            Total Price Left: ₱$ois
            Payment Option : $op
            ";
        }
    } else {
        echo "0 results";
    }

    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
        'number' => $num,
        'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
        Your Order ID : $action 
        $message $messageTotal
        has been accepted!",
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









    header("Location: ../../admin_Dashboard_Orders.php?errorss= Order Accepted");
} else {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Order Failed, The item is Hidden!");
}


// $sqlSelect = "SELECT ITEM_QUANTITY FROM items WHERE ITEM_ID = $iditem AND ITEM_STATUS = 'SHOW'; ";
// $resultSelect = $conn->query($sqlSelect);
// if ($resultSelect->num_rows > 0) {
//     // output data of each row
//     while ($rowSelect = $resultSelect->fetch_assoc()) {
//         $value = $rowSelect['ITEM_QUANTITY'];
//         if ($much <= $value) {
//             $sql = "UPDATE orders SET PACKAGE_STATUS ='ORDER ACCEPTED', ACCEPTED_BY ='$tdbAdminId', QRCODE ='$action$code$tdbAdminId' WHERE ID = $action";

//             if ($conn->query($sql) === TRUE) {
//                 $ch = curl_init();
//                 $parameters = array(
//                     'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
//                     'number' => $num,
//                     'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
//                     Your Order ID : $action 
//                     has been accepted!",
//                     'sendername' => 'SEMAPHORE'
//                 );
//                 curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
//                 curl_setopt($ch, CURLOPT_POST, 1);
//                 //Send the parameters set above with the request
//                 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
//                 // Receive response from server
//                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                 $output = curl_exec($ch);
//                 // curl_close($ch);
//                 //Show the server response
//                 echo $output;

//                 header("Location: ../../admin_Dashboard_Orders.php?errorss= Order Accepted");
//                 // $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - $much WHERE ITEM_ID = $iditem";

//                 // if ($conn->query($sqlsss) === TRUE) {
//                 //     echo "good";
//                 // } else {
//                 //     header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
//                 //     echo "bad";
//                 // }
//             } else {
//                 header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
//             }
//         } else {
//             echo "bad";
//             header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
//         }
//     }
// } else {
//     header("Location: ../../admin_Dashboard_Orders.php?errorss= Order Failed, The item is Hidden!");
// }
