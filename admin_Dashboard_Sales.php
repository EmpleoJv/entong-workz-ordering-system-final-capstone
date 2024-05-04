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
    <link rel="stylesheet" href="css/admin_Dashboard_Sales.css">
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
            <div style="background-color: #16324E;">
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
            <h1>Sales</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <!-- <button id="sortSalesTodayBtn">Sort by Sales Today</button> -->

        <div class="grid-container">
            <div class="grid-item" id="refreshTableBtn">
                <div>
                    <h3>Total Sales</h3>
                    <img src="img/icons/tag.png" alt="users image">
                </div>
                <?php
                $sql = "SELECT SUM(SALES) as total_all FROM ordercode WHERE PACKAGE_STATUS = 'ORDER SUCCESS';";
                // Execute the query
                $result = $conn->query($sql);
                // Check if the query was successful
                if ($result) {
                    // Fetch the result as an associative array
                    $row = $result->fetch_assoc();
                    // Get the total of all three columns
                    $totalAll = $row['total_all'];
                    // Output the total
                ?>
                    <h2><?php echo "₱" . number_format($totalAll, 2); ?></h2>

                <?php
                    // Close the result set
                    $result->close();
                } else {
                    echo "Error executing the query: " . $conn->error;
                }
                ?>
            </div>
            <div class="grid-item" id="sortSalesTodayBtn">
                <div>
                    <h3>Daily Sales</h3>
                    <img src="img/icons/tag.png" alt="users image">
                </div>
                <?php
                // Get today's date in the format 'Y-m-d'
                $todayDate = date("Y-m-d");

                $sql = "SELECT SUM(SALES) as total_today FROM ordercode WHERE PACKAGE_STATUS = 'ORDER SUCCESS' AND ORDER_DATE = '$todayDate';";

                // Execute the query
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result) {
                    // Fetch the result as an associative array
                    $row = $result->fetch_assoc();

                    // Get the total sales profit for today
                    $totalToday = $row['total_today'];

                    // Output the total
                ?>
                    <h2><?php echo "₱" . number_format($totalToday, 2); ?></h2>
                <?php

                    // Close the result set
                    $result->close();
                } else {
                    echo "Error executing the query: " . $conn->error;
                }
                ?>
            </div>
            <div class="grid-item" id="sortSalesThisMonthBtn">
                <div>
                    <h3>This Month Sales</h3>
                    <img src="img/icons/tag.png" alt="users image">
                </div>

                <?php
                $currentDate = date('Y-m-d');
                $firstDayOfMonth = date('Y-m-01', strtotime($currentDate));

                $currentDate2 = date('Y-m-d');
                $lastDayOfMonth = date('Y-m-t', strtotime($currentDate2));

                // Output the last day of the current month
                $sql = "SELECT SUM(SALES) as total_all FROM ordercode WHERE PACKAGE_STATUS = 'ORDER SUCCESS' AND ORDER_DATE >= '$firstDayOfMonth' AND ORDER_DATE <= '$lastDayOfMonth';";
                // Execute the query
                $result = $conn->query($sql);
                // Check if the query was successful
                if ($result) {
                    // Fetch the result as an associative array
                    $row = $result->fetch_assoc();
                    // Get the total for the latest month
                    $totalAll = $row['total_all'];
                    // Output the total
                ?>
                    <h2><?php echo "₱" . number_format($totalAll, 2); ?></h2>
                <?php
                    // Close the result set
                    $result->close();
                } else {
                    echo "Error executing the query: " . $conn->error;
                }
                ?>

            </div>
            <div class="grid-item" id="sortSalesLastMonthBtn">
                <div>
                    <h3>Last Month Sales</h3>
                    <img src="img/icons/tag.png" alt="users image">
                </div>
                <?php
                // Get the first day of the previous month
                $firstDayOfPreviousMonth = date('Y-m-01', strtotime('first day of previous month'));

                // Get the last day of the previous month
                $lastDayOfPreviousMonth = date('Y-m-t', strtotime('last day of previous month'));

                // Output the last day of the previous month
                $sql = "SELECT SUM(SALES) as total_all 
        FROM ordercode 
        WHERE PACKAGE_STATUS = 'ORDER SUCCESS' 
        AND ORDER_DATE >= '$firstDayOfPreviousMonth' 
        AND ORDER_DATE <= '$lastDayOfPreviousMonth';";

                // Execute the query
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result) {
                    // Fetch the result as an associative array
                    $row = $result->fetch_assoc();

                    // Get the total for the last month
                    $totalAll = $row['total_all'];

                    // Output the total
                ?>
                    <h2><?php echo "₱" . number_format($totalAll, 2); ?></h2>

                <?php

                    // Close the result set
                    $result->close();
                } else {
                    echo "Error executing the query: " . $conn->error;
                }

                ?>

            </div>
        </div>

        <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">

                <div class="filter">
                    <h1 class="allOrdersTitle">SALES </h1>

                    <div class="actionsTable">
                        <button id="refreshTable">REFRESH</button>
                        <?php
                        $sql = "SELECT MIN(ORDER_DATE) AS min_date, MAX(ORDER_DATE) AS max_date FROM ordercode WHERE PACKAGE_STATUS = 'ORDER SUCCESS'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $minDate = $row['min_date'];
                            $maxDate = $row['max_date'];
                        }
                        ?>
                        <div class="dateCon">
                            <label for="StartDateFilter">Start Date:</label>
                            <input type="date" id="StartDateFilter" min="<?php echo $minDate; ?>" max="<?php echo $maxDate; ?>" value="<?php echo $minDate; ?>">
                        </div>
                        <div class="dateCon">
                            <label for="LastDateFilter">End Date:</label>
                            <input type="date" id="LastDateFilter" min="<?php echo $minDate; ?>" max="<?php echo $maxDate; ?>" value="<?php echo $maxDate; ?>">

                        </div>

                        <button id="filterButton">Filter</button>

                    </div>
                </div>
            </div>

            <table id="ordersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <!--<th>ACTION</th>-->
                        <th>DATE</th>
                        <th>PACKAGE STATUS</th>
                        <th hidden>SALES</th>
                        <th>SALES</th>
                        <th>ORDER CODE</th>
                        <th>ORDER BY</th>
                        <th>ACCEPTED BY</th>
                        <th>DELIVER BY</th>
                        <th>DATE DELIVERED</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM ordercode WHERE PACKAGE_STATUS = 'ORDER SUCCESS' ORDER BY ID DESC;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr class="even-row">
                                <td><?php echo $row['ID']; ?></td>
                                <!--<td>-->
                                <!--    <button class=" Show" onclick="location.href='?id=<?php echo $row['CODE']; ?>&action=show'">DETAILS</button>-->
                                <!--</td>-->
                                <td>
                                    <?php 
                                    $datesor = $row['ORDER_DATE'];
                                    $formattedDate123 = date('F d, Y', strtotime($datesor));

                                    echo $formattedDate123;
                                    ?>
                                    </td>
                                <td>
                                    <?php echo $row['PACKAGE_STATUS']; ?></td>
                                <td hidden>
                                    <?php
                                    $final_Total = $row['SALES'];
                                    // $final_Total = $row['TOTAL_PRICE'] + $row['ITEM_FEE'] + $row['CITY_FEE'];
                                    echo $final_Total;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $final_Total = $row['SALES'];
                                    // $final_Total = $row['TOTAL_PRICE'] + $row['ITEM_FEE'] + $row['CITY_FEE'];
                                    echo "₱" . number_format($final_Total, 2);
                                    ?>
                                </td>
                                <td><?php echo $row['CODE']; ?></td>
                                <td>
                                    <?php
                                    $user = $row['USER_ID'];
                                    if (isset($user) && !empty($user)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM userlogin WHERE ID = $user";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();

                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                        echo "WALK IN";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $accepted = $row['ACCEPTED_BY'];
                                    if (isset($accepted) && !empty($accepted)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM companylogin WHERE ID = $accepted";
                                        $resultsss = $conn->query($sqlsss);

                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }

                                        $rowsss = $resultsss->fetch_assoc();

                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $delivereds = $row['DELIVERED_BY'];
                                    if (isset($delivereds) && !empty($delivereds)) {
                                        $sqlsss = "SELECT FIRSTNAME, LASTNAME FROM companylogin WHERE ID = $delivereds";
                                        $resultsss = $conn->query($sqlsss);

                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }

                                        $rowsss = $resultsss->fetch_assoc();

                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $dating = $row['DELIVERY_DATE'];
                                    $formattedDatesddd = date('F d, Y', strtotime($dating));

                                    echo $formattedDatesddd; 
                                    ?>
                                    </td>
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
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'show' && isset($_GET['id'])) :
        ?>
            <div class="show_Update">
                <div class="show_form">
                    <img src="img/icons/close.png" alt="xmark" class="Icon-close">

                    <div class="navForAnotherPage center-heading">
                        <h2 class="titleVoucher">ORDER INFORMATION</h2>
                    </div>
                    <div id="printArea">
                        <?php
                        $mainId = $_GET['id'];
                        $sqlQueryShot = "SELECT * FROM ordercode WHERE CODE = '$mainId';";
                        $runSqlShot = mysqli_query($conn, $sqlQueryShot);
                        while ($rowShot = mysqli_fetch_array($runSqlShot)) {
                            $priceFee = $rowShot['TOTAL_PRICE'];

                            $sqlQuery = "SELECT * FROM orders WHERE ORDERCODE = '$mainId';";
                            $runSql = mysqli_query($conn, $sqlQuery);
                            while ($row = mysqli_fetch_array($runSql)) {
                                $St = $row['ADDITIONAL_INFORMATION'];
                                $pv = $row['PROVINCE'];
                                $cm = $row['CITYMUNICIPALITY'];
                                $br = $row['BARANGAY'];
                                $pm = $row['PAYMENT_METHOD'];
                        ?>
                                <div class="grid-containers">
                                    <div class="item1s">
                                        <div class="detailsPrint">
                                            <img src="img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt=" ">
                                            <h3>Item Name: <span><?php echo $row['ORDERED_ITEM'] ?></span></h3>
                                            <h3>Item Quantity: <span>x<?php echo $row['QUANTITY'] ?></span></h3>
                                            <h3>Price: <span style="color: red;">₱<?php echo number_format($row['TOTAL_PRICE'], 2) ?></span></h3>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                            <div class="item2s">
                                <div class="detailsPrint">
                                    <br>
                                    <h3>Payment Method: <span><?php echo $pm ?></span></h3>
                                    <hr>
                                    <h3>Street/House Number: <span><?php echo $St ?></span></h3>
                                    <hr>
                                    <h3>Province: <span><?php echo $pv ?></span></h3>
                                    <hr>
                                    <h3>City/Municipality: <span><?php echo $cm ?></span></h3>
                                    <hr>
                                    <h3>Barangay: <span><?php echo $br ?></span></h3>
                                    <hr>
                                    <br>
                                    <h3>Order ID: <span><?php echo $rowShot['CODE'] ?></span></h3>
                                    <h3>Total Payment Left: <span style="color: red;">₱<?php echo number_format($rowShot['TOTAL_PRICE'], 2) ?></span></h3>
                                </div>
                            <?php
                        }
                            ?>
                            <button id="print" class="AnalyticsPrint">Print</button>
                            </div>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>
        <!-- <div class="show_Update">
            <div class="show_form">
                <img src="img/icons/close.png" alt="xmark" class="Icon-close">

                <div class="navForAnotherPage center-heading">
                    <h2 class="titleVoucher">Transaction Report</h2>
                </div>

                <div class="sub_Container">
                    <div class="card_Content" id="card_Content">


                    </div>
                </div>
            </div>
        </div> -->



    </main>

    <!-- <button class="Show" onclick="location.href='?id=<?php echo $row['ID']; ?>&action=show'">Details</button> -->

    <!-- <?php
            if (isset($_GET['action']) && $_GET['action'] == 'show' && isset($_GET['id'])) :
            ?>
        <div class="Show_Popup">
            <div class="add_form">
                <img src="img/icons/close.png" alt="xmark" class="Icon-close">
                <?php
                $mainId = $_GET['id'];
                echo $mainId;
                ?>
                <div id="printArea">
                    <h1>empleo</h1>
                </div>
                <button id="print" class="AnalyticsPrint">Print</button>
            </div>
        </div>

    <?php endif; ?> -->

    <script>
        $(document).ready(function() {
            // Function to sort the table by sales and show only last month's data
            function sortAndFilterTableBySalesLastMonth() {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById("ordersTable");
                switching = true;

                while (switching) {
                    switching = false;
                    rows = table.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;

                        x = rows[i].getElementsByTagName("td")[5].textContent; // Index 5 is the sales column
                        y = rows[i + 1].getElementsByTagName("td")[5].textContent;

                        // Convert sales values to numbers for comparison
                        x = parseFloat(x.replace("₱", "").replace(",", ""));
                        y = parseFloat(y.replace("₱", "").replace(",", ""));

                        if (x < y) {
                            shouldSwitch = true;
                            break;
                        }
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }

                // Show only last month's data
                var today = new Date();
                var lastMonthStartDate = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                var lastMonthEndDate = new Date(today.getFullYear(), today.getMonth(), 0);

                for (i = 1; i < rows.length; i++) {
                    var orderDate = new Date(rows[i].getElementsByTagName("td")[2].textContent);
                    var salesValue = parseFloat(rows[i].getElementsByTagName("td")[5].textContent.replace("₱", "").replace(",", "")); // Index 5 is the sales column

                    if (orderDate < lastMonthStartDate || orderDate > lastMonthEndDate || isNaN(salesValue)) {
                        rows[i].style.display = "none";
                    } else {
                        rows[i].style.display = "table-row";
                    }
                }
            }

            // Event listener for the button click
            $("#sortSalesLastMonthBtn").on("click", function() {
                $("#sortSalesLastMonthBtn").css("background-color", "lightgray");
                $("#sortSalesThisMonthBtn").css("background-color", "white");
                $("#sortSalesTodayBtn").css("background-color", "white");
                $("#refreshTableBtn").css("background-color", "white");
                sortAndFilterTableBySalesLastMonth();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to sort the table by sales this month
            function sortTableBySalesThisMonth() {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById("ordersTable");
                switching = true;

                while (switching) {
                    switching = false;
                    rows = table.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;

                        x = rows[i].getElementsByTagName("td")[5].textContent; // Index 5 is the sales column
                        y = rows[i + 1].getElementsByTagName("td")[5].textContent;

                        // Convert sales values to numbers for comparison
                        x = parseFloat(x.replace("₱", "").replace(",", ""));
                        y = parseFloat(y.replace("₱", "").replace(",", ""));

                        if (x < y) {
                            shouldSwitch = true;
                            break;
                        }
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }

                // Hide rows that are not from this month
                var today = new Date();
                var thisMonth = today.getMonth() + 1; // Months are zero-based
                var thisYear = today.getFullYear();

                for (i = 1; i < rows.length; i++) {
                    var orderDate = new Date(rows[i].getElementsByTagName("td")[2].textContent);
                    var orderMonth = orderDate.getMonth() + 1; // Months are zero-based
                    var orderYear = orderDate.getFullYear();
                    var salesValue = parseFloat(rows[i].getElementsByTagName("td")[5].textContent.replace("₱", "").replace(",", "")); // Index 5 is the sales column

                    if (orderYear !== thisYear || orderMonth !== thisMonth || isNaN(salesValue)) {
                        rows[i].style.display = "none";
                    } else {
                        rows[i].style.display = "table-row";
                    }
                }
            }

            // Event listener for the button click
            $("#sortSalesThisMonthBtn").on("click", function() {
                $("#sortSalesLastMonthBtn").css("background-color", "white");
                $("#sortSalesThisMonthBtn").css("background-color", "lightgray");
                $("#sortSalesTodayBtn").css("background-color", "white");
                $("#refreshTableBtn").css("background-color", "white");
                sortTableBySalesThisMonth();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to sort the table by sales today
            function sortTableBySalesToday() {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById("ordersTable");
                switching = true;

                while (switching) {
                    switching = false;
                    rows = table.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;

                        x = rows[i].getElementsByTagName("td")[5].textContent; // Index 5 is the sales column
                        y = rows[i + 1].getElementsByTagName("td")[5].textContent;

                        // Convert sales values to numbers for comparison
                        x = parseFloat(x.replace("₱", "").replace(",", ""));
                        y = parseFloat(y.replace("₱", "").replace(",", ""));

                        if (x < y) {
                            shouldSwitch = true;
                            break;
                        }
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }

                // Hide rows that are not from today
                var today = new Date().toLocaleDateString();
                for (i = 1; i < rows.length; i++) {
                    var orderDate = new Date(rows[i].getElementsByTagName("td")[2].textContent).toLocaleDateString(); // Index 2 is the date column
                    var salesValue = parseFloat(rows[i].getElementsByTagName("td")[5].textContent.replace("₱", "").replace(",", "")); // Index 5 is the sales column

                    if (orderDate !== today || isNaN(salesValue)) {
                        rows[i].style.display = "none";
                    } else {
                        rows[i].style.display = "table-row";
                    }
                }
            }

            // Event listener for the button click
            $("#sortSalesTodayBtn").on("click", function() {
                $("#sortSalesLastMonthBtn").css("background-color", "white");
                $("#sortSalesThisMonthBtn").css("background-color", "white");
                $("#sortSalesTodayBtn").css("background-color", "lightgray");
                $("#refreshTableBtn").css("background-color", "white");
                sortTableBySalesToday();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to refresh the table to its original state with default descending sorting by ID
            function refreshTable() {
                var table, rows, i;
                table = document.getElementById("ordersTable");
                rows = table.rows;

                // Show all rows
                for (i = 1; i < rows.length; i++) {
                    rows[i].style.display = "table-row";
                }

                // Remove any applied sorting
                var headerRow = table.rows[0];
                for (i = 0; i < headerRow.cells.length; i++) {
                    headerRow.cells[i].classList.remove("asc", "desc");
                }

                // Set default sorting to descending on ID column (index 0)
                headerRow.cells[0].classList.add("desc");

                // Sort the table
                sortTable(0, "desc");
            }

            // Event listener for the button click to refresh the table
            $("#refreshTableBtn").on("click", function() {
                $("#sortSalesLastMonthBtn").css("background-color", "white");
                $("#sortSalesThisMonthBtn").css("background-color", "white");
                $("#sortSalesTodayBtn").css("background-color", "white");
                $("#refreshTableBtn").css("background-color", "lightgray");
                refreshTable();
            });

            // Function to sort the table
            function sortTable(column, order) {
                var table, rows, switching, i, x, y, shouldSwitch;
                table = document.getElementById("ordersTable");
                switching = true;
                while (switching) {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = parseInt(rows[i].getElementsByTagName("td")[column].textContent);
                        y = parseInt(rows[i + 1].getElementsByTagName("td")[column].textContent);

                        if (order === "desc" ? x < y : x > y) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                    }
                }
            }
        });
    </script>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".Icon-close").forEach(function(button) {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    document.querySelector(".show_Update").style.display = "none";

                    // remove id parameter from the URL
                    var url = window.location.toString();
                    if (url.indexOf("?") > 0) {
                        var clean_url = url.substring(0, url.indexOf("?"));
                        window.history.replaceState({}, document.title, clean_url);
                    }
                });
            });
        });
    </script>

    <script>
        const refreshButton = document.getElementById("refreshTable");
        const table = document.getElementById("ordersTable");

        // Store the original table content when the page loads
        const originalTableContent = table.innerHTML;

        refreshButton.addEventListener("click", function() {
            // Call a function to refresh the table content with the original data
            refreshTable();
        });

        function refreshTable() {
            // Restore the original table content
            table.innerHTML = originalTableContent;
        }
    </script>

    <script>
        const startDateInput = document.getElementById("StartDateFilter");
        const lastDateInput = document.getElementById("LastDateFilter");
        const filterButton = document.getElementById("filterButton");

        filterButton.addEventListener("click", function() {
            filterAndCalculateTotal();
        });

        function filterAndCalculateTotal() {
            const startDate = new Date(startDateInput.value);
            const lastDate = new Date(lastDateInput.value);
            const rows = document.querySelectorAll("#ordersTable tbody tr");

            let totalSum = 0;

            rows.forEach(row => {
                const dateColumn = new Date(row.children[2].textContent);

                if (dateColumn >= startDate && dateColumn <= lastDate) {
                    row.style.display = "";

                    // Calculate the total sum for visible rows
                    const totalPrice = parseFloat(row.children[4].textContent);
                    totalSum += totalPrice;
                } else {
                    row.style.display = "none";
                }
            });

            alert("Total Sum of Sales ₱" + totalSum.toFixed(2));
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".Icon-close").forEach(function(button) {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    document.querySelector(".Show_Popup").style.display = "none";

                    // remove id parameter from the URL
                    var url = window.location.toString();
                    if (url.indexOf("?") > 0) {
                        var clean_url = url.substring(0, url.indexOf("?"));
                        window.history.replaceState({}, document.title, clean_url);
                    }
                });
            });
        });
    </script>


    <script>
        let printBtn = document.querySelector("#print");

        printBtn.addEventListener("click", function() {
            window.print(); // Print the content
        });
    </script>

    <!-- <script>
        function copyValue() {
            // Get the values of the first input
            var value1 = document.getElementById("idValue").value;

            // Set the value of the second input to the value of the first input
            document.getElementById("input2").value = value1;
        }
    </script>
    <script>
        document.querySelector(".update").addEventListener("click", function() {
            document.querySelector(".show_Update").style.display = "flex";
        });

        document.querySelector(".Icon-close").addEventListener("click", function() {
            document.querySelector(".show_Update").style.display = "none";
        });
    </script> -->
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
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const filterButton = document.getElementById("filterButton");
            const startDateFilter = document.getElementById("startDateFilter");
            const endDateFilter = document.getElementById("endDateFilter");
            const ordersTable = document.getElementById("ordersTable").getElementsByTagName("tbody")[0];

            filterButton.addEventListener("click", function() {
                const startDate = startDateFilter.value;
                const endDate = endDateFilter.value;

                // Initialize total earnings
                let totalEarnings = 0;

                // Loop through table rows and calculate total earnings for matching dates
                Array.from(ordersTable.rows).forEach(function(row) {
                    const dateColumn = row.cells[1].textContent;
                    const earningsColumn = parseFloat(row.cells[4].textContent);

                    if (dateColumn >= startDate && dateColumn <= endDate) {
                        totalEarnings += earningsColumn;
                        row.style.display = ""; // Show matching rows
                    } else {
                        row.style.display = "none"; // Hide non-matching rows
                    }
                });

                // Display the total earnings
                alert("Total Earnings: ₱" + totalEarnings.toFixed(2));
            });
        });
    </script> -->

</body>

</html>