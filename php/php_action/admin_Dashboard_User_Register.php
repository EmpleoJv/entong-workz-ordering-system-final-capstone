<?php
include("../connection/dbConnection.php");
$picHasBeenUploaded = 0;
$sameEmailVerifyer = 0;

if (isset($_REQUEST['submitToSignUp'])) {

    $AddUser_firstname = $_REQUEST['firstnameAddUser'];
    $AddUser_lastname = $_REQUEST['lastnameAddUser'];
    $AddUser_user = $_REQUEST['usernameAddUser'];
    $AddUser_password = $_REQUEST['passwordAddUser'];
    $AddUser_level = $_REQUEST['levellist'];
    $AddUser_status = "active";

    $AddUser_image = time() . $_FILES["imageAddUser"]["name"];


    $sqlQuery = 'SELECT EMAIL FROM companylogin';
    $runSql = mysqli_query($conn, $sqlQuery);
    while ($row = mysqli_fetch_array($runSql)) {
        if ($row['EMAIL'] === $AddUser_user) {
            header("Location: ../../admin_Dashboard_User.php?addingUserError=Email Already Taken");
            $sameEmailVerifyer = 1;
        }
    }

    if ($sameEmailVerifyer === 0) {

        if (move_uploaded_file($_FILES['imageAddUser']['tmp_name'], '../../img/companyUser/' . $AddUser_image)) {
            $target_file = '../../img/companyUser/' . $AddUser_image;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $picName = basename($_FILES["imageAddUser"]["name"]);
            $photo = time() . $picName;
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                header("Location: ../../admin_Dashboard_User.php?addingUserError=Wrong File ");
            } else if ($_FILES["imageAddUser"]["size"] > 20000000) {
                header("Location: ../../admin_Dashboard_User.php?addingUserError=To large File");
            } else {
                $picHasBeenUploaded = 1;
            }
        }
    }

    if ($picHasBeenUploaded == 1) {
        $insert_query = mysqli_query($conn, "INSERT INTO companylogin SET FIRSTNAME='$AddUser_firstname', LASTNAME='$AddUser_lastname', EMAIL='$AddUser_user', PASSWORD='$AddUser_password', LEVEL='$AddUser_level', STATUS='$AddUser_status', IMAGE='$photo';");
        if ($insert_query > 0) {
            header("Location: ../../admin_Dashboard_User.php?addingUserError=Registered Successfully");
        }
    } else {
        unlink("../../img/companyUser/" . $AddUser_image);
        header("Location: ../../admin_Dashboard_User.php?addingUserError=Change Email or Choose the right file!!");
    }
}
