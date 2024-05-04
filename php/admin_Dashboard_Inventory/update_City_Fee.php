<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

if (isset($_POST['start_Update_City'])) {
    $selected_City = $_POST['selected_City'];
    $location_Shipping_Fee = $_POST['location_Shipping_Fee'];

    $sql = "UPDATE cityshippingfee SET SHIPPING_FEE = '$location_Shipping_Fee' WHERE CITY = '$selected_City'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: ../../admin_Dashboard_Additem.php?msgIfUpdateSuccess=Updating Location delivery Fee : Successfully");
    } else {
        echo "Error updating record: " . $conn->error;
        header("Location: ../../admin_Dashboard_Additem.php?msgIfUpdateSuccess=Updating Location delivery Fee : Failed");
    }
}
