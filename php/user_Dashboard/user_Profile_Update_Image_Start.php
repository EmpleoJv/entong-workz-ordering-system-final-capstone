<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
$picHasBeenUploaded = 0;

if (isset($_POST['submit_to_Change_Main_Image'])) {
    $change_Main_Image = time() . $_FILES["file_Main_Image"]["name"];
    if (move_uploaded_file($_FILES['file_Main_Image']['tmp_name'], '../../img/userImage/' . $change_Main_Image)) {
        $target_file = '../../img/userImage/' . $change_Main_Image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picName = basename($_FILES["file_Main_Image"]["name"]);
        $photo = time() . $picName;
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: user_Profile.php?msg=Wrong File ");
        } else if ($_FILES["file_Main_Image"]["size"] > 20000000) {
            header("Location: user_Profile.php?msg=To large File");
        } else {
            $picHasBeenUploaded = 1;
        }
    }
    // echo $extract_id;
    if ($picHasBeenUploaded == 1) {
        $linkQuery = "SELECT IMAGE FROM userlogin WHERE ID = $tdbAdminId;";
        $linkImage = $conn->query($linkQuery);
        if ($linkImage->num_rows > 0) {
            while ($row = $linkImage->fetch_assoc()) {
                unlink("../../img/userImage/" . $row['IMAGE']);
            }
        }
        $fSql = "UPDATE userlogin SET IMAGE = '$photo' WHERE ID = $tdbAdminId;";
        $selectQuery_Run = mysqli_query($conn, $fSql);

        if ($selectQuery_Run) {
            header("Location: user_Profile.php?msg=Images deleted and updated Successfully");
        } else {
            header("Location: user_Profile.php?msg=Images deleted and updated Failed");
        }
    } else {
        unlink("../../img/userImage/" . $change_Main_Image);
        header("Location: user_Profile.php?msg=Error : Choose a right File!");
    }
}
