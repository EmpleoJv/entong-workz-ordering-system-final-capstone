<?php
include("../connection/dbConnection.php");

try {
    if (isset($_REQUEST['submitToRemoveCategory'])) {
        $removeCategory = $_REQUEST['itemRemoveCategory'];
        $insert_query = mysqli_query($conn, "DELETE FROM itembrand WHERE BRANDS='$removeCategory';");
        if ($insert_query > 0) {
            header("Location: ../../staff_Dashboard_Additem.php?removingBrandMsg=Removing Item Category Success");
        } else {
            header("Location: ../../staff_Dashboard_Additem.php?removingBrandMsg=Remove Item Failed!! Category still in use!!");
        }
    }
} catch (Exception $e) {
    header("Location: ../../staff_Dashboard_Additem.php?removingBrandMsg=Remove Item Failed!!!!");
}
