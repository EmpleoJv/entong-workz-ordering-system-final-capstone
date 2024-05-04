<?php
// Include database connection and initialize variables
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

// Check if the form was submitted
if (isset($_POST['startSubmit'])) {
    // Get the form data
    $upMO = $_POST['upMO'];
    $upPA = $_POST['upPA'];

    // Update the user's address in the database
    $sql = "UPDATE userlogin SET
            MOBILE = '$upMO',
            PASSWORD = '$upPA'
            WHERE ID = $tdbAdminId";

    if ($conn->query($sql) === TRUE) {
        // Address updated successfully
        echo "Address updated successfully.";
        header("Location: user_Profile.php?msgInfoUpdate=Information updated Successfully");
    } else {
        // Error occurred while updating the address
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("Location: user_Profile.php?msgInfoUpdate=Information updated Failed");
    }
} else {
    // Form was not submitted, handle accordingly
    echo "Form was not submitted correctly.";
}

// Close the database connection
