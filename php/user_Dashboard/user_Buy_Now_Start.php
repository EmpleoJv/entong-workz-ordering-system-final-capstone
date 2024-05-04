<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
if (isset($_REQUEST['submitOrder'])) {

    $orderHN = $_POST['houseName'];
    $orderPN = $_POST['provinceName'];
    $orderCN = $_POST['cityName'];
    $orderBN = $_POST['barangayName'];
    // $orderPS = "ORDER PENDING";
    $itemId = $_POST['itemIdHidden'];
    $orderIM = $_POST['itemImageHidden'];
    $orderIP = $_POST['itemInitialPrice'];
    $orderIF = $_POST['itemFee'];
    $orderPO = $_POST['payOption'];
    // $orderGC = $_POST['refNumIfGcash'];
    $orderTH = $_POST['totalHidden'];


    $orderIC = $_POST['itemCategory'];
    $tofay = 0;
    if ($orderPO == "GCASH") {
        $orderPS = "PAYMENT PENDING";
        $tofay = $orderTH;
    } else if ($orderPO == "HALF DOWNPAYMENT GCASH") {
        $orderPS = "PAYMENT PENDING";
        $tofay = $orderTH / 2;
    } else {
        $orderPS = "ORDER PENDING";
        $tofay = 0;
    }
    $date = date('Y-m-d');
    $sevenDaysLater = date('Y-m-d', strtotime($date . ' +7 days'));
    $threeDaysLater = date('Y-m-d', strtotime($date . ' +3 days'));
    $orderQN = $_POST['quantity'];
    $orderNM = $_POST['itemNameHidden'];
    $orderVC = $_POST['voucherCode'];
    $subsstotal = $_POST['subsstotal'];

    $voucherDiscount = 0;
    $checker = 0;
    $checker2 = 0;

    echo $orderVC . '<br>';
    // Check if a voucher code is provided and not empty
    // if (!empty($orderVC)) {
    //     $sql = "SELECT * FROM voucher WHERE CODE = '$orderVC' AND STATUS = 'UNUSED'";
    //     $result = $conn->query($sql);

    //     if ($result !== false && $result->num_rows > 0) {
    //         $row = $result->fetch_assoc();
    //         $voucherDiscount = $row['DISCOUNT'] / 100; // Convert to a decimal

    //         // Calculate the voucher discount and update the order total
    //         $voucherAmount = $voucherDiscount * $orderTH;
    //         $orderTH -= $voucherAmount;
    //         $checker = 1;
    //     } else {
    //         echo "Voucher code not found or invalid.";
    //     }
    // }

    // echo "Voucher Discount: " . ($voucherDiscount * 100) . "%<br>";
    // echo "Voucher Amount: " . $voucherAmount . "<br>";
    // echo "Order Total after Discount: " . $orderTH . "<br>";

    // Now you can proceed to insert the order into the database if needed
    // if ($checker = 1) {
    $orderVC = mysqli_real_escape_string($conn, $orderVC); // Escape the input to prevent SQL injection

    $sql = "UPDATE voucher SET STATUS = 'USED' WHERE CODE = '$orderVC'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully Voucher<br>";
    }
    // }
    $sql = "SELECT * FROM items WHERE ITEM_ID = '$itemId';";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        if ($row['ITEM_STATUS'] = 'SHOW') {
            $checker2 = 1;
        } else {
            header("Location: ../../admin_Dashboard_Orders.php?errorss= Order Suddenly became hidden, try again Later");
        }
    }
    $randomLetters = '';
    for ($i = 0; $i < 5; $i++) {
        $randomLetters .= chr(rand(65, 90)); // ASCII values for uppercase letters
    }
    $randomNumbers = rand(10000, 99999);
    $insert_querys = mysqli_query($conn, "INSERT INTO ordercode 
    (CODE,
    SALES,
    NUMBER,
    TOTAL_PRICE,
    PAYMENT_OPTION,
    TO_PAY_ONLINE,
    PACKAGE_STATUS,
    ORDER_DATE,
    DELIVERY_DATE,
    USER_ID) 
    VALUES 
    ('$randomNumbers$randomLetters',
    '$orderTH',
    '$tdbAdminNumber',
    '$orderTH',
    '$orderPO',
    '$tofay',
    '$orderPS',
    '$date',
    '$sevenDaysLater',
    '$tdbAdminId');");

    if (!$insert_querys) {
        echo "Error: " . mysqli_error($conn); // Output the error message for debugging
        exit; // Exit the loop immediately if an error occurs
        $sqlsss = "DELETE FROM ordercode WHERE CODE= $randomNumbers$randomLetters";
        if ($conn->query($sqlsss) === TRUE) {
            echo "Record deleted successfully";
            header("Location: ../../admin_Dashboard_Orders.php?errorss= Somethings Wrong try again!");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        // echo "failed";
    } else {
        $checker = 1;
    }
    // echo $tdbAdminId;
    if ($checker2 = 1) {
        if ($orderPO === "COD") {
            echo "cod";
            $insert_query = mysqli_query($conn, "INSERT INTO orders 
            (ITEM_ID,
            ORDERCODE,
            CUSTOMER_NUMBER,
            TO_PAY, 
            ORDER_TYPE_ID, 
            ORDER_BY, 
            ITEM_PRICE, 
            ORDER_CATEGORY, 
            -- ITEM_FEE,
            -- CITY_FEE,
            DATE, 
            ITEM_IMAGE,
            QUANTITY, 
            TOTAL_PRICE, 
            ORDERED_ITEM, 
            PACKAGE_STATUS, 
            PAYMENT_METHOD, 
            -- GCASH_REF_NUM, 
            DATE_LIMIT,
            ADDITIONAL_INFORMATION, 
            PROVINCE, 
            CITYMUNICIPALITY, 
            BARANGAY) 
            VALUES 
            ('$itemId',
            '$randomNumbers$randomLetters',
            '$tdbAdminNumber',
            '$tofay',
            'ONLINE', 
            '$tdbAdminId',
            '$orderIP',
            '$orderIC',
            -- '$orderIF',
            -- '$tdbUserCityFee',
            '$date',
            '$orderIM',
            '$orderQN', 
            '$orderTH',
            '$orderNM',
            '$orderPS',
            '$orderPO',
            -- '$orderGC',
            '$sevenDaysLater',
            '$orderHN',
            '$orderPN',
            '$orderCN',
            '$orderBN');");
            if (!$insert_query) {
                $checker = 0;
                echo "bad";
            } else {
                echo "good";
                $checker = 1;
                $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - $orderQN WHERE ITEM_ID = $itemId";
                if ($conn->query($sqlsss) === TRUE) {
                    echo "good";
                } else {
                    header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
                    echo "bad";
                }
            }
        } else if ($orderPO === "GCASH" or $orderPO === "HALF DOWNPAYMENT GCASH") {
            echo "GCASH";
            $insert_query = mysqli_query($conn, "INSERT INTO orders 
            (ITEM_ID,
            ORDERCODE,
            CUSTOMER_NUMBER,
            TO_PAY, 
            ORDER_TYPE_ID, 
            ORDER_BY, 
            ITEM_PRICE, 
            ORDER_CATEGORY, 
            -- ITEM_FEE,
            -- CITY_FEE,
            DATE, 
            ITEM_IMAGE,
            QUANTITY, 
            TOTAL_PRICE, 
            ORDERED_ITEM, 
            PACKAGE_STATUS, 
            PAYMENT_METHOD, 
            -- GCASH_REF_NUM, 
            DATE_LIMIT,
            DATE_PAY_LIMIT,
            ADDITIONAL_INFORMATION, 
            PROVINCE, 
            CITYMUNICIPALITY, 
            BARANGAY) 
            VALUES 
            ('$itemId',
            '$randomNumbers$randomLetters',
            '$tdbAdminNumber',
            '$tofay',
            'ONLINE', 
            '$tdbAdminId',
            '$orderIP',
            '$orderIC',
            -- '$orderIF',
            -- '$tdbUserCityFee',
            '$date',
            '$orderIM',
            '$orderQN', 
            '$orderTH',
            '$orderNM',
            '$orderPS',
            '$orderPO',
            -- '$orderGC',
            '$sevenDaysLater',
            '$threeDaysLater',

            '$orderHN',
            '$orderPN',
            '$orderCN',
            '$orderBN');");
            if (!$insert_query) {
                $checker = 0;
                echo "bad";
                header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
            } else {
                echo "good";
                $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - $orderQN WHERE ITEM_ID = $itemId";
                if ($conn->query($sqlsss) === TRUE) {
                    $checker = 1;

                    echo "good";
                } else {
                    $checker = 0;

                    header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
                    echo "bad";
                }
            }
        }
    }

    if ($checker = 1) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'empleojv22@gmail.com';
        $mail->Password = 'voriswopmgblddvn';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Sender info
        $mail->setFrom('empleojv22@gmail.com', 'EWOS');
        // Add a recipient
        $mail->addAddress($tdbAdminEmail);
        // Set email format to HTML
        $mail->isHTML(true);
        // Mail subject
        $mail->Subject = 'Email from Localhost Server';
        // Mail body content
        $bodyContent = '<h1>Entong Workz</h1><br>';
        // Concatenate the loop values to the email body content
        // $bodyContent .= "Item ID: $itemId<br>";
        // // $bodyContent .= "Item Image: $orderIM<br>";
        // $bodyContent .= "Item Price: $orderIP<br>";
        // $bodyContent .= "Item Quantity: $orderQN<br>";
        // $bodyContent .= "Item Total Price: $orderTH<br>";
        // $bodyContent .= "Item Name: $orderNM<br>";
        $bodyContent .= "<br>"; // Add some separation between items
        $bodyContent .= "Item Name: $orderNM<br>";
        $bodyContent .= "Item Price: ₱$orderIP.00<br>";
        $bodyContent .= "Shipping Fee: ₱$orderIF.00<br>";
        $bodyContent .= "Item Quantity: x$orderQN<br>";
        $bodyContent .= "Sub Total: ₱$subsstotal<br>";
        $bodyContent .= "Total Price: ₱$orderTH<br>";
        $bodyContent .= "To Pay Online: ₱$tofay<br>";
        $bodyContent .= "Payment Option: $orderPO<br>";
        $mail->Body = $bodyContent;
        // Send email 

        if ($mail->send()) {
            // header("Location: ../../admin_Dashboard_Walkin.php?failed= Success to place the order");
            $ch = curl_init();
            $message = "
    Item Name: $orderNM
    Item Price: ₱$orderIP.00
    Shipping Fee: ₱$orderIF.00
    Item Quantity: x$orderQN
    Sub Total: ₱$subsstotal
    Total Price: ₱$orderTH
    To Pay Online: ₱$tofay
    Payment Option: $orderPO
";

            $parameters = array(
                'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
                'number' => $tdbAdminNumber,
                'message' => "Entong Workz $message",
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
            header("Location: user_Buy_Orders.php");
        } else {
            // header("Location: ../../admin_Dashboard_Walkin.php?failed= Faild to place the order");
            header("Location: user_Buy_Now.php?failed= Failed to place the order");
        }
    }
}
