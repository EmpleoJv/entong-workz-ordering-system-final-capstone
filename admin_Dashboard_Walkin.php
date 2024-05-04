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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin_Dashboard_Walkin.css">
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="#">
                <img src="img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";

                ?>
            </a>
        </div>
        <a href="admin_Dashboard.php" class="list">
            <div>
                <img id="iconDss" src="img/icons/house.png" alt="dss">
                <span id="textDss">Dashboard</span>
            </div>
        </a>
        <a href="admin_Dashboard_Walkin.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconUser" src="img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="admin_Dashboard_User.php" class="list">
            <div>
                <img id="iconUser" src="img/icons/users.png" alt="Add Item">
                <span id="textUsers">Users</span>
            </div>
        </a>
        <a href="admin_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="admin_Dashboard_Inventory.php" class="list">
            <div>
                <img id="iconInven" src="img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="admin_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/cart.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
        <a href="php/admin_Dasboard_ChatBox/admin_Dashboard_ChatBox.php" class="list">
            <div>
                <img id="iconTrash" src="img/icons/support.png" alt="dss">
                <span id="textTrash">Chat Support</span>
            </div>
        </a>
        <a href="admin_Dashboard_Sales.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/cash.png" alt="orders">
                <span id="textBank">Sales</span>
            </div>
        </a>
        <a href="admin_Dashboard_Others.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/others.png" alt="orders">
                <span id="textBank">Others</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>Walk-In Order</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <!-- <h1 class="title">Walk-In Order</h1>
        <input type="text" id="searchBar" placeholder="Search items"> -->

        <div class="grid-container">
            <div class="item1">
                <div class="action2">
                    <input type="text" id="searchBar" placeholder="Search items">
                    <button id="sortButton">Sort (Low to High)</button>
                    <button id="sortButton2">Sort (High to Low)</button>
                    <select id="categorySelect">
                        <option disabled selected value="">- Categorie Option -</option>
                        <?php
                        $sqlCategories = "SELECT * FROM itemcategory;";
                        $runCategories = mysqli_query($conn, $sqlCategories);
                        if ($runCategories) {
                            while ($itemRow = mysqli_fetch_array($runCategories)) {
                                $fromDatabaseRow = $itemRow["CATEGORY"];
                                echo "<option>$fromDatabaseRow</option>";
                            }
                        }
                        ?>
                    </select>
                    <select id="brandSelect">
                        <option disabled selected value="">- Brand Option -</option>
                        <?php
                        $sqlCategories = "SELECT * FROM itembrand;";
                        $runCategories = mysqli_query($conn, $sqlCategories);
                        if ($runCategories) {
                            while ($itemRow = mysqli_fetch_array($runCategories)) {
                                $fromDatabaseRow = $itemRow["BRANDS"];
                                echo "<option>$fromDatabaseRow</option>";
                            }
                        }
                        ?>
                    </select>
                    <button id="refreshButton">Refresh</button>
                </div>
                <?php
                if (isset($_GET['finalMessage'])) { ?>
                    <p class="finalMessage"><?php echo $_GET['finalMessage']; ?></p>
                <?php } ?>
                <div class="card_Content" id="card_Content">
                    <?php
                    $sqlQuery = 'SELECT * FROM items WHERE ITEM_STATUS = "SHOW"';
                    $runSql = mysqli_query($conn, $sqlQuery);

                    while ($row = mysqli_fetch_array($runSql)) {
                    ?>
                        <div class="card" id="cards" data-category="<?php echo $row['ITEM_CATEGORY']; ?>" data-brand="<?php echo $row['ITEM_BRAND']; ?>">
                            <div class="image">
                                <img src="img/itemPhotos/<?php echo $row['ITEM_IMAGE']; ?>" alt="image">
                            </div>

                            <div class="details" id="main_Details">
                                <div>
                                    <h6 id="name" id="id_Name" class="name"><?php echo $row['ITEM_NAME']; ?></h6>
                                </div>
                                <div class="actions">
                                    <h6 id="price">₱<span><?php echo number_format($row['ITEM_PRICE'], 2); ?></span></h6>
                                    <input type="number" name="itemName" id="itemId_<?php echo $row['ITEM_ID']; ?>" value="<?php echo $row['ITEM_ID']; ?>" hidden>
                                    <input type="number" name="itemPrice" id="itemPrice_<?php echo $row['ITEM_PRICE']; ?>" value="<?php echo $row['ITEM_PRICE']; ?>" hidden>
                                    <input type="text" name="itemImage" id="itemImage_<?php echo $row['ITEM_IMAGE']; ?>" value="<?php echo $row['ITEM_IMAGE']; ?>" hidden>
                                    <input type="text" name="itemName" id="itemName_<?php echo $row['ITEM_NAME']; ?>" value="<?php echo $row['ITEM_NAME']; ?>" hidden>

                                    <?php
                                    if ($row['ITEM_QUANTITY'] <= 0) {
                                    ?>
                                        <button class="addButton" style="background-color: gray;" onclick="addItem(<?php echo $row['ITEM_ID']; ?>, <?php echo $row['ITEM_PRICE']; ?>, '<?php echo $row['ITEM_IMAGE']; ?>', '<?php echo $row['ITEM_NAME']; ?>')" disabled>ADD</button>
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

                <script>
                    function addItem(itemId, itemPrice, itemImage, itemName) {
                        // Your existing addItem logic here

                        // Disable the button after it's been clicked
                        document.getElementById('itemId_' + itemId).disabled = true;
                    }
                </script>

            </div>
            <div class="item2">
                <div>
                    <form action="php/admin_Dashboard_Walkin/admin_Dashboard_Walkin_Finalize.php" method="POST">
                        <div class="container">
                            <h1>Summary</h1>
                            <input type="hidden" id="idStorageInput" name="idStorageInput">
                            <input type="number" name="budget_Taker" id="budget_Taker" hidden>
                        </div>
                        <h1 id="totalPrice"></h1>
                        <h1 id="deductionPrice"></h1>
                        <div>
                            <h1 id="prices"></h1>
                            <h1 id="images"></h1>
                        </div>
                        <div id="itemImagesContainer"></div>
                        <h1 id="specificIdArray"></h1>

                        <input type="submit" class="addToCart" name="start" value="FINALIZE ORDER" id="finalizeOrderButton" onclick="return validateOrder()">
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.querySelector(".update").addEventListener("click", function() {
            document.querySelector(".show_Update").style.display = "flex";
        });

        document.querySelector(".Icon-close").addEventListener("click", function() {
            document.querySelector(".show_Update").style.display = "none";
        });
    </script>

    <!-- Search -->
    <script>
        const searchBar = document.getElementById('searchBar');
        const cards = document.querySelectorAll('.card');

        searchBar.addEventListener('input', function() {
            const query = searchBar.value.trim().toLowerCase();

            cards.forEach(card => {
                const itemName = card.querySelector('.name').innerText.toLowerCase();
                if (itemName.includes(query)) {
                    card.style.display = 'block'; // Show matching items
                } else {
                    card.style.display = 'none'; // Hide non-matching items
                }
            });
        });
    </script>
    <!-- Low To High -->
    <script>
        // Function to sort items based on price in ascending order
        function sortItemsLowToHigh() {
            var cardsContainer = document.getElementById("card_Content");
            var cards = cardsContainer.querySelectorAll(".card");

            var sortedCards = Array.from(cards).sort(function(a, b) {
                var priceA = parseFloat(a.querySelector("#price span").textContent);
                var priceB = parseFloat(b.querySelector("#price span").textContent);
                return priceA - priceB;
            });

            // Clear the container
            cardsContainer.innerHTML = "";

            // Append the sorted cards back to the container
            sortedCards.forEach(function(card) {
                cardsContainer.appendChild(card);
            });
        }

        // Add a click event listener to the "Sort (Low to High)" button
        var sortButton = document.getElementById("sortButton");
        sortButton.addEventListener("click", sortItemsLowToHigh);
    </script>
    <!-- High To Low -->
    <script>
        // Function to sort items based on price in descending order (high to low)
        function sortItemsHighToLow() {
            var cardsContainer = document.getElementById("card_Content");
            var cards = cardsContainer.querySelectorAll(".card");

            var sortedCards = Array.from(cards).sort(function(a, b) {
                var priceA = parseFloat(a.querySelector("#price span").textContent);
                var priceB = parseFloat(b.querySelector("#price span").textContent);
                return priceB - priceA;
            });

            // Clear the container
            cardsContainer.innerHTML = "";

            // Append the sorted cards back to the container
            sortedCards.forEach(function(card) {
                cardsContainer.appendChild(card);
            });
        }

        // Add a click event listener to the "Sort (High to Low)" button
        var sortButton2 = document.getElementById("sortButton2");
        sortButton2.addEventListener("click", sortItemsHighToLow);
    </script>
    <!-- Sort Category and Brand -->
    <script>
        // Function to filter and display items based on the selected category and brand
        function filterItems() {
            var categorySelect = document.getElementById("categorySelect");
            var brandSelect = document.getElementById("brandSelect");
            var selectedCategory = categorySelect.value;
            var selectedBrand = brandSelect.value;
            var cardsContainer = document.getElementById("card_Content");
            var cards = cardsContainer.querySelectorAll(".card");

            cards.forEach(function(card) {
                var cardCategory = card.getAttribute("data-category");
                var cardBrand = card.getAttribute("data-brand");

                var showCategory = selectedCategory === "" || cardCategory === selectedCategory;
                var showBrand = selectedBrand === "" || cardBrand === selectedBrand;

                if (showCategory && showBrand) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        // Add change event listeners to the category and brand select elements
        var categorySelect = document.getElementById("categorySelect");
        var brandSelect = document.getElementById("brandSelect");

        categorySelect.addEventListener("change", filterItems);
        brandSelect.addEventListener("change", filterItems);

        // Initialize the filter when the page loads
        filterItems();
    </script>
    <!-- refresh -->
    <script>
        // Function to reset the filters and display all items
        function refreshItems() {
            var categorySelect = document.getElementById("categorySelect");
            var brandSelect = document.getElementById("brandSelect");

            // Reset the select elements to their default values
            categorySelect.value = "";
            brandSelect.value = "";

            // Trigger the filter to display all items
            filterItems();
        }

        // Add a click event listener to the Refresh button
        var refreshButton = document.getElementById("refreshButton");
        refreshButton.addEventListener("click", refreshItems);
    </script>

    <script>
        var clickedItems = [];
        var idStorage = []; // Your array to store IDs

        function removeItem(index) {
            // Remove the item from the clickedItems array
            clickedItems.splice(index, 1);

            // Remove the corresponding item ID from the idStorage array
            var removedItemId = idStorage.splice(index, 1)[0]; // Get the removed item's ID

            // Enable the button for the removed item
            document.getElementById('itemId_' + removedItemId).disabled = false;

            // Call the functions to update the UI
            updatePrices();
            updateImages();
            updateIdStorageInput();
        }

        function addItem(itemId, itemPrice, itemImage, itemName) {
            var itemValue = document.getElementById("itemId_" + itemId).value;
            var priceValue = parseFloat(document.getElementById("itemPrice_" + itemPrice).value);
            var imageValue = document.getElementById("itemImage_" + itemImage).value;
            var nameValue = document.getElementById("itemName_" + itemName).value;

            // Check if the item ID is not already in the idStorage array
            if (!idStorage.includes(itemId)) {
                clickedItems.push({
                    id: itemId,
                    value: itemValue,
                    price: priceValue,
                    image: imageValue,
                    name: nameValue
                });

                idStorage.push(itemId);

                // Disable the button after it's been clicked
                document.getElementById('itemId_' + itemId).disabled = true;

                updatePrices();
                updateImages();
                updateIdStorageInput(); // Call the function to update the input
            } else {
                alert("Item already added!");
            }
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
            totalPriceElement.style.color = "red";
            totalPriceElement.innerHTML = "Total Price: ₱" + totalPrice.toFixed(2);
            // printDeductedValue.innerHTML = "Budget Left: " + storageBudgeter.toFixed(2) + "₱";

        }

        function updateImages() {
            var itemImagesContainer = document.getElementById("itemImagesContainer");
            itemImagesContainer.innerHTML = "";

            for (var i = 0; i < clickedItems.length; i++) {
                var item = clickedItems[i];
                var imgElement = document.createElement("img");
                imgElement.src = "img/itemPhotos/" + item.image;
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

        function validateOrder() {
            // Check if the clickedItems array is empty
            if (clickedItems.length === 0) {
                alert("Please add items to the cart before finalizing the order.");
                return false; // Prevent form submission
            }

            // Additional validation or processing logic can be added here if needed

            return true; // Allow form submission
        }
    </script>
</body>

</html>