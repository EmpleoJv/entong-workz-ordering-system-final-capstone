<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
// $myArray = array(1, 2, 3, 4, "asdasd");
// $arrayCount = count($myArray);

// echo "The number of elements in the array is: " . $arrayCount;

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $orderHN = $_POST['houseName'];
//     $orderPN = $_POST['provinceName'];
//     $orderCN = $_POST['cityName'];
//     $orderBN = $_POST['barangayName'];

//     $orderIH = $_POST['itemIdHidden'];
//     $orderIM = $_POST['itemImageHidden'];
//     $orderIP = $_POST['itemInitialPrice'];
//     $orderII = $_POST['itemId'];

//     $date = date('Y-m-d');

//     $orderQN = $_POST['quantity'];
//     $orderTH = $_POST['totalHidden'];
//     $orderNM = $_POST['itemNameHidden'];
//     $orderPS = "ORDER PENDING";

//     $arrayCount = count($orderIH);
//     echo "The number of elements in the array is: " . $arrayCount;

//     // Database connection and prepare statement
//     $stmt = $conn->prepare("INSERT INTO contacts 
//     (ITEM_ID, ORDER_TYPE_ID, ORDER_BY, ORDERED_ITEM_ID, ITEM_IMAGE, ITEM_PRICE, DATE, QUANTITY, TOTAL_PRICE, ORDERED_ITEM, PACKAGE_STATUS, ADDITIONAL_INFORMATION, PROVINCE, CITYMUNICIPALITY, BARANGAY) 
//     VALUES 
//     (?, 'MULTIPLE', $tdbAdminId, ?, ?, ?, $date, ?, ?, ?, $orderPS, ?, ?, ?, $orderBN);");



//     for ($i = 0; $i < $arrayCount; $i++) {
//         $orderIH_i = $orderIH[$i];
//         $orderIM_i = $orderIM[$i];
//         $orderIP_i = $orderIP[$i];
//         $orderQN_i = $orderQN[$i];
//         $orderTH_i = $orderTH[$i];
//         $orderNM_i = $orderNM[$i];

//         $result = $stmt->execute([$orderIH_i, $orderIH_i, $orderIM_i, $orderIP_i, $orderQN_i, $orderTH_i, $orderNM_i, $orderPS, $orderHN, $orderPN, $orderCN]);
//     }

//     echo "Data inserted successfully.";
// }


