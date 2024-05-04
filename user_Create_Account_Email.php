<?php
include('php/connection/dbConnection.php');
include('php/connection/dbConnection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'php/PHPMailer/Exception.php';
require 'php/PHPMailer/PHPMailer.php';
require 'php/PHPMailer/SMTP.php';

if (isset($_REQUEST['submitEmail'])) {
    $emailToSendVerification = $_POST['email'];
    $numberToSendVerification = $_POST['number'];

    $veriCode = rand(10000, 99999);
    $veriCode2 = rand(10000, 99999);

    $checker = 1;
    //multiple email Checker
    $sql = "SELECT * FROM userlogin";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($emailToSendVerification == $row['EMAIL'] or $numberToSendVerification == $row['MOBILE']) {
                $checker = 0;
            }
        }
        if ($checker == 1) {
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'empleojv22@gmail.com';
            $mail->Password = 'voriswopmgblddvn';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            // Sender info
            $mail->setFrom('empleojv22@gmail.com', 'EWOS');
            // Add a recipient
            $mail->addAddress($emailToSendVerification);
            // Set email format to HTML
            $mail->isHTML(true);
            // Mail subject
            $mail->Subject = 'Email from EWOS Server';
            // Mail body content
            $bodyContent = 'Verification Code is ' . $veriCode;
            $mail->Body = $bodyContent;
            // Send email 
            $link = "php/User_Register/user_Create_Account_Verify.php?number=$numberToSendVerification&emailAddress=$emailToSendVerification&veriCode=" . urlencode(base64_encode($veriCode)) . "&veriCode2=" . urlencode(base64_encode($veriCode2));
            if ($mail->send()) {

                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'dc3e313c4040a1eca721d46241a41d35', //Your API KEY
                    'number' => $numberToSendVerification,
                    'message' => "Entong Workz
                    The verification code is: $veriCode2",
                    'sendername' => 'SEMAPHORE'
                );
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                //Send the parameters set above with the request
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                // Receive response from server
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                // curl_close($ch);
                //Show the server response
                echo $output;
                header("Location: $link");
                // curl_close($ch);
                //Show the server response

            } else {
                header("Location: user_Create_Account_Email.php?msgerror=Email Failed to send");
            }
        } else {
            // header("Location: php/User_Register/user_Create_Account.php?passData=Email Failed2");
            header("Location: user_Create_Account_Email.php?msgerror=Email or Number Already Registered");
        }
    } else {
        header("Location: user_Create_Account_Email.php?msgerror=Database Error");

        echo "badsd";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- <link rel="stylesheet" href="css/footer.css"> -->
    <link rel="stylesheet" href="css/user_Create_Account_Email.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <nav>
        <a href="index.php" class="back_main_Login">
            <button>BACK</button>
        </a>
    </nav>
    <div class="main_Container">

        <div class="form_Container">
            <form action="" method="POST" class="main_Form">
                <h3>SIGN UP</h3>

                <br>
                <div>
                    <div class="input_Container">
                        <input class="admin_Input_Text" type="email" id="admin_Id" name="email" placeholder="Email" maxlength="100" required>
                        <img src="img/icons/gmailLogo.png" alt="Email Logo">
                    </div>
                    <div class="input_Container">
                        <input class="admin_Input_Text" type="text" id="admin_Id" name="number" placeholder="Mobile Number" maxlength="11" minlength="11" oninput="validateNumber(this)" required>
                        <img src="img/icons/number.png" alt=" Logo">
                    </div>
                    <br>
                    <input type="checkbox" id="checkTerms" required>
                    <label for="checkTerms"><a href="user_Dashboard_TermsCon.php" target="_blank">Terms and Conditions</a></label>
                    <br>
                    <input class="inputButton" type="submit" value="SUBMIT" name="submitEmail">
                    <?php
                    if (isset($_GET['msgerror'])) { ?>
                        <p class="msgerror"><?php echo $_GET['msgerror']; ?></p>
                    <?php } ?>

                </div>
            </form>
        </div>
    </div>

    <script>
        function validateNumber(input) {
            // Remove non-numeric characters using a regular expression
            var numericValue = input.value.replace(/\D/g, '');

            // Update the input value with only numeric characters
            input.value = numericValue;

            // Check if the input has reached the desired length
            if (numericValue.length === 11) {
                // Check if the first two characters are equal to "09"
                if (numericValue.slice(0, 2) !== '09') {
                    input.setCustomValidity('Mobile number must start with "09"');
                } else {
                    // Clear any previous validation message
                    input.setCustomValidity('');
                }
            } else {
                input.setCustomValidity('Mobile number must be 11 digits');
            }
        }
    </script>
    <footer>
        <div>
            <div class="footLinkLocation">
                <ul>
                    <li><img src="img/backgroundImages/icons8-microsoft-admin-64.png" alt=""><a href="adminLogin.php">COMPANY LOGIN</a></li>
                    <li><img src="img/backgroundImages/icons8-phone-64.png" alt=""><a href="#">+639972957511</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>