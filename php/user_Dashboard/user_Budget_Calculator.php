<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: index.php');
}
// error_reporting(E_ERROR | E_PARSE);
// if (isset($_POST['start'])) {
//     $serializedArray = $_POST["idStorageInput"];
//     $idArray = json_decode($serializedArray); // Decode the JSON array
//     // Now you can use the $idArray in your PHP code
//     $arrayCount = count($idArray);
//     // echo "The number of elements in the array is: " . $arrayCount;

//     for ($i = 0; $i < $arrayCount; $i++) {
//         $orderIH_i = $idArray[$i];
//         echo $orderIH_i . "<br>";
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/user_Budget_Calculator.css">
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const inputNumber = document.getElementById('budget_Taker');
        //     const outputH1 = document.getElementById('output');

        //     const enteredNumber = prompt('Please enter your budget:');

        //     if (enteredNumber !== null && enteredNumber !== '') {
        //         inputNumber.value = enteredNumber;
        //         outputH1.textContent = `Your Budget: ${enteredNumber}`;
        //     }
        // });
        document.addEventListener('DOMContentLoaded', function() {
            const inputNumber = document.getElementById('budget_Taker');
            const outputH1 = document.getElementById('output');

            let enteredNumber;

            do {
                enteredNumber = window.prompt('Please enter your budget (numbers only):');

                // If the user cancels the prompt or enters an invalid number, show an alert and retry
                if (enteredNumber === null || isNaN(parseInt(enteredNumber))) {
                    alert('Please enter a valid number.');
                }
            } while (enteredNumber === null || isNaN(parseInt(enteredNumber)));

            enteredNumber = parseInt(enteredNumber); // Convert to a number
            inputNumber.value = enteredNumber;
            outputH1.textContent = `Your Budget: ₱${enteredNumber.toFixed(2)}`;
        });
    </script>
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
    <div class="Recommendation">
        <div class="second_Con">
            <?php
            $sql = "SELECT ITEM_CATEGORY FROM usercart WHERE USER_ID = $tdbAdminId ORDER BY ID DESC LIMIT 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ITEM_CATEGORY = $row["ITEM_CATEGORY"];
                    $sqlQuerys = "SELECT * FROM items WHERE ITEM_CATEGORY = '$ITEM_CATEGORY' AND ITEM_STATUS ='SHOW' ORDER BY ITEM_ID ASC LIMIT 5;";
                    $runSqls = mysqli_query($conn, $sqlQuerys);
                    $count = 0;
                    while ($rowss = mysqli_fetch_array($runSqls)) {
            ?>
                        <a href="user_Buy_Now.php?idfromDb=<?php echo $rowss['ITEM_ID'] ?>" class="a">
                            <div class="card_con">
                                <div class="image_con">
                                    <img src="../../img/itemPhotos/<?php echo $rowss['ITEM_IMAGE']; ?>" alt=" ">
                                </div>
                                <div class="info_con">
                                    <p class="info"><?php echo $rowss['ITEM_NAME']; ?></p>
                                    <div>
                                        <p><?php echo $rowss['ITEM_CATEGORY']; ?></p>
                                    </div>

                                </div>
                            </div>
                        </a>
            <?php
                    }
                    break;
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>

    <div class="grid-container">
        <div class="item1">
            <h1 class="title">Budget Calculator</h1>


            <div class="card_Content" id="card_Content">
                <?php
                $sqlQuery = 'SELECT * FROM items WHERE ITEM_STATUS = "SHOW";';
                $runSql = mysqli_query($conn, $sqlQuery);

                while ($row = mysqli_fetch_array($runSql)) {
                ?>
                    <div class="card" id="cards">
                        <div class="image">
                            <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE']; ?>" alt="image">
                        </div>

                        <div class="details" id="main_Details">
                            <div>
                                <h6 id="name" id="id_Name" class="name"><?php echo $row['ITEM_NAME']; ?></h6>
                            </div>
                            <div class="actions">
                                <h6>₱<span><?php echo number_format($row['ITEM_PRICE'], 2) ?></span></h6>

                                <!-- <h6 id="price"><span><?php echo $row['ITEM_PRICE']; ?></span></h6> -->
                                <input type="number" name="itemName" id="itemId_<?php echo $row['ITEM_ID']; ?>" value="<?php echo $row['ITEM_ID']; ?>" hidden>
                                <input type="number" name="itemPrice" id="itemPrice_<?php echo $row['ITEM_PRICE']; ?>" value="<?php echo $row['ITEM_PRICE']; ?>" hidden>
                                <input type="text" name="itemImage" id="itemImage_<?php echo $row['ITEM_IMAGE']; ?>" value="<?php echo $row['ITEM_IMAGE']; ?>" hidden>
                                <input type="text" name="itemName" id="itemName_<?php echo $row['ITEM_NAME']; ?>" value="<?php echo $row['ITEM_NAME']; ?>" hidden>
                                <?php
                                if ($row['ITEM_QUANTITY'] <= 0) {
                                ?>
                                    <button class="addButton" style="background-color:gray;" disabled>ADD</button>
                                <?php
                                } else {
                                ?>
                                    <button class="addButton" onclick="addItem(<?php echo $row['ITEM_ID']; ?>, <?php echo $row['ITEM_PRICE']; ?>, '<?php echo $row['ITEM_IMAGE']; ?>', '<?php echo $row['ITEM_NAME']; ?>')">ADD</button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="item2">
            <div>
                <form action="user_Budget_Calculator_Add_Cart.php" method="POST">
                    <div class="container">
                        <h1 id="output">Enter a number:</h1>
                        <input type="hidden" id="idStorageInput" name="idStorageInput">
                    </div>
                    <input type="number" name="budget_Taker" id="budget_Taker" value="0" hidden>

                    <h1 id="totalPrice"></h1>
                    <h1 id="deductionPrice"></h1>

                    <div>
                        <h1 id="prices"></h1>
                        <h1 id="images"></h1>
                    </div>
                    <div id="itemImagesContainer"></div>
                    <h1 id="specificIdArray"></h1>
                    <input type="submit" class="addToCart" name="start" value="ADD TO CART">
                </form>
            </div>
        </div>
    </div>

    <div class="Recommendation">
        <div class="second_Con">
            <?php
            $sql = "SELECT ORDER_CATEGORY FROM orders WHERE ORDER_BY = $tdbAdminId ORDER BY ID DESC LIMIT 1;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ITEM_CATEGORY = $row["ORDER_CATEGORY"];
                    $sqlQuerys = "SELECT * FROM items WHERE ITEM_CATEGORY = '$ITEM_CATEGORY' AND ITEM_STATUS ='SHOW' ORDER BY ITEM_ID ASC LIMIT 5;";
                    $runSqls = mysqli_query($conn, $sqlQuerys);
                    $count = 0;
                    while ($rowss = mysqli_fetch_array($runSqls)) {
            ?>
                        <a href="user_Buy_Now.php?idfromDb=<?php echo $rowss['ITEM_ID'] ?>" class="a">
                            <div class="card_con">
                                <div class="image_con">
                                    <img src="../../img/itemPhotos/<?php echo $rowss['ITEM_IMAGE']; ?>" alt=" ">
                                </div>
                                <div class="info_con">
                                    <p class="info"><?php echo $rowss['ITEM_NAME']; ?></p>
                                    <div>
                                        <p><?php echo $rowss['ITEM_CATEGORY']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
            <?php
                    }
                    break;
                }
            } else {
                echo "0 results";
            }
            ?>
        </div>
    </div>
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
    <script>
        function removeItem(index) {
            // Remove the item from the clickedItems array
            clickedItems.splice(index, 1);

            // Remove the corresponding item ID from the idStorage array
            var removedItemId = idStorage.splice(index, 1)[0]; // Get the removed item's ID

            // Call the functions to update the UI
            updatePrices();
            updateImages();
            updateIdStorageInput();
        }

        // ... your existing code
        var clickedItems = [];
        var idStorage = []; // Your array to store IDs

        function addItem(itemId, itemPrice, itemImage, itemName) {
            var itemValue = document.getElementById("itemId_" + itemId).value;
            var priceValue = parseFloat(document.getElementById("itemPrice_" + itemPrice).value);
            var imageValue = document.getElementById("itemImage_" + itemImage).value;
            var nameValue = document.getElementById("itemName_" + itemName).value;

            // Calculate the remaining budget after adding the item
            var remainingBudget = calculateRemainingBudget(priceValue);

            // Check if the remaining budget is negative
            if (remainingBudget < 0) {
                alert("Adding this item will exceed your budget!");
                return; // Don't add the item if the budget is negative
            }

            clickedItems.push({
                id: itemId,
                value: itemValue,
                price: priceValue,
                image: imageValue,
                name: nameValue
            });

            idStorage.push(itemId);

            updatePrices();
            updateImages();
            updateIdStorageInput(); // Call the function to update the input
        }

        // Function to calculate remaining budget after adding an item
        function calculateRemainingBudget(itemPrice) {
            var budgetTakerInput = document.getElementById("budget_Taker");
            var budgetTaker = parseFloat(budgetTakerInput.value);
            var totalPrice = 0;

            for (var i = 0; i < clickedItems.length; i++) {
                totalPrice += clickedItems[i].price;
            }

            return budgetTaker - (totalPrice + itemPrice);
        }

        function updatePrices() {
            var pricesElement = document.getElementById("prices");
            var totalPriceElement = document.getElementById("totalPrice");
            var printDeductedValue = document.getElementById("deductionPrice");
            var budgetTakerInput = document.getElementById("budget_Taker");
            var totalPrice = 0;
            pricesElement.innerHTML = "";

            for (var i = 0; i < clickedItems.length; i++) {
                var item = clickedItems[i];
                var itemDetails = i + 1 + ") Price: ₱" + item.price.toFixed(2) + "<br> Name: " + item.name +
                    "<br><button style='background-color: #16324e; color: whitesmoke; padding: 0vw 2vw; border-radius: 1vw;' onclick='removeItem(" + i + ")'>Remove</button><br><br>";
                pricesElement.innerHTML += itemDetails;

                totalPrice += item.price;
            }
            var finalTotalPrice = totalPrice;
            var budgetTaker = parseFloat(budgetTakerInput.value); // Parse budgetTaker from the input value
            var storageBudgeter = budgetTaker - finalTotalPrice;
            totalPriceElement.innerHTML = "Total Price: ₱" + totalPrice.toFixed(2);
            printDeductedValue.innerHTML = "Budget Left: ₱" + storageBudgeter.toFixed(2);

        }

        function updateImages() {
            var itemImagesContainer = document.getElementById("itemImagesContainer");
            itemImagesContainer.innerHTML = "";

            for (var i = 0; i < clickedItems.length; i++) {
                var item = clickedItems[i];
                var imgElement = document.createElement("img");
                imgElement.src = "../../img/itemPhotos/" + item.image;
                imgElement.alt = "Item Image";
                imgElement.classList.add("clicked-image"); // You can add CSS classes for styling if needed
                itemImagesContainer.appendChild(imgElement);
            }
        }

        function updateIdStorageInput() {
            var idStorageInput = document.getElementById("idStorageInput");
            var serializedArray = JSON.stringify(idStorage); // Serialize the array
            idStorageInput.value = serializedArray;
        }
    </script>
</body>

</html>