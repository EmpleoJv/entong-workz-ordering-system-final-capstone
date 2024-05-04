<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

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
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin_Dashboard_User_Verification.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="#">
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
            <div style="background-color: #16324E;">
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
            <div>
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
            <h1>USER VERIFICATION</h1>
            <a href="../php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <!-- <div class="grid-container">
            <div class="grid-item" id="all">
                <div>
                    <h3>Total Sales</h3>
                    <img src="../../img/icons/tag.png" alt="users image">
                </div>
                <?php
                $selectQuerys = "SELECT COUNT(*) as count FROM veification WHERE STATUS = 'FULLY VERIFIED'";
                $results = $conn->query($selectQuerys);

                if ($results) {
                    $rows = $results->fetch_assoc();
                    $count = $rows['count'];
                ?>
                    <h2><?php echo $count; ?></h2>
                <?php
                } else {
                    echo "Error executing the query: " . $conn->error;
                }
                ?>
            </div>
        </div> -->

        <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">
                <h1 class="allOrdersTitle">VERIFICATION STATUS</h1>
                <div class="action_Container">
                    <button id="sortButton">Sort by Fully Verified</button>
                    <button id="sortButton2">Sort by NOT YET VERIFIED</button>
                    <button id="sortButton3">Sort by Pending Verification</button>
                </div>
            </div>
            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>ID </th>
                        <th>VERIFICATION</th>
                        <th>IMAGE</th>
                        <th>FIRSTNAME</th>
                        <th>LASTNAME</th>
                        <th>EMAIL</th>
                        <th>AGE</th>
                        <th>DATE</th>
                        <th>GENDER</th>
                        <th>ADDITIONAL INFORMATION</th>
                        <th>PROVINCE</th>
                        <th>CITYMUNICIPALITY</th>
                        <th>BARANGAY</th>
                    </tr>
                </thead>
                <tbody id="tableBody">

                    <?php
                    $sql = "SELECT * FROM userlogin;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $imagePath = "../../img/userImage/" . $row['IMAGE'];
                            $idFormUsers = $row['ID'];
                    ?>
                            <form method="get">

                                <tr class="clickable-row" data-href="admin_Dashboard_User_Verification.php?userId=<?php echo $row['ID']; ?>">
                                    <td><?php echo $row['ID']; ?></td>
                                    <td>
                                        <?php
                                        $sqls = "SELECT STATUS FROM veification WHERE USER_ID  = $idFormUsers;";
                                        $results = $conn->query($sqls);
                                        if ($results) {
                                            if ($results->num_rows > 0) {
                                                // Output data of each row
                                                while ($rows = $results->fetch_assoc()) {
                                                    // Assuming you have the images in the correct directory
                                                    if ($rows['STATUS'] === "FULLY VERIFIED") {
                                        ?>
                                                        <h4>FULLY VERIFIED</h4>
                                                    <?php
                                                        // break;
                                                        // } else if (isset($rows['STATUS'])) {
                                                    } else if (isset($rows['STATUS'])) {

                                                    ?>
                                                        <h4>PENDING VERIFICATION</h4>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <h4>NO SUBMITTED ID</h4>
                                                <?php
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <h4>NO SUBMITTED ID</h4>
                                        <?php
                                            }
                                        } else {
                                            echo "Error executing SQL query: " . $conn->error;
                                        }
                                        ?>
                                    </td>
                                    <td><img src="<?php echo $imagePath; ?>" alt="User Photos" class="tableImage"></td>
                                    <td><?php echo $row['FIRSTNAME']; ?></td>
                                    <td><?php echo $row['LASTNAME']; ?></td>
                                    <td><?php echo $row['EMAIL']; ?></td>
                                    <td><?php echo $row['AGE']; ?></td>
                                    <td><?php echo $row['DATE']; ?></td>
                                    <td><?php echo $row['GENDER']; ?></td>
                                    <td><?php echo $row['ADDITIONAL_INFORMATION']; ?></td>
                                    <td><?php echo $row['PROVINCE']; ?></td>
                                    <td><?php echo $row['CITY_MUNICIPALITY']; ?></td>
                                    <td><?php echo $row['BARANGAY']; ?></td>
                                </tr>
                                <input type="text" name="userId" value="<?php echo $row['ID'] ?>" hidden>
                            </form>
                    <?php
                        }
                    } else {
                        echo "no Data Found";
                    }
                    ?>
                </tbody>

            </table>
        </div>

        <div class="verification_Panel">
            <?php
            if (isset($_GET['veriMessage'])) { ?>
                <h1 class="veriMessage"><?php echo $_GET['veriMessage']; ?></h1>
            <?php } ?>
            <?php
            if (isset($_REQUEST['userId'])) {
                $userId = $_GET['userId'];
                $checkers = 0;
                $sql = "SELECT STATUS FROM veification WHERE USER_ID = $userId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if ($row['STATUS'] === 'NOT YET VERIFIED') {
                            $checkers = 1;
                        } else if ($row['STATUS'] === 'FULLY VERIFIED') {
                            $checkers = 2;
                        }
                    }
                } else {
            ?>
                    <h1><?php echo "NO SUBMITTED ID FOUND?"; ?></h1>
                <?php
                }
                if ($checkers == 2) {
                ?>
                    <h1><?php echo "THIS USER IS ALREADY VERIFIED!"; ?></h1>
                <?php
                }
                if ($checkers == 1) {
                ?>
                    <div class="img_Container">
                        <div class="id">
                            <?php
                            $sql = "SELECT * FROM veification WHERE USER_ID = $userId;";
                            $result = $conn->query($sql);

                            if ($result) {
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        // Assuming you have the images in the correct directory
                                        $imagePath = "../../img/veriImage/" . $row['VR_IMAGE_ID'];
                            ?>
                                        <img src="<?php echo $imagePath; ?>" alt="Image">
                                        <h1><?php echo $row['STATUS']; ?></h1>
                                    <?php
                                    }
                                } else {
                                    echo "No images found for this user.";
                                    ?>
                                    <h1>ID image not found</h1>
                            <?php
                                }
                            } else {
                                echo "Error executing SQL query: " . $conn->error;
                            }
                            ?>
                        </div>
                        <div class="image">
                            <?php

                            $sql = "SELECT * FROM userlogin WHERE ID = $userId;";
                            $result = $conn->query($sql);

                            if ($result) {
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        // Assuming you have the images in the correct directory
                                        $imagePath = "../../img/userImage/" . $row['IMAGE'];
                            ?>
                                        <img src="<?php echo $imagePath; ?>" alt="Image">
                                        <h1>Profile</h1>
                            <?php
                                    }
                                }
                            } else {
                                echo "Error executing SQL query: " . $conn->error;
                            }
                            ?>
                        </div>
                        <div class="submit_Class">
                            <form method="get" action="admin_Dashboard_User_Verification_Start.php">
                                <input type="submit" value="Verify" name="startVeification" class="submit_Start">
                                <input type="text" name="idName" value="<?php echo $userId ?>" hidden>
                            </form>
                        </div>
                    </div>

                <?php
                }
                ?>
            <?php
            }
            ?>
        </div>
        <script>
            // Function to sort the table rows by "Pending Verification"
            function sortTableByPendingVerification() {
                const table = document.getElementById("ordersTable");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));

                // Sort the rows based on the "VERIFICATION" column
                rows.sort((a, b) => {
                    const statusA = getStatus(a);
                    const statusB = getStatus(b);

                    // Custom sorting logic (Pending Verification should come first)
                    if (statusA === "PENDING VERIFICATION" && statusB !== "PENDING VERIFICATION") {
                        return -1;
                    } else if (statusA !== "PENDING VERIFICATION" && statusB === "PENDING VERIFICATION") {
                        return 1;
                    } else {
                        return 0;
                    }
                });

                // Reorder the table rows
                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }

            // Add an event listener to the "Sort by Pending Verification" button
            const pendingVerificationButton = document.getElementById("sortButton3");
            pendingVerificationButton.addEventListener("click", sortTableByPendingVerification);
        </script>

        <script>
            // Function to sort the table rows by "Fully Verified"
            function sortTableByFullyVerified() {
                const table = document.getElementById("ordersTable");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));

                // Sort the rows based on the "VERIFICATION" column
                rows.sort((a, b) => {
                    const statusA = getStatus(a);
                    const statusB = getStatus(b);

                    // Custom sorting logic (Fully Verified should come first)
                    if (statusA === "FULLY VERIFIED" && statusB !== "FULLY VERIFIED") {
                        return -1;
                    } else if (statusA !== "FULLY VERIFIED" && statusB === "FULLY VERIFIED") {
                        return 1;
                    } else {
                        return 0;
                    }
                });

                // Reorder the table rows
                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }

            // Add an event listener to the "Sort by Fully Verified" button
            const fullyVerifiedButton = document.getElementById("sortButton");
            fullyVerifiedButton.addEventListener("click", sortTableByFullyVerified);
        </script>

        <script>
            // Function to sort the table rows by "ORDER PENDING"
            function sortTableByOrderPending() {
                const table = document.getElementById("ordersTable");
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));

                // Sort the rows based on the "VERIFICATION" column
                rows.sort((a, b) => {
                    const statusA = getStatus(a);
                    const statusB = getStatus(b);

                    // Custom sorting logic (ORDER PENDING should come first)
                    if (statusA === "NO SUBMITTED ID" && statusB !== "NO SUBMITTED ID") {
                        return -1;
                    } else if (statusA !== "NO SUBMITTED ID" && statusB === "NO SUBMITTED ID") {
                        return 1;
                    } else {
                        return 0;
                    }
                });

                // Reorder the table rows
                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }

            // Helper function to get the verification status from a row
            function getStatus(row) {
                const statusCell = row.querySelector("td:nth-child(2)");
                if (statusCell) {
                    return statusCell.textContent.trim();
                }
                return "";
            }

            // Add an event listener to the button
            const sortButton = document.getElementById("sortButton2");
            sortButton.addEventListener("click", sortTableByOrderPending);
        </script>



        <script>
            // Add a click event listener to all elements with the class "clickable-row"
            document.querySelectorAll(".clickable-row").forEach(function(row) {
                row.addEventListener("click", function() {
                    // Get the destination URL from the data-href attribute
                    const url = row.getAttribute("data-href");

                    // Redirect to the specified URL
                    window.location.href = url;
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