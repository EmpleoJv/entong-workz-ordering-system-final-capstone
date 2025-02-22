<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
$id = $_GET['id']; //this is from adminAddUser.php

// if (isset($_REQUEST['sumbitToUpdateItem'])) {
//     $UpdateItem_itemName = $_REQUEST['itemName'];
//     $UpdateItem_itemDescription = $_REQUEST['itemDescription'];
//     $UpdateItem_itemCategory = $_REQUEST['itemCategory'];
//     $UpdateItem_itemBrand = $_REQUEST['itemBrand'];

//     $UpdateItem_itemPrice = $_REQUEST['itemPrice'];

//     $insert_query = "UPDATE items SET ITEM_NAME='$UpdateItem_itemName', ITEM_DESCRIPTION='$UpdateItem_itemDescription', ITEM_CATEGORY='$UpdateItem_itemCategory', ITEM_BRAND='$UpdateItem_itemBrand', ITEM_PRICE='$UpdateItem_itemPrice' WHERE ITEM_ID = $id;";
//     if ($conn->query($insert_query) === TRUE) {
//         header("Location: hidden.php?msg= Edit Item Successfully");
//     } else {
//         header("Location: hidden.php?msg= Edit Item Failed");
//     }
// }

// $picHasBeenUploaded = 0;

// if (isset($_POST['submit_to_Change_Main_Image'])) {
//     $change_Main_Image = time() . $_FILES["file_Main_Image"]["name"];


//     if (move_uploaded_file($_FILES['file_Main_Image']['tmp_name'], '../../img/itemPhotos/' . $change_Main_Image)) {
//         $target_file = '../../img/itemPhotos/' . $change_Main_Image;
//         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//         $picName = basename($_FILES["file_Main_Image"]["name"]);
//         $photo = time() . $picName;
//         if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
//             header("Location: hidden.php?msg=Wrong File ");
//         } else if ($_FILES["file_Main_Image"]["size"] > 20000000) {
//             header("Location: hidden.php?msg=To large File");
//         } else {
//             $picHasBeenUploaded = 1;
//         }
//     }
//     // echo $extract_id;

//     if ($picHasBeenUploaded == 1) {
//         $linkQuery = "SELECT ITEM_IMAGE FROM items WHERE ITEM_ID = $id;";
//         $linkImage = $conn->query($linkQuery);

//         if ($linkImage->num_rows > 0) {
//             while ($row = $linkImage->fetch_assoc()) {
//                 unlink("../../img/itemPhotos/" . $row['ITEM_IMAGE']);
//             }
//         }

//         $fSql = "UPDATE items SET ITEM_IMAGE = '$photo' WHERE ITEM_ID = $id;";
//         $selectQuery_Run = mysqli_query($conn, $fSql);

//         if ($selectQuery_Run) {
//             header("Location: hidden.php?msg=Images deleted and updated Successfully");
//         } else {
//             header("Location: hidden.php?msg=Images deleted and updated Failed");
//         }
//     } else {
//         unlink("../../img/itemPhotos/" . $change_Main_Image);

//         header("Location: hidden.php?msg=Error : Choose a right File!");
//     }
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/all_item_View.css">

    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Staff</h1>
        <div class="profile">
            <a href="../../admin_Dashboard.php">
                <img src="../../img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";
                ?>
            </a>
        </div>
        <a href="../../staff_Dashboard_Walkin.php" class="list">
            <div>
                <img id="iconUser" src="../../img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="../../staff_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="../../img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="../../staff_Dashboard_Inventory.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconInven" src="../../img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="../../staff_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/cash.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="../../img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>EDIT ITEM</h1>
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
            $forBrand = $rowQuery["ITEM_BRAND"];
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
                        <h5>Item Brand</h5>
                        <hr>
                        <h6><?php echo $rowQuery['ITEM_BRAND'] ?></h6>
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