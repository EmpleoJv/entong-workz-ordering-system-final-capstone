<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
$picHasBeenUploaded = 0;
$id = $_GET['id']; //this is from adminAddUser.php

try {
    if (isset($_REQUEST['sumbitToUpdate'])) {

        $AddUser_firstname = $_REQUEST['firstname'];
        $AddUser_lastname = $_REQUEST['lastname'];
        $AddUser_user = $_REQUEST['email'];
        $AddUser_password = $_REQUEST['password'];
        $AddUser_level = $_REQUEST['levellist'];


        $insert_query = "UPDATE companylogin SET FIRSTNAME='$AddUser_firstname', LASTNAME='$AddUser_lastname', EMAIL='$AddUser_user', PASSWORD='$AddUser_password', LEVEL='$AddUser_level'  WHERE ID = $id;";
        if ($conn->query($insert_query) === TRUE) {
            if ($AddUser_level === 'staff') {
                header("Location: staff.php?msg= User Edit Successfully!!");
            } else if ($AddUser_level === 'logistic') {
                header("Location: logistic.php?msg= User Edit Successfully!!");
            }
        } else {
            header("Location: adminUserDashStaff.php?msgIfUpdateSuccess= User Edit Failed");
        }
    }
} catch (Exception $e) {
    echo $e;
}


$picHasBeenUploaded = 0;

if (isset($_POST['submit_to_Change_Main_Image'])) {
    $change_Main_Image = time() . $_FILES["file_Main_Image"]["name"];


    if (move_uploaded_file($_FILES['file_Main_Image']['tmp_name'], '../../img/companyUser/' . $change_Main_Image)) {
        $target_file = '../../img/companyUser/' . $change_Main_Image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picName = basename($_FILES["file_Main_Image"]["name"]);
        $photo = time() . $picName;
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: ../../admin_Dashboard_User.php?msg=Wrong File ");
        } else if ($_FILES["file_Main_Image"]["size"] > 20000000) {
            header("Location: ../../admin_Dashboard_User.php?msg=To large File");
        } else {
            $picHasBeenUploaded = 1;
        }
    }
    // echo $extract_id;

    if ($picHasBeenUploaded == 1) {
        $linkQuery = "SELECT IMAGE FROM companylogin WHERE ID = $id;";
        $linkImage = $conn->query($linkQuery);

        if ($linkImage->num_rows > 0) {
            while ($row = $linkImage->fetch_assoc()) {
                unlink("../../img/itemPhotos/" . $row['ITEM_IMAGE']);
            }
        }

        $fSql = "UPDATE companylogin SET IMAGE = '$photo' WHERE ID = $id;";
        $selectQuery_Run = mysqli_query($conn, $fSql);

        if ($selectQuery_Run) {
            header("Location: ../../admin_Dashboard_User.php?msg=Images deleted and updated Successfully");
        } else {
            header("Location: ../../admin_Dashboard_User.php?msg=Images deleted and updated Failed");
        }
    } else {
        unlink("../../img/companyUser/" . $change_Main_Image);

        header("Location: ../../admin_Dashboard_User.php?msg=Error : Choose a right File!");
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
    <link rel="stylesheet" href="../../css/logistic_staff_Edit.css">

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
            <h1>EDIT STAFF/LOGISTIC</h1>
            <a href="../php_action/admin_logout.php" class="logout">logout</a>

        </nav>

        <?php
        if (isset($_GET['msg'])) { ?>
            <p class="msg"><?php echo $_GET['msg']; ?></p>
        <?php } ?>
        <?php
        $sql = "SELECT * FROM companylogin WHERE ID = $id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        ?>
        <div class="form_Container">
            <div class="img_Container">
                <h1 class="title">Edit Image</h1>
                <img src="../../img/companyUser/<?php echo $row["IMAGE"] ?>" alt="Image">
                <form action="#" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file_Main_Image">
                    <br>
                    <input type="submit" name="submit_to_Change_Main_Image" class="sumit_Image_Update">
                </form>
                <hr>

            </div>
            <form action="#" method="POST" class="main_Form">
                <h1 class="title">Edit User</h1>
                <label for="firstname">Firstname</label>
                <br>
                <input type="text" name="firstname" value="<?php echo $row["FIRSTNAME"] ?>" required>
                <br>
                <label for="lastname">Lastname</label>
                <br>
                <input type="text" name="lastname" value="<?php echo $row["LASTNAME"] ?>" required>
                <br>
                <label for="email">Username</label>
                <br>
                <input type="text" name="email" value="<?php echo $row["EMAIL"] ?>" required>
                <br>
                <label for="password">Password</label>
                <br>
                <input type="text" name="password" value="<?php echo $row["PASSWORD"] ?>" required>
                <br>
                <label for="level">Level</label>
                <br>
                <select id="level" name="levellist">
                    <option value="staff"><?php echo $row['LEVEL'] ?></option>

                    <option value="staff">staff</option>
                    <option value="logistic">logistic</option>

                </select>
                <br>
                <input type="submit" value="Update" name="sumbitToUpdate" class="submitToUpdate" required>
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