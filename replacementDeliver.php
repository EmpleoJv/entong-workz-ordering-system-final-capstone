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
    <link rel="stylesheet" href="css/logistic_Dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.0.3/html5-qrcode.min.js"></script>

    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>

</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Logistic</h1>
        <div class="profile">
            <a href="#">
                <img src="img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";
                ?>
            </a>
        </div>
        <a href="logistic_Dashboard.php" class="list">
            <div>
                <img id="iconDss" src="img/icons/deliver.png" alt="dss">
                <span id="textDss">DELIVERY ORDERS</span>
            </div>
        </a>
        <a href="replacementDeliver.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconDss" src="img/icons/free.png" alt="dss">
                <span id="textDss">REPLACEMENT</span>
            </div>
        </a>

    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>REPLACEMENT DELIVERY</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <div class="refreshButton">
            <a href="logistic_Dashboard.php">
                <button id="refreshButton">Scan Again!</button>
            </a>
        </div>
        <br>

        <div class="mainers">
            <div id="reader"></div>
            <div id="result"></div>
        </div>
        <div class="formContainer">
            <h2 id="sign">NO ACTIVE CODE</h2>
            <form action="php/php_action/logistic_Delivery_Success_Replace.php" method="get">
                <!-- <label for="code">Order Code</label> -->
                <input type="password" id="code" name="code" hidden>
                <input type="submit" name="delivered" value="SUBMIT" id="deliveryForm" disabled>
            </form>
            <?php
            if (isset($_GET['error'])) { ?>
                <h4 class="error"><?php echo $_GET['error']; ?></h4>
            <?php } ?>
        </div>

        <div class="allOrder" id="allOrder">
            <div class="allOrdersContainer">
                <h1 class="allOrdersTitle">TO DELIVER</h1>
                <!-- <label for="searchAllOrder">Search</label>
                <input type="text" name="searchAllOrdersName" id="searchAllOrder" placeholder="Search..."> -->
                <input type="text" id="searchBar" onkeyup="searchTable()" placeholder="Search the Order ID...">

            </div>

            <table id="ordersTable">

                <thead>
                    <tr>
                        <th>CODE</th>
                        <th>PACKAGE STATUS</th>
                        <th>NUMBER</th>
                        <th>ORDER BY</th>
                        <th>ACCEPTED BY</th>
                        <th>ADDITIONAL INFORMATION</th>
                        <th>PROVINCE</th>
                        <th>CITYMUNICIPALITY</th>
                        <th>BARANGAY</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM returnitem WHERE STATUS = 'REPLACEMENT ACCEPTED';";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $ordercode = $row['ORDERCODE'];
                            $userID = $row['USER_ID'];
                            $acceptby = $row['ACCEPTED_BY'];

                    ?>
                            <tr class="even-row">
                                <td><?php echo $row['ORDERCODE']; ?></td>
                                <td><?php echo $row['STATUS']; ?></td>
                                <td><?php echo $row['NUMBER']; ?></td>
                                <td>
                                    <?php
                                    if (isset($userID) && !empty($userID)) {
                                        $sqlsss = "SELECT * FROM userlogin WHERE ID = $userID";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $user";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($acceptby) && !empty($acceptby)) {
                                        $sqlsss = "SELECT * FROM companylogin WHERE ID = $acceptby";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['FIRSTNAME'] . " " . $rowsss['LASTNAME'];
                                        } else {
                                            echo "No data found for ID $user";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (isset($userID) && !empty($userID)) {
                                        $sqlsss = "SELECT * FROM userlogin WHERE ID = $userID";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['ADDITIONAL_INFORMATION'];
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
                                    if (isset($userID) && !empty($userID)) {
                                        $sqlsss = "SELECT * FROM userlogin WHERE ID = $userID";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['PROVINCE'];
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
                                    if (isset($user) && !empty($userID)) {
                                        $sqlsss = "SELECT * FROM userlogin WHERE ID = $userID";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['CITY_MUNICIPALITY'];
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
                                    if (isset($userID) && !empty($userID)) {
                                        $sqlsss = "SELECT * FROM userlogin WHERE ID = $userID";
                                        $resultsss = $conn->query($sqlsss);
                                        if ($resultsss === false) {
                                            echo "Not yet accepted";
                                        }
                                        $rowsss = $resultsss->fetch_assoc();
                                        if ($rowsss) {
                                            echo  $rowsss['BARANGAY'];
                                        } else {
                                            echo "No data found for ID $idForStatus";
                                        }
                                    } else {
                                        echo "Not yet Accepted";
                                    }
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

    </main>
    <script>
        function searchTable() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchBar");
            filter = input.value.toUpperCase();
            table = document.getElementById("ordersTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Change the index to the column you want to search

                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <!-- <script>
        // Get the button element
        const refreshButton = document.getElementById('refreshButton');

        // Add a click event listener to the button
        refreshButton.addEventListener('click', function() {
            // Reload the current page
            location.reload();
        });
    </script> -->
    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 250,
                height: 250,
            },
            fps: 20,
        });

        scanner.render(success, error)

        function success(result) {

            // document.getElementById('result').innerHTML = `<h2>Success!</h2> 
            //     <p><a href="${result}">${result}</a></p>
            //     `;
            document.getElementById('code').value = result;
            document.getElementById('deliveryForm').disabled = false;

            document.getElementById('sign').innerHTML = 'SCANNED';
            document.getElementById('sign').style.color = 'green';




            scanner.clear();
            document.getElementById('reader').remove();

        }

        function error(err) {
            console.error(err);
        }
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