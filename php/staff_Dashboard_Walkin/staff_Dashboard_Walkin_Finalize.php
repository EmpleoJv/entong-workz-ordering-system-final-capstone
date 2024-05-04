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
    <link rel="stylesheet" href="../../css/admin_Dashboard_Walkin_Finalize.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">
    </script> -->


</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Staff</h1>
        <div class="profile">
            <a href="#">
                <img src="../../img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";

                ?>
            </a>
        </div>
        <a href="../../staff_Dashboard_Walkin.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconUser" src="../../img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="../../staff_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="../../img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="../../staff_Dashboard_Inventory.php" class="list">
            <div>
                <img id="iconInven" src="../../img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="../../staff_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/cash.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>

    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="../../img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>Dashboard</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <form action="staff_Dashboard_Walkin_Finalize_Start.php" method="POST">
            <div class="navTwo">
                <h1 class="title">Walk In Finalize</h1>
                <div class="buttomSide">
                    <p>Total Quantity:<span id="totalQuantity" style="color: red;">0</span></p>
                    <p>Total Price:<span id="totalPrice" style="color: red;">Total Price: ₱0.00</span></p>
                </div>
                <div class="input_Container">
                    <!-- <input type="email" name="email" placeholder="juandelacruz@gmail.com" class="emailInput" required> -->
                    <input type="submit" value="SUBMIT" name="startWalkInOrder" class="submitNow">
                </div>
            </div>
            <div class="main_Content">

                <?php
                if (isset($_POST['start'])) {
                    $serializedArray = $_POST["idStorageInput"];
                    $idArray = json_decode($serializedArray); // Decode the JSON array
                    $arrayCount = count($idArray);
                    for ($i = 0; $i < $arrayCount; $i++) {
                        $orderIH_i = $idArray[$i];
                        $sql = "SELECT * FROM items WHERE ITEM_ID = '$orderIH_i'";
                        $result = $conn->query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                ?>
                            <div class="grid-container">
                                <div class="item1">
                                    <div class="image_Container">
                                        <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                                    </div>
                                    <div class="item_Name">
                                        <h1 class="name">NAME: <br></b><?php echo $row['ITEM_NAME'] ?></h1>
                                        <hr>
                                        <h3>Only <span style="color: red;">x<?php echo $row['ITEM_QUANTITY'] ?></span> Left</h3>
                                        <hr>
                                        <h3 id="item_Price_Add" class="item_Price_Add">Price: <span style="color: red;">₱<?php echo number_format($row['ITEM_PRICE'], 2) ?></span></h3>
                                        <hr>
                                        <input type="text" name="itemImage[]" value="<?php echo $row['ITEM_IMAGE']; ?>" hidden>
                                        <input type="number" name="itemId[]" value="<?php echo $row['ITEM_ID']; ?>" hidden>
                                        <input type="text" name="itemName[]" value="<?php echo $row['ITEM_NAME']; ?>" hidden>
                                        <!-- <input type="text" name="orderId[]" value="<?php echo $row['ID']; ?>" hidden> -->

                                        <input type="number" name="itemPrice[]" value="<?php echo $row['ITEM_PRICE']; ?>" class="item-input" data-quantity="<?php echo $row['ITEM_QUANTITY']; ?>" hidden>
                                        <input type="number" name="itemQuantity[]" value="1" min="1" max="<?php echo $row['ITEM_QUANTITY']; ?>" class="item-input" id="quantityAdder" data-price="<?php echo $row['ITEM_PRICE']; ?>" data-quantity="<?php echo $row['ITEM_QUANTITY']; ?>">
                                        <input type="number" name="itemPriceEspecific[]" value="<?php echo $row['ITEM_PRICE']; ?>" hidden>
                                        <input type="number" name="itemTotalprice[]" value="<?php echo $row['ITEM_PRICE']; ?>" hidden>

                                        <hr>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </form>

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add an event listener for the "itemQuantity[]" input field change
            $('.item-input').on('input', function() {
                var quantity = $(this).val();
                var price = $(this).data('price');
                var total = quantity * price;

                // Find the corresponding "itemTotalprice[]" input field
                var $totalPriceField = $(this).closest('.grid-container').find('input[name="itemTotalprice[]"]');

                // Set the value of "itemTotalprice[]" based on the calculation
                $totalPriceField.val(total);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var itemQuantityInput = document.querySelector('.item-inputs');
            var itemQuantity = <?php echo $row['ITEM_QUANTITY']; ?>; // Replace with the actual value from your PHP variable

            itemQuantityInput.addEventListener('input', function() {
                var inputValue = parseInt(itemQuantityInput.value);
                if (inputValue > itemQuantity) {
                    itemQuantityInput.value = itemQuantity;
                }
                itemQuantityInput.max = itemQuantity;
            });
        });
    </script>
    <script>
        // Function to update the total quantity and price
        function updateTotal() {
            var itemInputs = document.querySelectorAll('.item-input');
            var totalQuantity = 0;
            var totalPrice = 0;

            itemInputs.forEach(function(input) {
                var quantity = parseInt(input.value);
                var price = parseFloat(input.getAttribute('data-price'));

                if (!isNaN(quantity) && !isNaN(price)) {
                    totalQuantity += quantity;
                    totalPrice += quantity * price;
                }
            });

            // Update the total quantity and price on the page
            var totalQuantityElement = document.getElementById('totalQuantity');
            var totalPriceElement = document.getElementById('totalPrice');

            if (totalQuantityElement && totalPriceElement) {
                totalQuantityElement.textContent = ' x' + totalQuantity;
                totalPriceElement.textContent = ' ₱' + totalPrice.toFixed(2);
            }
        }

        // Add event listeners to all item input fields
        var itemInputs = document.querySelectorAll('.item-input');
        itemInputs.forEach(function(input) {
            input.addEventListener('input', updateTotal);
        });

        // Initialize total on page load
        updateTotal();
    </script>


    <script>
        function limitInput(inputField, maxLimit) {
            if (inputField.value > maxLimit) {
                inputField.value = maxLimit; // Set the value to the maximum limit
            }
        }
    </script>
</body>
<!-- <script>
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
</script> -->

</html>