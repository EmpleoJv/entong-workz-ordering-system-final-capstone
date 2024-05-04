<?php
include('../connection/dbTemporary.php');
include('../connection/dbConnection.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}
error_reporting(E_ERROR | E_PARSE);


$code = $_GET['messageCode'];

// echo $code
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/admin_Dashboard_ChatBox_Start.css">
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="#">
                <img src="../../img/companyUser/<?php echo $tdbAdminImage ?>" alt="UserImage">
                <?php
                echo "<p> $tdbAdminFirstname </p>";

                ?>
            </a>
        </div>
        <a href="../../admin_Dashboard.php" class="list">
            <div>
                <img id="iconDss" src="../../img/icons/house.png" alt="dss">
                <span id="textDss">Dashboard</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Walkin.php" class="list">
            <div>
                <img id="iconUser" src="../../img/icons/walkin.png" alt="Add Item">
                <span id="textUsers">Walk In</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_User.php" class="list">
            <div>
                <img id="iconUser" src="../../img/icons/users.png" alt="Add Item">
                <span id="textUsers">Users</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Additem.php" class="list">
            <div>
                <img id="iconCase" src="../../img/icons/box.png" alt="Add Item">
                <span id="textItem">Add Item</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Inventory.php" class="list">
            <div>
                <img id="iconInven" src="../../img/icons/inventory.png" alt="Inventory">
                <span id="textInventory">Inventory</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Orders.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/cart.png" alt="orders">
                <span id="textBank">Orders</span>
            </div>
        </a>
        <a href="../../php/admin_Dasboard_ChatBox/admin_Dashboard_ChatBox.php" class="list">
            <div style="background-color: #16324E;">
                <img id="iconTrash" src="../../img/icons/support.png" alt="dss">
                <span id="textTrash">Chat Support</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Sales.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/cash.png" alt="orders">
                <span id="textBank">Sales</span>
            </div>
        </a>
        <a href="../../admin_Dashboard_Others.php" class="list">
            <div>
                <img id="iconBank" src="../../img/icons/others.png" alt="orders">
                <span id="textBank">Others</span>
            </div>
        </a>
    </div>
    <main class="mainContent" id="mainContent">
        <nav>
            <a onclick="closeOpenNav()">
                <img src="../../img/icons/menu.png" alt="navigation Bar">
            </a>
            <h1>Dashboard</h1>
            <a href="../php_action/admin_logout.php" class="logout">logout</a>
        </nav>
        <div class="chatbox_panel">
            <div class="chatBox" id="link_wrapper">
                <p id="link_wrapper">

                </p>
            </div>
            <form id="myForm">
                <input type="text" id="sended" name="message" placeholder="Message....." required>
                <button type="submit">Send</button>
            </form>
            <div id="response"></div>
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

    <script>
        var lastCompanyMessageCount = 0; // Keep track of the last company message count
        var lastUserMessageCount = 0; // Keep track of the last user message count

        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        var newContent = this.responseText;
                        document.getElementById("link_wrapper").innerHTML = newContent;

                        // Count the number of new company messages
                        var currentCompanyMessageCount = (newContent.match(/<div class="div_company_Message">/g) || []).length;

                        // Count the number of new user messages
                        var currentUserMessageCount = (newContent.match(/<div class="div_User_Message">/g) || []).length;

                        if (currentCompanyMessageCount > lastCompanyMessageCount || currentUserMessageCount > lastUserMessageCount) {
                            scrollToBottom(); // Scroll to the bottom if new messages were added
                            lastCompanyMessageCount = currentCompanyMessageCount;
                            lastUserMessageCount = currentUserMessageCount;
                        }
                    } else {
                        // Handle server errors here
                        console.error("Error: " + this.status);
                    }
                }
            };
            xhttp.open("GET", "chatBox.php?z=<?php echo $code; ?>", true);
            xhttp.send();
        }

        // Function to scroll the chatbox to the bottom
        function scrollToBottom() {
            var chatBox = document.getElementById("link_wrapper");
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Initially load messages and update the message count
        window.onload = function() {
            loadXMLDoc();
        };

        // Periodically update the chatbox
        setInterval(function() {
            loadXMLDoc();
        }, 1000);
    </script>


    <!-- <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("link_wrapper").innerHTML =
                        this.responseText;
                }
            };
            xhttp.open("GET", "chatBox.php?z=<?php echo $code; ?>", true);
            xhttp.send();
        }
        setInterval(function() {
            loadXMLDoc();
            // 1sec
        }, 1000);

        window.onload = loadXMLDoc;
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('myForm');
            const responseDiv = document.getElementById('response');
            const sended = document.getElementById('sended');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Create a FormData object to collect form data
                const formData = new FormData(form);

                // Use AJAX to send the form data to the server
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'process_form.php?a=<?php echo $code; ?>', true); // Replace 'process_form.php' with your server-side script
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the server's response here
                        responseDiv.innerHTML = xhr.responseText;
                        sended.value = ""; // Clear the value of the 'sended' input

                    }
                };
                xhr.send(formData); // Send the form data to the server
            });
        });
    </script>
</body>

</html>