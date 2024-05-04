<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../img/backgroundImages/logo.png">
    <title>Entong Workz</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <link rel="stylesheet" href="../../css/user_Customer_Support.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
</head>

<body>
    <main>
        <nav>
            <h1>Entong Workz</h1>
            <ul>
                <li><a href="../../user_Dashboard.php">HOME</a></li>
                <li><a href="user_Budget_Calculator.php">BUDGETER</a></li>
                <li><a href="user_Add_To_Cart.php">CART</a></li>
                <li><a href="user_Buy_Orders.php">ORDERS</a></li>
                <li><a href="user_Profile.php">PROFILE</a></li>
                <li><a href="user_Customer_Support.php">SUPPORT</a></li>
                <li><a href="../php_action/user_logout.php">LOGOUT</a></li>
            </ul>
            <img src="../../img/icons/menu_Navy.png" alt="bar" onclick="openNav()">
        </nav>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <li><a href="../../user_Dashboard.php">HOME</a></li>
                <li><a href="user_Budget_Calculator.php">BUDGETER</a></li>
                <li><a href="user_Add_To_Cart.php">CART</a></li>
                <li><a href="user_Buy_Orders.php">ORDERS</a></li>
                <li><a href="user_Profile.php">PROFILE</a></li>
                <li><a href="user_Customer_Support.php">SUPPORT</a></li>
                <li><a href="../php_action/user_logout.php">LOGOUT</a></li>
            </div>
        </div>

        <!-- <form id="myForm">
            <textarea type="text" name="message" placeholder="Message..."></textarea>
        </form> -->
        <div class="chatbox_panel">
            <h1 class="module_Title">Customer Support</h1>
            <div class="chatBox" id="link_wrapper">

            </div>
            <div>
                <form id="myForm">
                    <input type="text" name="message" id="sended" placeholder="Message....." required>
                    <button type="submit">Send</button>
                </form>
                <div id="response"></div>
            </div>
        </div>

    </main>

    <script>
        var lastMessageCount = 0; // Keep track of the last message count

        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var newContent = this.responseText;
                    document.getElementById("link_wrapper").innerHTML = newContent;

                    // Check if new messages were added
                    var currentCompanyMessageCount = (newContent.match(/<p class="company_Message">/g) || []).length;
                    var currentUserMessageCount = (newContent.match(/<p class="user_Message">/g) || []).length;
                    var currentMessageCount = currentCompanyMessageCount + currentUserMessageCount;

                    if (currentMessageCount > lastMessageCount) {
                        scrollToBottom(); // Scroll to the bottom if new messages were added
                        lastMessageCount = currentMessageCount;
                    }
                }
            };
            xhttp.open("GET", "chatBox.php", true);
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
            xhttp.open("GET", "chatBox.php", true);
            xhttp.send();
        }
        setInterval(function() {
            loadXMLDoc();
            // 1sec
        }, 1000);

        window.onload = loadXMLDoc;
    </script> -->
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
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
                xhr.open('POST', 'process_form.php', true); // Replace 'process_form.php' with your server-side script
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