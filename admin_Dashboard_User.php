<?php
include('php/connection/dbTemporary.php');
include('php/connection/dbConnection.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin_Dashboard_User.css">
    <link rel="icon" href="img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="#">
                <img src="img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";
                ?>
            </a>
        </div>
        <a href="admin_Dashboard.php" class="list">
            <div>
                <img id="iconDss" src="img/icons/house.png" alt="dss">
                <span id="textDss">Dashboard</span>
            </div>
        </a>
        <a href="admin_Dashboard_Walkin.php" class="list">
            <div>
                <img id="iconUser" src="img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="admin_Dashboard_User.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconUser" src="img/icons/users.png" alt="Add Item">
                <span id="textUsers">Users</span>
            </div>
        </a>
        <a href="admin_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="admin_Dashboard_Inventory.php" class="list">
            <div>
                <img id="iconInven" src="img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="admin_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/cart.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
        <a href="php/admin_Dasboard_ChatBox/admin_Dashboard_ChatBox.php" class="list">
            <div>
                <img id="iconTrash" src="img/icons/support.png" alt="dss">
                <span id="textTrash">Chat Support</span>
            </div>
        </a>
        <a href="admin_Dashboard_Sales.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/cash.png" alt="orders">
                <span id="textBank">Sales</span>
            </div>
        </a>
        <a href="admin_Dashboard_Others.php" class="list">
            <div>
                <img id="iconBank" src="img/icons/others.png" alt="orders">
                <span id="textBank">Others</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>USERS</h1>
            <a href="php/php_action/admin_logout.php" class="logout">logout</a>

        </nav>
        <?php
        if (isset($_GET['msg'])) { ?>
            <p class="msg"><?php echo $_GET['msg']; ?></p>
        <?php } ?>
        <form class="first_container" method="post" action="php/php_action/admin_Dashboard_User_Register.php" enctype="multipart/form-data">
            <h1>Add Staff</h1>
            <div class="second_container">
                <div class="thrid_container_first">
                    <div class="fourt_container">
                        <label for="firstnameAddUser"><b>Firstname</b></label>
                        <input type="text" name="firstnameAddUser" placeholder="Firstname" maxlength="20" required>
                    </div>
                    <div class="fourt_container">
                        <label for="lastnameAddUser"><b>Lastname</b></label>
                        <input type="text" name="lastnameAddUser" placeholder="Lastname" maxlength="20" required>
                    </div>
                    <div class="fourt_container">
                        <label for="usernameAddUser"><b>Email</b></label>
                        <input type="text" name="usernameAddUser" placeholder="Email" maxlength="20" required>
                    </div>
                    <div class="fourt_container">
                        <label for="passwordAddUser"><b>Password</b></label>
                        <input type="text" name="passwordAddUser" placeholder="Password" maxlength="50" minlength="8" required>
                    </div>
                </div>
                <div class="thrid_container_third">
                    <div class="fourt_container">
                        <label for="level"><b>Level</b></label>
                        <select id="level" name="levellist">
                            <option value="staff">staff</option>
                            <option value="logistic">logistic</option>
                        </select>
                    </div>
                    <div class="fourt_container">
                        <label for="fileClassLable"><b>Upload Photo</b></label>
                        <!-- <label for="fileClassLable"><img src="img/icons/photo.png" alt="Upload Photo"></label> -->
                        <input class="fileClass" type="file" name="imageAddUser" id="fileClassLable" required>
                    </div>
                </div>
            </div>
            <div class="submitInput">
                <input type="submit" value="Register Staff" name="submitToSignUp" required>
            </div>
            <?php
            if (isset($_GET['addingUserError'])) { ?>
                <p class="addingUserError"><?php echo $_GET['addingUserError']; ?></p>
            <?php } ?>
        </form>

        <div class="grid-container">
            <a href="php/admin_Dashboard_User/staff.php">
                <div class="grid-item" id="staff_User">
                    <div>
                        <h3>Staff User</h3>
                        <img src="img/icons/staff.png" alt="users image">
                    </div>
                    <?php
                    $sqlForStaff = 'SELECT * FROM companylogin WHERE LEVEL = "staff" AND STATUS = "active";';
                    $runForStaff = mysqli_query($conn, $sqlForStaff);
                    $numberOfStaff = mysqli_num_rows($runForStaff);
                    ?>
                    <h2><?php echo $numberOfStaff; ?></h2>
                </div>
            </a>
            <a href="php/admin_Dashboard_User/logistic.php">
                <div class="grid-item" id="logistic_User">
                    <div>
                        <h3>Logistic User</h3>
                        <img src="img/icons/delivery.png" alt="users image">
                    </div>
                    <?php
                    $sqlForLogistic = 'SELECT * FROM companylogin WHERE LEVEL = "logistic" AND STATUS = "active";';
                    $runForLogistic = mysqli_query($conn, $sqlForLogistic);
                    $numberOfLogistic = mysqli_num_rows($runForLogistic);
                    ?>
                    <h2><?php echo $numberOfLogistic; ?></h2>
                </div>
            </a>
            <a href="php/admin_Dashboard_User/admin_Dashboard_User_Verification.php">
                <div class="grid-item" id="registered_User">
                    <div>
                        <h3>Registered User</h3>
                        <img src="img/icons/users.png" alt="users image">
                    </div>
                    <?php
                    $sqlForRegisteredUser = 'SELECT * FROM userlogin;';
                    $runForRegisteredUser = mysqli_query($conn, $sqlForRegisteredUser);
                    $numberOfRegisteredUser = mysqli_num_rows($runForRegisteredUser);
                    ?>
                    <h2><?php echo $numberOfRegisteredUser; ?></h2>
                </div>
            </a>
            <a href="php/admin_Dashboard_User/deactivated.php">
                <div class="grid-item" id="deactivated_User">
                    <div>
                        <h3>Deactivated Staff</h3>
                        <img src="img/icons/remove_user.png" alt="users image">
                    </div>
                    <?php
                    $sqlForDeactivatedUser = 'SELECT * FROM companylogin WHERE STATUS = "deactivate";';
                    $runForDeactivatedUser = mysqli_query($conn, $sqlForDeactivatedUser);
                    $numberOfDeactivatedUser = mysqli_num_rows($runForDeactivatedUser);
                    ?>
                    <h2><?php echo $numberOfDeactivatedUser; ?></h2>
                </div>
            </a>
        </div>
    </main>
    <script>
        function closeOpenNav() {
            if (document.getElementById("mainContent").style.marginLeft == "15vw") {
                document.getElementById("mainContent").style.marginLeft = "0vw";
                document.getElementById("sideNav").style.width = "0vw";

            } else if (document.getElementById("mainContent").style.marginLeft = "0vw") {
                document.getElementById("mainContent").style.marginLeft = "15vw";
                document.getElementById("sideNav").style.width = "15vw";
            }
        }
    </script>
</body>

</html>