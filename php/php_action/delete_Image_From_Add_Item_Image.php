<?php
include('../connection/dbConnection.php');


if (isset($_REQUEST['start_Delete'])) {
    if (empty($_REQUEST['deleted_Checked_Id'])) {
        header("Location: ../../admin_Dashboard_Inventory.php?msg=No Image Selected, Deleting Image Failed");
    }
    $all_id = $_REQUEST['deleted_Checked_Id'];
    $extract_id = implode(',', $all_id);
    //echo $extract_id;

    $queryUnlink = "SELECT * FROM itemimages WHERE ID IN ($extract_id);";
    $unlinkStart = $conn->query($queryUnlink);

    if ($unlinkStart->num_rows > 0) {
        while ($row = $unlinkStart->fetch_assoc()) {
            unlink("../../img/itemPhotos/" . $row['ITEM_FILENAME']);
        }
    } else {
        header("Location: ../../admin_Dashboard_Inventory.php?msg=Images deleted Failed");
    }

    $query = "DELETE FROM itemimages WHERE ID IN ($extract_id) ";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        header("Location: ../../admin_Dashboard_Inventory.php?msg=Images deleted Successfully");
    } else {
        header("Location: ../../admin_Dashboard_Inventory.php?msg=Images deleted Failed");
    }
}
