<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

$id = $_GET['idfromDb'];

// if (!isset($_SESSION['tdbAdminEmail'])) {
//     header('location: index.php');
// }

$cityFee;

$sql = "SELECT ITEM_SHIPPING_FEE FROM items WHERE ITEM_ID  ='$id';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $cityFee = $row['ITEM_SHIPPING_FEE'];
    }
} else {
    header("Location: ../../index.php?error= Address Not Seen");
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
    <link rel="stylesheet" href="../../css/user_Buy_Now.css">
    <script src="../../decimal.js"></script>
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

    <form action="user_Buy_Now_Start.php" method="post">

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
                <?php
                if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <?php
                $sqlQuery = "SELECT * FROM items WHERE ITEM_STATUS = 'SHOW' AND ITEM_ID = $id;";
                $runSql = mysqli_query($conn, $sqlQuery);
                while ($row = mysqli_fetch_array($runSql)) {
                ?>
                    <div class="imgCon">
                        <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                    </div>
                    <div class="documents">
                        <h1><?php echo $row['ITEM_NAME'] ?></h1>
                        <input type="text" class="itemNameHidden" name="itemNameHidden" id="itemNameHidden" value="<?php echo $row['ITEM_NAME'] ?>" hidden>
                        <input type="text" class="itemIdHidden" name="itemIdHidden" id="itemIdHidden" value="<?php echo $row['ITEM_ID'] ?>" hidden>
                        <input type="text" class="itemImageHidden" name="itemImageHidden" id="itemImageHidden" value="<?php echo $row['ITEM_IMAGE'] ?>" hidden>
                        <input type="text" class="itemInitialPrice" name="itemInitialPrice" id="itemInitialPrice" value="<?php echo $row['ITEM_PRICE'] ?>" hidden>
                        <input type="text" class="itemCategory" name="itemCategory" id="itemCategory" value="<?php echo $row['ITEM_CATEGORY'] ?>" hidden>
                        <br>
                        <h1><?php echo $row['ITEM_DESCRIPTION'] ?></h1>
                        <br>
                        <h1>Price : <span style="color: red;">₱<?php echo number_format($row['ITEM_PRICE'], 2) ?></span></h1>
                        <div class="action">
                            <h1>Brand : <?php echo $row['ITEM_BRAND']; ?></h1>
                        </div>
                        <div class="action">
                            <h1>Category : <?php echo $row['ITEM_CATEGORY']; ?></h1>
                        </div>
                        <div class="action">
                            <h1>Stocks : x<?php echo $row['ITEM_QUANTITY']; ?></h1>
                            <br>
                            <div>
                                <h1>Quantity</h1>
                                <input type="number" class="quantities" name="quantity" id="quantity" onchange="myFunction(this.value)" oninput="myFunctions(this.value)" value="1" min="1" max="<?php echo $row['ITEM_QUANTITY']; ?>" onKeyPress="if(this.value.length==2) return false;" oninput="limitInput(this, <?php echo $row['ITEM_QUANTITY']; ?>);" required>
                                <!-- <input type="number" class="quantities" name="quantity" id="quantity" onchange="myFunction(this.value)" oninput="myFunctions(this.value)" value="1" min="1" oninput="limitInput(this, <?php echo $row['ITEM_QUANTITY']; ?>);" onKeyPress="if(this.value.length==2) return false;"> -->
                                <!-- <input type="number" class="quantities" name="quantity" id="quantity" onchange="myFunction(this.value)" value="1" min="1" max="<?php echo $row['ITEM_QUANTITY']; ?>" onKeyPress="if(this.value.length==2) return false;"> -->
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <div class="item3">
                <div class="container_Buy">
                    <?php
                    $sqlQuery = "SELECT * FROM items WHERE ITEM_STATUS = 'SHOW' AND ITEM_ID = $id;";
                    $runSql = mysqli_query($conn, $sqlQuery);
                    while ($row = mysqli_fetch_array($runSql)) {
                    ?>
                        <h1 class="label">Order Summary</h1>
                        <div>
                            <h1>Sub Total</h1>
                            <input type="text" class="subsstotal" name="subsstotal" id="subsstotal" value="<?php echo number_format($row['ITEM_PRICE'], 2) ?>" hidden>
                            <div style="margin-top: 0.1vw;">
                                <h1>₱</h1>
                                <h1 class="subtotalShow" id="subtotalShow"><?php echo number_format($row['ITEM_PRICE'], 2) ?></h1>
                            </div>
                        </div>
                        <div>
                            <h1>Shipping Fee</h1>
                            <div style="margin-top: 0.1vw;">
                                <h1>
                                    <?php
                                    $totalShipping = $cityFee + $tdbUserCityFee;
                                    echo "₱" . number_format($totalShipping, 2);
                                    ?>
                                    <input type="text" class="itemFee" name="itemFee" id="itemFee" value="<?php echo $totalShipping ?>" hidden>
                                </h1>
                            </div>
                        </div>

                        <h1 class="itemPrice" hidden><?php echo $row['ITEM_PRICE'] ?></h1>
                        <div>
                            <h1>Estimated Delivery Date</h1>
                            <div style="margin-top: 0.1vw;">
                                <?php
                                $date = date('Y-m-d');
                                $sevenDaysLater = date('Y-m-d', strtotime($date . ' +7 days'));
                                $formattedDate = date('F d, Y', strtotime($sevenDaysLater));

                                ?>
                                <h1><?php echo $formattedDate; ?></h1>
                            </div>
                        </div>
                        <div>
                            <h1 id="discountLocated"></h1>
                            <div style="margin-top: 0.1vw;">
                                <h6 id="submit" class="update">Vouchers</h6>

                            </div>
                            <input type="text" id="totalDiscount" value="" hidden>
                            <input type="text" id="codeLocated" value="" name="voucherCode" placeholder="Collect a voucher" hidden>
                        </div>

                        <!-- <div>
                            <form id="voucherForm" action="" method="post">
                                <label for="voucherCode">Enter Voucher Code:</label>
                                <input type="text" id="voucherCode" name="voucherCode" required>
                                <button type="button" id="checkButton">Check Voucher</button>
                            </form>
                            <div id="voucherResult">

                            </div>
                        </div> -->
                        <!-- <div>
                            <h1 id="discountNumber"></h1>
                        </div> -->
                        <div class="payment_Option">
                            <h1 for="payOption">Payment Option</h1>
                            <select name="payOption" id="payOption" onchange="paymentOption()">
                                <option value="GCASH">GCASH</option>
                                <option value="HALF DOWNPAYMENT GCASH">HALF DOWNPAYMENT GCASH</option>
                                <option value="COD" id="hideGcash">COD</option>
                            </select>
                        </div>
                        <div>
                            <h1 id="dynamicText2"></h1>
                            <h1 id="dynamicText"></h1>
                        </div>
                        <!-- <div id="gcashDiv" class="gcashDiv" style="display: none">
                            <label for="refNumIfGcash">Enter Reference Number</label>
                            <input type="text" name="refNumIfGcash" id="refNumIfGcash">
                        </div> -->
                        <!-- <div id="gcashDivs" class="gcashDiv" style="display: none">
                            <h1 class="hoverButton" style="vertical-align: middle;">Hover The QR CODE</h1>
                            <img src="../../img/icons/icons8-qrcode-64.png" alt="hover" id="hoverButton">
                        </div> -->

                        <div>
                            <h1 class="total_Price">Total Price</h1>
                            <div>
                                <h1 class="total">₱</h1>
                                <h1 class="total" id="showTotalPrice"><?php echo number_format($row['ITEM_PRICE'] + $totalShipping, 2) ?></h1>
                            </div>

                            <input type="text" class="totalHidden" name="totalHidden" id="totalHidden" value="<?php echo number_format($row['ITEM_PRICE'] + $totalShipping, 2, '.', ''); ?>" step="0.01" hidden>

                            <!-- <input type="number" class="totalHidden" name="totalHidden" id="totalHidden" value="<?php echo $row['ITEM_PRICE'] + $totalShipping ?>"> -->
                        </div>

                        <div style="display:block; text-align:center;">
                            <input type="checkbox" required><a href="#" id="termsLink">Payment Terms and Conditions</a>

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
                                            $sqlsss = "SELECT ITEM_QUANTITY FROM items WHERE ITEM_ID = $id;";
                                            $resultsss = $conn->query($sqlsss);
                                            if ($resultsss === false) {
                                                echo "Not yet accepted";
                                            }
                                            $rowsss = $resultsss->fetch_assoc();

                                            if ($rowsss) {
                                                if ($rowsss['ITEM_QUANTITY'] == 0) {
                            ?>
                                                    <input type="submit" name="submitOrder" class="submitInput" style="background-color: gray;" value="NO STOCKS" disabled>
                                                <?php
                                                } else {
                                                ?>

                                                    <input type="submit" name="submitOrder" class="submitInput" value="PLACE ORDER">

                                            <?php
                                                }
                                            } else {
                                                echo "No data found for ID $idForStatus";
                                            }
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
        document.querySelector(".Icon_closeterms").addEventListener("click", function() {
            document.querySelector(".Show_PopupTerms").style.display = "none";
        });
    </script>
    <script>
        document.querySelector("#termsLink").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent the default behavior of the link
            document.querySelector(".Show_PopupTerms").style.display = "flex";
        });
    </script>

    <div class="show_Updates">
        <div class="show_forms">
            <!-- <img id="overflowImage" src="../../img/backgroundImages/code.jpg" style="display: none" alt="Overflow Image"> -->
            <img id="hoverImage" src="../../img/backgroundImages/code.jpg" alt="Hover Image">
        </div>
    </div>

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

    <div class="button">
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Wait for the DOM to be fully loaded

            // Get references to the select, h1, and input elements
            var selectOption = document.getElementById("payOption");
            var dynamicText = document.getElementById("dynamicText");
            var dynamicText2 = document.getElementById("dynamicText2");
            var inputField = document.getElementById("totalHidden");

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
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
    <script>
        // Function to handle the change in the total value
        function handleTotalChange() {
            // Get the total value from the hidden input
            var totalValue = parseFloat(document.getElementById('totalHidden').value);

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



</body>

</html>
<script>
    const hoverButton = document.getElementById("hoverButton");
    const showUpdates = document.querySelector(".show_Updates");

    hoverButton.addEventListener("mouseenter", function() {
        showUpdates.style.display = "block";
    });

    hoverButton.addEventListener("mouseleave", function() {
        showUpdates.style.display = "none";
    });
</script>
<!-- <script>
    function paymentOption() {
        var selectElement = document.getElementById("payOption");
        var gcashDiv = document.getElementById("gcashDiv");
        var gcashDivs = document.getElementById("gcashDivs");

        // var overflowImage = document.getElementById("overflowImage");

        if (selectElement.value === "GCASH") {
            gcashDiv.style.display = "block"; // Show the div
            gcashDivs.style.display = "block"; // Show the div

            // overflowImage.style.display = "block"; // Show the overflow image
        } else {
            gcashDiv.style.display = "none"; // Hide the div
            gcashDivs.style.display = "none"; // Hide the div

            // overflowImage.style.display = "none"; // Hide the overflow image
        }
    }
</script> -->
<script>
    function limitInput(inputField, maxLimit) {
        if (inputField.value > maxLimit) {
            inputField.value = maxLimit; // Set the value to the maximum limit
        }
    }
</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkButton = document.getElementById("checkButton");
        const voucherCodeInput = document.getElementById("voucherCode");
        const voucherResult = document.getElementById("voucherResult");

        checkButton.addEventListener("click", function() {
            const voucherCode = voucherCodeInput.value;

            // Make an AJAX request to a PHP script
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "check_voucher.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from the PHP script
                    voucherResult.innerHTML = xhr.responseText;
                }
            };
            xhr.send("voucherCode=" + voucherCode);
        });
    });
