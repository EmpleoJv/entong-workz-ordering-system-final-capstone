<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
error_reporting(E_ERROR | E_PARSE);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/all_Items.css">

    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <script>

    </script>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="../../admin_Dashboard.php">
                <img src="../../img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";
                ?>
            </a>
        </div>
        <a href="../../admin_Dashboard.php" class="list">
            <div>
                <img id="iconDss" src="../../img/icons/house.png" alt="dss">
                <span id="textDss">Dashboard</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Walkin.php" class="list">
            <div>
                <img id="iconUser" src="../../img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_User.php" class="list">
            <div>
                <img id="iconUser" src="../../img/icons/users.png" alt="Add Item">
                <span id="textUsers">Users</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="../../img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Inventory.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconInven" src="../../img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/cart.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
        <a href="../admin_Dasboard_ChatBox/admin_Dashboard_ChatBox.php" class="list">
            <div>
                <img id="iconTrash" src="../../img/icons/support.png" alt="dss">
                <span id="textTrash">Chat Support</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Sales.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/cash.png" alt="orders">
                <span id="textBank">Sales</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="../../img/icons/menu.png" alt="navigation Bar">
            </a>

            <h1>ALL ITEM</h1>
            <a href="../php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <nav>
            <div class="search_Container">
                <form method="POST" action="#" id="searchForm"> <!-- Replace "search.php" with your PHP script's file name -->
                    <input type="submit" value="Refresh" id="btnSearch">
                    <input type="submit" value="Search" id="btnSearch">
                    <input type="text" name="start_Search" id="search" placeholder="Search">
                </form>
            </div>
        </nav>

        <!-- partition -->
        <?php
        if (!isset($_POST['searchForm'])) {
            // Get the user's search query from the form
            $searchQuery = $_POST["start_Search"];
            // Create a SQL query to search for items based on the search query
            $sqlQuery = "SELECT * FROM items WHERE ITEM_NAME LIKE '%$searchQuery%' OR ITEM_CATEGORY LIKE '%$searchQuery%' OR ITEM_BRAND LIKE '%$searchQuery%';";
            // Run the SQL query
            $runSql = mysqli_query($conn, $sqlQuery);

            // Check if any results were found
            if (mysqli_num_rows($runSql) > 0) {
                echo '<div class="card_Content">';
                while ($row = mysqli_fetch_array($runSql)) {
                    // Display the search results as you did before
                    // (your existing code to display items goes here)
        ?>
                    <div class="card">
                        <div class="image">
                            <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE']; ?>" alt="image">
                        </div>
                        <div class="details">
                            <h6 class="name"><?php echo $row['ITEM_NAME']; ?> </h6>
                            <h6 class="price">₱<?php echo $row['ITEM_PRICE']; ?></h6>
                        </div>
                        <a href="all_Items_View.php?id=<?php echo $row['ITEM_ID'] ?>">
                            <button class="btn_View">View</button>
                        </a>
                    </div>

                <?php
                }
                // echo '</div>';
                exit; // Terminate the script to prevent further execution

            } else {
                ?>
                <div class="card_Content">
                    <?php
                    $sqlQuery = 'SELECT * FROM items WHERE ITEM_STATUS = "HIDE";';
                    $runSql = mysqli_query($conn, $sqlQuery);
                    echo "Error Search";
                    while ($row = mysqli_fetch_array($runSql)) {
                    ?>

                        <div class="card">
                            <div class="image">
                                <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE']; ?>" alt="image">
                            </div>
                            <div class="details">
                                <h6 class="name"><?php echo $row['ITEM_NAME']; ?> </h6>
                                <h6 class="price">₱<?php echo $row['ITEM_PRICE']; ?></h6>
                            </div>

                        </div>
                    <?php
                    }
                    ?>
                </div>
        <?php

            }
        }
        ?>
    </main>
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
</body>

</html>