<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
error_reporting(E_ERROR | E_PARSE);



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
    <link rel="stylesheet" href="../../css/user_Add_To_Cart.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">
    </script> -->


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
        </nav>
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
        <h1 class="title">CART</h1>


        <div class="main_Content">

            <?php
            if (isset($_GET['selectItemMessage'])) { ?>
                <p class="error"><?php echo $_GET['selectItemMessage']; ?></p>
            <?php } ?>
            <?php
            if (isset($_GET['noSelectedToBuy'])) { ?>
                <p class="noSelectedToBuy"><?php echo $_GET['noSelectedToBuy']; ?></p>
            <?php } ?>
            <!-- <form method="post" class="main_form_Container"> -->
            <form action="user_Buy_Multiple_Buy_Now.php" method="post" class="main_form_Container">
                <div class="card_Content" id="card_Content">
                    <?php
                    $sql = "SELECT * FROM usercart WHERE USER_ID = '$tdbAdminId'";
                    $result = $conn->query($sql);
                    while ($row = mysqli_fetch_array($result)) {
                        $ITEM_ID = $row['ITEM_ID'];
                        $itemPrice = $row['ITEM_PRICE'];

                        $sqlsss = "SELECT ITEM_QUANTITY FROM items WHERE ITEM_ID = '$ITEM_ID'";
                        $resultsss = mysqli_query($conn, $sqlsss);
                        if ($resultsss) { // Corrected the variable name here
                            while ($rowsss = mysqli_fetch_assoc($resultsss)) {
                                if ($rowsss['ITEM_QUANTITY'] == 0) {
                                } else {
                    ?>
                                    <div class="grid-container">

                                        <div class="grid-item">
                                            <a href="user_Add_To_Cart_Remove.php?itemIdRemove=<?php echo $row['ID'] ?>">
                                                <p id="removeCartBtn">
                                                    REMOVE ITEM
                                                </p>
                                            </a>
                                            <div class="image_Container">
                                                <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                                            </div>
                                        </div>
                                        <div class="grid-items">
                                            <div class="item_Name">
                                                <h1 class="name">NAME: <br></b><?php echo $row['ITEM_NAME'] ?></h1>
                                                <hr>
                                                <h3>Only <?php echo $rowsss['ITEM_QUANTITY'] ?>x Left</h3>
                                                <hr>
                                                <h3>Price: <span style="color: red;">₱<?php echo number_format($row['ITEM_PRICE'], 2) ?></span></h3>
                                                <h3 id="item_Price_Add" class="item_Price_Add" hidden>Price: <?php echo $row['ITEM_PRICE'] ?></h3>

                                                <hr>
                                                <h3>Item Description: <?php echo $row['ITEM_DESCRIPTION'] ?></h3>
                                                <hr>
                                                <label for="itemsID">Check to Add</label>
                                                <input type="checkbox" name='items[]' class='itemsClass' value='<?php echo $ITEM_ID; ?>'>
                                                <input type='hidden' name='item_ids[]' value='<?php echo $ITEM_ID; ?>'>
                                                <input type='hidden' name='item_prices[<?php echo $ITEM_ID; ?>]' value='<?php echo $itemPrice; ?>'>
                                                <br>
                                                <label for="quantity">Add Quantity to buy</label>
                                                <?php
                                                $sqlsss = "SELECT ITEM_QUANTITY FROM items WHERE ITEM_ID = '$ITEM_ID'";
                                                $resultsss = mysqli_query($conn, $sqlsss);
                                                if ($resultsss) { // Corrected the variable name here
                                                    while ($rowsss = mysqli_fetch_assoc($resultsss)) {
                                                        if ($row['ORDER_QUANTITY'] > $rowsss['ITEM_QUANTITY']) {
                                                ?>
                                                            <input class="" id='quantity' type="number" name="itemQuantity[<?php echo $ITEM_ID; ?>]" value="<?php echo $rowsss['ITEM_QUANTITY']; ?>" min="1" max="<?php echo $rowsss['ITEM_QUANTITY']; ?>" oninput="limitInput(this, <?php echo $rowsss['ITEM_QUANTITY']; ?>);" onKeyPress="if(this.value.length==2) return false;" required>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <input class="" id='quantity' type="number" name="itemQuantity[<?php echo $ITEM_ID; ?>]" value="<?php echo $row['ORDER_QUANTITY']; ?>" min="1" max="<?php echo $rowsss['ITEM_QUANTITY']; ?>" oninput="limitInput(this, <?php echo $rowsss['ITEM_QUANTITY']; ?>);" onKeyPress="if(this.value.length==2) return false;" required>
                                                <?php
                                                        }
                                                    }
                                                    // Free the result set
                                                    // mysqli_free_result($resultsss); // Corrected the variable name here
                                                } else {
                                                    // Handle the query error, e.g., display an error message
                                                    echo "Error: " . mysqli_error($conn); // Corrected the variable name here
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </div>

                <div class="total_Cart">
                    <div>
                        <?php
                        // if (isset($_POST['startTotal'])) {
                        //     $selectedItems = $_POST['items'];
                        //     $selectedItemsQuantity = $_POST['itemQuantity'];

                        //     $totalPrice = 0; // Initialize total price

                        //     foreach ($selectedItems as $item) {
                        //         $itemId = (int) $item;
                        //         $itemPrice = (float) $_POST['item_prices'][$itemId];
                        //         $itemQuantity = (int) $selectedItemsQuantity[$itemId];

                        //         $subtotal = $itemPrice * $itemQuantity;
                        //         $totalPrice += $subtotal;
                        //     }

                        //     echo "<h2>Total Price: ₱" . number_format($totalPrice, 2) . "</h2>";
                        // }
                        ?>

                        <input type="submit" value="SUBMIT" name="startTotal" class="btn_Submit">
                    </div>
                </div>
            </form>


        </div>
    </main>
    <script>
        function limitInput(inputField, maxQuantity) {
            if (inputField.value > maxQuantity) {
                inputField.value = maxQuantity;
            }
        }
    </script>
</body>
<script>
    function openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }
</script>
<script>
    function myFunction(selectedValue) {
        let ItemPrice = document.querySelector(".itemPrice").textContent;
        let a = parseInt(ItemPrice);
        let ItemQuantity = document.getElementById("quantity").value;
        let b = parseInt(ItemQuantity);

        var z = a * b;

        document.getElementById("showTotalPrice").innerHTML = z;
        document.getElementById("totalHidden").value = z;
    }

    function settedQuantity() {
        // document.getElementById("quantity");
        document.getElementById("totalHidden").value = 1;

    }

    // $("#quantity").on("input", function() {
    //     if (/^0/.test(this.value)) {
    //         this.value = this.value.replace(/^0/, "")
    //     }
    // })
</script>

</html>