</script> -->
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
                var discountValue = parseFloat(discountInput.value);
                var codeValue = codeInput.value;

                // Set the content of the located <h1> tag
                discountLocated.textContent = discountValue + "% Discount";

                // Set the value of the codeLocatedInput if needed
                codeLocatedInput.value = codeValue;

                let ItemPrice = parseFloat(document.querySelector(".itemPrice").textContent);
                let ItemQuantity = parseFloat(document.getElementById("quantity").value);

                var totalBeforeDiscount = ItemPrice * ItemQuantity;

                var discountAmount = (discountValue / 100) * totalBeforeDiscount;
                var discountedTotal = totalBeforeDiscount - discountAmount;

                document.getElementById("showTotalPrice").innerHTML = discountedTotal + <?php echo $totalShipping ?>;
                document.getElementById("totalHidden").value = discountedTotal + <?php echo $totalShipping ?>;


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
        var totalValue = parseFloat(document.getElementById('totalHidden').value);

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
    document.querySelector(".update").addEventListener("click", function() {
        document.querySelector(".show_Update").style.display = "flex";
    });

    document.querySelector(".Icon-close").addEventListener("click", function() {
        document.querySelector(".show_Update").style.display = "none";
    });
</script>
<!-- <script>
    function myFunction(selectedValue) {
        let ItemPrice = document.querySelector(".itemPrice").textContent;
        let a = parseInt(ItemPrice);
        let ItemQuantity = document.getElementById("quantity").value;
        let b = parseInt(ItemQuantity);

        var q = a * b;
        var z = (a * b) + <?php echo $totalShipping ?>;

        document.getElementById("showTotalPrice").innerHTML = z;
        document.getElementById("totalHidden").value = q;

    }
