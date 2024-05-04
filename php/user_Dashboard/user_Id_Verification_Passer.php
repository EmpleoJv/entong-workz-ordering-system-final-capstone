<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
$picHasBeenUploaded = 0;

if (isset($_POST['submit_to_Add_ID'])) {
    $change_Main_Image = time() . $_FILES["file_Main_Verification"]["name"];
    if (move_uploaded_file($_FILES['file_Main_Verification']['tmp_name'], '../../img/veriImage/' . $change_Main_Image)) {
        $target_file = '../../img/veriImage/' . $change_Main_Image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picName = basename($_FILES["file_Main_Verification"]["name"]);
        $photo = time() . $picName;
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: user_Profile.php?msgid=Wrong File ");
        } else if ($_FILES["file_Main_Verification"]["size"] > 20000000) {
            header("Location: user_Profile.php?msgid=To large File");
        } else {
            $picHasBeenUploaded = 1;
        }
    }
    // echo $extract_id;
    if ($picHasBeenUploaded == 1) {
        $sql = "INSERT INTO veification (USER_ID, VR_IMAGE_ID, STATUS) VALUES ('$tdbAdminId', '$photo', 'NOT YET VERIFIED')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
            header("Location: user_Profile.php?msgid=ID Submitted Successfully");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "error";
        }
    } else {
        unlink("../../img/veriImage/" . $change_Main_Image);
        // header("Location: user_Profile.php?msg=Error : Choose a right File!");
        echo "error daw";
    }
}
