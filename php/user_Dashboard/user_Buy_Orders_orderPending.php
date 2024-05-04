<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
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
    <link rel="stylesheet" href="../../css/user_Buy_Orders.css">
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
            <h1 class="title">Order Pending</h1>
            <?php
            if (isset($_GET['addMsg'])) { ?>
                <p class="addMsg"><?php echo $_GET['addMsg']; ?></p>
            <?php } ?>
            <!-- <div class="card_Content" id="card_Content">
                <?php
                $sql = "SELECT * FROM orders WHERE ORDER_BY = '$tdbAdminId' ORDER BY ID DESC";
                $result = $conn->query($sql);

                while ($row = mysqli_fetch_array($result)) {
                    $date = new DateTime($row['DATE']);
                    $date->add(new DateInterval('P3D'));
                    $updatedDate = $date->format('Y-m-d');
                ?>
                    <div class="main_Order_Container">
                        <div class="image_Container">
                            <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                        </div>
                        <div class="main_Info">
                            <h1>ORDER ID: <?php echo $row['ID'] ?></h1>
                            <hr>
                            <h1>NAME: <?php echo $row['ORDERED_ITEM'] ?></h1>
                            <hr>
                            <h1>PAYMENT METHOD: <?php echo $row['PAYMENT_METHOD'] ?></h1>
                            <hr>
                            <h1>ORDER DATE: <?php echo $row['DATE'] ?></h1>
                            <hr>
                            <h1>ESTIMATED DELIVERY DATE: <?php echo $row['DATE_LIMIT'] ?></h1>
                            <hr>
                        </div>
                        <div class="second_Info">
                            <h3>Price: <?php echo $row['ITEM_PRICE'] ?></h3>
                            <hr>
                            <h3>Total Price: <?php echo $row['TOTAL_PRICE'] ?></h3>
                            <hr>
                            <h3>Status: <?php echo $row['PACKAGE_STATUS'] ?></h3>
                            <hr>
                            <h3>Quantity: <?php echo $row['QUANTITY'] ?>x</h3>
                            <hr>
                            <h3>To Pay: ₱<?php echo $row['TO_PAY'] ?></h3>
                            <hr>
                        </div>
                        <div class="action">
                            <?php
                            if ($row['PAYMENT_METHOD'] === 'GCASH' or $row['PAYMENT_METHOD'] === 'HALF DOWNPAYMENT GCASH') {
                                if ($row['PACKAGE_STATUS'] === 'ORDER SUCCESS') {
                            ?>
                                    <a href="user_Review_Item.php?idOfTheItem=<?php echo $row['ITEM_ID'] ?>" class="review_Start"><button>Review Order</button></a>
                                    <?php
                                    if ($row['DATE_DELIVERED'] != null) {
                                        $dateReplace = new DateTime($row['DATE_DELIVERED']);
                                        $dateReplace->add(new DateInterval('P1D'));
                                        $updateddateReplace = $dateReplace->format('Y-m-d');
                                        if ($updateddateReplace > date('Y-m-d')) {
                                            if ($row['RETURN_VID'] === "") {
                                    ?>
                                                <a href="user_Replace_Item.php?orderID=<?php echo $row['ID'] ?>" class="review_Start"><button style="margin-top: 2vw;">Replace Item</button></a>
                                            <?php
                                            } else {
                                                echo "<br><br>The maximum try of replacement request is one time only for each order";
                                            }
                                        } else if ($updateddateReplace < date('Y-m-d')) {
                                            ?>
                                            <a class="review_Start"><button style="margin-top: 2vw; background-color: gray;">Replace Item Not Available (DATE EXCEEDED)</button></a>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                } else if ($row['PACKAGE_STATUS'] === 'ORDER CANCELED') {
                                    echo "ORDER CANCELED <br>";
                                    echo "Reason: " . $row['REASON_FOR_CANCEL'];
                                } else if ($row['PACKAGE_STATUS'] === 'ORDER ACCEPTED') {
                                    echo "ORDER HAS BEEN ACCEPTED <br>";
                                } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT REQUEST') {
                                    echo "The staff are processing your request";
                                } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT ACCEPTED') {
                                    echo "The Replacement request has been accepted.";
                                } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT DECLINED') {
                                    echo "The Replacement request has been decline. <br>";
                                    echo $row['REASON_FOR_CANCEL'];
                                } else if ($row['DATE_PAY_LIMIT'] > date('Y-m-d')) {
                                    ?>
                                    <form action="user_Buy_Cancel.php" method="post">
                                        <label for="reason">Reason For Cancelation</label>
                                        <br>
                                        <input type="text" name="reason" maxlength="200" placeholder="Reason For Cancelation" required>
                                        <input type="text" value="<?php echo $row['QUANTITY'] ?>" name="quantity" hidden>
                                        <input type="text" value="<?php echo $row['ITEM_ID'] ?>" name="itemId" hidden>
                                        <input type="text" value="<?php echo $row['ID'] ?>" name="orderid" hidden>
                                        <div>
                                            <input type="checkbox" name="terms" id="#" required>
                                            <a href="../../payment_terms.php" target="_blank">Payment Terms and Conditions</a>
                                        </div>
                                        <input type="submit" value="CANCEL ORDER" name="startCancelation">
                                    </form>
                                    <br>
                                    <a href="user_Online_Payment.php?orderID=<?php echo $row["ID"] ?>&orderStatus=<?php echo $row["PACKAGE_STATUS"] ?>"><button>PLACE/VIEW PAYMENT</button></a>
                                <?php
                                } else {
                                    echo "Your order has now exceed the payment date limit,";
                                    echo " the Staff has the rights to cancel your order up to this date,";
                                    echo " message our support for further information."
                                ?>
                                    <br>
                                    <br>
                                    <a href="user_Online_Payment.php?orderID=<?php echo $row["ID"] ?>&orderStatus=<?php echo $row["PACKAGE_STATUS"] ?>"><button>PLACE/VIEW PAYMENT</button></a>
                                <?php
                                }
                            } else if ($row['PAYMENT_METHOD'] === 'COD') {
                                if ($row['PACKAGE_STATUS'] === 'ORDER SUCCESS') {
                                ?>
                                    <a href="user_Review_Item.php?idOfTheItem=<?php echo $row['ITEM_ID'] ?>" class="review_Start"><button>Review Order</button></a>
                                    <?php
                                    if ($row['DATE_DELIVERED'] != null) {
                                        $dateReplace = new DateTime($row['DATE_DELIVERED']);
                                        $dateReplace->add(new DateInterval('P1D'));
                                        $updateddateReplace = $dateReplace->format('Y-m-d');
                                        if ($updateddateReplace > date('Y-m-d')) {
                                    ?>
                                            <a href="user_Replace_Item.php?orderID=<?php echo $row['ID'] ?>" class="review_Start"><button style="margin-top: 2vw;">Replace Item</button></a>
                                        <?php
                                        } else if ($updateddateReplace < date('Y-m-d')) {
                                        ?>
                                            <a class="review_Start"><button style="margin-top: 2vw; background-color: gray;">Replace Item Not Available (DATE EXCEEDED)</button></a>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                } else if ($row['PACKAGE_STATUS'] === 'ORDER CANCELED') {
                                    echo "ORDER CANCELED <br>";
                                    echo "Reason: " . $row['REASON_FOR_CANCEL'];
                                } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT REQUEST') {
                                    echo "The staff are processing your request";
                                } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT ACCEPTED') {
                                    echo "The Replacement request has been accepted.";
                                } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT DECLINED') {
                                    echo "The Replacement request has been decline. <br> Staff Message: ";
                                    echo $row['REASON_FOR_CANCEL'];
                                } else if ($updatedDate > date('Y-m-d')) {
                                    ?>
                                    <form action="user_Buy_Cancel.php" method="post">
                                        <label for="reason">Reason For Cancelation</label>
                                        <input type="text" name="reason" maxlength="200" placeholder="Reason For Cancelation" required>
                                        <input type="text" value="<?php echo $row['QUANTITY'] ?>" name="quantity" hidden>
                                        <input type="text" value="<?php echo $row['ITEM_ID'] ?>" name="itemId" hidden>
                                        <input type="text" value="<?php echo $row['ID'] ?>" name="orderid" hidden>
                                        <div>
                                            <input type="checkbox" name="terms" id="#" required>
                                            <a href="../../payment_terms.php" target="_blank">Payment Terms and Conditions</a>
                                        </div>
                                        <input type="submit" value="CANCEL ORDER" name="startCancelation">
                                    </form>
                            <?php
                                } else {
                                    echo "The Item will be delivered with in seven days from the day you place the order or request replacement. <br> ";
                                    echo $row['PACKAGE_STATUS'];
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div> -->
            <div class="card_Content" id="card_Content">
                <div class="clickableOrders">
                    <a href="user_Buy_Orders.php"><button>ALL ORDERS</button></a>
                    <a href="user_Buy_Orders_orderSuccess.php"><button>ORDER SUCCESS</button></a>
                    <a href="user_Buy_Orders_orderPending.php"><button>ORDER PENDING</button></a>
                    <a href="user_Buy_Orders_orderPayment.php"><button>PAYMENT PENDING</button></a>
                    <a href="user_Buy_OrdersCanceled.php"><button>ORDER CANCELED</button></a>

                </div>
                <?php
                $sqlordercode = "SELECT * FROM ordercode WHERE USER_ID = '$tdbAdminId' AND PACKAGE_STATUS = 'ORDER PENDING' ORDER BY ID DESC";
                $resultordercode  = $conn->query($sqlordercode);
                while ($rowordercode  = mysqli_fetch_array($resultordercode)) {
                    $ordercode = $rowordercode['CODE'];
                ?>
                    <div class="mainPaymentCon">
                        <div class="allDetails">
                            <h1>ORDER ID: <?php echo $rowordercode['CODE'] ?></h1>
                            <h1>Total Payment Left: <span style="color: red;">₱<?php echo number_format($rowordercode['TOTAL_PRICE'], 2) ?></span></h1>
                            <h1>Payment Method: <?php echo $rowordercode['PAYMENT_OPTION'] ?></h1>
                            <h1>Order Status: <?php echo $rowordercode['PACKAGE_STATUS'] ?></h1>

                            <h1>
                                <?php
                                if ($rowordercode['PAYMENT_OPTION'] === 'GCASH' or $rowordercode['PAYMENT_OPTION'] === 'HALF DOWNPAYMENT GCASH') {
                                ?>
                                    Pending Payment Online <span style="color: red;">₱<?php echo number_format($rowordercode['TO_PAY_ONLINE'], 2); ?></span>
                                <?php
                                } else {
                                    echo "Pending Payment Online ₱" . number_format(0, 2);
                                }
                                ?>
                            </h1>
                        </div>
                        <hr>
                        <?php
                        $sql = "SELECT * FROM orders WHERE ORDERCODE = '$ordercode' ORDER BY ID DESC";
                        $result = $conn->query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                            $date = new DateTime($row['DATE']);
                            $date->add(new DateInterval('P3D'));
                            // Now $date contains the updated date with 3 days added
                            $updatedDate = $date->format('Y-m-d');
                        ?>
                            <div class="main_Order_Container">
                                <div class="image_Container">
                                    <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                                </div>
                                <div class="main_Info">
                                    <h1>NAME: <?php echo $row['ORDERED_ITEM'] ?></h1>
                                    <hr>
<h1>ORDER DATE: 
                                    <?php
                                    $thisdate = $rowordercode['ORDER_DATE'];
                                    $formattedDates = date('F d, Y', strtotime($thisdate));

                                    echo $formattedDates;
                                    ?>
                                    </h1>
                                    <hr>
                                    <h1>DELIVERY DATE: 
                                    <?php 
                                    $thisdate1 = $rowordercode['DELIVERY_DATE'];
                                    $formattedDates1 = date('F d, Y', strtotime($thisdate1));

                                    echo $formattedDates1;
                                    ?>
                                    </h1>
                                    <hr>
                                    <h1>PRICE: ₱<?php echo number_format($row['ITEM_PRICE'], 2) ?></h1>
                                    <hr>
                                    <h1>TOTAL PRICE WITH FEE: ₱<?php echo number_format($row['TOTAL_PRICE'], 2) ?></h1>
                                    <hr>

                                </div>
                                <div class="second_Info">
                                    <h3>QUANTITY: x<?php echo $row['QUANTITY'] ?></h3>
                                    <hr>
                                    <?php
                                    if ($row['PACKAGE_STATUS'] === "REPLACEMENT ACCEPTED") {
                                    ?>
                                        <h3>REPLACEMENT STATUS: <?php echo $row['PACKAGE_STATUS'] ?></h3>
                                        <hr>
                                        <h3>DELIVERY OF REPLACEMENT: <?php echo $row['DATE_DELIVERED'] ?></h3>
                                        <hr>
                                    <?php
                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT SUCCESS") {
                                    ?>
                                        <h3>REPLACEMENT STATUS: <?php echo $row['PACKAGE_STATUS'] ?></h3>
                                        <hr>
                                        <h3>DELIVERY OF REPLACEMENT: <?php echo $row['DATE_DELIVERED'] ?></h3>
                                        <hr>
                                    <?php
                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT REQUEST") {
                                    ?>
                                        <h3>REPLACEMENT STATUS: <?php echo $row['PACKAGE_STATUS'] ?></h3>
                                        <hr>
                                        <h3>ESTIMATED DELIVERY FOR REPLACEMENT: <?php echo $row['DATE_DELIVERED'] ?></h3>
                                        <hr>
                                    <?php
                                    } else if ($row['PACKAGE_STATUS'] === "REPLACEMENT DECLINED") {
                                    ?>
                                        <h3>REPLACEMENT STATUS: <?php echo $row['PACKAGE_STATUS'] ?></h3>
                                        <hr>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="second_Info">
                                    <?php
                                    if ($rowordercode['PAYMENT_OPTION'] === 'GCASH' or $rowordercode['PAYMENT_OPTION'] === 'HALF DOWNPAYMENT GCASH') {
                                        if ($rowordercode['PACKAGE_STATUS'] === 'ORDER SUCCESS') {
                                    ?>
                                            <a href="user_Review_Item.php?idOfTheItem=<?php echo $row['ITEM_ID'] ?>" class="review_Start"><button>Review Order</button></a>
                                            <?php
                                            if ($row['PACKAGE_STATUS'] === 'REPLACEMENT REQUEST') {
                                            } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT ACCEPTED') {
                                            } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT DECLINED') {
                                            } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT SUCCESS') {
                                            } else if ($rowordercode['DELIVERY_DATE'] != null) {
                                                $dateReplace = new DateTime($rowordercode['DELIVERY_DATE']);
                                                $dateReplace->add(new DateInterval('P3D'));
                                                $updateddateReplace = $dateReplace->format('Y-m-d');
                                                if ($updateddateReplace > date('Y-m-d') and $row['PACKAGE_STATUS'] !== 'REPLACEMENT REQUEST') {
                                            ?>
                                                    <a href="user_Replace_Item.php?itemid=<?php echo $row['ITEM_ID'] ?>&code=<?php echo $row['ORDERCODE'] ?>&orderid=<?php echo $row['ID'] ?>" class="review_Start"><button style="margin-top: 2vw;">Replace Item</button></a>
                                                <?php
                                                } else if ($updateddateReplace < date('Y-m-d')) {
                                                ?>
                                                    <a class="review_Start"><button style="margin-top: 2vw; background-color: gray;">Replace Item Not Available (DATE EXCEEDED)</button></a>
                                        <?php
                                                }
                                            }
                                        }
                                    } else if ($rowordercode['PACKAGE_STATUS'] === 'ORDER SUCCESS' and $rowordercode['PAYMENT_OPTION'] === 'COD') {
                                        ?>
                                        <a href="user_Review_Item.php?idOfTheItem=<?php echo $row['ITEM_ID'] ?>" class="review_Start"><button>Review Order</button></a>
                                        <?php
                                        if ($row['PACKAGE_STATUS'] === 'REPLACEMENT REQUEST') {
                                        } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT ACCEPTED') {
                                        } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT DECLINED') {
                                        } else if ($row['PACKAGE_STATUS'] === 'REPLACEMENT SUCCESS') {
                                        } else if ($rowordercode['DELIVERY_DATE'] != null) {
                                            $dateReplace = new DateTime($rowordercode['DELIVERY_DATE']);
                                            $dateReplace->add(new DateInterval('P2D'));
                                            $updateddateReplace = $dateReplace->format('Y-m-d');
                                            if ($updateddateReplace > date('Y-m-d')) {
                                        ?>
                                                <a href="user_Replace_Item.php?itemid=<?php echo $row['ITEM_ID'] ?>&code=<?php echo $row['ORDERCODE'] ?>&orderid=<?php echo $row['ID'] ?>" class="review_Start"><button style="margin-top: 2vw;">Replace Item</button></a>
                                            <?php
                                            } else if ($updateddateReplace < date('Y-m-d')) {
                                            ?>
                                                <a class="review_Start"><button style="margin-top: 2vw; background-color: gray;">Replace Item Not Available (DATE EXCEEDED)</button></a>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="action">
                            <?php
                            if ($rowordercode['PAYMENT_OPTION'] === 'GCASH' or $rowordercode['PAYMENT_OPTION'] === 'HALF DOWNPAYMENT GCASH') {
                                if ($rowordercode['PACKAGE_STATUS'] === 'ORDER CANCELED') {
                                    echo "ORDER CANCELED <br>";
                                    echo "Reason: " . $rowordercode['REASON_FOR_CANCEL'];
                                } else if ($rowordercode['PACKAGE_STATUS'] === 'ORDER ACCEPTED') {
                                    echo "ORDER HAS BEEN ACCEPTED <br>";
                                } else if ($updatedDate > date('Y-m-d') and $rowordercode['PACKAGE_STATUS'] === 'PAYMENT PENDING') {
                            ?>
                                    <form action="user_Buy_Cancel.php" method="post">
                                        <label for="reason">Reason For Cancelation</label>
                                        <br>
                                        <input type="text" name="reason" maxlength="200" placeholder="Reason For Cancelation" required>
                                        <input type="text" value="<?php echo $rowordercode['CODE'] ?>" name="code" hidden>
                                        <div>
                                            <input type="checkbox" name="terms" id="#" required>
                                            <a href="../../payment_terms.php" target="_blank">Payment Terms and Conditions</a>
                                        </div>
                                        <input type="submit" value="CANCEL ORDER" name="startCancelation">
                                    </form>
                                    <br>
                                    <a href="user_Online_Payment.php?topayOnly=<?php echo $rowordercode['TO_PAY_ONLINE'] ?>&orderID=<?php echo $rowordercode['CODE'] ?>&orderStatus=<?php echo $rowordercode['PACKAGE_STATUS'] ?>"><button>PLACE/VIEW PAYMENT</button></a>
                                <?php
                                }
                            } else if ($rowordercode['PAYMENT_OPTION'] === 'COD') {
                                if ($rowordercode['PACKAGE_STATUS'] === 'ORDER CANCELED') {
                                    echo "ORDER CANCELED <br>";
                                    echo "Reason: " . $rowordercode['REASON_FOR_CANCEL'];
                                } else if ($rowordercode['PACKAGE_STATUS'] === 'ORDER ACCEPTED') {
                                    echo "ORDER HAS BEEN ACCEPTED <br>";
                                } else if ($updatedDate > date('Y-m-d') and $rowordercode['PACKAGE_STATUS'] === 'ORDER PENDING') {
                                ?>
                                    <form action="user_Buy_Cancel.php" method="post">
                                        <label for="reason">Reason For Cancelation</label>
                                        <br>
                                        <input type="text" name="reason" maxlength="200" placeholder="Reason For Cancelation" required>
                                        <input type="text" value="<?php echo $rowordercode['CODE'] ?>" name="code" hidden>
                                        <div>
                                            <input type="checkbox" name="terms" id="#" required>
                                            <a href="../../payment_terms.php" target="_blank">Payment Terms and Conditions</a>
                                        </div>
                                        <input type="submit" value="CANCEL ORDER" name="startCancelation">
                                    </form>
                                    <br>
                            <?php
                                }
                            }
                            ?>

                        </div>
                    </div>

                <?php
                }
                ?>

            </div>
        </div>
    </main>
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