</script> -->

<script>
    function myFunctions(selectedValue) {
        let ItemPrice = document.querySelector(".itemPrice").textContent;
        let a = parseFloat(ItemPrice);
        let ItemQuantity = document.getElementById("quantity").value;
        let b = parseFloat(ItemQuantity);
        let ItemVoucher = document.getElementById("totalDiscount").value;
        let c = parseFloat(ItemVoucher);
        let subtotalShow = document.querySelector(".subtotalShow").textContent;
        let subtotalShowb = parseFloat(subtotalShow);


        var totalValue = parseFloat(document.getElementById('totalHidden').value);

        if (isNaN(c)) {
            // myFloat is empty (NaN)
            var q = a * b;
            var sub = a * b;
            var formattedSub = sub.toFixed(2);


            var totalAmount = q + <?php echo $totalShipping ?>;
            var formattedTotalAmount = totalAmount.toFixed(2);

            document.getElementById("showTotalPrice").innerHTML = formattedTotalAmount;
            document.getElementById("totalHidden").value = formattedTotalAmount;
            document.getElementById("subtotalShow").innerHTML = formattedSub;
            document.getElementById("subsstotal").value = formattedSub;
        } else {
            // myFloat is a valid float
            var q = a * b;
            var voucherAmount = (a * b) * c;
            var q = q - voucherAmount;
            var sub = a * b;
            var formattedSub = sub.toFixed(2);


            var totalAmount = q + <?php echo $totalShipping ?>;
            var formattedTotalAmount = totalAmount.toFixed(2);

            document.getElementById("showTotalPrice").innerHTML = formattedTotalAmount;
            document.getElementById("totalHidden").value = formattedTotalAmount;
            document.getElementById("subtotalShow").innerHTML = formattedSub;
            document.getElementById("subsstotal").value = formattedSub;
        }
        downpayment();

        function downpayment() {
            var selectOption = document.getElementById("payOption").value;
            var dynamicText = document.getElementById("dynamicText");
            var dynamicText2 = document.getElementById("dynamicText2");
            var totalValue = parseFloat(document.getElementById('totalHidden').value);

            if (selectOption === "HALF DOWNPAYMENT GCASH") {
                var downpayment = totalValue / 2;
                dynamicText2.textContent = "Downpayment Price ";
                dynamicText.textContent = "₱" + downpayment.toFixed(2);

            } else {
                dynamicText2.textContent = "";
                dynamicText.textContent = "";

            }
        }
    }
</script>