<?php
include('../connection/dbConnection.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if (isset($_REQUEST['submitEmail'])) {

    $emailFormHtml = $_POST['emailForPassword'];

    $newPassword = rand(10000000, 99999999);

    $checker = 1;

    $sql = "SELECT * FROM userlogin";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($emailFormHtml == $row['EMAIL']) {
                // header("Location: ../../admin_Forgot_Password.php?msgerror=good $emailFormHtml");
                $checker = 0;

                $sqlUpdate = "UPDATE userlogin SET PASSWORD = '$newPassword' WHERE EMAIL= '$emailFormHtml';";
                if ($conn->query($sqlUpdate) === TRUE) {

                    $mail = new PHPMailer;
                    //
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'empleojv22@gmail.com';
                    $mail->Password = 'voriswopmgblddvn';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    // Sender info
                    $mail->setFrom('empleojv22@gmail.com', 'gmail');
                    // Add a recipient
                    $mail->addAddress($emailFormHtml);
                    // Set email format to HTML
                    $mail->isHTML(true);
                    // Mail subject
                    $mail->Subject = 'Email from Localhost Server';
                    // Mail body content
                    $bodyContent = 'New Password is ' . $newPassword;
                    $mail->Body = $bodyContent;
                    // Send email 
                    if ($mail->send()) {
                        // header("location: ../../adminLogin.php");
                        header("Location: ../../index.php?failed=Password Change!! check your Email");
                    } else {
                        header("Location: ../../user_Forgot_Password.php?msgerror=Email Not Send!");
                    }
                    // header("Location: ../../admin_Forgot_Password.php?msgerror=GOOD");
                } else {
                    header("Location: ../../user_Forgot_Password.php?msgerror=no good");
                }
                break;
            }
        }
        if ($checker == 1) {
            header("Location: ../../user_Forgot_Password.php?msgerror=Email $emailFormHtml Not found!");
        }
    } else {
        header("Location: ../../user_Forgot_Password.php?msgerror=Email Not Found");
    }
}
