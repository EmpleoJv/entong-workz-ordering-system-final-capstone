<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
error_reporting(E_ERROR | E_PARSE);

// $id = $_GET['idfromDb'];

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: index.php');
}
// // down, this isset is to check if the quantity is not valid.
// if (isset($_REQUEST['startTotal'])) {
//     $selectedItems = $_POST['items'];
//     $selectedItemsQuantity = $_POST['itemQuantity'];

//     if ($selectedItems == "") {
//         echo "bad";
//         header("Location: user_Add_To_Cart.php?selectItemMessage=You need to select an item.");
//     }
// }


// $subtotalssss = array();
// if (isset($_REQUEST['startTotal'])) {
//     $selectedItemsss = $_POST['items'];
//     $selectedItemsQuantityss = $_POST['itemQuantity'];

//     // Create an array to store subtotals

//     foreach ($selectedItemsss as $indexss => $itemss) {
//         $query = "SELECT ITEM_PRICE FROM usercart WHERE ITEM_ID = '$itemss'";
//         $result = mysqli_query($conn, $query);

//         if (mysqli_num_rows($result) > 0) {
//             $row = mysqli_fetch_assoc($result);

//             $pricess = floatval($row['ITEM_PRICE']);
//             $quanss = $selectedItemsQuantityss[$indexss];

//             $subtotalss = $pricess * $quanss;

//             // Store the subtotal in the array
//             $subtotalssss[$itemss] = $subtotalss;
//         }
//     }

//     // Loop through the subtotals array and print them
//     foreach ($subtotalssss as $item => $subtotal) {
//         $query = "SELECT ITEM_NAME FROM usercart WHERE ITEM_ID = '$item'";

//         $result = mysqli_query($conn, $query);
//         if (mysqli_num_rows($result) > 0) {
//             $row = mysqli_fetch_assoc($result);
//             $item_Name = $row['ITEM_NAME'];
//         }

//         echo "<p>Total for Item $item_Name: ₱" . number_format($subtotal, 2) . "</p>";
//     }
// }


// // if (isset($_REQUEST['startTotal'])) {
// //     $selectedItemsss = $_POST['items'];
// //     $selectedItemsQuantityss = $_POST['itemQuantity'];

// //     foreach ($selectedItemsss as $indexss => $itemss) {
// //         $query = "SELECT ITEM_PRICE FROM usercart WHERE ITEM_ID = '$itemss'";
// //         $result = mysqli_query($conn, $query);

// //         if (mysqli_num_rows($result) > 0) {
// //             $row = mysqli_fetch_assoc($result);

// //             $pricess = floatval($row['ITEM_PRICE']);
// //             $quanss = $selectedItemsQuantityss[$indexss];

// //             $subtotalss = $pricess * $quanss;

// //             // Echo the total for each specific item
// //             echo "<p>Total for Item $item: ₱" . number_format($subtotalss, 2) . "</p>";
// //         }
// //     }
// // }

// $cityFee;

// if (isset($_POST['startTotal'])) {
//     $selectedItems = $_POST['items'];
//     $selectedItemsQuantity = $_POST['itemQuantity'];

//     $totalPrice = 0; // Initialize total price

//     foreach ($selectedItems as $item) {
//         $itemId = (int) $item;
//         $itemPrice = (float) $_POST['item_prices'][$itemId];
//         $itemQuantity = (int) $selectedItemsQuantity[$itemId];
//         echo $itemQuantity . '<br>';
//         $subtotal = $itemPrice * $itemQuantity;
//         $totalPrice += $subtotal;
//     }

//     echo "<h2>Total Price: ₱" . number_format($totalPrice, 2) . "</h2>";
// }
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
    <link rel="stylesheet" href="../../css/user_Buy_Multiple_Buy_Now.css">
</head>

