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
    <link rel="stylesheet" href="css/admin_Dashboard_Additem.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
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
            <div style="background-color: #16324E;">
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
            <h1>ADD ITEM</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <?php
        if (isset($_GET['msgIfUpdateSuccess'])) { ?>
            <p class="msgIfUpdateSuccess"><?php echo $_GET['msgIfUpdateSuccess']; ?></p>
        <?php } ?>
        <div class="form_container">
            <div>
                <form action="php/php_action/admin_Dashboard_Additem_Add.php" method="POST" enctype="multipart/form-data">
                    <h1 class="main_Title"> Add Item</h1>
                    <label for="itemName"><b>Item Name</b></label>
                    <br>
                    <input type="text" name="itemName" placeholder="Item Name" maxlength="200" required>
                    <br>
                    <label for="itemDescription"><b>Item Description</b></label>
                    <br>
                    <input type="text" name="itemDescription" placeholder="Item Description" maxlength="1000" required>
                    <br>
                    <label for="itemQuantity"><b>Item Quantity</b></label>
                    <br>
                    <input type="number" name="itemQuantity" placeholder="Item Quantity" onKeyPress="if(this.value.length==4) return false;" required>
                    <br>
                    <label for="itemPrice"><b>Item Price</b></label>
                    <br>
                    <input type="number" name="itemPrice" placeholder="Item Price" onKeyPress="if(this.value.length==4) return false;" required>
                    <br>
                    <label for="itemPrice"><b>Item Shipping Fee</b></label>
                    <br>
                    <input type="number" name="itemShippingFee" placeholder="Item Shipping Fee" onKeyPress="if(this.value.length==4) return false;" required>
                    <br>
                    <label for="itemCategory"><b>Item Category</b></label>
                    <br>
                    <select name="itemCategory" id="idItemCategory">
                        <?php
                        $sqlQuery = "SELECT * FROM itemcategory;";
                        $runSql = mysqli_query($conn, $sqlQuery);
                        if ($runSql) {
                            while ($itemRow = mysqli_fetch_array($runSql)) {
                                $fromDatabaseRow = $itemRow["CATEGORY"];
                                echo "<option>$fromDatabaseRow</option>";
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <label for="itemBrand"><b>Item Brand</b></label>
                    <br>
                    <select name="itemBrand" id="itemBrand">
                        <?php
                        $sqlQuery = "SELECT * FROM itembrand;";
                        $runSql = mysqli_query($conn, $sqlQuery);
                        if ($runSql) {
                            while ($itemRow = mysqli_fetch_array($runSql)) {
                                $fromDatabaseRow = $itemRow["BRANDS"];
                                echo "<option>$fromDatabaseRow</option>";
                            }
                        }
                        ?>
                    </select>

                    <br>
                    <label for="fileClassLable"><b>Upload Photo</b></label>
                    <br>
                    <input class="fileClass" type="file" name="itemImage" id="fileClassLable" accept="image/*" required>
                    <br>
                    <input type="submit" value="Add Item" name="sumbitToAddItem" class="sumitInput" required>
                    <?php
                    if (isset($_GET['addMsg'])) { ?>
                        <p class="addMsg"><?php echo $_GET['addMsg']; ?></p>
                    <?php } ?>
                </form>
                <!-- <hr> -->
            </div>

            <div>
                <form action="php/php_action/admin_Dashboard_Additem_Add_Category.php">
                    <h1 class="main_Title">Add/Remove Category</h1>

                    <label for="addCategory"><b>Add Item Category</b></label>
                    <br>
                    <input type="text" name="addCategory" id="addCategoryInput" placeholder="Add Category" maxlength="50" required>
                    <br>
                    <input type="submit" value="Add Category" name="submitToAddCategory" class="addCategoryClass" require>
                    <?php
                    if (isset($_GET['addCategoryMsg'])) { ?>
                        <p class="addCategoryMsg"><?php echo $_GET['addCategoryMsg']; ?></p>
                    <?php } ?>
                </form>
                <!-- <hr> -->

                <form action="php/php_action/admin_Dashboard_Additem_Remove_Category.php">
                    <label for="itemRemoveCategory"><b>Remove Item Category</b></label>
                    <br>
                    <select name="itemRemoveCategory" id="idItemCategory">
                        <?php
                        $sqlForCategoryDelete = "SELECT * FROM itemcategory;";
                        $runSqlForCategoryDelete = mysqli_query($conn, $sqlForCategoryDelete);
                        if ($runSqlForCategoryDelete) {
                            while ($rowDeleteCategory = mysqli_fetch_array($runSqlForCategoryDelete)) {
                                $fromDatabaseRowDeleteCategory = $rowDeleteCategory["CATEGORY"];
                                echo "<option>$fromDatabaseRowDeleteCategory</option>";
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" value="Delete Category" name="submitToRemoveCategory" class="addCategoryClass" require>
                    <?php
                    if (isset($_GET['removingCategoryMsg'])) { ?>
                        <p class="removingCategoryMsg"><?php echo $_GET['removingCategoryMsg']; ?></p>
                    <?php } ?>
                </form>
                <!-- <hr> -->
                <form action="php/php_action/admin_Dashboard_AddItem_Add_Brand.php">
                    <h1 class="main_Title">Add/Remove Brand</h1>

                    <label for="addCategory"><b>Add Item Brand</b></label>
                    <br>
                    <input type="text" name="addCategory" id="addBrandInput" placeholder="Add Brand" maxlength="50" required>
                    <br>
                    <input type="submit" value="Add Brand" name="submitToAddCategory" class="addCategoryClass" require>
                    <?php
                    if (isset($_GET['addBrandMsg'])) { ?>
                        <p class="addBrandMsg"><?php echo $_GET['addBrandMsg']; ?></p>
                    <?php } ?>
                </form>
                <!-- <hr> -->

                <form action="php/php_action/admin_Dashboard_Additem_Remove_Brand.php">
                    <label for="itemRemoveCategory"><b>Remove Item Brand</b></label>
                    <br>
                    <select name="itemRemoveCategory" id="idItemCategory">
                        <?php
                        $sqlForCategoryDelete = "SELECT * FROM itembrand;";
                        $runSqlForCategoryDelete = mysqli_query($conn, $sqlForCategoryDelete);
                        if ($runSqlForCategoryDelete) {
                            while ($rowDeleteCategory = mysqli_fetch_array($runSqlForCategoryDelete)) {
                                $fromDatabaseRowDeleteCategory = $rowDeleteCategory["BRANDS"];
                                echo "<option>$fromDatabaseRowDeleteCategory</option>";
                            }
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" value="Delete Brand" name="submitToRemoveCategory" class="addCategoryClass" require>
                    <?php
                    if (isset($_GET['removingBrandMsg'])) { ?>
                        <p class="removingBrandMsg"><?php echo $_GET['removingBrandMsg']; ?></p>
                    <?php } ?>
                </form>
                <!-- <hr> -->
            </div>

            <div>
                <form action="php/admin_Dashboard_Inventory/update_City_Fee.php" method="post">
                    <h1 class="main_Title">Update City Delivery Fee</h1>

                    <label for="selected_City">City</label>
                    <select name="selected_City" id="selected_City">
                        <option selected="true" disabled="disabled">Choose a City</option>
                        <option value="Caloocan City">Caloocan City</option>
                        <option value="Las Piñas City">Las Piñas City</option>
                        <option value="Makati City">Makati City</option>
                        <option value="Malabon City">Malabon City</option>
                        <option value="Mandaluyong City">Mandaluyong City</option>
                        <option value="Tondo I / li">Tondo I / li</option>
                        <option value="Binondo">Binondo</option>
                        <option value="Ermita">Ermita</option>
                        <option value="Intramuros">Intramuros</option>
                        <option value="Malate">Malate</option>
                        <option value="Paco">Paco</option>
                        <option value="Pandacan">Pandacan</option>
                        <option value="Port Area">Port Area</option>
                        <option value="Quiapo">Quiapo</option>
                        <option value="Sampaloc">Sampaloc</option>
                        <option value="San Miguel">San Miguel</option>
                        <option value="San Nicolas">San Nicolas</option>
                        <option value="Santa Ana">Santa Ana</option>
                        <option value="Santa Cruz">Santa Cruz</option>
                        <option value="Santa Mesa">Santa Mesa</option>
                        <option value="Marikina City">Marikina City</option>
                        <option value="Muntinlupa City">Muntinlupa City</option>
                        <option value="Navotas City">Navotas City</option>
                        <option value="Parañaque City">Parañaque City</option>
                        <option value="Pasay City">Pasay City</option>
                        <option value="Pasig City">Pasig City</option>
                        <option value="Pateros City">Pateros City</option>
                        <option value="Quezon City">Quezon City</option>
                        <option value="San Juan City">San Juan City</option>
                        <option value="Taguig City">Taguig City</option>
                        <option value="Valenzuela City">Valenzuela City</option>
                    </select>
                    <br>
                    <label for="location_Shipping_Fee">Location Shipping Fee</label>
                    <input type="number" name="location_Shipping_Fee" min="1" max="1000" placeholder="Ex. 100" required>
                    <br>
                    <input type="submit" value="UPDATE" name="start_Update_City">
                </form>
                <div class="city_Table">
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <th>CITY</th>
                                <th>SHIPPING FEE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM cityshippingfee ;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr class="even-row">
                                        <td><?php echo $row['CITY']; ?></td>
                                        <td><?php echo $row['SHIPPING_FEE']; ?></td>
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

            </div>
        </div>




    </main>
    <script>
        document.getElementById('addCategoryInput').addEventListener('input', function(event) {
            // Get the input value
            var inputValue = event.target.value;

            // Remove numeric characters from the input
            var nonNumericValue = inputValue.replace(/[0-9]/g, '');

            // Update the input value with non-numeric characters only
            event.target.value = nonNumericValue;
        });
    </script>
    // <script>
    //     document.getElementById('addBrandInput').addEventListener('input', function(event) {
    //         // Get the input value
    //         var inputValue = event.target.value;

    //         // Remove numeric characters from the input
    //         var nonNumericValue = inputValue.replace(/[0-9]/g, '');

    //         // Update the input value with non-numeric characters only
    //         event.target.value = nonNumericValue;
    //     });
    // </script>
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