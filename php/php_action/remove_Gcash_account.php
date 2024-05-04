<?php
include("../connection/dbConnection.php");

if (isset($_REQUEST['submitToRemoveCategory'])) {
    $removeCategory = $_REQUEST['itemRemoveCategory'];
    $insert_query = mysqli_query($conn, "DELETE FROM gcashimage WHERE NUMBER='$removeCategory';");
    if ($insert_query > 0) {
        header("Location: ../../admin_Dashboard_Others.php?msgIfUpdateSuccess=Removing GCASH Account Success");
    } else {
        header("Location: ../../admin_Dashboard_Others.php?msgIfUpdateSuccess=Removing GCASH Account Failed");
    }
}