<body>
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
    <h1 class="checkOut">Check Out</h1>

    <form action="user_Buy_Now_Start_Multiple.php" method="POST">

        <div class="grid-container">
            <div class="item1">
                <?php
                $sqlQuerys = "SELECT * FROM userlogin WHERE ID = $tdbAdminId;";
                $runSqls = mysqli_query($conn, $sqlQuerys);
                while ($rows = mysqli_fetch_array($runSqls)) {
                ?>
                    <div>
                        <label for="houseName">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                        <br>
                        <input type="text" name="houseName" id="houseName" value="<?php echo $rows['ADDITIONAL_INFORMATION'] ?>" disabled>
                        <input type="text" name="houseName" id="houseName" value="<?php echo $rows['ADDITIONAL_INFORMATION'] ?>" hidden>
                    </div>
                    <div>
                        <label for="provinceName">Province</label>
                        <br>
                        <input type="text" name="provinceName" id="provinceName" value="<?php echo $rows['PROVINCE'] ?>" disabled>
                        <input type="text" name="provinceName" id="provinceName" value="<?php echo $rows['PROVINCE'] ?>" hidden>

                    </div>
                    <div>
                        <label for="cityName">City/Municipality</label>
                        <br>
                        <input type="text" name="cityName" id="cityName" value="<?php echo $rows['CITY_MUNICIPALITY'] ?>" disabled>
                        <input type="text" name="cityName" id="cityName" value="<?php echo $rows['CITY_MUNICIPALITY'] ?>" hidden>

                    </div>
                    <div>
                        <label for="barangayName">Barangay</label>
                        <br>
                        <input type="text" name="barangayName" id="barangayName" value="<?php echo $rows['BARANGAY'] ?>" disabled>
                        <input type="text" name="barangayName" id="barangayName" value="<?php echo $rows['BARANGAY'] ?>" hidden>

                    </div>
                <?php
                }
                ?>

            </div>

            <div class="item2">
                <div>
                    <?php
                    if (isset($_POST['startTotal'])) {
                        $selectedItems = $_POST['items'];
                        $selectedItemsQuantity = $_POST['itemQuantity'];

                        $totalPrice = 0; // Initialize total price

                        foreach ($selectedItems as $item) {
                            $itemId = (int) $item;
                            $itemPrice = (float) $_POST['item_prices'][$itemId];
                            $itemQuantity = (int) $selectedItemsQuantity[$itemId];
                            $subtotal = $itemPrice * $itemQuantity;
                            // $subtotal = $subtotal + $subtotal;

                            $query = "SELECT * FROM usercart WHERE ITEM_ID = '$itemId'";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $price = floatval($row['ITEM_PRICE']);
                                // $totalPrice = $totalPrice + $price;
                                $sql = "SELECT * FROM items WHERE ITEM_ID = '$itemId';";
                                $results = $conn->query($sql);
                                if ($results->num_rows > 0) {
                                    // Output data of each row
                                    while ($rows = $results->fetch_assoc()) {
                                        $itemFee = $rows['ITEM_SHIPPING_FEE'];
                    ?>
                                        <div class="main_Documents_Container">
                                            <div class="img_Container">
                                                <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                                            </div>
                                            <div class="documents">
                                                <h1>Name : <?php echo $row['ITEM_NAME'] ?></h1>
                                                <input type="text" class="itemIdHidden" name="itemIdHidden[]" id="itemIdHidden" value="<?php echo $row['ITEM_ID'] ?>" hidden>
                                                <input type="text" class="itemNameHidden" name="itemNameHidden[]" id="itemNameHidden" value="<?php echo $row['ITEM_NAME'] ?>" hidden>
                                                <input type="text" class="itemImageHidden" name="itemImageHidden[]" id="itemImageHidden" value="<?php echo $row['ITEM_IMAGE'] ?>" hidden>
                                                <input type="text" class="itemInitialPrice" name="itemInitialPrice[]" id="itemInitialPrice" value="<?php echo $row['ITEM_PRICE'] ?>" hidden>
                                                <input type="number" class="quantities" name="quantity[]" id="quantity" onchange="myFunction(this.value)" value="<?php echo $itemQuantity; ?>" hidden>
                                                <input type="text" class="itemCategory" name="itemCategory[]" id="itemCategory" value="<?php echo $row['ITEM_CATEGORY'] ?>" hidden>
                                                <input type="number" class="itemFee" name="itemFee[]" id="itemFee" value="<?php echo $itemFee ?>" hidden>
                                                <input type="text" class="totalHidden" name="totalHidden[]" id="totalHidden" value="<?php echo $subtotal + $itemFee + $tdbUserCityFee ?>" hidden>
                                                <br>
                                                <h1>Description : <?php echo $row['ITEM_DESCRIPTION'] ?></h1>
                                                <br>
                                                <!-- <h1>Quantity : <?php echo $rows['ITEM_QUANTITY'] ?>x</h1> -->
                                                <h1> Price : ₱<?php echo number_format($rows['ITEM_PRICE'], 2) ?></h1>
                                                <h1> Category : <?php echo $rows['ITEM_CATEGORY'] ?></h1>
                                                <h1> Brand : <?php echo $rows['ITEM_BRAND'] ?></h1>

                                            </div>
                                        </div>
                                        <div class="action">

                                            <h1>Total Price: <span>₱<?php echo number_format($subtotal, 2) ?></span></h1>

                                            <div>
                                                <h1>To Order Quantity</h1>
                                                <input type="number" class="quantities" name="quantity[]" id="quantity" onchange="myFunction(this.value)" value="<?php echo $itemQuantity; ?>" disabled>

                                            </div>
                                        </div>
                                        <hr>

                    <?php
                                        $totalSpecificQuan = 0;
                                    }
                                } else {
                                    echo "ayaw";
                                }
                            } else {
                                echo "ayaw";
                            }
                        }
                    }
                    ?>
                </div>

            </div>

            <div class="item3">
                <div class="container_Buy">
                    <h1 class="label">Order Summary</h1>
                    <?php

                    if (isset($_POST['startTotal'])) {
                        $selectedItems = $_POST['items'];
                        $selectedItemsQuantity = $_POST['itemQuantity'];

                        $totalPrice = 0; // Initialize total price
                        $totalFee = 0;
                        $counter = 0;
                        foreach ($selectedItems as $item) {
                            $itemId = (int) $item;
                            $itemPrice = (float) $_POST['item_prices'][$itemId];
                            $itemQuantity = (int) $selectedItemsQuantity[$itemId];
                            $quanCounter += $itemQuantity;
                            $subtotal = $itemPrice * $itemQuantity;
                            $totalPrice += $subtotal;
                            $counter++;
                            $sql = "SELECT ITEM_SHIPPING_FEE FROM items WHERE ITEM_ID = '$itemId';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    $itemFee = $row['ITEM_SHIPPING_FEE'];
                                    $totalFee += $itemFee; // Add ITEM_SHIPPING_FEE to total price
                                }
                            } else {
                                echo "ayaw";
                            }
                        }
                        if ($counter > 0) {
                            $totalOnly += $totalPrice;
                            $totalFee += $tdbUserCityFee;
                            $totalPrice += $totalFee;
                            // $result = $tdbUserCityFee / $counter;
                            $results = $totalFee;
                        } else {
                            header("Location: user_Add_To_Cart.php?noSelectedToBuy= No Selected To Buy");
                        }

                        // echo $result;
                    ?>
                        <input type="number" class="feeCity" name="feeCity" id="feeCity" value="<?php echo number_format($results) ?>" hidden>
                        <input type="text" name="finaltotals" id="finaltotals" value="<?php echo $totalPrice ?>" hidden>
                        <div>
                            <h1>Sub Total</h1>
                            <h1 class="itemPrices">₱<?php echo number_format($totalOnly, 2); ?></h1>
                            <input type="text" id="itemPrices" value="<?php echo $totalOnly ?>" hidden>
                            <input type="number" class="subsss" name="subsss" id="subsss" value="<?php echo $totalOnly  ?>" hidden>

                        </div>
                        <div>
                            <h1>Shipping Fee</h1>
                            <h1>₱<?php echo number_format($totalFee, 2); ?></h1>
                            <input type="number" class="totalfess" name="totalfess" id="totalfess" value="<?php echo $totalFee ?>" hidden>
                        </div>

                        <div>
                            <h1>Total Quantity</h1>
                            <h1>x<?php echo $quanCounter; ?></h1>
                            <input type="number" class="totalquans" name="totalquans" id="totalquans" value="<?php echo $quanCounter ?>" hidden>
                        </div>
                        <div>
                            <h1>Estimated Delivery</h1>
                            <?php
                            $date = date('Y-m-d');
                            $sevenDaysLater = date('Y-m-d', strtotime($date . ' +7 days'));
                            $formattedDate = date('F d, Y', strtotime($sevenDaysLater));

                            ?>
                            <h1 class="itemPrice"><?php echo $formattedDate; ?></h1>
                        </div>
                        <div class="payment_Option">
                            <h1 for="payOption">Payment Option</h1>
                            <select name="payOption" id="payOption" onchange="paymentOption()">
                                <option value="GCASH">GCASH</option>
                                <option value="HALF DOWNPAYMENT GCASH">HALF DOWNPAYMENT GCASH</option>
                                <option value="COD" id="hideGcash">COD</option>
                            </select>
                            <!-- <h1 id="hoverButton">Hover over me</h1> -->
                        </div>
                        <div>
                            <h1 id="dynamicText2"></h1>
                            <h1 id="dynamicText"></h1>
                        </div>
                        <div>
                            <h1 id="discountLocated"></h1>
                            <h6 id="submit" class="update">Vouchers</h6>
                            <input type="text" id="totalDiscount" value="" hidden>
                            <input type="text" id="codeLocated" value="" name="voucherCode" placeholder="Collect a voucher" hidden>
                        </div>
                        <div>
                            <h1 class="total_Price">Totat Price</h1>
                            <div style="display: flex; justify-content: flex-end;">
                                <h1 class="total" id="showTotalPrice">₱<?php echo number_format($totalPrice, 2) ?></h1>
                            </div>

                            <!-- <input type="text" class="totalHidden" name="totalHidden[]" id="totalHidden" value="<?php echo number_format($totalPrice, 2) ?>" hidden> -->
                        </div>


                        <div style="display:block; text-align:center;">
                            <input type="checkbox" required><a href="#" id="termsLink">Payment Terms and Conditions</a>
                            <!-- <input type="submit" name="submitOrder" class="submitInput" value="PLACE ORDER"> -->
                            <?php
                            $sql = "SELECT * FROM veification WHERE USER_ID = $tdbAdminId;";
                            $result = $conn->query($sql);
                            if ($result) {
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        // Assuming you have the images in the correct directory
                                        //Not yet Verified
                                        if ($row['STATUS'] === "FULLY VERIFIED") {
                            ?>
                                            <input type="submit" name="submitOrder" class="submitInput" value="PLACE ORDER">

                                        <?php
                                        } else {
                                        ?>
                                            <input type="submit" name="submitOrder" class="submitInput" style="background-color: gray;" value="NOT VERIFIED" disabled>
                                    <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <input type="submit" name="submitOrder" class="submitInput" style="background-color: gray;" value="NOT VERIFIED" disabled>

                            <?php
                                }
                            } else {
                                echo "Error executing SQL query: " . $conn->error;
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </form>
    <div class="Show_PopupTerms" style="display: none;">
        <span class="Icon_closeterms" id="icon_Close">
            <img src="../../img/icons/close.png" class="Icon-close" alt="">
        </span>
        <div class="innerDiv">
            <h1>Order Terms and Conditions</h1>
            <h3>Cash on Delivery (COD)</h3>
            <ul>
                <li>Within three (3) days of placing an order, customers are able to cancel it, or until it has been accepted by the staff, by providing a reason.</li>
                <li>Orders cannot be cancelled once it has been delivered or accepted.</li>
            </ul>
            <h3>GCash Payments</h3>
            <ul>
                <li>Orders must be paid within three (3) days upon placing it.</li>
                <li>Staff and admin have the right to cancel orders if the payment is not fully receive.</li>
                <li>GCash payments are non-refundable and non-transferable once it has been processed or canceled by the admin because of the three (3) day limit for order payment.</li>
            </ul>
            <h3>
                Half Down Payment
            </h3>
            <ul>
                <li>Customers must pay a half of payment to proceed with delivery.</li>
                <li>Orders cancellation policies for half payment are the same as those for COD orders, which means cancellations are not permitted once the order has been delivered.</li>
                <li>If the half payment has been fulfilled, the staff/admin will process the order, and there are no refunds or partial refunds for half payment orders.</li>
            </ul>
            <h3>
                Cancellation Rights
            </h3>
            <ul>
                <li>COD cancellations are permitted up until three (3) days after placing the orders.</li>
                <li>Successful orders cannot be cancelled once they have been processed and shipped out by staff.</li>
            </ul>
            <h3>
                Replacement
            </h3>
            <ul>
                <li>Items can only be replaced with proof of damage or incorrect item provided within 24 hours of receipt.</li>
            </ul>
        </div>
    </div>

    <script>
        document.querySelector(".Icon-close").addEventListener("click", function() {
            document.querySelector(".Show_PopupTerms").style.display = "none";
        });
    </script>
    <script>
        document.querySelector("#termsLink").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default behavior of the link
            document.querySelector(".Show_PopupTerms").style.display = "flex";
        });
    </script>

    <div class="show_Update">
        <div class="show_form">
            <img src="../../img/icons/close.png" alt="xmark" class="Icon-close">

            <div class="navForAnotherPage center-heading">
                <h2 class="titleVoucher">VOUCHERS</h2>
            </div>

            <div class="sub_Container">
                <div class="card_Content" id="card_Content">
                    <?php
                    $sqlQuery = 'SELECT * FROM voucher WHERE STATUS = "UNUSED";';
                    $runSql = mysqli_query($conn, $sqlQuery);
                    while ($row = mysqli_fetch_array($runSql)) {
                    ?>
                        <div class="card" id="cards">
                            <!-- Card content here -->
                            <div class="details" id="main_Details">
                                <h1>-<?php echo $row['DISCOUNT']; ?>%</h1>
                                <img src="../../img/icons/ticket.png" alt="ticket">
                            </div>
                            <input type="text" id="discountValue-<?php echo $row['CODE']; ?>" value="<?php echo $row['DISCOUNT']; ?>" hidden>
                            <input type="text" id="codeValue-<?php echo $row['CODE']; ?>" value="<?php echo $row['CODE']; ?>" hidden>

                            <button onclick="collectDiscount('<?php echo $row['CODE']; ?>')">Collect</button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the DOM to be fully loaded

        // Get references to the select and h1 elements
        var selectOption = document.getElementById("payOption");
        var dynamicText = document.getElementById("dynamicText");
        var pricesElement = document.getElementById("totalHidden");

        // Extract the value from the "totalHidden" element and convert it to a number
        var prices = parseFloat(pricesElement.textContent);

        // Add an event listener to the select element
        selectOption.addEventListener("change", function() {
            // Update the text of the h1 element based on the selected option
            var downpayment = prices / 2;
            dynamicText.textContent = "Downpayment Price: ₱" + downpayment.toFixed(2);
        });
    });
