<?php
session_start();
include_once '../connection/dbConnection.php';
include_once '../connection/dbTemporary.php';

try {
    if (isset($_POST['admin_Email']) && isset($_POST['admin_Password'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $user = validate($_POST['admin_Email']);
        $pass = validate($_POST['admin_Password']);

        $sql = "SELECT * FROM companylogin WHERE EMAIL='$user' AND PASSWORD ='$pass'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {

                $id = $row['ID'];
                $firstname = $row['FIRSTNAME'];
                $lastname = $row['LASTNAME'];
                $email = $row['EMAIL'];
                $password = $row['PASSWORD'];
                $level = $row['LEVEL'];
                $status = $row['STATUS'];
                $image = $row['IMAGE'];

                $_SESSION['tdbAdminId'] = $id;
                $_SESSION['tdbAdminFirstname'] = $firstname;
                $_SESSION['tdbAdminEmail'] = $email;
                $_SESSION['tdbAdminImage'] = $image;
                $_SESSION['tdbUserCityFee'] = null;
                $_SESSION['tdbAdminNumber'] = null;



                if ($email === $user && $password === $pass && $level == "admin" && $status == "active") {
                    header("Location: ../../admin_Dashboard.php");
                } elseif ($email === $user && $password === $pass && $level == "staff" && $status == "active") {
                    header("Location: ../../staff_Dashboard_Walkin.php");
                } elseif ($email === $user && $password === $pass && $level == "logistic" && $status == "active") {
                    header("Location: ../../logistic_Dashboard.php");
                } else {
                    header("Location: ../../adminLogin.php?error=Incorrect User name or password");
                }
            }
        } else {
            header("Location: ../../adminLogin.php?error=Incorrect User name or password");
        }
    }
} catch (Exception $e) {
    header("Location: index.php?error=Database Error");
}
