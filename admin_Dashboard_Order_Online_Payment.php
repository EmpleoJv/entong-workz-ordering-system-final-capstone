<?php
include('php/connection/dbTemporary.php');
include('php/connection/dbConnection.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
$mainIDs = $_GET['id'];
$status = $_GET['status'];
$topay = $_GET['topay'];
$total = $_GET['total'];
$num = $_GET['num'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin_Dashboard_Order_Online_Payment.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


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
            <div style="background-color: #16324E;">
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
            <h1>PAYMENT OF ONLINE ORDERS</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>

        <a href="admin_Dashboard_Orders.php"><button class="btnBack">BACK</button></a>
        <div class="form_Container">
            <div>
                <form action="php/admin_Dashboard_Orders/add_Payment_Of_Customer.php" method="post">
                    <label for="customers_Payment">Accept Payment</label>
                    <!-- <input type="number" id="customers_Payment" name="customers_Payment" min="1" max="<?php echo $topay; ?>" required> -->
                    <input type="text" value="<?php echo $mainIDs; ?>" name="id" hidden>
                    <input type="number" value="<?php echo $topay; ?>" name="topay" hidden>
                    <input type="text" value="<?php echo $status; ?>" name="status" hidden>
                    <input type="text" value="<?php echo $num; ?>" name="num" hidden>
                    <br>
                    <input type="checkbox" id="checkbx" required><a href="#" id="checkbx">CLICK TO CONFIRM</a>
                    <br>
                    <?php
                    $sql = "SELECT * FROM onlinepayment WHERE ORDER_CODE = '$mainIDs';";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $sqls = "SELECT * FROM ordercode WHERE CODE = '$mainIDs';";
                            $results = $conn->query($sqls);
                            if ($results->num_rows > 0) {
                                while ($rows = $results->fetch_assoc()) {
                                    if ($rows['PACKAGE_STATUS'] === 'PAYMENT PENDING') {
                    ?>
                                        <input type="submit" name="submit_Payment" value="SUBMIT PAYMENT" class="infut">
                                    <?php
                                    } else {
                                    ?>
                                        <input type="submit" value="SUBMIT PAYMENT" class="infut" style="background-color: gray;" disabled>
                    <?php
                                    }
                                }
                            }
                        }
                    } else {
                    }
                    ?>
                </form>
            </div>
        </div>
        <?php
        if (isset($_GET['errorss'])) { ?>
            <p class="errorss"><?php echo $_GET['errorss']; ?></p>
        <?php } ?>
        <hr>
        <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">
                <h1 class="allOrdersTitle">All PAYMENT FOR ORDER: <?php echo $mainIDs ?> </h1>
                <h1 class="allOrdersTitle">CUSTOMER'S ONLINE PENDING PAYMENT: <span style="color: red;">₱<?php echo number_format($topay, 2) ?></span></h1>
            </div>
            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>ORDER CODE</th>
                        <th>DATE OF UPLOAD</th>
                        <th>REFERENCE NUMBER</th>
                        <th>STATUS</th>
                        <th>CUSTOMER SENDER</th>
                        <th>RECEIPT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM onlinepayment WHERE ORDER_CODE = '$mainIDs';";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $custom = $row['SENDER']
                    ?>
                            <tr class="even-row">
                                <td><?php echo $row['ORDER_CODE'] ?></td>
                                <td><?php echo $row['DATE_OF_UPLOAD'] ?></td>
                                <td><?php echo $row['REFERENCE_NUM'] ?></td>
                                <td><?php echo $row['STATUS'] ?></td>
                                <td>
                                    <?php
                                    $sqlsss = "SELECT * FROM userlogin WHERE ID = $custom;";
                                    $resultsss = $conn->query($sqlsss);
                                    if ($resultsss->num_rows > 0) {
                                        // output data of each row
                                        while ($rowsss = $resultsss->fetch_assoc()) {
                                            echo $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="img_con_table"><img src="img/receipt/<?php echo $row['RECEIPT_IMG']; ?>" alt=" " class="img"></td>
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let input = document.getElementById("receipt_Img");
                let imageName = document.getElementById("imageName");

                input.addEventListener("change", () => {
                    let inputImage = input.files[0];

                    if (inputImage) {
                        imageName.textContent = inputImage.name;
                    } else {
                        imageName.textContent = ""; // Clear the text if no file is selected
                    }
                });
            });
        </script>
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