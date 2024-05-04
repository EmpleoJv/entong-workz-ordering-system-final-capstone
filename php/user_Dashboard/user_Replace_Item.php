<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL & ~E_NOTICE);
// ini_set('display_errors', 'Off');

$itemid = $_GET['itemid'];
$code = $_GET['code'];
$orderid = $_GET['orderid'];
$date = date('Y-m-d');
$sevenDaysLater = new DateTime($date);
$sevenDaysLater->add(new DateInterval('P7D'));
$newDate = $sevenDaysLater->format('Y-m-d');

if (isset($_POST['payment_Start'])) {
    $reason = $_POST['reason'];
    $picHasBeenUploaded = 0;
    $change_Main_Image = time() . $_FILES["return_Proof"]["name"];


    if (move_uploaded_file($_FILES['return_Proof']['tmp_name'], '../../img/videoProof/' . $change_Main_Image)) {
        $target_file = '../../img/videoProof/' . $change_Main_Image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedVideoTypes = array("avi", "flv", "wmv", "mov", "mp4");

        if (!in_array($imageFileType, $allowedVideoTypes)) {
            unlink($target_file);
            header("Location: user_Buy_Orders.php?addMsg=Wrong File");
        } else if ($_FILES["return_Proof"]["size"] > 20000000) {
            unlink($target_file);
            header("Location: user_Buy_Orders.php?addMsg=Too large File");
        } else {
            $picHasBeenUploaded = 1;
        }
    }

    if ($picHasBeenUploaded == 1) {

        $sql = "INSERT INTO returnitem (ITEM_ID, ORDERCODE, VID, STATUS, MESSAGE, ORDERID, DATE_REQUEST, NUMBER, USER_ID)
                    VALUES ('$itemid', '$code', '$change_Main_Image', 'REPLACEMENT REQUEST', '$reason', '$orderid', '$date', '$tdbAdminNumber', '$tdbAdminId')";
        if ($conn->query($sql) === TRUE) {
            $sqls = "UPDATE orders SET PACKAGE_STATUS ='REPLACEMENT REQUEST',  DATE_DELIVERED = '$newDate' WHERE ID = '$orderid';";
            if ($conn->query($sqls) === TRUE) {
                header("Location: user_Buy_Orders.php?addMsg= Replacement Request Submitted");
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
                header("Location: user_Buy_Orders.php?addMsg=Error: Choose a right File!, Too large File");
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            header("Location: user_Buy_Orders.php?addMsg=Error: Choose a right File!, Too large File");
        }
    } else {
        header("Location: user_Buy_Orders.php?addMsg=Error: Choose a right File!, Too large File");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/user_Replace_Item.css">
</head>

<body>
    <main>
        <nav>
            <h1>Entong Workz</h1>
            <ul>
                <li><a href="../../user_Dashboard.php">HOME</a></li>
                <li><a href="user_Budget_Calculator.php">BUDGETER</a></li>
                <li><a href="user_Add_To_Cart.php">CART</a></li>
                <li><a href="user_Buy_Orders.php">ORDERS</a></li>
                <li><a href="user_Profile.php">PROFILE</a></li>
                <li><a href="user_Customer_Support.php">SUPPORT</a></li>
                <li><a href="../php_action/user_logout.php">LOGOUT</a></li>
            </ul>
            <img src="../../img/icons/menu_Navy.png" alt="bar" onclick="openNav()">
            <div id="myNav" class="overlay">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="overlay-content">
                    <li><a href="../../user_Dashboard.php">HOME</a></li>
                    <li><a href="user_Budget_Calculator.php">BUDGETER</a></li>
                    <li><a href="user_Add_To_Cart.php">CART</a></li>
                    <li><a href="user_Buy_Orders.php">ORDERS</a></li>
                    <li><a href="user_Profile.php">PROFILE</a></li>
                    <li><a href="user_Customer_Support.php">SUPPORT</a></li>
                    <li><a href="../php_action/user_logout.php">LOGOUT</a></li>
                </div>
            </div>
        </nav>
        <a href="user_Buy_Orders.php"><button class="toback">Back</button></a>

        <form action="#" method="post" enctype="multipart/form-data" class="formClass">
            <label for="reason">Reason</label>
            <br>
            <!-- <input type="text" name="reason" id="reason" maxlength="255" required> -->
            <textarea name="reason" id="" cols="100" rows="3" maxlength="255" required></textarea>
            <br>
            <br>
            <label for="return_Proof" class="return_Proof" required>
                UPLOAD VIDEO PROOF<br />
                <img src="../../img/icons/vid.png" alt=" ">
                <input id="return_Proof" type="file" name="return_Proof" accept="video/*" required hidden>
                <br />
                <span id="imageName"></span>
            </label>
            <br>
            <input type="submit" class="submit_Payment" name="payment_Start" value="SUBMIT PROOF">
        </form>
    </main>
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let input = document.getElementById("return_Proof");
            let imageName = document.getElementById("imageName");

            input.addEventListener("change", () => {
                let inputImage = input.files[0];

                if (inputImage) {
                    imageName.innerText = inputImage.name;
                } else {
                    imageName.innerText = ""; // Clear the text if no file is selected
                }
            });
        });
    </script>
</body>


</html>