<?php
include("../connection/dbConnection.php");

$addingStarter = 0;

if (isset($_REQUEST['submitToAddCategory'])) {
    $addCategory = $_REQUEST['addCategory'];

    $sqlQuery = 'SELECT CATEGORY FROM itemcategory';
    $runSql = mysqli_query($conn, $sqlQuery);
    while ($row = mysqli_fetch_array($runSql)) {
        if ($row['CATEGORY'] === $addCategory) {
            header("Location: ../../staff_Dashboard_Additem.php?addCategoryMsg=Duplicated Category Taken");
            $addingStarter = 1;
        }
    }

    if ($addingStarter == 0) {
        $insert_query = mysqli_query($conn, "INSERT INTO itemcategory SET CATEGORY='$addCategory';");
        if ($insert_query > 0) {
            header("Location: ../../staff_Dashboard_Additem.php?addCategoryMsg= Add Item Successfully!!");
        } else {
            header("Location: ../../staff_Dashboard_Additem.php?addCategoryMsg= Add Item Failed!!");
        }
    }
}
