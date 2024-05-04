<?php
$dbServerName = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "capstone";

$conn = mysqli_connect($dbServerName, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Include your database connection code here (as you provided earlier)

// Check if the voucher code is valid (replace this with your validation logic)
$voucherCode = $_POST['voucherCode'];
$isValidResult = isValidVoucher($conn, $voucherCode);

if ($isValidResult['isValid']) {
    $discount = $isValidResult['discount']; // Retrieve the discount value
    echo "Voucher code is valid! Discount: $discount"; // Print the discount value
} else {
    echo "Invalid voucher code.";
}

function isValidVoucher($conn, $code)
{
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM voucher WHERE CODE = ? AND STATUS = 'UNUSED'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            // Voucher code found, you can perform further checks here
            while ($row = $result->fetch_assoc()) {
                if ($row['CODE'] === $code) {
                    // Handle fully verified voucher code logic here
                    return [
                        'isValid' => true,
                        'discount' => $row['DISCOUNT'] . '%' // Return the discount value

                    ];
                }
            }
        }
    }

    return [
        'isValid' => false,
        'discount' => 0 // Return a default value for discount if the voucher is not valid or not found
    ];
}
