<?php
// Include database connection and initialize variables
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

// Check if the form was submitted
if (isset($_POST['start_Address_Update'])) {
    // Get the form data
    $additionalInformation = $_POST['regAddition'];
    $province = $_POST['regProvince'];
    $cityMunicipality = $_POST['regCity'];
    $barangay = $_POST['regBarangay'];
    $userId = 1; // Replace with the actual user identifier

    // Update the user's address in the database
    $sql = "UPDATE userlogin SET
            ADDITIONAL_INFORMATION = '$additionalInformation',
            PROVINCE = '$province',
            CITY_MUNICIPALITY = '$cityMunicipality',
            BARANGAY = '$barangay'
            WHERE ID = $tdbAdminId";

    if ($conn->query($sql) === TRUE) {
        // Address updated successfully
        echo "Address updated successfully.";
        header("Location: user_Profile.php?msgAddressUpdate=Address updated Successfully");
    } else {
        // Error occurred while updating the address
        echo "Error: " . $sql . "<br>" . $conn->error;
        header("Location: user_Profile.php?msgAddressUpdate=Address updated Failed");
    }
} else {
    // Form was not submitted, handle accordingly
    echo "Form was not submitted correctly.";
}
// Close the database connection