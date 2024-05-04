<?php
// Replace these database connection settings with your own
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

// Check if item_id is provided in the POST request
$id = $_GET['itemIdRemove'];
echo $id;
// Prepare and execute the SQL query to remove the item from the cart
$sql = "DELETE FROM usercart WHERE ID = $id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    header("Location: user_Add_To_Cart.php?removeMessage= Item remove success");
} else {
    echo "Error deleting record: " . $conn->error;
    header("Location: user_Add_To_Cart.php?removeMessage= item remove failed");
}


// Close the database connection
