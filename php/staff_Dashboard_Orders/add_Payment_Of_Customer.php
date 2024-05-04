<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (isset($_REQUEST['submit_Payment'])) {

    // $customers_Payment = $_POST['customers_Payment'];
    $id = $_POST['id'];
    $topay = $_POST['topay'];
    $status = $_POST['status'];
    $status = $_POST['status'];
    $num = $_POST['num'];

    echo $status;
    echo $id;
    echo $topay;
    echo $num;

    $sql = "UPDATE onlinepayment SET STATUS = 'RECIEVED' WHERE ORDER_CODE= '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        $sql = "UPDATE ordercode SET TOTAL_PRICE = TOTAL_PRICE - $topay, TO_PAY_ONLINE = 0, PACKAGE_STATUS = 'ORDER ACCEPTED', QRCODE = '$id$tdbAdminId', ACCEPTED_BY='$tdbAdminId' WHERE CODE= '$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
            $sqlss = "SELECT * FROM orders WHERE ORDERCODE = '$id';";
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


            $sqlss = "SELECT * FROM ordercode WHERE CODE = '$id';";
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
                Your Order ID : $id has been accepted!
                $message 
                $messageTotal
                ",
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
            header("Location: ../../staff_Dashboard_Orders.php?errorss= Payment of order number . $id . accepted");
        } else {
            header("Location: ../../staff_Dashboard_Orders.php?errorss= Update Failed");
        }
    } else {
        header("Location: ../../staff_Dashboard_Orders.php?errorss= Update Failed");
    }

    // $sql = "SELECT * FROM ordercode WHERE CODE = '$id'";
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     while ($row = $result->fetch_assoc()) {
    //     }
    // } else {
    //     echo "0 results";
    // }

    // $sql = "UPDATE orders SET TO_PAY ='$customers_Payment' WHERE ID = $id";
    // if ($conn->query($sql) === TRUE) {
    //     header("Location: ../../admin_Dashboard_Orders.php?errorss= Payment of order number . $id . updated");
    // } else {
    //     header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
    // }
}
