<?php
include('../connection/dbConnection.php');
include('../connection/dbConnection.php');

$email = $_GET['emailAddress'];
$num = $_GET['number'];

$code = $_GET['veriCode'];
$veriCode2 = $_GET['veriCode2'];

$finalCode = base64_decode(urldecode($code));
$finalCode2 = base64_decode(urldecode($veriCode2));
if (isset($_REQUEST['submitCode'])) {
    $codeVerification = $_POST['code'];
    $codeVerification2 = $_POST['code2'];

    if ($codeVerification == $finalCode and $codeVerification2 == $finalCode2) {
        echo "GOOD";
        header("Location: user_Create_Account.php?passedEmail=$email&number=$num");
    } else {
        header("Location: user_Create_Account_Verify.php?msgerror=Wrong Code");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../../css/footer.css"> -->
    <link rel="stylesheet" href="../../css/user_Create_Account_Verify.css">
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <script type="text/javascript">
        window.history.forward();
    </script>
</head>

<body>

    <nav>
        <a href="../../index.php" class="back_main_Login">
            <button>BACK</button>
        </a>
    </nav>
    <div class="main_Container">

        <div class="form_Container">
            <form action="" method="POST" class="main_Form">
                <h3>OTP Verification</h3>
                <br>
                <h3>Enter the OTP you received at your <br> phone and email</h3>
                <br>
                <div>
                    <div class="input_Container">
                        <input class="admin_Input_Text" type="number" id="admin_Id" name="code" placeholder="Email Code" maxlength="50" required>
                        <img src="../../img/icons/gmailLogo.png" alt="Email Logo">
                    </div>
                    <div class="input_Container">
                        <input class="admin_Input_Text" type="number" id="admin_Id" name="code2" placeholder="Phone Code" maxlength="50" required>
                        <img src="../../img/icons/number.png" alt="Phone Logo">
                    </div>
                    <br>
                    <input class="inputButton" type="submit" value="SUBMIT" name="submitCode">
                    <?php
                    if (isset($_GET['msgerror'])) { ?>
                        <p class="msgerror"><?php echo $_GET['msgerror']; ?></p>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div>
            <div class="footLinkLocation">
                <ul>
                    <li><img src="../../img/backgroundImages/icons8-microsoft-admin-64.png" alt=""><a href="adminLogin.php">COMPANY LOGIN</a></li>
                    <li><img src="../../img/backgroundImages/icons8-phone-64.png" alt=""><a href="#">+639972957511</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- <div class="main_Container">
        <nav>
            <a href="../../index.php" class="back_main_Login">
                <button>BACK</button>
            </a>
        </nav>

        <div class="form_Container_Code_Checker">
            <form action="" method="POST" class="main_Form">
                <h3>Input the code from your Email</h3>
                <br>
                <div>
                    <input class="admin_Input_Text" type="text" id="admin_Id" name="code" placeholder="Code" maxlength="20" required>
                    <br>
                    <br>
                    <input class="inputButton" type="submit" value="Submit" name="submitCode">

                    <?php
                    if (isset($_GET['msgerror'])) { ?>
                        <p class="msgerror"><?php echo $_GET['msgerror']; ?></p>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div>
            <div>

            </div>
            <div>
                <ul>
                    <li><a href="#">LINK</a></li>
                    <li><a href="#">LINK</a></li>
                    <li><a href="#">LINK</a></li>
                </ul>
            </div>
        </div>
    </footer> -->
</body>

</html>