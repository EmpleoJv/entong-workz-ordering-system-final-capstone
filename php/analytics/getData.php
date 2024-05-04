<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

// $sql = "SELECT ITEM_ID, ORDERED_ITEM, item_count
//         FROM (
//             SELECT ITEM_ID, ORDERED_ITEM, COUNT(*) AS item_count
//             FROM orders
//             GROUP BY ITEM_ID, ORDERED_ITEM
//             ORDER BY item_count DESC
//         ) AS subquery
//         LIMIT 5";


$sql = "SELECT ITEM_ID, ORDERED_ITEM, item_count
        FROM (
            SELECT ITEM_ID, ORDERED_ITEM, COUNT(*) AS item_count
            FROM orders
            GROUP BY ITEM_ID, ORDERED_ITEM
            ORDER BY item_count DESC
        ) AS subquery
        LIMIT 5";





$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'ITEM_ID' => $row['ITEM_ID'],
            'ORDERED_ITEM' => $row['ORDERED_ITEM'],
            'item_count' => $row['item_count']
        );
    }
}

// Output the data as JSON
echo json_encode($data);

// Close the database connection if needed
// $conn->close();
