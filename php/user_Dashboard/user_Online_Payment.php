<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
$orderID = $_GET['orderID'];
$orderStatus = $_GET['orderStatus'];
$topayOnly = $_GET['topayOnly'];

if (isset($_POST['payment_Start'])) {

    $change_Main_Image = time() . $_FILES["receipt_Img"]["name"];
    $ref_Num = $_POST['reference_Number'];
    $date = date('Y-m-d');

    if (move_uploaded_file($_FILES['receipt_Img']['tmp_name'], '../../img/receipt/' . $change_Main_Image)) {
        $target_file = '../../img/receipt/' . $change_Main_Image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picName = basename($_FILES["receipt_Img"]["name"]);
        $photo = time() . $picName;
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: user_Buy_Orders.php?addMsg=Wrong File ");
        } else if ($_FILES["receipt_Img"]["size"] > 20000000) {
            header("Location: user_Buy_Orders.php?addMsg=To large File");
        } else {
            $picHasBeenUploaded = 1;
        }
    }
    // echo $extract_id;
    if ($picHasBeenUploaded == 1) {
        $sql = "INSERT INTO onlinepayment 
        (ORDER_CODE , REFERENCE_NUM, RECEIPT_IMG, SENDER, STATUS, DATE_OF_UPLOAD)
        VALUES 
        ('$orderID', '$ref_Num', '$photo', '$tdbAdminId', 'ON PROCESS', '$date')";
        if ($conn->query($sql) === TRUE) {
            // echo "New record created successfully";
            header("Location: user_Buy_Orders.php?addMsg=Success : Placing Payment Reciept");
        } else {
            header("Location: user_Buy_Orders.php?addMsg=Error : Placing Order");
        }
    } else {
        unlink("../../img/receipt/" . $change_Main_Image);
        header("Location: user_Buy_Orders.php?addMsg=Error : Choose a right File!");
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
    <link rel="stylesheet" href="../../css/user_Online_Payment.css">
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

        <div class="main_Content">
            <h1 class="title">Online Payment</h1>
            <?php
            if ($orderStatus === "PAYMENT PENDING") {
            ?>
                <div class="main_panel">
                    <div class="form_Con">
                        <p>ONLINE PENDING PAYMENT: <span class="price">₱<?php echo number_format($topayOnly, 2); ?></span></p>
                        <p>FILL UP GCASH RECEIPT</p>
                        <form action="#" method="post" enctype="multipart/form-data">
                            <label for="reference_Number">REFERENCE NUMBER</label>
                            <br>
                            <input type="text" name="reference_Number" id="reference_Number" maxlength="100" required>
                            <br>
                            <!-- <label for="receipt_Img">Image Receipt</label> -->
                            <br>
                            <!-- <input type="file" name="receipt_Img" id="receipt_Img" required> -->
                            <label for="receipt_Img" class="receipt_Img" required>
                                UPLOAD IMAGE RECEIPT<br />
                                <!-- <i class="fa fa-2x fa-camera"></i> -->
                                <img src="../../img/icons/receipt.png" alt=" ">
                                <input id="receipt_Img" type="file" name="receipt_Img" accept=".jpg, .jpeg, .png" required hidden>
                                <br />
                                <span id="imageName"></span>
                            </label>
                            <br>
                            <!-- <div>
                            <input type="checkbox" required>
                            <h6>Terms and Conditions</h6>
                        </div> -->
                            <input type="submit" class="submit_Payment" name="payment_Start" value="SUBMIT PAYMENT">
                        </form>
                    </div>
                    <hr class="hr">
                    <div class="img_Con">
                        <p>SCAN GCASH QR-CODE</p>
                        <?php
                        $sql = "SELECT * FROM gcashimage;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $img = $row['IMAGE'];
                        ?>
                                <p><?php echo $row['GCASH_NAME']; ?></p>
                                <img src="../../img/companyGcash/<?php echo $img ?>" alt=" ">
                                <p>COPY GCASH NUMBER</p>
                                <p><?php echo $row['NUMBER']; ?></p>
                                <hr class="hr2">

                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            <?php
            } else {
            ?>
                <!-- <p><?php echo $orderStatus; ?></p> -->
            <?php
            }
            ?>
            <hr>

            <div class="allOrder" id="allOrder">
                <p class="allOrdersTitle">Payment for this Order</p>
                <table id="ordersTable">
                    <thead>
                        <tr>
                            <th>ORDER CODE</th>
                            <th>DATE OF UPLOAD</th>
                            <th>REFERENCE NUMBER</th>
                            <th>STATUS</th>
                            <th>CUSTOMER SENDER</th>
                            <th>RECEIPT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM onlinepayment WHERE ORDER_CODE = '$orderID';";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['SENDER'];
                        ?>
                                <tr class="even-row">
                                    <td><?php echo $row['ID']; ?></td>
                                    <td>
                                        <?php 
                                        $daters = $row['DATE_OF_UPLOAD'];
                                        $formattedDate = date('F d, Y', strtotime($daters));

                                        echo $formattedDate;
                                        ?>
                                        </td>
                                    <td><?php echo $row['ORDER_CODE']; ?></td>
                                    <td><?php echo $row['REFERENCE_NUM']; ?></td>
                                    <td>
                                        <?php
                                        if ($row['STATUS'] == "") {
                                            echo "REVIEW ON PROGRESS BY STAFF";
                                        } else {
                                            echo $row['STATUS'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $sqls = "SELECT * FROM userlogin WHERE ID = $id;";
                                        $results = $conn->query($sqls);
                                        if ($results->num_rows > 0) {
                                            // output data of each row
                                            while ($rows = $results->fetch_assoc()) {
                                                echo $rows['FIRSTNAME'] . " " . $rows['LASTNAME'];
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td class="img_con_table"><img src="../../img/receipt/<?php echo $row['RECEIPT_IMG']; ?>" alt=" " class="img"></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "no Data Found";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let input = document.getElementById("receipt_Img");
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
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
</body>


</html>