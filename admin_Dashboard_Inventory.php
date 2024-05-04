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
    <link rel="stylesheet" href="css/admin_Dashboard_Inventory.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            <div>
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
            <div style="background-color: #16324E;">
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
            <h1>INVENTORY</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <?php
        if (isset($_GET['msgIfUpdateSuccess'])) { ?>
            <p class="msgIfUpdateSuccess"><?php echo $_GET['msgIfUpdateSuccess']; ?></p>
        <?php } ?>
        <div class="grid-container">
            <a href="#" id="filterRefreshButton">
                <div class="grid-item" id="all">
                    <div>
                        <h3>All Items</h3>
                        <img src="img/icons/tag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForAll = "SELECT COUNT(*) as total_rows FROM items";
                    $resultForAll = $conn->query($sqlForAll);
                    if ($resultForAll->num_rows > 0) {
                        $rowForAll = $resultForAll->fetch_assoc();
                        $totalRows = $rowForAll["total_rows"];
                    ?>
                        <h2><?php echo $totalRows; ?></h2>
                    <?php
                    } else {
                        echo "No results found";
                    }
                    ?>
                </div>
            </a>
            <a href="#" id="filterHideButton">
                <div class="grid-item" id="hidden">
                    <div>
                        <h3>Hidden Items</h3>
                        <img src="img/icons/hiddenTag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForHidden = 'SELECT * FROM items WHERE ITEM_STATUS = "HIDE";';
                    $runForHidden = mysqli_query($conn, $sqlForHidden);
                    $numberForHidden = mysqli_num_rows($runForHidden);
                    ?>
                    <h2><?php echo $numberForHidden; ?></h2>
                </div>
            </a>

            <a href="#" id="filterShowButton">
                <div class="grid-item" id="posted">
                    <div>
                        <h3>On Display Items</h3>
                        <img src="img/icons/tag.png" alt="users image">
                    </div>
                    <?php
                    $sqlForReadyToPost = 'SELECT * FROM items WHERE ITEM_STATUS = "SHOW";';
                    $runForReadyToPost = mysqli_query($conn, $sqlForReadyToPost);
                    $numberForReadyToPost = mysqli_num_rows($runForReadyToPost);
                    ?>
                    <h2><?php echo $numberForReadyToPost; ?></h2>
                </div>
            </a>

            <a href="#" id="filterLowQuantityButton">
                <div class="grid-item" id="lowest">
                    <div>
                        <h3>Low Stock Items</h3>
                        <img src="img/icons/tag.png" alt="users image">
                    </div>
                    <?php
                    $sql = "SELECT COUNT(*) AS count_lowest_quantity FROM items WHERE ITEM_QUANTITY <= 10";
                    $result = $conn->query($sql);

                    if ($result) {
                        // Fetch the result
                        $row = $result->fetch_assoc();
                        // Get the count of rows with the lowest quantity
                        $countLowestQuantity = $row['count_lowest_quantity'];
                        // Output the count
                    ?>
                        <h2><?php echo $countLowestQuantity; ?></h2>
                    <?php
                    } else {
                        echo "Error executing query: " . $conn->error;
                    }
                    ?>
                </div>
            </a>
            <a href="#" id="filterHighQuantityButton">
                <div class="grid-item" id="highests">
                    <div>
                        <h3>Highest Stock Items</h3>
                        <img src="img/icons/tag.png" alt="users image">
                    </div>
                    <?php
                    $sql = "SELECT COUNT(*) AS count_lowest_quantity FROM items WHERE ITEM_QUANTITY > 20";
                    $result = $conn->query($sql);

                    if ($result) {
                        // Fetch the result
                        $row = $result->fetch_assoc();
                        // Get the count of rows with the lowest quantity
                        $countLowestQuantity = $row['count_lowest_quantity'];
                        // Output the count
                    ?>
                        <h2><?php echo $countLowestQuantity; ?></h2>
                    <?php
                    } else {
                        echo "Error executing query: " . $conn->error;
                    }
                    ?>
                </div>
            </a>
            <a href="#" id="filterNoStockButton">
                <div class="grid-item" id="highest">
                    <div>
                        <h3>Out Of Stock</h3>
                        <img src="img/icons/tag.png" alt="users image">

                    </div>
                    <?php
                    $sql = "SELECT COUNT(*) AS count_lowest_quantity FROM items WHERE ITEM_QUANTITY = 0";
                    $result = $conn->query($sql);

                    if ($result) {
                        // Fetch the result
                        $row = $result->fetch_assoc();
                        // Get the count of rows with the lowest quantity
                        $countLowestQuantity = $row['count_lowest_quantity'];
                        // Output the count
                    ?>
                        <h2><?php echo $countLowestQuantity; ?></h2>
                    <?php
                    } else {
                        echo "Error executing query: " . $conn->error;
                    }
                    ?>

                </div>
            </a>
        </div>
        <?php
        if (isset($_GET['msg'])) { ?>
            <p class="msg"><?php echo $_GET['msg']; ?></p>
        <?php } ?>


        <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">
                <!-- <button id="filterShowButton">Filter SHOW</button> -->
                <!-- <button id="filterHideButton">Filter HIDE</button> -->
                <!-- <button id="filterLowQuantityButton">Filter Low Quantity</button> -->
                <!-- <button id="filterHighQuantityButton">Filter High Quantity</button> -->
                <!-- <button id="filterNoStockButton">Filter Out of stock Quantity</button> -->
                <!-- <button id="filterRefreshButton">Refresh</button> -->

            </div>

            <table id="ordersTable">
                <thead>
                    <tr class="header_Table">
                        <th>ID</th>
                        <th>ACTION</th>
                        <th>IMAGE</th>
                        <th>NAME</th>
                        <th>STATUS</th>
                        <th>QUANTITY</th>
                        <th>CATEGORY</th>
                        <th>BRAND</th>
                        <th>PRICE</th>
                        <th>DESCRIPTION</th>
                        <th>SHIPPING FEE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM items ORDER BY ITEM_ID DESC;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // Fetch all rows into an array for easier processing
                        $rows = $result->fetch_all(MYSQLI_ASSOC);

                        // Sort the rows by ITEM_QUANTITY
                        usort($rows, function ($a, $b) {
                            return $a['ITEM_QUANTITY'] <=> $b['ITEM_QUANTITY'];
                        });

                        // output data of each row
                        foreach ($rows as $row) {
                            $imagePath = "img/itemPhotos/" . $row['ITEM_IMAGE'];
                    ?>
                            <tr class="even-row" data-status="<?php echo $row['ITEM_STATUS']; ?>">
                                <td><?php echo $row['ITEM_ID']; ?></td>
                                <td>
                                    <?php
                                    if ($row['ITEM_STATUS'] == "HIDE") {
                                    ?>
                                        <div class="action_Div">
                                            <div>
                                                <a href="php/admin_Dashboard_Inventory/edit_Item.php?id=<?php echo $row['ITEM_ID'] ?>">
                                                    <button>EDIT INFO</button>
                                                </a>
                                                <a href="php/admin_Dashboard_Inventory/edit_Item_Stock.php?id=<?php echo $row['ITEM_ID'] ?>">
                                                    <button>EDIT STOCK</button>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="php/admin_Dashboard_Inventory/add_Item_Image.php?id=<?php echo $row['ITEM_ID']; ?>">
                                                    <button>ADD IMAGE</button>
                                                </a>
                                                <a href="php/php_action/hidden_Activate.php?id=<?php echo $row['ITEM_ID'] ?>">
                                                    <button>SHOW ITEM</button>
                                                </a>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="action_Div">
                                            <div>
                                                <a href="php/php_action/showed_Deactivate.php?id=<?php echo $row['ITEM_ID'] ?>">
                                                    <button>HIDE ITEM</button>
                                                </a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><img src="<?php echo $imagePath; ?>" alt=" "></td>
                                <td><?php echo $row['ITEM_NAME']; ?></td>
                                <td><?php echo $row['ITEM_STATUS']; ?></td>
                                <td><?php echo $row['ITEM_QUANTITY']; ?></td>
                                <td><?php echo $row['ITEM_CATEGORY']; ?></td>
                                <td><?php echo $row['ITEM_BRAND']; ?></td>
                                <td><?php echo $row['ITEM_PRICE']; ?></td>
                                <td><?php echo $row['ITEM_DESCRIPTION']; ?></td>
                                <td><?php echo $row['ITEM_SHIPPING_FEE']; ?></td>
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

    </main>

    <script>
        $(document).ready(function() {
            $("#filterShowButton").click(function() {
                // Show only the "SHOW" status rows
                $(".even-row[data-status='SHOW']").show();
                $(".even-row[data-status!='SHOW']").hide();

                $("#all").css("background-color", "white");
                $("#hidden").css("background-color", "white");
                $("#posted").css("background-color", "lightgray");
                $("#lowest").css("background-color", "white");
                $("#highests").css("background-color", "white");
                $("#highest").css("background-color", "white");
            });

            $("#filterHideButton").click(function() {
                // Show only the "HIDE" status rows
                $(".even-row[data-status='HIDE']").show();
                $(".even-row[data-status!='HIDE']").hide();

                $("#all").css("background-color", "white");
                $("#hidden").css("background-color", "lightgray");
                $("#posted").css("background-color", "white");
                $("#lowest").css("background-color", "white");
                $("#highests").css("background-color", "white");
                $("#highest").css("background-color", "white");
            });

            $("#filterLowQuantityButton").click(function() {
                // Sort the rows by ITEM_QUANTITY
                var sortedRows = $(".even-row").toArray().sort(function(a, b) {
                    return +$(a).find("td:eq(5)").text() - +$(b).find("td:eq(5)").text();
                });
                // Show only rows with ITEM_QUANTITY lower than 10
                var thresholdQuantity = 10;
                $(".even-row").hide();
                $(sortedRows).filter(function() {
                    return +$(this).find("td:eq(5)").text() < thresholdQuantity;
                }).show();

                $("#all").css("background-color", "white");
                $("#hidden").css("background-color", "white");
                $("#posted").css("background-color", "white");
                $("#lowest").css("background-color", "lightgray");
                $("#highests").css("background-color", "white");
                $("#highest").css("background-color", "white");
            });

            $("#filterHighQuantityButton").click(function() {
                // Show only rows with ITEM_QUANTITY higher than 20
                var thresholdQuantity = 20;
                $(".even-row").hide().filter(function() {
                    return +$(this).find("td:eq(5)").text() > thresholdQuantity;
                }).show();

                $("#all").css("background-color", "white");
                $("#hidden").css("background-color", "white");
                $("#posted").css("background-color", "white");
                $("#lowest").css("background-color", "white");
                $("#highests").css("background-color", "lightgray");
                $("#highest").css("background-color", "white");
            });

            $("#filterNoStockButton").click(function() {
                // Show only rows with ITEM_QUANTITY equal to 0
                var zeroQuantityRows = $(".even-row").filter(function() {
                    return +$(this).find("td:eq(5)").text() === 0;
                });
                $(".even-row").hide();
                $(zeroQuantityRows).show();

                $("#all").css("background-color", "white");
                $("#hidden").css("background-color", "white");
                $("#posted").css("background-color", "white");
                $("#lowest").css("background-color", "white");
                $("#highests").css("background-color", "white");
                $("#highest").css("background-color", "lightgray");
            });
            $("#filterRefreshButton").click(function() {
                // Show all rows
                $(".even-row").show();

                $("#all").css("background-color", "lightgray");
                $("#hidden").css("background-color", "white");
                $("#posted").css("background-color", "white");
                $("#lowest").css("background-color", "white");
                $("#highests").css("background-color", "white");
                $("#highest").css("background-color", "white");
            });
        });
    </script>

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