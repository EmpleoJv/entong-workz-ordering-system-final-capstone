<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
$id = $_GET['id']; //this is from adminAddUser.php
if (isset($_REQUEST['submitAddStock'])) {
    $UpdateItem_S = $_REQUEST['ItemQuantity'];

    $insert_query = "UPDATE items SET ITEM_QUANTITY = ITEM_QUANTITY+'$UpdateItem_S' WHERE ITEM_ID = $id;";
    if ($conn->query($insert_query) === TRUE) {
        header("Location: ../../admin_Dashboard_Inventory.php?msg= Edit Item Successfully");
    } else {
        header("Location: ../../admin_Dashboard_Inventory.php?msg= Edit Item failed");
    }
}

if (isset($_REQUEST['submitUpdateStock'])) {
    $item_New_Quantity = $_REQUEST['smallQuantity'];

    $insert_query = "UPDATE items SET ITEM_QUANTITY = '$item_New_Quantity' WHERE ITEM_ID = $id;";
    if ($conn->query($insert_query) === TRUE) {
        header("Location: ../../admin_Dashboard_Inventory.php?msg= Edit Item Successfully");
    } else {
        header("Location: ../../admin_Dashboard_Inventory.php?msg= Edit Item failed");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/edit_Item_Stock.css">

    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
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
        <a href="../../admin_Dashboard_Others.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/others.png" alt="orders">
                <span id="textBank">Others</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="../../img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>ADD ITEM STOCK</h1>
            <a href="../php_action/admin_logout.php" class="logout">logout</a>

        </nav>
        <?php
        if (isset($_GET['msg'])) { ?>
            <p class="msg"><?php echo $_GET['msg']; ?></p>
        <?php } ?>

        <?php
        $sqlUpdaterQuery = "SELECT * FROM items WHERE ITEM_ID = $id;";
        $runSqlQuery = mysqli_query($conn, $sqlUpdaterQuery);
        while ($rowQuery = mysqli_fetch_array($runSqlQuery)) {
            $forCategory = $rowQuery["ITEM_CATEGORY"];
        ?>
            <div class="img_Container">
                <img src="../../img/itemPhotos/<?php echo $rowQuery['ITEM_IMAGE'] ?>" alt="Image">
            </div>
            <div class="container">
                <div class="card">
                    <div>
                        <h5>Item Name </h5>
                        <hr>
                        <h6><?php echo $rowQuery['ITEM_NAME'] ?></h6>
                    </div>
                </div>
                <div class="card" id="card_description">
                    <div>
                        <h5>Item Description</h5>
                        <hr>
                        <h6><?php echo $rowQuery['ITEM_DESCRIPTION'] ?></h6>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h5>Item Category</h5>
                        <hr>
                        <h6><?php echo $rowQuery['ITEM_CATEGORY'] ?></h6>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h5>Item Price</h5>
                        <hr>
                        <h6><?php echo $rowQuery['ITEM_PRICE'] ?>₱</h6>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <h5>Item Quantity</h5>
                        <hr>
                        <h6>Only <?php echo $rowQuery['ITEM_QUANTITY'] ?> items left</h6>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="form_Container">
            <form action="#" method="POST" class="form_Update_Item_Container">
                <h4>Add item stocks</h4>
                <label for="ItemQuantity">Add Quantity</label>
                <br>
                <input type="Number" name="ItemQuantity" placeholder="Input to add Quantity" onKeyPress="if(this.value.length==4) return false;">
                <br>
                <input type="submit" value="Update Item" name="submitAddStock" class="sumbitToUpdateItemQuantity" required>
            </form>

            <form action="#" method="POST" class="reset_item_Container">
                <h4>Manual update stock</h4>
                <label for="smallQuantity">Update item Quantity</label>
                <br>
                <input type="Number" name="smallQuantity" placeholder="Update Quantity" onKeyPress="if(this.value.length==4) return false;">
                <br>
                <input type="submit" value="Update Item" name="submitUpdateStock" class="sumbitToUpdateItemQuantity" required>
            </form>
        </div>
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