<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

$id = $_GET['idfromDb'];

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: index.php');
}

// if (isset($_REQUEST['submit_Cart'])) {

//     // $orderHN = $_POST['houseName'];
//     // $orderPN = $_POST['provinceName'];
//     $insert_query = mysqli_query($conn, "INSERT INTO usercart SET 
//                             ITEM_ID='$id;',
//                             USER_ID='$tdbAdminId';");

//     if ($insert_query > 0) {
//         // header("Location: ../../user_Dashboard.php?addMsg=Order Success");
//         echo "GODD";
//     } else {
//         echo "BAD";
//         // header("Location: ../../user_Create_Account_Email.php?msgerror=Can't place Order, Try Again");
//     }
// }



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/user_Specific_Item.css">

</head>

<body>
    <nav>
        <h1>Entong Workz</h1>
        <ul>
            <li><a href="../../user_Dashboard.php">HOME</a></li>
            <li><a href="user_Budget_Calculator.php">BUDGETER</a></li>
            <li><a href="user_Add_To_Cart.php">CART</a></li>
            <li><a href="user_Buy_Orders.php">ORDERS</a></li>
            <li><a href="user_Profile.php">PROFILE</a></li>
            <li><a href="user_Customer_Support.php">SUPPORT</a></li>
            <li><a href="../php_action/user_logout.php">LOGOUT</a></li>
        </ul>
        <img src="../../img/icons/menu.png" alt="bar" onclick="openNav()">
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <li><a href="../../user_Dashboard.php">HOME</a></li>
                <li><a href="user_Budget_Calculator.php">BUDGETER</a></li>
                <li><a href="user_Add_To_Cart.php">CART</a></li>
                <li><a href="user_Buy_Orders.php">ORDERS</a></li>
                <li><a href="user_Profile.php">PROFILE</a></li>
                <li><a href="user_Customer_Support.php">SUPPORT</a></li>
                <li><a href="../php_action/user_logout.php">LOGOUT</a></li>
            </div>
        </div>
    </nav>
    <div class="mainPanel">

        <div class="main_Document">
            <?php
            ?>
            <?php
            $sqlQuery = "SELECT * FROM items WHERE ITEM_STATUS = 'SHOW' AND ITEM_ID = $id;";
            $runSql = mysqli_query($conn, $sqlQuery);
            while ($row = mysqli_fetch_array($runSql)) {
            ?>
                <div class="upper">
                    <div>
                        <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">

                    </div>
                    <?php
                    if ($row['ITEM_QUANTITY'] == 0) {
                    ?>
                        <a href="user_Buy_Now.php?idfromDb=<?php echo $row['ITEM_ID'] ?>"><button style="background-color: gray;" disabled>No Stock!</button></a>
                        <a href="user_Add_To_Cart_Start.php?itemID=<?php echo $row['ITEM_ID'] ?>&itemName=<?php echo $row['ITEM_NAME'] ?>&itemImage=<?php echo $row['ITEM_IMAGE'] ?>&itemDescription=<?php echo $row['ITEM_DESCRIPTION'] ?>&itemQuantity=<?php echo $row['ITEM_QUANTITY'] ?>&itemPrice=<?php echo $row['ITEM_PRICE'] ?>"><button style="background-color: gray;" disabled>NO STOCK</button></a>
                    <?php
                    } else if ($row['ITEM_QUANTITY'] != 0) {
                    ?>
                        <a href="user_Buy_Now.php?idfromDb=<?php echo $row['ITEM_ID'] ?>"><button>Buy Now!</button></a>

                        <a href="user_Add_To_Cart_Start.php?itemID=<?php echo $row['ITEM_ID'] ?>&itemName=<?php echo $row['ITEM_NAME'] ?>&itemImage=<?php echo $row['ITEM_IMAGE'] ?>&itemDescription=<?php echo $row['ITEM_DESCRIPTION'] ?>&itemQuantity=<?php echo $row['ITEM_QUANTITY'] ?>&itemPrice=<?php echo $row['ITEM_PRICE'] ?>&itemCat=<?php echo $row['ITEM_CATEGORY'] ?>"><button>Add To Cart</button></a>
                    <?php
                    }
                    ?>

                </div>
                <div class="lower">
                    <h1 class="name">Name</h1>
                    <h1 class="name"><?php echo $row['ITEM_NAME'] ?></h1>
                    <br>
                    <h1 class="description">Description</h1>
                    <h1 class="description"><?php echo $row['ITEM_DESCRIPTION'] ?></h1>
                    <br>
                    <div class="document">
                        <div>
                            <h1>Category :</h1>
                            <h1><?php echo $row['ITEM_CATEGORY']; ?></h1>
                        </div>
                        <div>
                            <h1>Brand :</h1>
                            <h1><?php echo $row['ITEM_BRAND']; ?></h1>
                        </div>
                        <div>
                            <h1>Quantity :</h1>
                            <h1>Only x<?php echo $row['ITEM_QUANTITY']; ?> items left</h1>
                        </div>
                        <div>
                            <h1>Price :</h1>
                            <h1 class="price_Content">₱<?php echo number_format($row['ITEM_PRICE'], 2) ?></h1>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="gallery_Container">
            <div class="grid-container">
                <?php
                $sqlQuery = "SELECT * FROM itemimages WHERE ITEM_ID = $id;";
                $runSql = mysqli_query($conn, $sqlQuery);
                while ($row = mysqli_fetch_array($runSql)) {
                ?>
                    <div class="grid-item">
                        <img src="../../img/itemPhotos/<?php echo $row['ITEM_FILENAME'] ?>" alt="Item Image">
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="reviews">
            <h1>Item Reviews</h1>
            <?php
            $sqlQuery = "SELECT * FROM itemreview WHERE ITEM_ID = $id;";
            $runSql = mysqli_query($conn, $sqlQuery);
            while ($row = mysqli_fetch_array($runSql)) {
            ?>
                <div class="reviews_Container">
                    <div>
                        <div class="star_Container">
                            <?php
                            if ($row['ITEM_RATING'] == 1) {
                            ?>
                                <img src="../../img/icons/star.png" alt="star">
                            <?php
                            } else if ($row['ITEM_RATING'] == 2) {
                            ?>
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">

                            <?php
                            } else if ($row['ITEM_RATING'] == 3) {
                            ?>
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">

                            <?php
                            } else if ($row['ITEM_RATING'] == 4) {
                            ?>
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                            <?php
                            } else if ($row['ITEM_RATING'] == 5) {
                            ?>
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                                <img src="../../img/icons/star.png" alt="star">
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="comment_Container">
                        <!-- <h4>Comment</h4> -->
                        <h1 class="comment"><?php echo $row['ITEM_REVIEW']; ?></h1>
                    </div>
                    <!-- <h1> <?php echo $row['REVIEWER_ID']; ?></h1> -->
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
</body>


</html>