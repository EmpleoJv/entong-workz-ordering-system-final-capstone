<?php
include("../connection/dbConnection.php");
$picHasBeenUploaded = 0;

if (isset($_REQUEST['sumbitToAddItem'])) {

    $AddItem_itemName = $_REQUEST['itemName'];
    $AddItem_itemDescription = $_REQUEST['itemDescription'];
    $AddItem_itemQuantity = $_REQUEST['itemQuantity'];
    $AddItem_itemPrice = $_REQUEST['itemPrice'];
    $AddItem_itemCategory = $_REQUEST['itemCategory'];
    $AddItem_itemBrand = $_REQUEST['itemBrand'];
    $AddItem_itemShippingFee = $_REQUEST['itemShippingFee'];


    $AddUser_itemImage = time() . $_FILES["itemImage"]["name"];
    $AddItem_status = "HIDE";

    if (move_uploaded_file($_FILES['itemImage']['tmp_name'], '../../img/itemPhotos/' . $AddUser_itemImage)) {
        $target_file = '../../img/itemPhotos/' . $AddUser_itemImage;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picName = basename($_FILES["itemImage"]["name"]);
        $photo = time() . $picName;
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: ../../admin_Dashboard_Additem.php?addMsg=Wrong File ");
        } else if ($_FILES["itemImage"]["size"] > 20000000) {
            header("Location: ../../admin_Dashboard_Additem.php?addMsg=To large File");
        } else {
            $sql = "SELECT * FROM items";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
              // output data of each row
                while($row = $result->fetch_assoc()) {
                    $name = $row['ITEM_NAME'];
                    if($name == $AddItem_itemName){
                        $picHasBeenUploaded = 0;       
                        break;
                        header("Location: ../../staff_Dashboard_Additem.php?addMsg=It has similar name!");
                    }else{
                        $picHasBeenUploaded = 1;       
                    }
                }
            } 
            // $picHasBeenUploaded = 1;
        }
    }

    if ($picHasBeenUploaded == 1) {
        $insert_query = mysqli_query($conn, "INSERT INTO items SET 
        ITEM_NAME='$AddItem_itemName', 
        ITEM_DESCRIPTION='$AddItem_itemDescription', 
        ITEM_QUANTITY='$AddItem_itemQuantity', 
        ITEM_CATEGORY='$AddItem_itemCategory', 
        ITEM_BRAND='$AddItem_itemBrand', 
        ITEM_PRICE='$AddItem_itemPrice',
        ITEM_SHIPPING_FEE='$AddItem_itemShippingFee',
        ITEM_IMAGE='$photo',
        ITEM_STATUS='$AddItem_status';");

        if ($insert_query > 0) {
            header("Location: ../../staff_Dashboard_Additem.php?addMsg=Add Item Successfully");
        } else {
            unlink("../../img/itemPhotos/" . $photo);

            header("Location: ../../staff_Dashboard_Additem.php?addMsg=Can't Add Item");
        }
    } else {
        unlink("../../img/itemPhotos/" . $photo);

        header("Location: ../../staff_Dashboard_Additem.php?addMsg=Can't Add Item");
    }
}
