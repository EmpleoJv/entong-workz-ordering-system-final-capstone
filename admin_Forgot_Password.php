<?php
include('php/connection/dbConnection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/admin_Forgot_Password.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <nav>
        <a href="adminLogin.php" class="back_main_Login">
            <button>BACK</button>
        </a>
    </nav>
    <div class="main_Container">

        <div class="form_Container">
            <form action="php/php_action/adminForgotPassword.php" method="POST" class="main_Form">
                <h3>Admin/Staff Email</h3>
                <br>
                <div>
                    <div class="input_Container">
                        <input class="admin_Input_Text" type="text" id="admin_Id" name="emailForPassword" placeholder="Email" maxlength="50" required>
                        <img src="img/icons/gmailLogo.png" alt="Email Logo">
                    </div>
                    <br>
                    <input class="inputButton" type="submit" value="Submit" name="submitEmail">
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
                    <li><img src="img/backgroundImages/icons8-microsoft-admin-64.png" alt=""><a href="adminLogin.php">COMPANY LOGIN</a></li>
                    <li><img src="img/backgroundImages/icons8-phone-64.png" alt=""><a href="#">+639972957511</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>