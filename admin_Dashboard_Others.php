<?php
include('php/connection/dbTemporary.php');
include('php/connection/dbConnection.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}

if (isset($_POST['submit_Image'])) {

    $change_Main_Image = time() . $_FILES["gcash_QR"]["name"];
    $name = $_POST['name'];
    $number2 = $_POST['number2'];
    $number = $_POST['number'];

    $final = $number2 . $number;

    $sqlss = "SELECT NUMBER FROM gcashimage WHERE NUMBER = $final";
    $resultss = $conn->query($sqlss);
    if ($resultss->num_rows > 0) {
        while ($rowss = $resultss->fetch_assoc()) {
            if ($rowss['NUMBER'] == $final) {
                header("Location: admin_Dashboard_Others.php?msgIfUpdateSuccess=Number already recorded!");
            }
        }
    } else {
        if (move_uploaded_file($_FILES['gcash_QR']['tmp_name'], 'img/companyGcash/' . $change_Main_Image)) {
            $target_file = '../../img/receipt/' . $change_Main_Image;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $picName = basename($_FILES["gcash_QR"]["name"]);
            $photo = time() . $picName;
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                header("Location: admin_Dashboard_Others.php?addMsg=Wrong File ");
            } else if ($_FILES["gcash_QR"]["size"] > 20000000) {
                header("Location: admin_Dashboard_Others.php?addMsg=To large File");
            } else {
                $picHasBeenUploaded = 1;
            }
        }
        // echo $extract_id;
        if ($picHasBeenUploaded == 1) {
            $sql = "INSERT INTO gcashimage 
            (IMAGE, NUMBER, GCASH_NAME)
            VALUES 
            ('$photo', '$final', '$name')";
            if ($conn->query($sql) === TRUE) {
                // echo "New record created successfully";
                header("Location: admin_Dashboard_Others.php?addMsg=Success : Placing Payment Reciept");
            } else {
                header("Location: admin_Dashboard_Others.php?addMsg=Error : Placing Order");
            }
        } else {
            unlink("../../img/receipt/" . $change_Main_Image);
            header("Location: admin_Dashboard_Others.php?addMsg=Error : Choose a right File!");
        }
        // header("Location: admin_Dashboard_Others.php?msgIfUpdateSuccess=Error : Adding Gcash!!");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin_Dashboard_Others.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.42.0/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts">


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
            <div style="background-color: #16324E;">
                <img id="iconBank" src="img/icons/others.png" alt="orders">
                <span id="textBank">Others</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()"><img src="img/icons/menu.png" alt="navigation Bar"></a>
            <h1>Others</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <?php
        if (isset($_GET['msgIfUpdateSuccess'])) { ?>
            <p class="msgIfUpdateSuccess"><?php echo $_GET['msgIfUpdateSuccess']; ?></p>
        <?php } ?>
        <div class="main_Con">
            <div class="gcash_Info">
                <div class="gcash_Table">
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <th>IMAGE</th>
                                <th>NUMBER</th>
                                <th>GCASH NAME</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM gcashimage;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr class="even-row">
                                        <td><img src="img/companyGcash/<?php echo $row['IMAGE']; ?>" alt=" "></td>
                                        <td><?php echo $row['NUMBER']; ?></td>
                                        <td><?php echo $row['GCASH_NAME']; ?></td>
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
                <div class="form_container">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <label for="number">GCASH NUMBER</label>
                        <br>
                        <input type="text" value="09" id="commondNum" required disabled>
                        <input type="text" name="number2" value="09" required hidden>
                        <input type="text" name="number" id="number" maxlength="9" minlength="9" required oninput="validateInput(event)">
                        <br>
                        <label for="name">GCASH NAME</label>
                        <br>
                        <input type="text" name="name" id="name" min="11" max="11" required>
                        <br>
                        <label for="gcash_QR" class="gcash_QR" required>
                            UPLOAD GCASH QR CODE IMAGE<br />
                            <img src="img/icons/receipt.png" alt=" ">
                            <input id="gcash_QR" type="file" name="gcash_QR" accept=".jpg, .jpeg, .png" required hidden>
                            <br />
                            <span id="imageName"></span>
                        </label>
                        <br>
                        <input type="submit" class="submit_Payment" name="submit_Image" value="SUBMIT">
                    </form>
                </div>
                <div class="form_container">
                    <form action="php/php_action/remove_Gcash_account.php">
                        <label for="itemRemoveCategory"><b>Remove Gcash Account</b></label>
                        <br>
                        <select name="itemRemoveCategory" id="idItemCategory">
                            <?php
                            $sqlForCategoryDelete = "SELECT * FROM gcashimage;";
                            $runSqlForCategoryDelete = mysqli_query($conn, $sqlForCategoryDelete);
                            if ($runSqlForCategoryDelete) {
                                while ($rowDeleteCategory = mysqli_fetch_array($runSqlForCategoryDelete)) {
                                    $fromDatabaseRowDeleteCategory = $rowDeleteCategory["NUMBER"];
                                    echo "<option>$fromDatabaseRowDeleteCategory</option>";
                                }
                            }
                            ?>
                        </select>
                        <br>
                        <input type="submit" value="Delete GCASH Account" name="submitToRemoveCategory" class="addCategoryClass" require>
                        <?php
                        if (isset($_GET['removingBrandMsg'])) { ?>
                            <p class="removingBrandMsg"><?php echo $_GET['removingBrandMsg']; ?></p>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <hr>
            <div class="discount_Con">
                <div class="form_container2">
                    <form action="php/php_action/voucher_Creator.php" method="post">
                        <label for="percent_Discount">Discount</label>
                        <br class="brake">
                        <input type="number" name="percent_Discount" id="percent_Discount" max="90" min="1" required>
                        <input type="text" id="displayDiscountValue" disabled>
                        <br>

                        <input type="submit" name="submit_Discount" class="submit_Discount">
                    </form>
                </div>
                <div class="vouchers">
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <th>DISCOUNT</th>
                                <th>CODE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM voucher;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr class="even-row">
                                        <td><?php echo $row['DISCOUNT']; ?>%</td>
                                        <td><?php echo $row['CODE']; ?></td>
                                        <td><?php echo $row['STATUS']; ?></td>
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
        // Add an event listener to the percent_Discount input
        document.getElementById('percent_Discount').addEventListener('input', function() {
            // Get the value entered in percent_Discount input
            var discountValue = this.value + "%";

            // Display the value in the displayDiscountValue input
            document.getElementById('displayDiscountValue').value = discountValue;
        });
    </script>
    <script>
        function validateInput(event) {
            const inputElement = event.target;
            const inputValue = inputElement.value;
            // Define a regular expression to allow only numbers
            const regex = /^[0-9]+$/;
            if (!regex.test(inputValue)) {
                // If the input doesn't match the regular expression, remove the last character
                inputElement.value = inputValue.slice(0, -1);
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let input = document.getElementById("gcash_QR");
            let imageName = document.getElementById("imageName");

            input.addEventListener("change", () => {
                let inputImage = input.files[0];

                if (inputImage) {
                    imageName.innerText = inputImage.name;
                } else {
                    imageName.innerText = ""; // Clear the text if no file is selected
                }
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