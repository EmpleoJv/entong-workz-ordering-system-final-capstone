<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

$sql = "SELECT CODE FROM support;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Create an array to store unique values
    $uniqueValues = array();

    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $code = $row['CODE'];

        // Check if the value is unique
        if (!in_array($code, $uniqueValues)) {
            $uniqueValues[] = $code;
            $sqlss = "SELECT * FROM userlogin WHERE ID = $code;";
            $resultss = $conn->query($sqlss);
            if ($resultss->num_rows > 0) {
                // output data of each row
                while ($rowss = $resultss->fetch_assoc()) {
?>
                    <a href="admin_Dashboard_ChatBox_Start.php?messageCode=<?php echo $code; ?>" style="text-decoration: none;">
                        <div class="block_main_Container">
                            <div class="img_Container">
                                <img src="../../img/userImage/<?php echo $rowss['IMAGE']; ?>" alt="User Image" class="img_Profile">
                            </div>
                            <div class="info_Container">
                                <h2 class="name"><?php echo $rowss['FIRSTNAME'] . " " . $rowss['LASTNAME'] ?></h2>
                            </div>
                        </div>
                    </a>
<?php
                }
            } else {
                // echo "0 results";
            }
        }
    }
} else {
    // echo "0 results";
}
