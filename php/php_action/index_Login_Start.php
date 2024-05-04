<?php
session_start();

include_once '../connection/dbConnection.php';
include_once '../connection/dbTemporary.php';

$checker = 0;
$checker2 = 0;
// $cityFormShippingFee = null;
// $fee = null;

if (isset($_REQUEST['submitToLogin'])) {

    $user = $_POST['user_Login_email'];
    $pass = $_POST['user_Login_Pass'];

    $sql = "SELECT * FROM userlogin WHERE EMAIL='$user';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $id = $row['ID'];
            $firstname = $row['FIRSTNAME'];
            $email = $row['EMAIL'];
            $password = $row['PASSWORD'];
            $image = $row['IMAGE'];
            $number = $row['MOBILE'];

            $cityFormShippingFee = $row['CITY_MUNICIPALITY'];

            $_SESSION['tdbAdminId'] = $id;
            $_SESSION['tdbAdminFirstname'] = $firstname;
            $_SESSION['tdbAdminEmail'] = $email;
            $_SESSION['tdbAdminImage'] = $image;
            $_SESSION['tdbAdminNumber'] = $number;

            if ($password === $pass) {
                $checker = 1;
                break;
            }
        }
    } else {
        header("Location: ../../index.php?error= No account of $user has been found");
    }

    $sql = "SELECT SHIPPING_FEE FROM cityshippingfee WHERE CITY ='$cityFormShippingFee';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $fee = $row['SHIPPING_FEE'];

            $_SESSION['tdbUserCityFee'] = $fee;

            if ($fee != null) {
                $checker2 = 1;
                break;
            }
        }
    } else {
        header("Location: ../../index.php?failed= Address Not Seen");
    }

    if ($checker == 1 && $checker2 == 1) {
        echo "good";
        header("Location: ../../user_Dashboard.php");
    } else {
        echo "bad";
        header("Location: ../../index.php?failed=Incorrect User name or password");
    }



    // $sql = "SELECT * FROM userlogin WHERE EMAIL='$user';";
    // $result = $conn->query($sql);

    // if ($result->num_rows > 0) {
    //     // output data of each row
    //     while ($row = $result->fetch_assoc()) {
    //         $id = $row['ID'];
    //         $firstname = $row['FIRSTNAME'];
    //         $email = $row['EMAIL'];
    //         $password = $row['PASSWORD'];
    //         $image = $row['IMAGE'];
    //         $cityFormShippingFee = $row['CITY_MUNICIPALITY'];

    //         $_SESSION['tdbAdminId'] = $id;
    //         $_SESSION['tdbAdminFirstname'] = $firstname;
    //         $_SESSION['tdbAdminEmail'] = $email;
    //         $_SESSION['tdbAdminImage'] = $image;

    //         if ($password === $pass) {
    //             $checker = 1;
    //             break;
    //         }
    //     }
    //     if ($checker == 1) {
    //         echo "good";
    //         // header("Location: ../../user_Dashboard.php");
    //     } else {
    //         echo "bad";
    //         // header("Location: ../../index.php?error=Incorrect User name or password");
    //     }
    // } else {
    //     header("Location: ../../index.php?error= No account of $user has been found");
    // }
}
