<?php
include('php/connection/dbTemporary.php');
include('php/connection/dbConnection.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/staff_Dashboard_Orders.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Staff</h1>
        <div class="profile">
            <a href="#">
                <img src="img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";
                ?>
            </a>
        </div>
        <a href="staff_Dashboard_Walkin.php" class="list">
            <div>
                <img id="iconUser" src="img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="staff_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="staff_Dashboard_Inventory.php" class="list">
            <div>
                <img id="iconInven" src="img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="staff_Dashboard_Orders.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconBank" src="img/icons/cash.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>ORDERS</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <div class="grid-container">
            <a href="#" id="sortLatestToOldestButton">
                <div class="grid-item" id="all_Orders">
                    <div>
                        <h3>ALL ORDERS</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM ordercode;';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a href="#" id="sortCanceledButton">
                <div class="grid-item" id="canceled_Orders">
                    <div>
                        <h3>CANCEL ORDERS</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "ORDER CANCELED";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a href="#" id="sortAndHideRows">
                <div class="grid-item" id="done_Orders">
                    <div>
                        <h3>SUCCESS ORDERS</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "ORDER SUCCESS";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a href="#" id="sortPendingButton">
                <div class="grid-item" id="pending_Orders">
                    <div>
                        <h3>PENDING ORDERS</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "ORDER PENDING";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a href="#" id="sortAcceptedButton">
                <div class="grid-item" id="accepted_Order">
                    <div>
                        <h3>ACCEPTED ORDERS</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "ORDER ACCEPTED";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a href="#" id="sortPaymentPendingButton">
                <div class="grid-item" id="accepted_Orders">
                    <div>
                        <h3>PENDING PAYMENT</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM ordercode WHERE PACKAGE_STATUS = "PAYMENT PENDING";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
        </div>

        <?php
        if (isset($_GET['errorss'])) { ?>
            <p class="errorss"><?php echo $_GET['errorss']; ?></p>
        <?php } ?>

        <!-- <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">
                <h1 class="allOrdersTitle">ALL ORDERS</h1>
            </div>
            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ACTION</th>
                        <th>PACKAGE STATUS</th>
                        <th>ONLINE PENDING PAYMENT</th>
                        <th>TOTAL PRICE</th>
                        <th>QUANTITY</th>
                        <th>PAYMENT METHOD</th>
                        <th>ITEM IMAGE</th>
                        <th>ORDERED ITEM</th>
                        <th>ORDER BY</th>
                        <th>ACCEPTED BY</th>
                        <th>DATE</th>
                        <th>VIDEO PROOF</th>
                        <th>REASON OF CANCEL/REPLACEMENT</th>
                        <th>CANCELATION</th>
                        <th>ADDITIONAL INFORMATION</th>
                        <th>PROVINCE</th>
                        <th>CITYMUNICIPALITY</th>
                        <th>BARANGAY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM orders ORDER BY DATE DESC;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $imagePath = "img/itemPhotos/" . $row['ITEM_IMAGE'];
                            $idForStatus = $row['ID'];
                            $ORDER_BY = $row['ORDER_BY'];

                            $idForAcceptors = $row['ACCEPTED_BY'];
                            $iditems = $row['ITEM_ID'];
                            $QUANTITYorders = $row['QUANTITY'];
                    ?>
                            <tr class="even-row">
                                <td><?php echo $row['ID']; ?></td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <?php
                                    if ($row['PAYMENT_METHOD'] === "GCASH" or $row['PAYMENT_METHOD'] === "HALF DOWNPAYMENT GCASH") {
                                        if ($row['PACKAGE_STATUS'] === "PAYMENT PENDING") {
                                    ?>
                                            <a href="admin_Dashboard_Order_Online_Payment.php?id=<?php echo $row['ID']; ?>&status=<?php echo $row['PACKAGE_STATUS'] ?>&topay=<?php echo $row['TO_PAY'] ?>&total=<?php echo $row['TOTAL_PRICE'] ?>"><button class="show">VEIW PAYMENT</button></a>
                                            <a href="php/admin_Dashboard_Orders/accept_Order.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&action=<?php echo urlencode($row['ID']); ?>&qrCode=<?php echo urlencode($row['ORDERED_ITEM']); ?>&iditem=<?php echo urlencode($row['ITEM_ID']); ?>&much=<?php echo urlencode($row['QUANTITY']); ?>">
                                                <button class="acceptOrder" id="showed">ACCEPT</button>
                                            </a>
                                        <?php
                                        } else if ($row['PACKAGE_STATUS'] === "ORDER ACCEPTED") {
                                        ?>
                                            <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">DETAILS</button>
                                            <a href="admin_Dashboard_Order_Online_Payment.php?id=<?php echo $row['ID']; ?>&status=<?php echo $row['PACKAGE_STATUS'] ?>&topay=<?php echo $row['TO_PAY'] ?>&total=<?php echo $row['TOTAL_PRICE'] ?>"><button class="show">VEIW PAYMENT</button></a>
                                            <a href="php/admin_Dashboard_Orders/back_To_Pending.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&id=<?php echo $row['ID']; ?>"><button class="pends">UNDO ORDER TO PENDING</button></a>
                                        <?php
                                        } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT REQUEST") {
                                        ?>
                                            <a href="php/admin_Dashboard_Orders/accept_Replacement.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&id=<?php echo $row['ID']; ?>"><button class="pends">ACCEPT REPLACEMENT</button></a>
                                        <?php
                                        } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT ACCEPTED") {
                                        ?>
                                            <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">DETAILS</button>

                                            <a href="php/admin_Dashboard_Orders/undo_Replacement.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&id=<?php echo $row['ID']; ?>"><button class="pends">UNDO ACCEPT REPLACEMENT</button></a>
                                        <?php
                                        } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT DECLINED") {
                                        ?>
                                        <?php
                                        } else if ($row['PACKAGE_STATUS'] === "ORDER SUCCESS") {
                                        ?>
                                            <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">DETAILS</button>
                                            <?php
                                        }
                                    } else if ($row['PAYMENT_METHOD'] === "COD") {
                                        $sqls = "SELECT PACKAGE_STATUS FROM orders WHERE ID = $idForStatus;";
                                        $results = $conn->query($sqls);
                                        if ($results) {
                                            if ($results->num_rows > 0) {
                                                while ($rows = $results->fetch_assoc()) {
                                                    if ($rows['PACKAGE_STATUS'] === "ORDER SUCCESS") {
                                            ?>
                                                        <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">DETAILS</button>
                                                    <?php
                                                        break;
                                                    } else if ($rows['PACKAGE_STATUS'] === "ORDER PROCESSING") {
                                                    ?>
                                                        <h4>PACKAGE PROCESSING</h4>
                                                    <?php
                                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT REQUEST") {
                                                    ?>
                                                        <a href="php/admin_Dashboard_Orders/accept_Replacement.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&id=<?php echo $row['ID']; ?>"><button class="pends">ACCEPT REPLACEMENT</button></a>
                                                    <?php
                                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT ACCEPTED") {
                                                    ?>
                                                        <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">DETAILS</button>
                                                        <a href="php/admin_Dashboard_Orders/undo_Replacement.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&id=<?php echo $row['ID']; ?>"><button class="pends">UNDO ACCEPT REPLACEMENT</button></a>
                                                    <?php
                                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT DECLINED") {
                                                    ?>
                                                    <?php
                                                    } else if ($rows['PACKAGE_STATUS'] === "ORDER CANCELED") {
                                                    ?>
                                                    <?php
                                                    } else if ($rows['PACKAGE_STATUS'] === "ORDER ACCEPTED") {
                                                    ?>
                                                        <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">DETAILS</button>
                                                        <a href="php/admin_Dashboard_Orders/back_To_pending_COD.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&id=<?php echo $row['ID']; ?>"><button class="pends">UNDO ORDER TO PENDING</button></a>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a href="php/admin_Dashboard_Orders/accept_Order.php?num=<?php echo $row['CUSTOMER_NUMBER']; ?>&action=<?php echo urlencode($row['ID']); ?>&qrCode=<?php echo urlencode($row['ORDERED_ITEM']); ?>&iditem=<?php echo urlencode($row['ITEM_ID']); ?>&much=<?php echo urlencode($row['QUANTITY']); ?>">
                                                            <button class="acceptOrder">ACCEPT</button>
                                                        </a>
                                                <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                    <?php
                                            }
                                        } else {
                                            echo "Error executing SQL query: " . $conn->error;
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['PACKAGE_STATUS']; ?></td>
                                <td><?php
                                    if ($row['ORDER_TYPE_ID'] == 'WALK IN') {
                                    } else {
                                        if ($row['TO_PAY'] == 0) {
                                            echo "FULLY PAID";
                                        } else {
                                    ?>
                                            ₱<?php echo $row['TO_PAY']; ?>
                                    <?php
                                        }
                                    }

                                    ?></td>
                                <td>₱<?php echo $row['TOTAL_PRICE']; ?></td>
                                <td><?php echo $row['QUANTITY']; ?></td>


                                <td><?php
                                    if ($row['PAYMENT_METHOD'] == '') {
                                        echo "WALK-IN";
                                    } else {
                                        echo $row['PAYMENT_METHOD'];
                                    }
                                    ?></td>
                                <td><img src="<?php echo $imagePath; ?>" alt="itemphotos" class="tableImage"></td>
                                <td><?php echo $row['ORDERED_ITEM']; ?></td>
                                <td>
                                    <?php
                                    if (isset($idForAcceptors) && !empty($idForAcceptors)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM userlogin WHERE ID = $ORDER_BY";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row['ACCEPTED_BY']; ?>
                                    <?php
                                    if (isset($idForAcceptors) && !empty($idForAcceptors)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM companylogin WHERE ID = $idForAcceptors";
                                        $resultsss = $conn->query($sqlsss);

                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }

                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['DATE']; ?></td>
                                <td>
                                    <?php
                                    if ($row['PACKAGE_STATUS'] === "REPLACEMENT REQUEST") {
                                    ?>
                                        <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&proof=show'">DETAILS</button>
                                    <?php
                                    }
                                    ?>
                                </td>

                                <td><?php echo $row['REASON_FOR_CANCEL']; ?></td>
                                <td>
                                    <?php
                                    if ($row['DATE_PAY_LIMIT'] > date('Y-m-d') and $row['PACKAGE_STATUS'] === "PAYMENT PENDING" or $row['PACKAGE_STATUS'] === "ORDER PENDING") {
                                    ?>
                                        <form action="php/admin_Dashboard_Orders/admin_Buy_cancel.php" method="post" class="formms">
                                            <label for="reason">Reason For Cancelation</label>
                                            <br>
                                            <input type="text" name="reason" maxlength="200" placeholder="Reason For Cancelation" required>
                                            <input type="text" value="<?php echo $row['QUANTITY'] ?>" name="quantity" hidden>
                                            <input type="text" value="<?php echo $row['ITEM_ID'] ?>" name="itemId" hidden>
                                            <input type="text" value="<?php echo $row['ID'] ?>" name="orderid" hidden>
                                            <input type="text" value="<?php echo $row['CUSTOMER_NUMBER'] ?>" name="num" hidden>

                                            <div>
                                                <input type="checkbox" name="terms" id="#" required>
                                                <a>Once you canceled,<br>
                                                    it cannot be undo.</a>
                                            </div>
                                            <input type="submit" value="CANCEL ORDER" name="startCancelation" class="cancelBtn">
                                        </form>
                                    <?php
                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT REQUEST") {
                                    ?>
                                        <form action="php/admin_Dashboard_Orders/decline_Request.php" method="post" class="formms">
                                            <label for="reason">Decline Request Reason</label>
                                            <br>
                                            <input type="text" name="reason" maxlength="200" placeholder="Reason For Declining" required>
                                            <input type="text" value="<?php echo $row['QUANTITY'] ?>" name="quantity" hidden>
                                            <input type="text" value="<?php echo $row['ITEM_ID'] ?>" name="itemId" hidden>
                                            <input type="text" value="<?php echo $row['ID'] ?>" name="orderid" hidden>
                                            <input type="text" value="<?php echo $row['CUSTOMER_NUMBER'] ?>" name="num" hidden>

                                            <div>
                                                <input type="checkbox" name="terms" id="#" required>
                                                <a>Once you canceled,<br>
                                                    it cannot be undo.</a>
                                            </div>
                                            <input type="submit" value="DECLINE REQUEST" name="startCancelation" class="cancelBtn">
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['ADDITIONAL_INFORMATION']; ?></td>
                                <td><?php echo $row['PROVINCE']; ?></td>
                                <td><?php echo $row['CITYMUNICIPALITY']; ?></td>
                                <td><?php echo $row['BARANGAY']; ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "no Data Found";
                    }
                    ?>
                </tbody>
            </table>
        </div> -->
        <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">
                <h1 class="allOrdersTitle" id="allorderstitle">ALL ORDERS</h1>
            </div>
            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ORDER CODE</th>
                        <th>DETAILS</th>
                        <th>ACTION</th>
                        <th>PACKAGE STATUS</th>
                        <th>PAYMENT METHOD</th>
                        <th>TOTAL PAYMENT LEFT</th>
                        <th>ONLINE TOTAL PAYMENT</th>
                        <th>ORDER BY</th>
                        <th>DATE</th>
                        <th>DELIVERY</th>
                        <th>CANCEL ORDER</th>
                        <th>MESSAGE</th>
                        <th>ACCEPTED BY</th>
                        <th>DELIVERY BY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqls = "SELECT * FROM ordercode ORDER BY ID DESC;";
                    $results = $conn->query($sqls);
                    if ($results->num_rows > 0) {
                        while ($rows = $results->fetch_assoc()) {
                            $codeorder = $rows['CODE'];
                            $userID = $rows['USER_ID'];
                            $userAccepted = $rows['ACCEPTED_BY'];
                            $userDelivery = $rows['DELIVERED_BY'];

                            $orderDate = new DateTime($rows['ORDER_DATE']);
                            $orderDate->add(new DateInterval('P3D'));
                            $updatedOrderDate = $orderDate->format('Y-m-d');
                            // $sql = "SELECT * FROM orders ORDER BY DATE DESC;";
                            // $result = $conn->query($sql);
                            // if ($result->num_rows > 0) {
                            //     while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr class="even-row" data-status="<?php echo $rows['PACKAGE_STATUS']; ?>">
                                <td><?php echo $rows['ID'] ?></td>
                                <td><?php echo $rows['CODE'] ?></td>
                                <td>
                                    <button class=" Show" onclick="location.href='?qr=<?php echo $rows['QRCODE']; ?>&id=<?php echo $rows['CODE']; ?>&action=show'">DETAILS</button>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['PAYMENT_OPTION'] === "GCASH" or $rows['PAYMENT_OPTION'] === "HALF DOWNPAYMENT GCASH") {
                                        if ($rows['PACKAGE_STATUS'] === "PAYMENT PENDING") {
                                    ?>
                                            <a href="staff_Dashboard_Order_Online_Payment.php?num=<?php echo $rows['NUMBER']; ?>&id=<?php echo $rows['CODE']; ?>&status=<?php echo $rows['PACKAGE_STATUS'] ?>&topay=<?php echo $rows['TO_PAY_ONLINE'] ?>&total=<?php echo $rows['TOTAL_PRICE'] ?>"><button class="show">VEIW PAYMENT</button></a>
                                        <?php
                                        } else if ($rows['PACKAGE_STATUS'] === "ORDER ACCEPTED") {
                                        ?>
                                            <a href="staff_Dashboard_Order_Online_Payment.php?num=<?php echo $rows['NUMBER']; ?>&id=<?php echo $rows['CODE']; ?>&status=<?php echo $rows['PACKAGE_STATUS'] ?>&topay=<?php echo $rows['TO_PAY_ONLINE'] ?>&total=<?php echo $rows['TOTAL_PRICE'] ?>"><button class="show">VEIW PAYMENT</button></a>
                                        <?php
                                        } else if ($rows['PACKAGE_STATUS'] === "ORDER SUCCESS") {
                                        ?>
                                            <a href="staff_Dashboard_Order_Online_Payment.php?num=<?php echo $rows['NUMBER']; ?>&id=<?php echo $rows['CODE']; ?>&status=<?php echo $rows['PACKAGE_STATUS'] ?>&topay=<?php echo $rows['TO_PAY_ONLINE'] ?>&total=<?php echo $rows['TOTAL_PRICE'] ?>"><button class="show">VEIW PAYMENT</button></a>
                                        <?php
                                        }
                                        // else if ($rows['PACKAGE_STATUS'] === "ORDER SUCCESS") {
                                        //     echo "ORDER SUCCESS";
                                        // } else if ($rows['PACKAGE_STATUS'] === "ORDER ACCEPTED") {
                                        //     echo "ORDER ACCEPTED";
                                        // } else if ($rows['PACKAGE_STATUS'] === "ORDER CANCELED") {
                                        //     echo "ORDER CANCELED";
                                        // }
                                    } else if ($rows['PAYMENT_OPTION'] === "COD" or $rows['PAYMENT_OPTION'] === "WALK-IN") {
                                        if ($rows['PACKAGE_STATUS'] === "ORDER PENDING") {
                                        ?>
                                            <a href="php/staff_Dashboard_Orders/accept_Order.php?num=<?php echo $rows['NUMBER']; ?>&action=<?php echo urlencode($rows['CODE']); ?>">
                                                <button class="acceptOrder" id="showed">ACCEPT</button>
                                            </a>
                                    <?php
                                        }
                                        //  else if ($rows['PACKAGE_STATUS'] === "ORDER SUCCESS") {
                                        //     echo "ORDER SUCCESS";
                                        // } else if ($rows['PACKAGE_STATUS'] === "ORDER ACCEPTED") {
                                        //     echo "ORDER ACCEPTED";
                                        // } else if ($rows['PACKAGE_STATUS'] === "ORDER CANCELED") {
                                        //     echo "ORDER CANCELED";
                                        // }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['PACKAGE_STATUS'] === '') {
                                        echo "WALK-IN";
                                    } else {
                                        echo $rows['PACKAGE_STATUS'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($rows['PAYMENT_OPTION'] == '') {
                                        echo "WALK-IN";
                                    } else {
                                        echo $rows['PAYMENT_OPTION'];
                                    }
                                    ?>
                                </td>
                                <td>₱<?php echo number_format($rows['TOTAL_PRICE'], 2); ?></td>
                                <td>₱<?php echo number_format($rows['TO_PAY_ONLINE'], 2); ?></td>
                                <td>
                                    <?php
                                    if (isset($userID) && !empty($userID)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM userlogin WHERE ID = $userID";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo $rows['USER_ID'] . " " . $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                    }
                                    ?>
                                </td>
                                <td><?php echo $rows['ORDER_DATE'] ?></td>
                                <td><?php echo $rows['DELIVERY_DATE'] ?></td>
                                <td>
                                    <?php
                                    // $updatedOrderDate > date('Y-m-d')
                                    if ($rows['PACKAGE_STATUS'] === "PAYMENT PENDING" or $rows['PACKAGE_STATUS'] === "ORDER PENDING") {
                                    ?>
                                        <form action="php/staff_Dashboard_Orders/admin_Buy_cancel.php" method="post" class="formms">
                                            <label for="reason">Reason For Cancelation</label>
                                            <br>
                                            <input type="text" name="reason" maxlength="200" placeholder="Reason For Cancelation" required>
                                            <input type="text" value="<?php echo $rows['CODE'] ?>" name="orderid" hidden>
                                            <input type="text" value="<?php echo $rows['NUMBER'] ?>" name="num" hidden>
                                            <div>
                                                <input type="checkbox" name="terms" id="#" required>
                                                <a>Once you canceled,<br>
                                                    it cannot be undo.</a>
                                            </div>
                                            <input type="submit" value="CANCEL ORDER" name="startCancelation" class="cancelBtn">
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?php echo $rows['REASON_FOR_CANCEL']; ?></td>
                                <td>
                                    <?php
                                    if (isset($userAccepted) && !empty($userAccepted)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM companylogin WHERE ID = $userAccepted";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo $rows['ACCEPTED_BY'] . " " . $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($userDelivery) && !empty($userDelivery)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM companylogin WHERE ID = $userDelivery";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo $rows['ACCEPTED_BY'] . " " . $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                    }
                                    ?>
                                </td>
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
        <div class="grid-container">
            <a class="bringback">
                <div class="grid-item" id="accepted_Orders1">
                    <div>
                        <h3>ALL REPLACEMENT RECORD</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM returnitem;';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a class="sortReplacementButton">
                <div class="grid-item" id="accepted_Orders2">
                    <div>
                        <h3>REPLACEMENT REQUEST</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM returnitem WHERE STATUS = "REPLACEMENT REQUEST";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a class="sortAcceptReplacementButton">
                <div class="grid-item" id="accepted_Orders3">
                    <div>
                        <h3>REPLACEMENT ACCEPTED</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM returnitem WHERE STATUS = "REPLACEMENT ACCEPTED";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a class="sortDeclineReplacementButton">
                <div class="grid-item" id="accepted_Orders4">
                    <div>
                        <h3>REPLACEMENT DECLINED</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM returnitem WHERE STATUS = "REPLACEMENT DECLINED";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
            <a class="sortDeclineReplacementSuccessButton">
                <div class="grid-item" id="accepted_Orders5">
                    <div>
                        <h3>REPLACEMENT SUCCESS</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM returnitem WHERE STATUS = "REPLACEMENT SUCCESS";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>
        </div>
        <div class="allOrders" id="allOrders">
            <div class="allOrdersContainer">
                <h1 class="allOrdersTitle" id="replaceID">ALL REPLACEMENT</h1>
            </div>
            <table id="ordersTables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ORDER CODE</th>
                        <th>DETAILS</th>
                        <th>MESSAGE</th>
                        <th>STATUS</th>
                        <th>REQUEST DATE</th>
                        <th>ACCEPT</th>
                        <th>VIDEO PROOF</th>
                        <th>DECLINE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqls = "SELECT * FROM returnitem ORDER BY ID DESC;";
                    $results = $conn->query($sqls);
                    if ($results->num_rows > 0) {
                        while ($rows = $results->fetch_assoc()) {
                    ?>
                            <tr class="even-rows" data-status="<?php echo $rows['STATUS']; ?>">
                                <td><?php echo $rows['ID'] ?></td>
                                <td><?php echo $rows['ORDERCODE'] ?></td>
                                <td><button class="Show" onclick="location.href='?orderIDReplace=<?php echo $rows['ID']; ?>&replace=show'">DETAILS</button></td>
                                <td><?php echo $rows['MESSAGE'] ?></td>
                                <td><?php echo $rows['STATUS'] ?></td>
                                <td><?php echo $rows['DATE_REQUEST'] ?></td>
                                <td>
                                    <?php
                                    if ($rows['STATUS'] === 'REPLACEMENT REQUEST') {
                                    ?>
                                        <a style="display: flex; justify-content: center;" href="php/staff_Dashboard_Orders/accept_Replacement.php?num=<?php echo $rows['NUMBER']; ?>&id=<?php echo $rows['ID']; ?>&orderid=<?php echo $rows['ORDERID']; ?>&ordercode=<?php echo $rows['ORDERCODE']; ?>"><button class="pends">ACCEPT REPLACEMENT</button></a>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><button class="Show" onclick="location.href='?orderid=<?php echo $rows['ID']; ?>&proof=show'">VIDEO PROOF</button></td>
                                <td>
                                    <?php
                                    if ($rows['STATUS'] === 'REPLACEMENT REQUEST') {
                                    ?>
                                        <form action="php/staff_Dashboard_Orders/decline_Request.php" method="post" class="formms">
                                            <label for="reason">Decline Request Reason</label>
                                            <br>
                                            <input type="text" name="reason" maxlength="200" placeholder="Reason For Declining" required>
                                            <input type="text" value="<?php echo $rows['NUMBER'] ?>" name="num" hidden>
                                            <input type="text" value="<?php echo $rows['ID'] ?>" name="id" hidden>
                                            <input type="text" value="<?php echo $rows['ORDERID'] ?>" name="orderid" hidden>
                                            <div>
                                                <input type="checkbox" name="terms" id="#" required>
                                                <a>Once you canceled,<br>
                                                    it cannot be undo.</a>
                                            </div>
                                            <input type="submit" value="DECLINE REQUEST" name="startCancelation" class="cancelBtn">
                                        </form>
                                    <?php
                                    }
                                    ?>

                                </td>
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
        <br><br><br><br><br><br>
    </main>
    <?php
    if (isset($_GET['replace']) && $_GET['replace'] == 'show' && isset($_GET['orderIDReplace'])) :
    ?>
        <div class="show_Update">
            <div class="show_form">
                <img src="img/icons/close.png" alt="xmark" class="Icon-close">
                <div class="navForAnotherPage center-heading">
                    <h2 class="titleVoucher">ORDER REPLACEMENT INFORMATION</h2>
                    <br><br>
                    <?php
                    $mainId = $_GET['orderIDReplace'];
                    $sqlQuery = "SELECT * FROM returnitem WHERE ID = $mainId;";
                    $runSql = mysqli_query($conn, $sqlQuery);
                    while ($row = mysqli_fetch_array($runSql)) {
                        $orderCode = $row['ORDERCODE'];
                        $idorders = $row['ORDERID'];
                        $packagestats = $row['STATUS'];
                        $qrcode = $row['QRCODE'];

                        $forQR = $orderCode . $idorders;
                        $sqlQuerys = "SELECT * FROM orders WHERE ID = $idorders;";
                        $runSqls = mysqli_query($conn, $sqlQuerys);
                        while ($rows = mysqli_fetch_array($runSqls)) {
                    ?>
                            <div class="grid-containers">
                                <div class="item1s">
                                    <div class="detailsPrint">
                                        <h3>Item Name: <span><?php echo $rows['ORDERED_ITEM'] ?></span></h3>
                                        <hr>
                                        <h3>Item Quantity: <span>x<?php echo $rows['QUANTITY'] ?></span></h3>
                                        <hr>
                                        <h3>Street/House Number: <span><?php echo $rows['ADDITIONAL_INFORMATION'] ?></span></h3>
                                        <hr>
                                        <h3>Province: <span><?php echo $rows['PROVINCE'] ?></span></h3>
                                        <hr>
                                        <h3>City/Municipality: <span><?php echo $rows['CITYMUNICIPALITY'] ?></span></h3>
                                        <hr>
                                        <h3>Barangay: <span><?php echo $rows['BARANGAY'] ?></span></h3>
                                    </div>
                                </div>
                                <div>
                                </div>
                                <div class="item3s">
                                    <img src="img/itemPhotos/<?php echo $rows['ITEM_IMAGE'] ?>" alt=" ">
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <?php
                            if ($packagestats === 'REPLACEMENT ACCEPTED') { ?>
                                <div class="QRcon">
                                    <div id="QrCodeGen"></div>
                                    <script>
                                        var generatedCodes = [];
                                        var qrCodeText = <?php echo json_encode($qrcode); ?>;
                                        generatedCodes.push(qrCodeText);
                                        var qrcode = new QRCode(document.getElementById("QrCodeGen"), {
                                            text: qrCodeText,
                                            width: 500,
                                            height: 500,
                                            colorDark: "#000000",
                                            colorLight: "#ffffff",
                                            correctLevel: QRCode.CorrectLevel.H
                                        });
                                        document.querySelector("#qrText span").textContent = qrCodeText;
                                    </script>
                                </div>

                            <?php
                            }
                            ?>
                    <?php
                        }
                    }
                    ?>
                    <button id="print" class="AnalyticsPrint">Print</button>

                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
    <?php
    if (isset($_GET['proof']) && $_GET['proof'] == 'show' && isset($_GET['orderid'])) :
    ?>
        <div class="show_Update">
            <div class="show_form">
                <img src="img/icons/close.png" alt="xmark" class="Icon-close">
                <div class="navForAnotherPage center-heading">
                    <h2 class="titleVoucher"></h2>
                    <?php
                    $mainId = $_GET['orderid'];
                    $sqlQuery = "SELECT VID FROM returnitem WHERE ID = $mainId;";
                    $runSql = mysqli_query($conn, $sqlQuery);

                    while ($row = mysqli_fetch_array($runSql)) {
                    ?>
                        <video src="img/videoProof/<?php echo $row['VID']; ?>" controls></video>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'show' && isset($_GET['id'])) :
    ?>
        <div class="show_Update">
            <div class="show_form">
                <img src="img/icons/close.png" alt="xmark" class="Icon-close">

                <div class="navForAnotherPage center-heading">
                    <h2 class="titleVoucher">ORDER INFORMATION</h2>
                </div>
                <div id="printArea">
                    <?php
                    $mainId = $_GET['id'];
                    $QR = $_GET['qr'];

                    $sqlQueryShot = "SELECT * FROM ordercode WHERE CODE = '$mainId';";
                    $runSqlShot = mysqli_query($conn, $sqlQueryShot);
                    while ($rowShot = mysqli_fetch_array($runSqlShot)) {
                        $priceFee = $rowShot['TOTAL_PRICE'];

                        $sqlQuery = "SELECT * FROM orders WHERE ORDERCODE = '$mainId';";
                        $runSql = mysqli_query($conn, $sqlQuery);
                        while ($row = mysqli_fetch_array($runSql)) {
                            $St = $row['ADDITIONAL_INFORMATION'];
                            $pv = $row['PROVINCE'];
                            $cm = $row['CITYMUNICIPALITY'];
                            $br = $row['BARANGAY'];
                            $pm = $row['PAYMENT_METHOD'];
                    ?>
                            <div class="grid-containers">
                                <div class="item1s">
                                    <div class="detailsPrint">
                                        <h3>Item Name: <span><?php echo $row['ORDERED_ITEM'] ?></span></h3>
                                        <h3>Item Quantity: <span>x<?php echo $row['QUANTITY'] ?></span></h3>
                                        <h3>Price: <span style="color: red;">₱<?php echo number_format($row['TOTAL_PRICE'], 2) ?></span></h3>
                                    </div>
                                </div>
                                <div>
                                </div>
                                <div class="item3s">
                                    <img src="img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt=" ">
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                        <div class="item2s">
                            <div class="detailsPrint">
                                <br>
                                <h3>Payment Method: <span><?php echo $pm ?></span></h3>
                                <hr>
                                <h3>Street/House Number: <span><?php echo $St ?></span></h3>
                                <hr>
                                <h3>Province: <span><?php echo $pv ?></span></h3>
                                <hr>
                                <h3>City/Municipality: <span><?php echo $cm ?></span></h3>
                                <hr>
                                <h3>Barangay: <span><?php echo $br ?></span></h3>
                                <hr>
                                <br>
                                <h3>Order ID: <span><?php echo $rowShot['CODE'] ?></span></h3>
                                <h3>Total Payment Left: <span style="color: red;">₱<?php echo number_format($rowShot['TOTAL_PRICE'], 2) ?></span></h3>
                            </div>

                            <?php
                            if ($QR) { ?>
                                <div class="QRcon">
                                    <!-- <p id="qrText">QRCode Text: <span></span></p> -->
                                    <div id="QrCodeGen"></div>
                                    <script>
                                        var generatedCodes = [];
                                        var qrCodeText = <?php echo json_encode($QR); ?>;
                                        generatedCodes.push(qrCodeText);
                                        var qrcode = new QRCode(document.getElementById("QrCodeGen"), {
                                            text: qrCodeText,
                                            width: 350,
                                            height: 350,
                                            colorDark: "#000000",
                                            colorLight: "#ffffff",
                                            correctLevel: QRCode.CorrectLevel.H
                                        });
                                        document.querySelector("#qrText span").textContent = qrCodeText;
                                    </script>
                                </div>

                        <?php
                            }
                        }
                        ?>
                        <button id="print" class="AnalyticsPrint">Print</button>
                        </div>
                </div>
            </div>
        </div>
    <?php
    endif;
    ?>
</body>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".Icon-close").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                document.querySelector(".show_Update").style.display = "none";

                // remove id parameter from the URL
                var url = window.location.toString();
                if (url.indexOf("?") > 0) {
                    var clean_url = url.substring(0, url.indexOf("?"));
                    window.history.replaceState({}, document.title, clean_url);
                }
            });
        });
    });
</script>
<script>
    function updateContent() {
        location.reload();
    }
    setInterval(updateContent, 60000);
</script>
<script>
    let printBtn = document.querySelector("#print");

    printBtn.addEventListener("click", function() {
        window.print(); // Print the content
    });
</script>


<script>
    $(document).ready(function() {
        $("#sortAndHideRows").click(function() {
            // Show only the "SHOW" status rows
            $(".even-row[data-status='ORDER SUCCESS']").show();
            $(".even-row[data-status!='ORDER SUCCESS']").hide();
            $("#allorderstitle").text("ORDER SUCCESS");

            $("#all_Orders").css("background-color", "white");
            $("#canceled_Orders").css("background-color", "white");
            $("#done_Orders").css("background-color", "lightgray");
            $("#pending_Orders").css("background-color", "white");
            $("#accepted_Order").css("background-color", "white");
            $("#accepted_Orders").css("background-color", "white");
        });
        $("#sortCanceledButton").click(function() {
            // Show only the "HIDE" status rows
            $(".even-row[data-status='ORDER CANCELED']").show();
            $(".even-row[data-status!='ORDER CANCELED']").hide();
            $("#allorderstitle").text("ORDER CANCELED");

            $("#all_Orders").css("background-color", "white");
            $("#canceled_Orders").css("background-color", "lightgray");
            $("#done_Orders").css("background-color", "white");
            $("#pending_Orders").css("background-color", "white");
            $("#accepted_Order").css("background-color", "white");
            $("#accepted_Orders").css("background-color", "white");
        });
        $("#sortPendingButton").click(function() {
            // Show only the "HIDE" status rows
            $(".even-row[data-status='ORDER PENDING']").show();
            $(".even-row[data-status!='ORDER PENDING']").hide();
            $("#allorderstitle").text("ORDER PENDING");

            $("#all_Orders").css("background-color", "white");
            $("#canceled_Orders").css("background-color", "white");
            $("#done_Orders").css("background-color", "white");
            $("#pending_Orders").css("background-color", "lightgray");
            $("#accepted_Order").css("background-color", "white");
            $("#accepted_Orders").css("background-color", "white");
        });
        $("#sortAcceptedButton").click(function() {
            // Show only the "HIDE" status rows
            $(".even-row[data-status='ORDER ACCEPTED']").show();
            $(".even-row[data-status!='ORDER ACCEPTED']").hide();
            $("#allorderstitle").text("ORDER ACCEPTED");

            $("#all_Orders").css("background-color", "white");
            $("#canceled_Orders").css("background-color", "white");
            $("#done_Orders").css("background-color", "white");
            $("#pending_Orders").css("background-color", "white");
            $("#accepted_Order").css("background-color", "lightgray");
            $("#accepted_Orders").css("background-color", "white");
        });
        $("#sortPaymentPendingButton").click(function() {
            // Show only the "HIDE" status rows
            $(".even-row[data-status='PAYMENT PENDING']").show();
            $(".even-row[data-status!='PAYMENT PENDING']").hide();
            $("#allorderstitle").text("PAYMENT PENDING");

            $("#all_Orders").css("background-color", "white");
            $("#canceled_Orders").css("background-color", "white");
            $("#done_Orders").css("background-color", "white");
            $("#pending_Orders").css("background-color", "white");
            $("#accepted_Order").css("background-color", "white");
            $("#accepted_Orders").css("background-color", "lightgray");

        });
        $("#sortLatestToOldestButton").click(function() {
            // Show all rows
            $(".even-row").show();
            $("#allorderstitle").text("ALL ORDERS");

            $("#all_Orders").css("background-color", "lightgray");
            $("#canceled_Orders").css("background-color", "white");
            $("#done_Orders").css("background-color", "white");
            $("#pending_Orders").css("background-color", "white");
            $("#accepted_Order").css("background-color", "white");
            $("#accepted_Orders").css("background-color", "white");

        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".sortReplacementButton").click(function() {
            // Show only the "SHOW" status rows
            $(".even-rows[data-status='REPLACEMENT REQUEST']").show();
            $(".even-rows[data-status!='REPLACEMENT REQUEST']").hide();
            $("#replaceID").text("REPLACEMENT REQUEST");

            $("#accepted_Orders1").css("background-color", "white");
            $("#accepted_Orders2").css("background-color", "lightgray");
            $("#accepted_Orders3").css("background-color", "white");
            $("#accepted_Orders4").css("background-color", "white");
            $("#accepted_Orders5").css("background-color", "white");
        });
        $(".sortAcceptReplacementButton").click(function() {
            // Show only the "SHOW" status rows
            $(".even-rows[data-status='REPLACEMENT ACCEPTED']").show();
            $(".even-rows[data-status!='REPLACEMENT ACCEPTED']").hide();
            $("#replaceID").text("REPLACEMENT ACCEPTED");

            $("#accepted_Orders1").css("background-color", "white");
            $("#accepted_Orders2").css("background-color", "white");
            $("#accepted_Orders3").css("background-color", "lightgray");
            $("#accepted_Orders4").css("background-color", "white");
            $("#accepted_Orders5").css("background-color", "white");

        });
        $(".sortDeclineReplacementButton").click(function() {
            // Show only the "SHOW" status rows
            $(".even-rows[data-status='REPLACEMENT DECLINED']").show();
            $(".even-rows[data-status!='REPLACEMENT DECLINED']").hide();
            $("#replaceID").text("REPLACEMENT DECLINED");

            $("#accepted_Orders1").css("background-color", "white");
            $("#accepted_Orders2").css("background-color", "white");
            $("#accepted_Orders3").css("background-color", "white");
            $("#accepted_Orders4").css("background-color", "lightgray");
            $("#accepted_Orders5").css("background-color", "white");
        });
        $(".sortDeclineReplacementSuccessButton").click(function() {
            // Show only the "SHOW" status rows
            $(".even-rows[data-status='REPLACEMENT SUCCESS']").show();
            $(".even-rows[data-status!='REPLACEMENT SUCCESS']").hide();
            $("#replaceID").text("REPLACEMENT SUCCESS");
            $("#accepted_Orders1").css("background-color", "white");
            $("#accepted_Orders2").css("background-color", "white");
            $("#accepted_Orders3").css("background-color", "white");
            $("#accepted_Orders4").css("background-color", "white");
            $("#accepted_Orders5").css("background-color", "lightgray");
        });
        $(".bringback").click(function() {
            // Show all rows
            $(".even-rows").show();
            $("#replaceID").text("ALL REPLACEMENT RECORD");
            $("#accepted_Orders1").css("background-color", "lightgray");
            $("#accepted_Orders2").css("background-color", "white");
            $("#accepted_Orders3").css("background-color", "white");
            $("#accepted_Orders4").css("background-color", "white");
            $("#accepted_Orders5").css("background-color", "white");
        });
    });
</script>
</main>
<div class="just">

</div>
<script>
    function closeOpenNav() {
        if (document.getElementById("mainContent").style.marginLeft == "15vw") {
            document.getElementById("mainContent").style.marginLeft = "0vw";
            document.getElementById("sideNav").style.width = "0vw";

        } else if (document.getElementById("mainContent").style.marginLeft = "0vw") {
            document.getElementById("mainContent").style.marginLeft = "15vw";
            document.getElementById("sideNav").style.width = "15vw";
        }
    }
</script>

</html>