</script> -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the DOM to be fully loaded

        // Get references to the select, h1, and input elements
        var selectOption = document.getElementById("payOption");
        var dynamicText = document.getElementById("dynamicText");
        var dynamicText2 = document.getElementById("dynamicText2");
        var inputField = document.getElementById("finaltotals");

        // Add an event listener to the select element
        selectOption.addEventListener("change", function() {
            // Get the value of the input field
            var inputValue = parseFloat(inputField.value);

            if (selectOption.value === "HALF DOWNPAYMENT GCASH") {
                var downpayment = inputValue / 2;
                dynamicText2.textContent = "Downpayment Price ";
                dynamicText.textContent = "₱" + downpayment.toFixed(2);

            } else {
                dynamicText2.textContent = "";
                dynamicText.textContent = "";

            }
        });
    });
</script>


<script>
    var isCollected = false; // Initialize a flag to check if a voucher is collected

    function collectDiscount(code) {
        if (!isCollected) {
            var discountInput = document.getElementById('discountValue-' + code);
            var codeInput = document.getElementById('codeValue-' + code);
            var discountLocated = document.getElementById('discountLocated');
            var codeLocatedInput = document.getElementById('codeLocated');
            var cards = document.getElementsByClassName('card'); // Get all cards
            var discountTotal = document.getElementById('totalDiscount');

            if (discountInput && codeInput && discountLocated && codeLocatedInput) {
                var discountValue = discountInput.value;
                var codeValue = codeInput.value;

                // Set the content of the located <h1> tag
                discountLocated.textContent = discountValue + "% Discount";

                // Set the value of the codeLocatedInput if needed
                codeLocatedInput.value = codeValue;

                // let ItemPrice = document.querySelector(".itemPrices").textContent;
                // let a = parseFloat(ItemPrice);
                let itemPrices = document.getElementById("itemPrices").value;
                let qe = parseFloat(itemPrices);
                discounttotal = discountValue / 100;
                var q = qe;

                var voucherAmount = (q * discounttotal);
                var q = q - voucherAmount;
                var formattedValue = q + <?php echo $results ?>;

                document.getElementById("showTotalPrice").innerHTML = '₱' + formattedValue.toFixed(2);
                // document.getElementById("totalHidden").value = formattedValue.toFixed(2);
                document.getElementById("finaltotals").value = formattedValue.toFixed(2);

                discountTotal.value = discountValue / 100;
                // Disable all other "Collect" buttons
                isCollected = true;
                downpayment();
            }
        }
    }

    function downpayment() {
        var selectOption = document.getElementById("payOption").value;
        var dynamicText = document.getElementById("dynamicText");
        var dynamicText2 = document.getElementById("dynamicText2");
        var totalValue = parseFloat(document.getElementById('finaltotals').value);

        if (selectOption === "HALF DOWNPAYMENT GCASH") {
            var downpayment = totalValue / 2;
            dynamicText2.textContent = "Downpayment Price ";
            dynamicText.textContent = "₱" + downpayment.toFixed(2);

        } else {
            dynamicText2.textContent = "";
            dynamicText.textContent = "";

        }

        disableCollectButtons();

    }

    function disableCollectButtons() {
        var buttons = document.querySelectorAll('.card button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].disabled = true;
        }
        document.querySelector(".show_Update").style.display = "none";
    }
