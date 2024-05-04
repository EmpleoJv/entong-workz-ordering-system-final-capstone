<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

$action = $_GET['id'];
echo $action;
$num = $_GET['num'];

$sql = "UPDATE orders SET PACKAGE_STATUS ='PAYMENT PENDING' WHERE ID = $action";
if ($conn->query($sql) === TRUE) {
    $ch = curl_init();
    $parameters = array(
        'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
        'number' => $num,
        'message' => "ENTONG WORKZ MOTORCYCLE PARTS AND ACCESSORIES
        Your Order status has been change 
        to PAYMENT PENDING!",
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
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Order Undo Successfully");
} else {
    header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
}
