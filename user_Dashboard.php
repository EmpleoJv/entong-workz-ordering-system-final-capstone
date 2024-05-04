<?php
include "php/connection/dbConnection.php";
include "php/connection/dbTemporary.php";

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: index.php');
}
// error_reporting(E_ERROR | E_PARSE);
// echo $tdbUserCityFee;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/user_Dashboard.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <main class="main_Container">
        <nav>
            <h1>Entong Workz</h1>
            <ul>
                <li><a href="user_Dashboard.php">HOME</a></li>
                <li><a href="php/user_Dashboard/user_Budget_Calculator.php">BUDGETER</a></li>
                <li><a href="php/user_Dashboard/user_Add_To_Cart.php">CART</a></li>
                <li><a href="php/user_Dashboard/user_Buy_Orders.php">ORDERS</a></li>
                <li><a href="php/user_Dashboard/user_Profile.php">PROFILE</a></li>
                <li><a href="php/user_Dashboard/user_Customer_Support.php">SUPPORT</a></li>
                <li><a href="php/php_action/user_logout.php">LOGOUT</a></li>
            </ul>
            <img src="img/icons/menu_Navy.png" alt="bar" onclick="openNav()">
        </nav>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <li><a href="user_Dashboard.php">HOME</a></li>
                <li><a href="php/user_Dashboard/user_Budget_Calculator.php">BUDGETER</a></li>
                <li><a href="php/user_Dashboard/user_Add_To_Cart.php">CART</a></li>
                <li><a href="php/user_Dashboard/user_Buy_Orders.php">ORDERS</a></li>
                <li><a href="php/user_Dashboard/user_Profile.php">PROFILE</a></li>
                <li><a href="php/user_Dashboard/user_Customer_Support.php">SUPPORT</a></li>
                <li><a href="php/php_action/user_logout.php">LOGOUT</a></li>
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
                            <a href="php/user_Dashboard/user_Buy_Now.php?idfromDb=<?php echo $rowss['ITEM_ID'] ?>" class="a">
                                <div class="card_con">
                                    <div class="image_con">
                                        <img src="img/itemPhotos/<?php echo $rowss['ITEM_IMAGE']; ?>" alt=" ">
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

        <?php
        if (isset($_GET['failed'])) { ?>
            <p class="failed"><?php echo $_GET['failed']; ?></p>
        <?php } ?>
        <!-- <div class="search_Container">
            <input type="text" id="myInput" name="keyword" placeholder="Search for names.." title="Type in a name">
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
        </div> -->
        <div class="sub_Container">
            <div class="search_Container">
                <input type="text" id="myInput" name="keyword" placeholder="Search for names.." title="Type in a name">
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
            <div class="card_Content" id="card_Content">
                <?php
                $sqlQuery = 'SELECT * FROM items WHERE ITEM_STATUS = "SHOW";';
                $runSql = mysqli_query($conn, $sqlQuery);
                while ($row = mysqli_fetch_array($runSql)) {
                ?>
                    <div class="card" id="cards" data-category="<?php echo $row['ITEM_CATEGORY']; ?>" data-brand="<?php echo $row['ITEM_BRAND']; ?>">
                        <!-- Card content here -->
                        <!--<a href="user_Create_Account_Email.php?idfromDb=<?php echo $row['ITEM_ID'] ?>">-->
                        <a href="php/user_Dashboard/user_Specific_Item.php?idfromDb=<?php echo $row['ITEM_ID'] ?>">

                            <div class="image">
                                <img src="img/itemPhotos/<?php echo $row['ITEM_IMAGE']; ?>" alt="image">
                            </div>
                        </a>
                        <div class="details" id="main_Details">
                            <div>
                                <h6 id="name" id="id_Name" class="name"><?php echo $row['ITEM_NAME']; ?></h6>
                                <h6><span>₱<?php echo number_format($row['ITEM_PRICE'], 2) ?></span></h6>
                                <h6 class="price" hidden><span><?php echo $row['ITEM_PRICE']; ?></span></h6>
                            </div>
                            <h5 class="description"><?php echo $row['ITEM_DESCRIPTION']; ?></h5>
                        </div>
                        <div class="actions">
                            <?php
                            if ($row['ITEM_QUANTITY'] == 0) {
                            ?>
                                <a href="php/user_Dashboard/user_Buy_Now.php?idfromDb=<?php echo $row['ITEM_ID'] ?>"><button style="background-color: gray;" disabled>No Stocks!</button></a>
                            <?php
                            } else if ($row['ITEM_QUANTITY'] != 0) {
                            ?>
                                <a href="php/user_Dashboard/user_Buy_Now.php?idfromDb=<?php echo $row['ITEM_ID'] ?>"><button>Buy Now!</button></a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
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
                            <a href="php/user_Dashboard/user_Buy_Now.php?idfromDb=<?php echo $rowss['ITEM_ID'] ?>" class="a">
                                <div class="card_con">
                                    <div class="image_con">
                                        <img src="img/itemPhotos/<?php echo $rowss['ITEM_IMAGE']; ?>" alt=" ">
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
        $(document).ready(function() {
            // Get the input field and card elements
            var $searchInput = $("#myInput");
            var $cards = $(".card");

            // Add an event listener to the input field
            $searchInput.on("input", function() {
                var searchText = $(this).val().toLowerCase();

                // Filter the card elements based on the search text
                $cards.each(function() {
                    var cardText = $(this).text().toLowerCase();

                    // Show or hide the card based on the search text
                    if (cardText.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
    <!-- low to high -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var sortButton = document.getElementById("sortButton");
            var cardContainer = document.getElementById("card_Content");
            var cards = Array.from(cardContainer.getElementsByClassName("card"));

            sortButton.addEventListener("click", function() {
                cards.sort(function(a, b) {
                    var priceA = parseFloat(a.querySelector(".price span").textContent);
                    var priceB = parseFloat(b.querySelector(".price span").textContent);
                    return priceA - priceB;
                });

                // Clear the card container
                cardContainer.innerHTML = "";

                // Append the sorted cards back to the container
                cards.forEach(function(card) {
                    cardContainer.appendChild(card);
                });
            });
        });
    </script>
    <!-- high to low -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var sortButton = document.getElementById("sortButton2");
            var cardContainer = document.getElementById("card_Content");
            var cards = Array.from(cardContainer.getElementsByClassName("card"));

            sortButton.addEventListener("click", function() {
                cards.sort(function(a, b) {
                    var priceA = parseFloat(a.querySelector(".price span").textContent);
                    var priceB = parseFloat(b.querySelector(".price span").textContent);
                    return priceB - priceA; // Sort in descending order
                });

                // Clear the card container
                cardContainer.innerHTML = "";

                // Append the sorted cards back to the container
                cards.forEach(function(card) {
                    cardContainer.appendChild(card);
                });
            });
        });
    </script>
    <!-- Category  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var categorySelect = document.getElementById("categorySelect");
            var cards = Array.from(document.querySelectorAll(".card"));

            categorySelect.addEventListener("change", function() {
                var selectedCategory = categorySelect.value;

                cards.forEach(function(card) {
                    var cardCategory = card.getAttribute("data-category");

                    if (selectedCategory === "") {
                        card.style.display = "block"; // Show the card for the placeholder option
                    } else if (selectedCategory === cardCategory) {
                        card.style.display = "block"; // Show the card for the selected category
                    } else {
                        card.style.display = "none"; // Hide the card for other categories
                    }
                });
            });

            // Initially, show all cards
            categorySelect.value = "";
            cards.forEach(function(card) {
                card.style.display = "block";
            });
        });
    </script>
    <!-- Brand -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var brandSelect = document.getElementById("brandSelect");
            var cards = Array.from(document.querySelectorAll(".card"));

            brandSelect.addEventListener("change", function() {
                var selectedBrand = brandSelect.value;

                cards.forEach(function(card) {
                    var cardBrand = card.getAttribute("data-brand");

                    if (selectedBrand === "") {
                        card.style.display = "block"; // Show the card for the placeholder option
                    } else if (selectedBrand === cardBrand) {
                        card.style.display = "block"; // Show the card for the selected brand
                    } else {
                        card.style.display = "none"; // Hide the card for other brands
                    }
                });
            });

            // Initially, show all cards
            brandSelect.value = "";
            cards.forEach(function(card) {
                card.style.display = "block";
            });
        });
    </script>
    <!-- refresher -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var brandSelect = document.getElementById("brandSelect");
            var categorySelect = document.getElementById("categorySelect");
            var sortButton = document.getElementById("sortButton");
            var sortButton2 = document.getElementById("sortButton2");
            var cardContainer = document.getElementById("card_Content");
            var cards = Array.from(cardContainer.getElementsByClassName("card"));
            var refreshButton = document.getElementById("refreshButton");

            brandSelect.addEventListener("change", filterCards);
            categorySelect.addEventListener("change", filterCards);

            // Click event handler for the "Refresh" button
            refreshButton.addEventListener("click", function() {
                // Reset both select elements to their default values
                brandSelect.value = "";
                categorySelect.value = "";

                // Show all cards
                cards.forEach(function(card) {
                    card.style.display = "block";
                });

                // Sort the cards back to their initial order
                sortCards();
            });

            sortButton.addEventListener("click", function() {
                cards.sort(function(a, b) {
                    var priceA = parseFloat(a.querySelector(".price span").textContent);
                    var priceB = parseFloat(b.querySelector(".price span").textContent);
                    return priceA - priceB;
                });

                // Clear the card container
                cardContainer.innerHTML = "";

                // Append the sorted cards back to the container
                cards.forEach(function(card) {
                    cardContainer.appendChild(card);
                });
            });

            sortButton2.addEventListener("click", function() {
                cards.sort(function(a, b) {
                    var priceA = parseFloat(a.querySelector(".price span").textContent);
                    var priceB = parseFloat(b.querySelector(".price span").textContent);
                    return priceB - priceA; // Sort in descending order
                });

                // Clear the card container
                cardContainer.innerHTML = "";

                // Append the sorted cards back to the container
                cards.forEach(function(card) {
                    cardContainer.appendChild(card);
                });
            });

            // Function to filter and display cards based on the selected brand and category
            function filterCards() {
                var selectedBrand = brandSelect.value;
                var selectedCategory = categorySelect.value;

                cards.forEach(function(card) {
                    var cardBrand = card.getAttribute("data-brand");
                    var cardCategory = card.getAttribute("data-category");

                    var brandMatch = selectedBrand === "" || selectedBrand === cardBrand;
                    var categoryMatch = selectedCategory === "" || selectedCategory === cardCategory;

                    if (brandMatch && categoryMatch) {
                        card.style.display = "block"; // Show the card
                    } else {
                        card.style.display = "none"; // Hide the card
                    }
                });

                // After filtering, also sort the filtered cards
                sortCards();
            }

            // Function to sort the cards back to their initial order
            function sortCards() {
                // Sort the cards based on their data-order attribute (initial order)
                cards.sort(function(a, b) {
                    var orderA = parseInt(a.getAttribute("data-order"));
                    var orderB = parseInt(b.getAttribute("data-order"));
                    return orderA - orderB;
                });

                // Clear the card container
                cardContainer.innerHTML = "";

                // Append the sorted cards back to the container
                cards.forEach(function(card) {
                    cardContainer.appendChild(card);
                });
            }

            // Initially, show all cards and sort them initially
            brandSelect.value = "";
            categorySelect.value = "";
            cards.forEach(function(card, index) {
                card.style.display = "block";
                card.setAttribute("data-order", index); // Store the initial order
            });
        });
    </script>

</body>



</html>