<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

$sql = "SELECT * FROM support WHERE CODE = $tdbAdminId ORDER BY 1 ASC;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['REPLY_BY'])) {
            // $var has a value
?>
            <div class="div_company_Message">
                <p class="company_Message">
                    Support: <?php echo $row['REPLY_BY']; ?>
                    <br>
                    Message: <?php echo $row['MESSAGE'] ?>
                </p>
            </div>
        <?php
        } else {
        ?>
            <div class="div_User_Message">
                <p class="user_Message">
                    <!-- Customer: <?php echo $row['NAME']; ?> <br> -->
                    <?php echo $row['MESSAGE'] ?>
                </p>
            </div>

<?php
        }
    }
} else {
    echo "0 results";
}