if (isset($_POST['submitOrder'])) {
    $orderHN = $_POST['houseName'];
    $orderPN = $_POST['provinceName'];
    $orderCN = $_POST['cityName'];
    $orderBN = $_POST['barangayName'];

    $orderIH = $_POST['itemIdHidden'];
    $orderNM = $_POST['itemNameHidden'];
    $orderIP = $_POST['itemInitialPrice'];
    $orderIC = $_POST['itemCategory'];

    // $orderIF = $_POST['itemFee'];
    // $orderFC = $_POST['feeCity'];
    $orderIIM = $_POST['itemImageHidden'];
    $orderPO = $_POST['payOption'];

    $date = date('Y-m-d');
    $sevenDaysLater = date('Y-m-d', strtotime($date . ' +7 days'));
    $ThreeDaysLater = date('Y-m-d', strtotime($date . ' +3 days'));

    $orderQN = $_POST['quantity'];

    $orderTH = $_POST['totalHidden'];
    $finaltotals = $_POST['finaltotals'];

    $subsss = $_POST['subsss'];
    $totalquans = $_POST['totalquans'];
    $totalfess = $_POST['totalfess'];

    $tofay = 0;
    if ($orderPO == "GCASH") {
        $orderPS = "PAYMENT PENDING";
        $tofay = $finaltotals;
    } else if ($orderPO == "HALF DOWNPAYMENT GCASH") {
        $orderPS = "PAYMENT PENDING";
        $tofay = $finaltotals / 2;
    } else {
        $orderPS = "ORDER PENDING";
        $tofay = 0;
    }

    // if ($orderPO == "GCASH" or $orderPO == "HALF DOWNPAYMENT GCASH") {
    //     $orderPS = "PAYMENT PENDING";
    // } else {
    //     $orderPS = "ORDER PENDING";
    // }
    $checker = 0;
    $checker2 = 0;

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
    '$finaltotals',
    '$tdbAdminNumber',
    '$finaltotals',
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



    echo $orderVC . '<br>';

    $arrayCount = count($orderIH);
    echo "The number of elements in the array is: " . $arrayCount . '<br>';

    for ($i = 0; $i < $arrayCount; $i++) {
        $orderIH_i = $orderIH[$i];
        $orderIP_i = $orderIP[$i];
        $orderQN_i = $orderQN[$i];
        $orderTH_i = $orderTH[$i];
        $orderNM_i = $orderNM[$i];
        // $orderIF_i = $orderIF[$i];
        $orderIIM_i = $orderIIM[$i];
        $orderIC_i = $orderIC[$i];

        $sql = "SELECT * FROM items WHERE ITEM_ID = '$orderIH_i';";
        $result = $conn->query($sql);

        if ($result !== false && $result->num_rows > 0) {
            if ($row['ITEM_STATUS'] === 'SHOW') {
                $checker2 = 1;
            }
        }

        if ($checker2 = 1) {
            if ($orderPO === "COD") {
                $insert_query = mysqli_query($conn, "INSERT INTO orders 
            (ITEM_ID, 
            ORDERCODE,
            CUSTOMER_NUMBER,
            TO_PAY,
            ORDER_TYPE_ID, 
            ORDER_BY, 
            ITEM_PRICE, 
            -- ITEM_FEE,
            -- CITY_FEE,
            PAYMENT_METHOD, 
            ORDER_CATEGORY, 
            DATE, 
            ITEM_IMAGE,
            QUANTITY, 
            TOTAL_PRICE, 
            ORDERED_ITEM, 
            DATE_LIMIT, 
            PACKAGE_STATUS, 
            ADDITIONAL_INFORMATION, 
            PROVINCE, 
            CITYMUNICIPALITY, 
            BARANGAY) 
            VALUES 
            ('$orderIH_i',
            '$randomNumbers$randomLetters',
            '$tdbAdminNumber',
            '$orderTH_i',
            'ONLINE', 
            '$tdbAdminId',
            '$orderIP_i',
            -- '$orderIF_i',
            -- '$orderFC',
            '$orderPO',
            '$orderIC_i',

            '$date',
            '$orderIIM_i',
            '$orderQN_i', 
            '$orderTH_i',
            '$orderNM_i',
            
            '$sevenDaysLater',

            '$orderPS',
            '$orderHN',
            '$orderPN', 
            '$orderCN',
            '$orderBN');");

                if (!$insert_query) {
                    echo "Error: " . mysqli_error($conn); // Output the error message for debugging
                    // exit; // Exit the loop immediately if an error occurs
                    $checker = 0;

                    // header("Location: user_Buy_Multiple_Buy_Now.php?failed= Failed to place the order");
                } else {
                    // header("Location: user_Buy_Orders.php");
                    $checker = 1;
                    $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - $orderQN_i WHERE ITEM_ID = $orderIH_i";
                    if ($conn->query($sqlsss) === TRUE) {
                        echo "good";
                        $sqlsss = "DELETE FROM usercart WHERE ITEM_ID= $orderIH_i";
                        if ($conn->query($sqlsss) === TRUE) {
                        } else {
                        }
                    } else {
                        header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
                        echo "bad";
                    }
                }
            } else if ($orderPO === "GCASH" or $orderPO === "HALF DOWNPAYMENT GCASH") {
                $insert_query = mysqli_query($conn, "INSERT INTO orders 
                (ITEM_ID, 
                ORDERCODE,
                CUSTOMER_NUMBER,
                TO_PAY, 
                ORDER_TYPE_ID, 
                ORDER_BY, 
                ITEM_PRICE, 
                -- ITEM_FEE,
                -- CITY_FEE,
                PAYMENT_METHOD, 
                ORDER_CATEGORY, 
                DATE, 
                ITEM_IMAGE,
                QUANTITY, 
                TOTAL_PRICE, 
                ORDERED_ITEM, 
                DATE_LIMIT, 
                DATE_PAY_LIMIT,
                PACKAGE_STATUS, 
                ADDITIONAL_INFORMATION, 
                PROVINCE, 
                CITYMUNICIPALITY, 
                BARANGAY) 
                VALUES 
                ('$orderIH_i',
                '$randomNumbers$randomLetters',

                '$tdbAdminNumber',

                '$orderTH_i',
                'ONLINE', 
                '$tdbAdminId',
                '$orderIP_i',
                -- '$orderIF_i',
                -- '$orderFC',
                '$orderPO',
                '$orderIC_i',
    
                '$date',
                '$orderIIM_i',
                '$orderQN_i', 
                '$orderTH_i',
                '$orderNM_i',
                
                '$sevenDaysLater',
                '$ThreeDaysLater',
    
                '$orderPS',
                '$orderHN',
                '$orderPN',
                '$orderCN',
                '$orderBN');");

                if (!$insert_query) {
                    echo "Error: " . mysqli_error($conn); // Output the error message for debugging
                    // exit; // Exit the loop immediately if an error occurs
                    $checker = 0;

                    // header("Location: user_Buy_Multiple_Buy_Now.php?failed= Failed to place the order");
                } else {
                    // header("Location: user_Buy_Orders.php");
                    $checker = 1;
                    $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - $orderQN_i WHERE ITEM_ID = $orderIH_i";
                    if ($conn->query($sqlsss) === TRUE) {
                        echo "good";
                        $sqlsss = "DELETE FROM usercart WHERE ITEM_ID= $orderIH_i";
                        if ($conn->query($sqlsss) === TRUE) {
                        } else {
                        }
                    } else {
                        header("Location: ../../admin_Dashboard_Orders.php?errorss= Update Failed");
                        echo "bad";
                    }
                }
            }
            // Insert the data into the database

            echo "Good";
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

        for ($i = 0; $i < $arrayCount; $i++) {
            $orderIH_i = $orderIH[$i];
            $orderIP_i = $orderIP[$i];
            $orderQN_i = $orderQN[$i];
            $orderTH_i = $orderTH[$i];
            $orderNM_i = $orderNM[$i];
            // $orderIF_i = $orderIF[$i];
            $orderIIM_i = $orderIIM[$i];

            // Concatenate the loop values to the email body content
            // $bodyContent .= "Item Image: $orderIM<br>";
            $bodyContent .= "Item Price: ₱$orderIP_i.00<br>";
            $bodyContent .= "Item Quantity: x$orderQN_i<br>";
            $bodyContent .= "Item Total Price: ₱$orderTH_i<br>";
            $bodyContent .= "Item Name: $orderNM_i<br>";
            $bodyContent .= "<br>"; // Add some separation between items
        }
        $bodyContent .= "SubTotal: ₱$subsss.00<br> ";
        $bodyContent .= "Shipping: ₱$totalfess.00<br> ";
        $bodyContent .= "Qty: x$totalquans<br> ";
        $bodyContent .= "Total: ₱$finaltotals<br> ";
        $bodyContent .= "To Pay: ₱$tofay<br> ";
        $bodyContent .= "Payment: $orderPO";
        $mail->Body = $bodyContent;
        // Send email 

        if ($mail->send()) {

            $ch = curl_init();

            // Initialize an empty message string outside the loop
            $message = '';

            for ($i = 0; $i < $arrayCount; $i++) {
                $orderIH_i = $orderIH[$i];
                $orderIP_i = $orderIP[$i];
                $orderQN_i = $orderQN[$i];
                $orderTH_i = $orderTH[$i];
                $orderNM_i = $orderNM[$i];
                $orderIIM_i = $orderIIM[$i];

                // Concatenate the item information to the message string
                $message .= "
                Item Name: $orderNM_i
                Item Price: ₱$orderIP_i.00
                Item Quantity: x$orderQN_i
                Item Total Price: ₱$orderTH_i.00
                ";
            }

            // After the loop, send a single message with all the concatenated data
            $parameters = array(
                'apikey' => 'dc3e313c4040a1eca721d46241a41d35', // Your API KEY
                'number' => $tdbAdminNumber,
                'message' => "Entong Workz 
                    $message " . "
                    Sub Total: ₱$subsss.00 
                    Shipping Fee ₱$totalfess.00 
                    Total Quantity x$totalquans
                    Total Price: ₱$finaltotals
                    To Pay Online: ₱$tofay
                    Payment Option: $orderPO",
                'sendername' => 'SEMAPHORE'
            );

            curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute cURL request
            $output = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                // Output the response
                echo 'Response: ' . $output;
            }

            // You might want to add a delay between requests to avoid rate limits
            // sleep(1); // Add a delay of 1 second between requests


            // Close cURL resource
            // curl_close($ch);


            // header("Location: ../../admin_Dashboard_Walkin.php?failed= Success to place the order");
            header("Location: user_Buy_Orders.php");
        } else {
            // header("Location: ../../admin_Dashboard_Walkin.php?failed= Faild to place the order");
            header("Location: user_Buy_Now.php?failed= Failed to place the order");
        }
    }
}
