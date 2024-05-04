<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

if (isset($_REQUEST['idName'])) {
    $userId = $_GET['idName'];
    $checker = 0;

    $sql = "SELECT STATUS FROM veification WHERE USER_ID = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $checker = 1;
        }
    } else {
        echo "NO SUBMITTED ID FOUND?";
    }
    // Retrieve form data
    if ($checker == 1) {
        $sql = "UPDATE veification SET STATUS='FULLY VERIFIED' WHERE USER_ID =$userId";

        if (mysqli_query($conn, $sql)) {
            header("Location: admin_Dashboard_User_Verification.php?veriMessage= User verification success");

            // echo "Record updated successfully";
        } else {
            // echo "Error updating record: " . mysqli_error($conn);
            header("Location: admin_Dashboard_User_Verification.php?veriMessage= User verification failed");
        }
    }
}
