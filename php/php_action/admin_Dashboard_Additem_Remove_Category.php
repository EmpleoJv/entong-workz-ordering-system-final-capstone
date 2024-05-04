<?php
include("../connection/dbConnection.php");

try {
    if (isset($_REQUEST['submitToRemoveCategory'])) {
        $removeCategory = $_REQUEST['itemRemoveCategory'];
        $insert_query = mysqli_query($conn, "DELETE FROM itemcategory WHERE CATEGORY='$removeCategory';");
        if ($insert_query > 0) {
            header("Location: ../../admin_Dashboard_Additem.php?removingCategoryMsg=Removing Item Category Success");
        } else {
            header("Location: ../../admin_Dashboard_Additem.php?removingCategoryMsg=Remove Item Failed!! Category still in use!!");
        }
    }
} catch (Exception $e) {
    header("Location: ../../admin_Dashboard_Additem.php?removingCategoryMsg=Remove Item Failed!!!!");
}
