<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

$itemID = $_GET['itemID'];

$itemNAME = $_GET['itemName'];
$itemIMAGE = $_GET['itemImage'];
$itemDESCRIPTION = $_GET['itemDescription'];
// $itemQUANTITY = $_GET['itemQuantity'];
$itemPRICE = $_GET['itemPrice'];
$itemCat = $_GET['itemCat'];

// $orderHN = $_POST['houseName'];
// $orderPN = $_POST['provinceName'];
$sql = "SELECT ITEM_ID FROM usercart WHERE ITEM_ID = $itemID AND USER_ID = $tdbAdminId;";
$result = $conn->query($sql);
$checker = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "good";
        // $itemIDForChecker = $row['ITEM_ID'];
        // $userIDForChecker = $row['USER_ID'];

        // if ($itemIDForChecker === $itemID and $userIDForChecker === $tdbAdminId) {
        $checker = 1;
        //     break;
        break;
        // }
    }

    if ($checker == 1) {
        $sqlAddingQuantity = "UPDATE usercart SET ORDER_QUANTITY = ORDER_QUANTITY + 1 WHERE ITEM_ID = $itemID AND USER_ID = $tdbAdminId;";
        if ($conn->query($sqlAddingQuantity) === true) {
            header("Location: user_Add_To_Cart.php?selectItemMessage=Item Successfully Added");
            echo "Good";
        } else {
            header("Location: user_Specific_Item.php?selectItemMessage=Add to cart Failed");
        }
    }
} else {
    $insert_query = mysqli_query($conn, "INSERT INTO usercart SET 
    ITEM_ID='$itemID',
    ITEM_NAME='$itemNAME',
    ITEM_IMAGE='$itemIMAGE',
    ITEM_DESCRIPTION='$itemDESCRIPTION',
    ITEM_CATEGORY='$itemCat',
    -- ITEM_QUANTITY='$itemQUANTITY',
    ITEM_PRICE='$itemPRICE',
    ORDER_QUANTITY='1',
    USER_ID='$tdbAdminId';");

    if ($insert_query > 0) {
        header("Location: user_Add_To_Cart.php?selectItemMessage=Item Successfully Added");
        echo "GODD";
    } else {
        echo "BAD";
        header("Location: user_Specific_Item.php?selectItemMessage=Add to cart Failed");
    }
}
