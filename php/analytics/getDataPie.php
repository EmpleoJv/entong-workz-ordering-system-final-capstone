<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

// Query to get total count of orders
$sqlTotalCount = "SELECT COUNT(*) as total_count FROM orders";
$resultTotalCount = $conn->query($sqlTotalCount);
$totalCount = $resultTotalCount->fetch_assoc()['total_count'];

// Query to get data from the database, including conditional count based on ORDER_TYPE_ID
$sql = "SELECT 
            SUM(CASE WHEN ORDER_TYPE_ID = 'WALK IN' THEN 1 ELSE 0 END) as walk_in_count,
            SUM(CASE WHEN ORDER_TYPE_ID != 'WALK IN' THEN 1 ELSE 0 END) as other_count
        FROM orders";

$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        "name" => "WALK IN",
        "data" => intval(($row['walk_in_count'] / $totalCount) * 100)
    );
    $data[] = array(
        "name" => "Other",
        "data" => intval(($row['other_count'] / $totalCount) * 100)
    );
}

echo json_encode($data);