</script>



<script>
    // Function to handle the change in the total value
    function handleTotalChange() {
        // Get the total value from the hidden input
        var totalValue = parseFloat(document.getElementById('finaltotals').value);

        // Get the hideGcash option
        var hideGcashOption = document.getElementById('hideGcash');
        var payOption = document.getElementById('payOption');

        // Check if the total value is over 1000
        if (totalValue >= 1000) {
            // Hide the hideGcash option
            hideGcashOption.style.display = 'none';

            // Set the payment option to GCASH if it's currently COD
            if (payOption.value === 'COD') {
                payOption.value = 'GCASH';
            }
        } else {
            // Show the hideGcash option
            hideGcashOption.style.display = 'block';
        }
    }

    // Add the event listener to the hidden input for the input event
    document.getElementById('totalHidden').addEventListener('input', handleTotalChange);

    // Add the event listener to the payOption element for the change event
    document.getElementById('payOption').addEventListener('change', handleTotalChange);

    // Call the function initially to set the initial state based on the default value
    handleTotalChange();
</script>

<script>
    function openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }
</script>
<script>
    document.querySelector(".update").addEventListener("click", function() {
        document.querySelector(".show_Update").style.display = "flex";
    });
    document.querySelector(".Icon-close").addEventListener("click", function() {
        document.querySelector(".show_Update").style.display = "none";
    });
</script>
<script>
    function myFunction(selectedValue) {
        let ItemPrice = document.querySelector(".itemPrice").textContent;
        let a = parseInt(ItemPrice);
        let ItemQuantity = document.getElementById("quantity").value;
        let b = parseInt(ItemQuantity);

        var z = a * b;

        document.getElementById("showTotalPrice").innerHTML = z;
        // document.getElementById("totalHidden").value = z;
    }
</script>

</html>