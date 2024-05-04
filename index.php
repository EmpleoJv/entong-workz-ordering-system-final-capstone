<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <script type="text/javascript">
        window.history.forward();
    </script>
</head>

<body>
    <main>
        <div class="main_Section">
            <div class="main_Title">
                <div>
                    <img src="img/backgroundImages/logo.png" alt=" ">
                </div>
                <a href="user_Dashboard_View_Only.php">
                    <button class="view_Products">View Products</button>
                </a>
            </div>
            <div class="main_Form">
                <form class="user_Login_Form" method="POST" action="php/php_action/index_Login_Start.php">
                    <h3>Log In</h3>
                    <br>
                    <div>
                        <input class="user_Input_Text" type="text" id="user_Input_Id" name="user_Login_email" placeholder="Email" maxlength="50" required>
                        <img src="img/icons/gmailLogo.png" alt="Email Logo">
                    </div>
                    <br>
                    <div>
                        <input type="password" class="user_Input_Text" id="pass_Input_Id" name="user_Login_Pass" placeholder="Password" maxlength="50" required>
                        <span onclick="pass()">
                            <img id="show_Password" src="img/icons/crosseye.png" alt="Email Logo">
                        </span>
                    </div>
                    <br>
                    <input class="inputButton" type="submit" value="Log In" name="submitToLogin">
                    <br>
                    <br>
                    <?php
                    if (isset($_GET['failed'])) { ?>
                        <p class="failed"><?php echo $_GET['failed']; ?></p>
                    <?php } ?>
                    <br>
                </form>
                <div class="others_container">
                    <a href="user_Forgot_Password.php">Forgot Password?</a>
                    <a href="user_Create_Account_Email.php"><button>Create new account</button></a>
                </div>
            </div>
        </div>
        <div class="about">
            <div class="about_Container">
                <div class="pContainer">
                    <h1>ABOUT US</h1>
                    <p>
                        <span>Welcome to "Entong Workz Shop,"</span> the perfect online destination for fulfilling all your motorcycle-related requirements. We boast a vast range of high-quality parts, accessories, and apparel, enabling you to customize your ride and add your own personal touch. No matter if you're a weekend warrior or a daily commuter, we provide everything you need to enhance your overall motorcycle experience.
                        We exhibit a diverse range of parts, accessories, and apparel from top brands, including batteries, exhaust systems, tires, brakes, air intakes, helmets, jackets, gloves, boots, and much more. Our aim is to keep our customers safe and secure on the road while providing them with the most comfortable riding experience.
                        At "Entong Workz Shop," our passion for motorcycles and all things associated runs deep. This is why we always strive to offer our clients customized customer service, speedy deliveries for their purchased goods, and very competitive prices. Our team of specialists is always available to answer your questions and help you choose the products that best suit your motorcycle.
                        We are very grateful that you have chosen "Entong Workz Shop" as your preferred destination for all your motorcycle needs. It is our pleasure to serve you and provide you with the finest products that enable you to derive the most satisfaction from your ride.
                    </p>
                </div>
                <div class="imgContainer">
                    <img src="img/backgroundImages/Picture1.jpg" alt="background">
                </div>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.095028881992!2d120.95507747585974!3d14.65054677585041!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b5f67792ec7d%3A0x6f2d2ca8c140f6a2!2sEntong%20Workz%20Motorcycle%20Parts%20And%20Accesories%20Shop!5e0!3m2!1sen!2sph!4v1697460197680!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <footer>
            <div>
                <div class="footLinkLocation">
                    <ul>
                        <li><img src="img/backgroundImages/icons8-microsoft-admin-64.png" alt=""><a href="adminLogin.php">COMPANY LOGIN</a></li>
                        <li><img src="img/backgroundImages/icons8-phone-64.png" alt=""><a href="#">+639972957511</a></li>
                        <li><img src="img/backgroundImages/icons8-facebook-64.png" alt=""><a href="https://www.facebook.com/profile.php?id=100066463342028&mibextid=ZbWKwL">FACEBOOK</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </main>

    <script>
        var a;

        function pass() {
            if (a == 1) {
                document.getElementById("pass_Input_Id").type = "password";
                document.getElementById("show_Password").src = "img/icons/crosseye.png";

                a = 0;
            } else {
                document.getElementById("pass_Input_Id").type = "text";
                document.getElementById("show_Password").src = "img/icons/eye.png";
                a = 1;
            }
        }
    </script>
</body>

</html>