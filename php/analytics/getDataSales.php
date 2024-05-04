<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');


$query = "SELECT YEAR(ORDER_DATE) AS year, SUM(SALES) AS sales
          FROM ordercode
          WHERE PACKAGE_STATUS = 'ORDER SUCCESS'
          GROUP BY YEAR(ORDER_DATE)
          ORDER BY year";

$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {

    $data[] = $row;
}

// Close the database connection

// Return data as JSON
echo json_encode($data);
