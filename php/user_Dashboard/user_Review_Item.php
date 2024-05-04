<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

$idofItem = $_GET['idOfTheItem'];

// if (isset($_REQUEST['submitReview'])) {

//     $reviewStar = $_POST['number_Stars'];
//     $reviewLegit = $_POST['costReview'];

//     $insert_query = mysqli_query($conn, "INSERT INTO itemreview SET 
//         ITEM_RATING='$reviewStar',
//         ITEM_REVIEW='$reviewLegit',
//         REVIEWER_ID='$tdbAdminId',
//         ITEM_ID ='$idofItem';");

//     if ($insert_query > 0) {
//         // header("Location: ../../user_Dashboard.php?addMsg=Order Success");
//         echo "GODD";
//     } else {
//         echo "BAD";
//         // header("Location: ../../user_Create_Account_Email.php?msgerror=Can't place Order, Try Again");
//     }
// }
if (isset($_REQUEST['submitReview'])) {

    $reviewStar = $_POST['number_Stars'];
    $reviewLegit = $_POST['costReview'];

    $insert_query = mysqli_query($conn, "INSERT INTO itemreview SET 
        ITEM_RATING='$reviewStar',
        ITEM_REVIEW='$reviewLegit',
        REVIEWER_ID='$tdbAdminId',
        ITEM_ID ='$idofItem';");

    if ($insert_query > 0) {
        header("Location: user_Buy_Orders.php?addMsg=Review Submitted Successfully");
        // echo "GODD";
    } else {
        header("Location: user_Buy_Orders.php?addMsg=Can't Register, Try Again");
        echo "badd";
    }
}
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
    <link rel="stylesheet" href="../../css/user_Review_Item.css">
</head>

<body>
    <main>
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
            <img src="../../img/icons/menu_Navy.png" alt="bar" onclick="openNav()">
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
        <a href="user_Buy_Orders.php"><button class="toback">Back</button></a>
        <form action="#" method="POST">
            <div class="review_Panel">
                <div class="card_Content" id="card_Content">
                    <?php
                    $sql = "SELECT * FROM items WHERE ITEM_ID = '$idofItem'";
                    $result = $conn->query($sql);

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <div class="image_Container">
                            <img src="../../img/itemPhotos/<?php echo $row['ITEM_IMAGE'] ?>" alt="Item Image">
                        </div>
                        <div class="info_Container">
                            <h1>NAME: <br></b><?php echo $row['ITEM_NAME'] ?></h1>
                        </div>
                    <?php

                    }

                    ?>
                </div>
                <div class="grid-container">
                    <div class="item1">
                        <h1>Rate Item</h1>
                        <div class="rate_Container">
                            <div class="rate">
                                <input type="radio" onclick="OneStarFunction()" id="star5" name="rate" value="5" hidden />
                                <label for="star5" title="5 Star"> </label>
                                <input type="radio" onclick="OneStarFunctions()" id="star4" name="rate" value="4" hidden />
                                <label for="star4" title="4 Star"> </label>
                                <input type="radio" onclick="OneStarFunctionss()" id="star3" name="rate" value="3" hidden />
                                <label for="star3" title="3 Star"> </label>
                                <input type="radio" onclick="OneStarFunctionsss()" id="star2" name="rate" value="2" hidden />
                                <label for="star2" title="2 Star"> </label>
                                <input type="radio" onclick="OneStarFunctionssss()" id="star1" name="rate" value="1" hidden />
                                <label for="star1" title="1 Star"> </label>
                            </div>
                        </div>
                    </div>
                    <div class="item2">
                        <input type="number" id="number_Stars" name="number_Stars" value="0" hidden />
                        <h1>Review Item</h1>

                        <div>
                            <textarea id="costReview" name="costReview" rows="9" cols="70" placeholder="Write a review"></textarea>
                            <input type="submit" name="submitReview" value="SUBMIT" class="submit">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</body>

<script>
    function OneStarFunction() {
        textField = document.getElementById("number_Stars");
        textField.value = 5;
    }

    function OneStarFunctions() {
        textField = document.getElementById("number_Stars");
        textField.value = 4;
    }

    function OneStarFunctionss() {
        textField = document.getElementById("number_Stars");
        textField.value = 3;
    }

    function OneStarFunctionsss() {
        textField = document.getElementById("number_Stars");
        textField.value = 2;
    }

    function OneStarFunctionssss() {
        textField = document.getElementById("number_Stars");
        textField.value = 1;
    }
</script>
<script>
    function openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }
</script>

</html>