<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
$checker = 0;
$finalPrice = 0;
if (isset($_POST['startWalkInOrder'])) {
    // Retrieve arrays from the form data
    $itemImages = $_POST["itemImage"];
    $itemIds = $_POST["itemId"];
    $itemPrices = $_POST["itemPrice"];
    $itemQuantities = $_POST["itemQuantity"];
    $itemTotalprices = $_POST["itemTotalprice"];
    $itemNames = $_POST["itemName"];
    $currentDate = date('Y-m-d');
    $type = "WALK IN";
    $package = "ORDER SUCCESS";
    $randomLetters = '';
    for ($i = 0; $i < 5; $i++) {
        $randomLetters .= chr(rand(65, 90)); // ASCII values for uppercase letters
    }
    $randomNumbers = rand(10000, 99999);
    if (!empty($itemIds)) {
        // Iterate through the arrays
        for ($i = 0; $i < count($itemIds); $i++) {
            $itemId = $itemIds[$i];
            $itemImage = $itemImages[$i];
            $itemPrice = $itemPrices[$i];
            $itemQuantity = $itemQuantities[$i];
            $itemTotalprice = $itemTotalprices[$i];
            $itemName = $itemNames[$i];

            $finalPrice = $finalPrice + $itemTotalprice;
        }
        $insert_querys = mysqli_query($conn, "INSERT INTO ordercode 
        (CODE,
        ACCEPTED_BY,
        DELIVERED_BY,
        ORDER_DATE,
        DELIVERY_DATE,
        PACKAGE_STATUS,
        PAYMENT_OPTION,
        SALES) 
        VALUES 
        ('$randomNumbers$randomLetters',
        '$tdbAdminId',
        '$tdbAdminId',
        '$currentDate',
        '$currentDate',
        'ORDER SUCCESS',
        'WALK IN',
        '$finalPrice');");

        if (!$insert_querys) {
            echo "Error: " . mysqli_error($conn); // Output the error message for debugging
            exit; // Exit the loop immediately if an error occurs
            $sqlsss = "DELETE FROM ordercode WHERE CODE= $randomNumbers$randomLetters";
            if ($conn->query($sqlsss) === TRUE) {
                echo "Record deleted successfully";
                header("Location: ../../admin_Dashboard_Walkin.php?finalMessage= Failed to place the order");
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            // echo "failed";
        } else {
            $checker = 1;
        }
        for ($i = 0; $i < count($itemIds); $i++) {
            $itemId = $itemIds[$i];
            $itemImage = $itemImages[$i];
            $itemPrice = $itemPrices[$i];
            $itemQuantity = $itemQuantities[$i];
            $itemTotalprice = $itemTotalprices[$i];
            $itemName = $itemNames[$i];

            // You can process each item's data as needed
            // echo "Item ID: " . $itemId . "<br>";
            // echo "Item Image: " . $itemImage . "<br>";
            // echo "Item Price: " . $itemPrice . "<br>";
            // echo "Item Quantity: " . $itemQuantity . "<br>";
            // echo "Item total price: " . $itemTotalprice . "<br>";


            $insert_query = mysqli_query($conn, "INSERT INTO orders 
            (ITEM_ID,
            ORDERCODE, 
            ACCEPTED_BY, 
            QUANTITY,
            TOTAL_PRICE,
            ITEM_PRICE,
            ORDER_TYPE_ID,
            ITEM_IMAGE,
            PACKAGE_STATUS,
            ORDERED_ITEM,
            DATE) 
            VALUES 
            ('$itemId',
            '$randomNumbers$randomLetters',
            '$tdbAdminId', 
            '$itemQuantity', 
            '$itemTotalprice', 
            '$itemPrice', 
            '$type', 
            '$itemImage',
            '$package',
            '$itemName',
            '$currentDate');");

            if (!$insert_query) {
                echo "Error: " . mysqli_error($conn); // Output the error message for debugging
                exit; // Exit the loop immediately if an error occurs
                header("Location: ../../admin_Dashboard_Walkin.php?finalMessage= Failed to place the order");
                // echo "failed";
            } else {
                $checker = 1;
                $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY - $itemQuantity WHERE ITEM_ID = $itemId";
                if ($conn->query($sqlsss) === TRUE) {

                    // header("Location: ../../admin_Dashboard_Walkin.php?failed= Success to place the order");
                    // echo "good1";
                } else {
                    // echo "no good1";
                    $checker = 0;
                    header("Location: ../../admin_Dashboard_Walkin.php?finalMessage= Failed to place the order");
                }
                // echo "good";
            }
        }
        // if ($checker = 1) {

        //     $mail = new PHPMailer;
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.gmail.com';
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'empleojv22@gmail.com';
        //     $mail->Password = 'voriswopmgblddvn';
        //     $mail->SMTPSecure = 'ssl';
        //     $mail->Port = 465;

        //     // Sender info
        //     $mail->setFrom('empleojv22@gmail.com', 'EWOS');
        //     // Add a recipient
        //     $mail->addAddress('janeiyo74@gmail.com');
        //     // Set email format to HTML
        //     $mail->isHTML(true);
        //     // Mail subject
        //     $mail->Subject = 'Email from Localhost Server';
        //     // Mail body content
        //     $bodyContent = '<h1>Entong Workz</h1><br>';

        //     for ($i = 0; $i < count($itemIds); $i++) {
        //         $itemId = $itemIds[$i];
        //         $itemImage = $itemImages[$i];
        //         $itemPrice = $itemPrices[$i];
        //         $itemQuantity = $itemQuantities[$i];
        //         $itemTotalprice = $itemTotalprices[$i];
        //         $itemName = $itemNames[$i];

        //         // Concatenate the loop values to the email body content
        //         $bodyContent .= "Item ID: $itemId<br>";
        //         // $bodyContent .= "Item Image: $itemImage<br>";
        //         $bodyContent .= "Item Price: $itemPrice<br>";
        //         $bodyContent .= "Item Quantity: $itemQuantity<br>";
        //         $bodyContent .= "Item Total Price: $itemTotalprice<br>";
        //         $bodyContent .= "Item Name: $itemName<br>";
        //         $bodyContent .= "<br>"; // Add some separation between items
        //     }
        //     $mail->Body = $bodyContent;
        //     // Send email 

        //     if ($mail->send()) {
        //         $ch = curl_init();

        //         for ($i = 0; $i < count($itemIds); $i++) {
        //             $itemId = $itemIds[$i];
        //             $itemImage = $itemImages[$i];
        //             $itemPrice = $itemPrices[$i];
        //             $itemQuantity = $itemQuantities[$i];
        //             $itemTotalprice = $itemTotalprices[$i];
        //             $itemName = $itemNames[$i];

        //             $parameters = array(
        //                 'apikey' => 'dc3e313c4040a1eca721d46241a41d35', // Your API KEY
        //                 'number' => $email,
        //                 'message' => "Entong Workz
        //                 Item Name: $itemName
        //                 Item Price: $itemPrice
        //                 Item Quantity: $itemQuantity
        //                 Item Total Price: $itemTotalprice",
        //                 'sendername' => 'SEMAPHORE'
        //             );

        //             curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        //             curl_setopt($ch, CURLOPT_POST, 1);
        //             curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //             // Execute cURL request
        //             $output = curl_exec($ch);
        //             // Check for cURL errors
        //             if (curl_errno($ch)) {
        //                 // echo 'Curl error: ' . curl_error($ch);
        //             } else {
        //                 // Output the response
        //                 // echo 'Response: ' . $output;
        //             }
        //             // You might want to add a delay between requests to avoid rate limits
        //             // sleep(1); // Add a delay of 1 second between requests
        //         }
        //         // header("Location: ../../admin_Dashboard_Walkin.php?finalMessage= Success to place the order");
        //     } else {

        //         for ($i = 0; $i < count($itemIds); $i++) {

        //             $itemId = $itemIds[$i];
        //             $itemImage = $itemImages[$i];
        //             $itemPrice = $itemPrices[$i];
        //             $itemQuantity = $itemQuantities[$i];
        //             $itemTotalprice = $itemTotalprices[$i];
        //             $itemName = $itemNames[$i];

        //             $sqlsss = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY + $itemQuantity WHERE ITEM_ID = $itemId";
        //             if ($conn->query($sqlsss) === TRUE) {
        //                 // echo "good1";
        //             }
        //         }
        //         header("Location: ../../admin_Dashboard_Walkin.php?finalMessage= Failed to place the order");
        //     }
        // } else {
        // }
    } else {
        echo "No items were selected.";
    }
} else {
    header("Location: admin_Dashboard_Walkin_Finalize_Start.php?finalMessage=Database Error");
    echo "badsd";
}
if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Document</title> -->
    <script type="text/javascript">
        window.history.forward();
    </script>
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>

</head>

<body>
    <h1>Entong Workz</h1>

    <main style="display: flex; justify-content: center;">
        <div>
            <?php
            if (isset($_POST['startWalkInOrder'])) {
                $itemImages = $_POST["itemImage"];
                $itemIds = $_POST["itemId"];
                $itemPrices = $_POST["itemPrice"];
                $itemQuantities = $_POST["itemQuantity"];
                $itemTotalprices = $_POST["itemTotalprice"];
                $itemNames = $_POST["itemName"];

                // $email = $_POST["email"];
                $currentDate = date('Y-m-d');
                $type = "WALK IN";
                $package = "ORDER SUCCESS";
                // echo $email;
                if (!empty($itemIds)) {
                    // Iterate through the arrays
                    for ($i = 0; $i < count($itemIds); $i++) {
                        $itemId = $itemIds[$i];
                        $itemImage = $itemImages[$i];
                        $itemPrice = $itemPrices[$i];
                        $itemQuantity = $itemQuantities[$i];
                        $itemTotalprice = $itemTotalprices[$i];
                        $itemName = $itemNames[$i];

                        // You can process each item's data as needed
                        // echo "Item ID: " . $itemId . "<br>";
                        // echo "Item Image: " . $itemImage . "<br>";

                        echo "Item Price: " . $itemName . "<br>";
                        echo "Item Price: ₱" . number_format($itemPrice, 2) . "<br>";
                        echo "Item Quantity: " . $itemQuantity . "<br>";
                        echo "Item total price: " . $itemTotalprice . "<br>";
                        echo "<br>";
                    }
                    echo "₱" . number_format($finalPrice, 2);
                }
            }
            ?>
        </div>

    </main>
    <script>
        // Function to be called after printing is done or canceled
        function afterPrint() {
            // Redirect to another page
            window.location.href = "../../admin_Dashboard_Walkin.php";
        }

        // Use window.onload to ensure the script runs after the page has fully loaded
        window.onload = function() {
            // Use window.print() to trigger the print dialog
            window.print();
        };

        // Use the afterprint event to detect when printing is done or canceled
        window.addEventListener('afterprint', afterPrint);
    </script>

</body>

</html>