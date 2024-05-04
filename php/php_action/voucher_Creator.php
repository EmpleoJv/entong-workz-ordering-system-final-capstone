<?php
include("../connection/dbConnection.php");

if (isset($_REQUEST['submit_Discount'])) {
    $percent_Discount = $_REQUEST['percent_Discount'];

    $randomLetters = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
    $randomLetters = strtoupper($randomLetters);
    echo $randomLetters;

    $randomNumber1 = rand(100, 999); // Adjust the range as needed

    $insert_query = mysqli_query($conn, "INSERT INTO voucher SET DISCOUNT='$percent_Discount', CODE='$randomLetters$randomNumber1', STATUS='UNUSED';");
    if ($insert_query > 0) {
        header("Location: ../../admin_Dashboard_Others.php?msgIfUpdateSuccess= Add Voucher Successfully!!");
    } else {
        header("Location: ../../admin_Dashboard_Others.php?msgIfUpdateSuccess= Add Voucher Failed!!");
    }
}
