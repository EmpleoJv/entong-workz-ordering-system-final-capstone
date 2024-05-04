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
    <link rel="stylesheet" href="../../css/user_Profile.css">
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
            <img src="../../img/icons/menu.png" alt="bar" onclick="openNav()">
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
        </nav>

        <div class="grid-container">
            <div class="top">
                <h1>Profile</h1>

            </div>

            <div class="item1">

                <div class="img_Container">
                    <h1 class="title">Edit Image</h1>
                    <?php
                    $sql = "SELECT IMAGE FROM userlogin WHERE ID = $tdbAdminId;";
                    $result = $conn->query($sql);
                    if ($result) {
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                // Assuming you have the images in the correct directory
                                $imagePath = "../../img/userImage/" . $row['IMAGE'];
                    ?>
                                <img src="<?php echo $imagePath; ?>" alt="Image" class="imgPerson">
                    <?php
                            }
                        }
                    }
                    ?>

                    <form action="user_Profile_Update_Image_Start.php" method="POST" enctype="multipart/form-data">
                        <!-- <input type="file" name="file_Main_Image" class="inputFileImage"> -->
                        <label for="file_Main_Image" class="custom-file-upload">
                            <input type="file" name="file_Main_Image" id="file_Main_Image" class="inputFileImage">
                            Update Profile Image
                        </label>
                        <br>
                        <input type="submit" name="submit_to_Change_Main_Image" class="sumit_Image_Update">
                    </form>

                    <?php
                    if (isset($_GET['msg'])) { ?>
                        <p class="msg"><?php echo $_GET['msg']; ?></p>
                    <?php } ?>
                </div>
            </div>
            <div class="item2">
                <div class="img_Container">
                    <h1 class="title">Verification</h1>
                    <!-- <img src="../../img/companyUser/<?php echo $row["IMAGE"] ?>" alt="Image"> -->
                    <?php
                    $sql = "SELECT * FROM veification WHERE USER_ID = $tdbAdminId;";
                    $result = $conn->query($sql);
                    if ($result) {
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                // Assuming you have the images in the correct directory
                                $imagePath = "../../img/veriImage/" . $row['VR_IMAGE_ID'];
                    ?>
                                <img src="<?php echo $imagePath; ?>" alt="Image" class="verificationID">
                                <h1><?php echo $row['STATUS']; ?></h1>
                                <?php
                                if (isset($_GET['msgid'])) { ?>
                                    <p class="msgid"><?php echo $_GET['msgid']; ?></p>
                                <?php } ?>
                            <?php
                            }
                        } else {
                            echo "No images found for this user.";
                            ?>
                            <form action="user_Id_Verification_Passer.php" method="POST" enctype="multipart/form-data">
                                <!-- <input type="file" name="file_Main_Verification" class="inputFileImage"> -->
                                <!-- <label for="file_Main_Verification" class="custom-file-upload-verification">
                                    <input type="file" name="file_Main_Verification" class="inputFileImage" id="file_Main_Verification">
                                    Upload Valid ID
                                </label> -->
                                <!-- <h1 class="title">Add Profile Image</h1> -->
                                <!-- <input type="file" name="file_Main_Image" required>  -->
                                <label for="file_Main_Verification" class="file_Main_Verification" required>
                                    Select ID Image <br />
                                    <!-- <i class="fa fa-2x fa-camera"></i> -->
                                    <img src="../../img/icons/im.png" alt="">
                                    <input id="file_Main_Verification" type="file" name="file_Main_Verification" accept=".jpg, .jpeg, .png" required>
                                    <br />
                                    <span id="imageName"></span>
                                </label>
                                <br>
                                <input type="submit" name="submit_to_Add_ID" class="sumit_Image_Update">
                            </form>
                    <?php
                        }
                    } else {
                        echo "Error executing SQL query: " . $conn->error;
                    }
                    ?>

                </div>
            </div>
            <div class="item3">
                <?php
                $sql = "SELECT * FROM userlogin WHERE ID = $tdbAdminId;";
                $result = $conn->query($sql);
                if ($result) {
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <div class="profile_Info_Container">
                                <div class="left">
                                    <div>
                                        <h2>Name</h2>
                                        <h2>Date</h2>
                                        <h2>Mobile Number</h2>
                                        <h2>Email</h2>
                                        <h2>Age</h2>
                                    </div>
                                    <div>
                                        <h2><?php echo $row['FIRSTNAME']; ?> <?php echo $row['LASTNAME']; ?> </h2>
                                        <h2>
                                            <?php 
                                            $dater = $row['DATE'];
                                            $formattedDate = date('F d, Y', strtotime($dater));

                                            echo $formattedDate; 
                                            ?>
                                            </h2>
                                        <h2><?php echo $row['MOBILE']; ?></h2>
                                        <h2><?php echo $row['EMAIL']; ?></h2>
                                        <h2><?php echo $row['AGE']; ?></h2>
                                    </div>
                                </div>
                                <div class="right">
                                    <div>
                                        <h2>Gender</h2>
                                        <h2>Street Information</h2>
                                        <h2>Provice</h2>
                                        <h2>City/Municipality</h2>
                                        <h2>Barangay</h2>
                                    </div>
                                    <div>
                                        <h2><?php echo $row['GENDER']; ?></h2>
                                        <h2><?php echo $row['ADDITIONAL_INFORMATION']; ?></h2>
                                        <h2><?php echo $row['PROVINCE']; ?></h2>
                                        <h2><?php echo $row['CITY_MUNICIPALITY']; ?></h2>
                                        <h2><?php echo $row['BARANGAY']; ?></h2>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    }
                }
                ?>
                <button id="submit" class="update">UPDATE</button>
            </div>

        </div>
        <!-- <div class="floater">
            <form action="addressUpdate.php" method="post">
                <?php
                if (isset($_GET['msgAddressUpdate'])) { ?>
                    <p class="msgAddressUpdate"><?php echo $_GET['msgAddressUpdate']; ?></p>
                <?php } ?>

                <label for="regAddition">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                <input type="text" name="regAddition" placeholder="Ex. 589 Quintin Paredes St" required><br>
                <label for="regProvince">Province</label>
                <select name="regProvince" required>

                    <option value="Metro Manila-Caloocan">Metro Manila-Caloocan</option>
                    <option value="Metro Manila-Las Piñas">Metro Manila-Las Piñas</option>
                    <option value="Metro Manila-Makati">Metro Manila-Makati</option>
                    <option value="Metro Manila-Malabon">Metro Manila-Malabon</option>
                    <option value="Metro Manila-Mandaluyong">Metro Manila-Mandaluyong</option>
                    <option value="Metro Manila-Manila">Metro Manila-Manila</option>
                    <option value="Metro Manila-Marikina">Metro Manila-Marikina</option>
                    <option value="Metro Manila-Muntinlupa">Metro Manila-Muntinlupa</option>
                    <option value="Metro Manila-Navotas">Metro Manila-Navotas</option>
                    <option value="Metro Manila-Parañaque">Metro Manila-Parañaque</option>
                    <option value="Metro Manila-Pasay">Metro Manila-Pasay</option>
                    <option value="Metro Manila-Pasig">Metro Manila-Pasig</option>
                    <option value="Metro Manila-Pateros">Metro Manila-Pateros</option>
                    <option value="Metro Manila-Quezon City">Metro Manila-Quezon City</option>
                    <option value="Metro Manila-San Juan">Metro Manila-San Juan</option>
                    <option value="Metro Manila-Taguig">Metro Manila-Taguig</option>
                    <option value="Metro Manila-Valenzuela">Metro Manila-Valenzuela</option>
                </select><br>

                <label for="regCity">City/Municipality</label>
                <select name="regCity" required>
                </select>
                <br>
                <label for="regBarangay">Barangay</label>
                <select name="regBarangay" required>
                </select>
                <br>
                <input type="submit" name="start_Address_Update">
            </form>
        </div>
 -->


        <div class="show_Update">
            <div class="show_form">
                <img src="../../img/icons/close.png" alt="xmark" class="Icon-close">
                <div class="update_Container">
                    <div>
                        <form action="addressUpdate.php" method="post">
                            <div>
                                <label for="regAddition" style="padding-right: 10vw;">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                                <input type="text" name="regAddition" placeholder="Ex. 589 Quintin Paredes St" required>
                            </div>
                            <br>
                            <div>
                                <label for="regProvince">Province</label>
                                <select name="regProvince" required>
                                    <option value="Metro Manila-Caloocan">Metro Manila-Caloocan</option>
                                    <option value="Metro Manila-Las Piñas">Metro Manila-Las Piñas</option>
                                    <option value="Metro Manila-Makati">Metro Manila-Makati</option>
                                    <option value="Metro Manila-Malabon">Metro Manila-Malabon</option>
                                    <option value="Metro Manila-Mandaluyong">Metro Manila-Mandaluyong</option>
                                    <option value="Metro Manila-Manila">Metro Manila-Manila</option> <!-- Corrected the typo here -->
                                    <option value="Metro Manila-Marikina">Metro Manila-Marikina</option>
                                    <option value="Metro Manila-Muntinlupa">Metro Manila-Muntinlupa</option>
                                    <option value="Metro Manila-Navotas">Metro Manila-Navotas</option>
                                    <option value="Metro Manila-Parañaque">Metro Manila-Parañaque</option>
                                    <option value="Metro Manila-Pasay">Metro Manila-Pasay</option>
                                    <option value="Metro Manila-Pasig">Metro Manila-Pasig</option>
                                    <option value="Metro Manila-Pateros">Metro Manila-Pateros</option>
                                    <option value="Metro Manila-Quezon City">Metro Manila-Quezon City</option>
                                    <option value="Metro Manila-San Juan">Metro Manila-San Juan</option>
                                    <option value="Metro Manila-Taguig">Metro Manila-Taguig</option>
                                    <option value="Metro Manila-Valenzuela">Metro Manila-Valenzuela</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <br>
                            <div>
                                <label for="regCity">City/Municipality</label>
                                <select name="regCity" required>
                                </select>
                            </div>
                            <br>
                            <div>
                                <label for="regBarangay">Barangay</label>
                                <select name="regBarangay" required>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <br>
                            <div>
                                <input type="submit" name="start_Address_Update" class="start_Update">
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['msgAddressUpdate'])) { ?>
                            <p class="msgAddressUpdate"><?php echo $_GET['msgAddressUpdate']; ?></p>
                        <?php } ?>
                    </div>
                    <div>

                        <form action="user_Update.php" method="post" class="secondForm">

                            <?php
                            $sql = "SELECT * FROM userlogin WHERE ID = $tdbAdminId;";
                            $result = $conn->query($sql);
                            if ($result) {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                                        <div>
                                            <label for="upMO">Mobile</label>
                                            <input type="number" name="upMO" id="upMO" value="<?php echo $row['MOBILE']; ?>" required>
                                        </div>
                                        <br>
                                        <div>
                                            <label for="upPA">Password</label>
                                            <input type="text" name="upPA" id="upPA" value="<?php echo $row['PASSWORD']; ?>" required>
                                        </div>
                                        <br>
                                        <div>
                                            <input type="submit" name="startSubmit" class="start_Update">

                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </form>
                        <?php
                        if (isset($_GET['msgInfoUpdate'])) { ?>
                            <p class="msgInfoUpdate"><?php echo $_GET['msgInfoUpdate']; ?></p>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
    <script>
        document.querySelector(".update").addEventListener("click", function() {
            document.querySelector(".show_Update").style.display = "flex";
        });

        document.querySelector(".Icon-close").addEventListener("click", function() {
            document.querySelector(".show_Update").style.display = "none";
        });
    </script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let input = document.getElementById("file_Main_Verification");
        let imageName = document.getElementById("imageName");

        input.addEventListener("change", () => {
            let inputImage = input.files[0];

            if (inputImage) {
                imageName.innerText = inputImage.name;
            } else {
                imageName.innerText = ""; // Clear the text if no file is selected
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to the province, city, and barangay dropdowns
        var provinceDropdown = document.querySelector("select[name='regProvince']");
        var cityDropdown = document.querySelector("select[name='regCity']");
        var barangayDropdown = document.querySelector("select[name='regBarangay']");

        // Define an object mapping provinces to their corresponding cities
        var cityOptions = {
            "Metro Manila-Caloocan": ["Caloocan City"],
            "Metro Manila-Las Piñas": ["Las Piñas City"],
            "Metro Manila-Makati": ["Makati City"],
            "Metro Manila-Malabon": ["Malabon City"],
            "Metro Manila-Mandaluyong": ["Mandaluyong City"],
            "Metro Manila-Manila": ["Tondo I / li", "Binondo", "Ermita", "Intramuros", "Malate", "Paco", "Pandacan", "Port Area", "Quiapo", "Sampaloc", "San Miguel", "San Nicolas", "Santa Ana", "Santa Cruz", "Santa Mesa"],
            "Metro Manila-Marikina": ["Marikina City"],
            "Metro Manila-Muntinlupa": ["Muntinlupa City"],
            "Metro Manila-Navotas": ["Navotas City"],
            "Metro Manila-Parañaque": ["Parañaque City"],
            "Metro Manila-Pasay": ["Pasay City"],
            "Metro Manila-Pasig": ["Pasig City"],
            "Metro Manila-Pateros": ["Pateros City"],
            "Metro Manila-Quezon City": ["Quezon City"],
            "Metro Manila-San Juan": ["San Juan City"],
            "Metro Manila-Taguig": ["Taguig City"],
            "Metro Manila-Valenzuela": ["Valenzuela City"],
            // Add more provinces and cities as needed
        };

        // Define an object mapping cities to their corresponding barangays
        var barangayOptions = {
            "Caloocan City": ["Barangay 1", "Barangay 10", "Barangay 100", "Barangay 101", "Barangay 102", "Barangay 103", "Barangay 104", "Barangay 105", "Barangay 106", "Barangay 107", "Barangay 108", "Barangay 109", "Barangay 110", "Barangay 111", "Barangay 112", "Barangay 113", "Barangay 114", "Barangay 115", "Barangay 116", "Barangay 117", "Barangay 118", "Barangay 119", "Barangay 12", "Barangay 120", "Barangay 121", "Barangay 122", "Barangay 123", "Barangay 124", "Barangay 125", "Barangay 126", "Barangay 127", "Barangay 128", "Barangay 129", "Barangay 13", "Barangay 130", "Barangay 131", "Barangay 132", "Barangay 133", "Barangay 134", "Barangay 135", "Barangay 136", "Barangay 137", "Barangay 138", "Barangay 139", "Barangay 14", "Barangay 140", "Barangay 141", "Barangay 142", "Barangay 143", "Barangay 144", "Barangay 145", "Barangay 146", "Barangay 147", "Barangay 148", "Barangay 149", "Barangay 15", "Barangay 150", "Barangay 151", "Barangay 152", "Barangay 152", "Barangay 153", "Barangay 154", "Barangay 155", "Barangay 156", "Barangay 157", "Barangay 18", "Barangay 159", "Barangay 16", "Barangay 160", "Barangay 161", "Barangay 162", "Barangay 163", "Barangay 164", "Barangay 165", "Barangay 166", "Barangay 167", "Barangay 168", "Barangay 169", "Barangay 17", "Barangay 170", "Barangay 171", "Barangay 172", "Barangay 173", "Barangay 174", "Barangay 175", "Barangay 176", "Barangay 177", "Barangay 178", "Barangay 179", "Barangay 18", "Barangay 180", "Barangay 181", "Barangay 182", "Barangay 183", "Barangay 184", "Barangay 185", "Barangay 186", "Barangay 187", "Barangay 188", "Barangay 19", "Barangay 2", "Barangay 20", "Barangay 21", "Barangay 22", "Barangay 23", "Barangay 24", "Barangay 25", "Barangay 26", "Barangay 27", "Barangay 28", "Barangay 29", "Barangay 3", "Barangay 30", "Barangay 31", "Barangay 32", "Barangay 33", "Barangay 34", "Barangay 35", "Barangay 36", "Barangay 37", "Barangay 38", "Barangay 39", "Barangay 4", "Barangay 40", "Barangay 41", "Barangay 42", "Barangay 43", "Barangay 44", "Barangay 45", "Barangay 46", "Barangay 47", "Barangay 48", "Barangay 49", "Barangay 5", "Barangay 50", "Barangay 51", "Barangay 52", "Barangay 53", "Barangay 54", "Barangay 55", "Barangay 56", "Barangay 57", "Barangay 58", "Barangay 59", "Barangay 6", "Barangay 60", "Barangay 61", "Barangay 62", "Barangay 63", "Barangay 64", "Barangay 65", "Barangay 66", "Barangay 67", "Barangay 68", "Barangay 69", "Barangay 7", "Barangay 70", "Barangay 71", "Barangay 72", "Barangay 73", "Barangay 74", "Barangay 75", "Barangay 76", "Barangay 77", "Barangay 78", "Barangay 79", "Barangay 8", "Barangay 80", "Barangay 81", "Barangay 82", "Barangay 83", "Barangay 84", "Barangay 85", "Barangay 86", "Barangay 87", "Barangay 88", "Barangay 89", "Barangay 9", "Barangay 90", "Barangay 91", "Barangay 92", "Barangay 93", "Barangay 94", "Barangay 95", "Barangay 96", "Barangay 97", "Barangay 98", "Barangay 99", ],
            "Las Piñas City": ["Almanza Dos", "Almanza Uno", "B. F. International Village", "Daniel Fajardo", "Elias Aldana", "Ilaya", "Manuyo Dos", "Manuyo Uno", "Pamplona Dos", "Pamplona Uno", "Pilar", "Pulang Lupas Dos", "Pulang Lupa Uno", "Talon Dos", "Talon Kuatro", "Talon Singko", "Talon Tres", "Talon Uno", "Zapote", ],
            "Makati City": ["Bangkal", "Bel-air", "Carmona", "Cembo", "Comembo", "Dasmarinas", "East Rembo", "Forbes Park", "Guadalupe Nuevo", "Guadalupe Viejo", "Kasilawan", "La Paz", "Magallanes", "Olympia", "Palanan", "Pembo", "Pinagkaisahan", "Pio del Pilar", "Pitogo", "Poblacio", "Post Proper Northside", "Post Proper Southside", "Rizal", "San Antonio", "San Isidro", "San Lorenzo", "Santa Cruz", "Singkamas", "South Cembo", "Tejeros", "Urdaneta", "Valenzuela", "West Rembo", ],
            "Malabon City": ["Acacia", "Baritan", "Bayan-Bayanan", "Catmon", "Concepcion", "Dampalit", "Flores", "Hulong Duhat", "Ibaba", "Longos", "Maysilo", "Muzan", "Niugan", "Panghulo", "Potrero", "San Agustin", "Santolan", "Tanong", "Tinajeros", "Tonsuya", "Tugatog", ], // Add more cities and barangays as needed
            "Mandaluyong City": ["Addition Hills", "Bagong Silang", "Barangka Drive", "Barangka Ibaba", "Barangka Ilaya", "Barangka Itaas", "Buayang Bato", "Burol", "Daang Bakal", "Hagdang Bato Itaas", "Hagdang Bato Libis", "Harapin Ang Bukas", "Highway Hills", "Hulo", "Mabini- J. Rizal", "Malamig", "Mauway", "Namayan", "New Zaniga", "Old Zaniga", "Pag-asa", "Plainview", "Pleasant Hills", "Poblacion", "San Jose", "Vergara", "Wack-Wack Greenhills", ],

            "Tondo I / li": ["Barangay 1", "Barangay 10", "Barangay 100", "Barangay 101", "Barangay 102", "Barangay 103", "Barangay 104", "Barangay 105", "Barangay 106", "Barangay 107", "Barangay 108", "Barangay 109", "Barangay 11", "Barangay 110", "Barangay 111", "Barangay 112", "Barangay 113", "Barangay 114", "Barangay 115", "Barangay 116", "Barangay 117", "Barangay 118", "Barangay 119", "Barangay 12", "Barangay 120", "Barangay 121", "Barangay 122", "Barangay 123", "Barangay 124", "Barangay 125", "Barangay 126", "Barangay 127", "Barangay 128", "Barangay 129", "Barangay 13", "Barangay 130", "Barangay 131", "Barangay 132", "Barangay 133", "Barangay 134", "Barangay 135", "Barangay 136", "Barangay 137", "Barangay 138", "Barangay 139", "Barangay 14", "Barangay 14", "Barangay 140", "Barangay 141", "Barangay 142", "Barangay 143", "Barangay 144", "Barangay 145", "Barangay 146", "Barangay 147", "Barangay 148", "Barangay 149", "Barangay 15", "Barangay 150", "Barangay 151", "Barangay 152", "Barangay 153", "Barangay 154", "Barangay 155", "Barangay 156", "Barangay 157", "Barangay 158", "Barangay 159", "Barangay 16", "Barangay 160", "Barangay 161", "Barangay 162", "Barangay 163", "Barangay 164", "Barangay 165", "Barangay 166", "Barangay 167", "Barangay 168", "Barangay 169", "Barangay 17", "Barangay 170", "Barangay 171", "Barangay 172", "Barangay 173", "Barangay 174", "Barangay 175", "Barangay 176", "Barangay 177", "Barangay 178", "Barangay 179", "Barangay 18", "Barangay 180", "Barangay 181", "Barangay 182", "Barangay 183", "Barangay 184", "Barangay 185", "Barangay 186", "Barangay 187", "Barangay 188", "Barangay 189", "Barangay 19", "Barangay 190", "Barangay 191", "Barangay 192", "Barangay 193", "Barangay 194", "Barangay 195", "Barangay 196", "Barangay 197", "Barangay 198", "Barangay 199", "Barangay 2", "Barangay 20", "Barangay 200", "Barangay 201", "Barangay 201", "Barangay 202-A", "Barangay 203", "Barangay 204", "Barangay 205", "Barangay 206", "Barangay 207", "Barangay 208", "Barangay 209", "Barangay 210", "Barangay 211", "Barangay 212", "Barangay 213", "Barangay 214", "Barangay 215", "Barangay 216", "Barangay 217", "Barangay 218", "Barangay 219", "Barangay 220", "Barangay 221", "Barangay 222", "Barangay 223", "Barangay 224", "Barangay 225", "Barangay 226", "Barangay 227", "Barangay 228", "Barangay 229", "Barangay 230", "Barangay 231", "Barangay 232", "Barangay 233", "Barangay 234", "Barangay 235", "Barangay 236", "Barangay 237", "Barangay 238", "Barangay 239", "Barangay 240", "Barangay 241", "Barangay 242", "Barangay 243", "Barangay 244", "Barangay 245", "Barangay 246", "Barangay 247", "Barangay 248", "Barangay 249", "Barangay 25", "Barangay 250", "Barangay 251", "Barangay 252", "Barangay 253", "Barangay 254", "Barangay 255", "Barangay 256", "Barangay 257", "Barangay 258", "Barangay 259", "Barangay 26", "Barangay 261", "Barangay 262", "Barangay 263", "Barangay 264", "Barangay 265", "Barangay 266", "Barangay 267", "Barangay 28", "Barangay 29", "Barangay 3", "Barangay 30", "Barangay 31", "Barangay 32", "Barangay 33", "Barangay 34", "Barangay 35", "Barangay 36", "Barangay 37", "Barangay 38", "Barangay 39", "Barangay 4", "Barangay 41", "Barangay 42", "Barangay 43", "Barangay 44", "Barangay 45", "Barangay 46", "Barangay 47", "Barangay 48", "Barangay 49", "Barangay 5", "Barangay 50", "Barangay 51", "Barangay 52", "Barangay 53", "Barangay 54", "Barangay 55", "Barangay 56", "Barangay 57", "Barangay 58", "Barangay 59", "Barangay 6", "Barangay 60", "Barangay 61", "Barangay 62", "Barangay 63", "Barangay 64", "Barangay 65", "Barangay 66", "Barangay 67", "Barangay 68", "Barangay 69", "Barangay 7", "Barangay 70", "Barangay 71", "Barangay 72", "Barangay 73", "Barangay 74", "Barangay 75", "Barangay 76", "Barangay 77", "Barangay 78", "Barangay 79", "Barangay 8", "Barangay 80", "Barangay 81", "Barangay 82", "Barangay 83", "Barangay 84", "Barangay 85", "Barangay 86", "Barangay 87", "Barangay 88", "Barangay 89", "Barangay 9", "Barangay 90", "Barangay 91", "Barangay 92", "Barangay 93", "Barangay 92", "Barangay 93", "Barangay 94", "Barangay 95", "Barangay 96", "Barangay 97", "Barangay 98", "Barangay 99", ],
            "Binondo": ["Barangay 287", "Barangay 288", "Barangay 289", "Barangay 290", "Barangay 291", "Barangay 292", "Barangay 293", "Barangay 294", "Barangay 295", "Barangay 296", ],
            "Ermita": ["Barangay 659", "Barangay 659-A", "Barangay 660", "Barangay 660-A", "Barangay 661", "Barangay 663", "Barangay 663-A", "Barangay 664", "Barangay 666", "Barangay 667", "Barangay 668", "Barangay 669", "Barangay 670", ],
            "Intramuros": ["Barangay 654", "Barangay 655", "Barangay 656", "Barangay 657", "Barangay 658", ],
            "Malate": ["Barangay 688", "Barangay 689", "Barangay 690", "Barangay 691", "Barangay 692", "Barangay 693", "Barangay 694", "Barangay 695", "Barangay 696", "Barangay 697", "Barangay 698", "Barangay 699", "Barangay 700", "Barangay 701", "Barangay 702", "Barangay 703", "Barangay 704", "Barangay 705", "Barangay 706", "Barangay 707", "Barangay 708", "Barangay 709", "Barangay 710", "Barangay 711", "Barangay 712", "Barangay 713", "Barangay 714", "Barangay 715", "Barangay 716", "Barangay 717", "Barangay 718", "Barangay 719", "Barangay 720", "Barangay 721", "Barangay 722", "Barangay 723", "Barangay 724", "Barangay 725", "Barangay 726", "Barangay 727", "Barangay 728", "Barangay 729", "Barangay 730", "Barangay 731", "Barangay 732", "Barangay 733", "Barangay 734", "Barangay 735", "Barangay 736", "Barangay 737", "Barangay 738", "Barangay 739", "Barangay 740", "Barangay 741", "Barangay 742", "Barangay 743", "Barangay 744", ],
            "Paco": ["Barangay 662", "Barangay 664-A", "Barangay 671", "Barangay 672", "Barangay 673", "Barangay 674", "Barangay 675", "Barangay 676", "Barangay 677", "Barangay 678", "Barangay 679", "Barangay 680", "Barangay 681", "Barangay 682", "Barangay 683", "Barangay 684", "Barangay 685", "Barangay 686", "Barangay 687", "Barangay 809", "Barangay 810", "Barangay 811", "Barangay 812", "Barangay 813", "Barangay 814", "Barangay 815", "Barangay 816", "Barangay 817", "Barangay 818", "Barangay 819", "Barangay 820", "Barangay 821", "Barangay 822", "Barangay 823", "Barangay 824", "Barangay 825", "Barangay 826", "Barangay 827", "Barangay 828", "Barangay 829", "Barangay 830", "Barangay 831", "Barangay 832", ],
            "Pandacan": ["Barangay 833", "Barangay 834", "Barangay 835", "Barangay 836", "Barangay 837", "Barangay 838", "Barangay 839", "Barangay 840", "Barangay 841", "Barangay 842", "Barangay 843", "Barangay 844", "Barangay 845", "Barangay 846", "Barangay 847", "Barangay 848", "Barangay 849", "Barangay 850", "Barangay 851", "Barangay 852", "Barangay 853", "Barangay 854", "Barangay 855", "Barangay 856", "Barangay 857", "Barangay 858", "Barangay 859", "Barangay 860", "Barangay 861", "Barangay 862", "Barangay 863", "Barangay 864", "Barangay 865", "Barangay 866", "Barangay 867", "Barangay 868", "Barangay 869", "Barangay 870", "Barangay 871", "Barangay 872", ],
            "Port Area": ["Barangay 649", "Barangay 650", "Barangay 651", "Barangay 652", "Barangay 653", ],
            "Quiapo": ["Barangay 306", "Barangay 307", "Barangay 308", "Barangay 309", "Barangay 383", "Barangay 384", "Barangay 385", "Barangay 386", "Barangay 387", "Barangay 388", "Barangay 389", "Barangay 390", "Barangay 391", "Barangay 392", "Barangay 393", "Barangay 394", ],
            "Sampaloc": ["Barangay 395", "Barangay 396", "Barangay 397", "Barangay 398", "Barangay 399", "Barangay 400", "Barangay 401", "Barangay 402", "Barangay 403", "Barangay 404", "Barangay 405", "Barangay 406", "Barangay 407", "Barangay 408", "Barangay 409", "Barangay 410", "Barangay 411", "Barangay 412", "Barangay 413", "Barangay 414", "Barangay 415", "Barangay 416", "Barangay 417", "Barangay 418", "Barangay 419", "Barangay 420", "Barangay 421", "Barangay 423", "Barangay 424", "Barangay 425", "Barangay 426", "Barangay 427", "Barangay 428", "Barangay 429", "Barangay 430", "Barangay 431", "Barangay 432", "Barangay 433", "Barangay 434", "Barangay 435", "Barangay 436", "Barangay 437", "Barangay 438", "Barangay 439", "Barangay 440", "Barangay 441", "Barangay 442", "Barangay 443", "Barangay 444", "Barangay 445", "Barangay 446", "Barangay 447", "Barangay 448", "Barangay 449", "Barangay 450", "Barangay 451", "Barangay 452", "Barangay 453", "Barangay 454", "Barangay 456", "Barangay 457", "Barangay 458", "Barangay 459", "Barangay 460", "Barangay 461", "Barangay 462", "Barangay 463", "Barangay 464", "Barangay 465", "Barangay 466", "Barangay 467", "Barangay 468", "Barangay 469", "Barangay 470", "Barangay 471", "Barangay 472", "Barangay 473", "Barangay 474", "Barangay 475", "Barangay 476", "Barangay 477", "Barangay 478", "Barangay 479", "Barangay 480", "Barangay 481", "Barangay 482", "Barangay 483", "Barangay 484", "Barangay 485", "Barangay 486", "Barangay 487", "Barangay 488", "Barangay 489", "Barangay 490", "Barangay 491", "Barangay 492", "Barangay 493", "Barangay 494", "Barangay 495", "Barangay 496", "Barangay 497", "Barangay 498", "Barangay 499", "Barangay 500", "Barangay 501", "Barangay 502", "Barangay 503", "Barangay 504", "Barangay 505", "Barangay 506", "Barangay 507", "Barangay 508", "Barangay 509", "Barangay 510", "Barangay 511", "Barangay 512", "Barangay 513", "Barangay 514", "Barangay 515", "Barangay 516", "Barangay 517", "Barangay 518", "Barangay 519", "Barangay 520", "Barangay 521", "Barangay 522", "Barangay 523", "Barangay 524", "Barangay 525", "Barangay 526", "Barangay 527", "Barangay 528", "Barangay 529", "Barangay 530", "Barangay 531", "Barangay 532", "Barangay 533", "Barangay 534", "Barangay 535", "Barangay 536", "Barangay 537", "Barangay 538", "Barangay 539", "Barangay 540", "Barangay 541", "Barangay 542", "Barangay 543", "Barangay 544", "Barangay 545", "Barangay 546", "Barangay 547", "Barangay 548", "Barangay 549", "Barangay 550", "Barangay 551", "Barangay 552", "Barangay 553", "Barangay 554", "Barangay 555", "Barangay 556", "Barangay 557", "Barangay 558", "Barangay 559", "Barangay 560", "Barangay 561", "Barangay 562", "Barangay 563", "Barangay 564", "Barangay 565", "Barangay 566", "Barangay 567", "Barangay 568", "Barangay 569", "Barangay 570", "Barangay 571", "Barangay 572", "Barangay 572", "Barangay 573", "Barangay 574", "Barangay 575", "Barangay 576", "Barangay 577", "Barangay 578", "Barangay 579", "Barangay 580", "Barangay 581", "Barangay 582", "Barangay 583", "Barangay 584", "Barangay 585", "Barangay 586", "Barangay 587", "Barangay 587-A", "Barangay 588", "Barangay 589", "Barangay 590", "Barangay 591", "Barangay 592", "Barangay 593", "Barangay 594", "Barangay 595", "Barangay 596", "Barangay 597", "Barangay 598", "Barangay 599", "Barangay 600", "Barangay 601", "Barangay 602", "Barangay 603", "Barangay 604", "Barangay 605", "Barangay 606", "Barangay 607", "Barangay 608", "Barangay 609", "Barangay 610", "Barangay 611", "Barangay 612", "Barangay 613", "Barangay 614", "Barangay 615", "Barangay 616", "Barangay 617", "Barangay 618", "Barangay 619", "Barangay 620", "Barangay 621", "Barangay 622", "Barangay 623", "Barangay 624", "Barangay 625", "Barangay 626", "Barangay 627", "Barangay 628", "Barangay 629", "Barangay 630", "Barangay 631", "Barangay 632", "Barangay 6033", "Barangay 634", "Barangay 635", "Barangay 636", ],
            "San Miguel": ["Barangay 637", "Barangay 638", "Barangay 639", "Barangay 640", "Barangay 641", "Barangay 642", "Barangay 643", "Barangay 644", "Barangay 645", "Barangay 646", "Barangay 647", "Barangay 648", ],
            "San Nicolas": ["Barangay 268", "Barangay 269", "Barangay 270", "Barangay 271", "Barangay 272", "Barangay 273", "Barangay 274", "Barangay 275", "Barangay 276", "Barangay 277", "Barangay 278", "Barangay 279", "Barangay 280", "Barangay 281", "Barangay 282", "Barangay 283", "Barangay 284", "Barangay 285", "Barangay 286", ],
            "Santa Ana": ["Barangay 745", "Barangay 746", "Barangay 747", "Barangay 748", "Barangay 749", "Barangay 750", "Barangay 751", "Barangay 752", "Barangay 753", "Barangay 754", "Barangay 755", "Barangay 756", "Barangay 757", "Barangay 758", "Barangay 759", "Barangay 760", "Barangay 761", "Barangay 762", "Barangay 763", "Barangay 764", "Barangay 765", "Barangay 766", "Barangay 767", "Barangay 768", "Barangay 769", "Barangay 770", "Barangay 771", "Barangay 772", "Barangay 773", "Barangay 774", "Barangay 775", "Barangay 776", "Barangay 778", "Barangay 779", "Barangay 780", "Barangay 781", "Barangay 782", "Barangay 783", "Barangay 784", "Barangay 785", "Barangay 786", "Barangay 787", "Barangay 788", "Barangay 789", "Barangay 790", "Barangay 791", "Barangay 792", "Barangay 793", "Barangay 794", "Barangay 795", "Barangay 796", "Barangay 787", "Barangay 798", "Barangay 799", "Barangay 800", "Barangay 801", "Barangay 802", "Barangay 803", "Barangay 804", "Barangay 805", "Barangay 806", "Barangay 808", "Barangay 818-A", "Barangay 866", "Barangay 873", "Barangay 874", "Barangay 875", "Barangay 876", "Barangay 877", "Barangay 878", "Barangay 879", "Barangay 880", "Barangay 881", "Barangay 882", "Barangay 883", "Barangay 884", "Barangay 885", "Barangay 886", "Barangay 887", "Barangay 888", "Barangay 889", "Barangay 890", "Barangay 891", "Barangay 892", "Barangay 893", "Barangay 894", "Barangay 895", "Barangay 896", "Barangay 897", "Barangay 890", "Barangay 891", "Barangay 892", "Barangay 893", "Barangay 894", "Barangay 895", "Barangay 896", "Barangay 897", "Barangay 898", "Barangay 899", "Barangay 900", "Barangay 901", "Barangay 902", "Barangay 903", "Barangay 904", "Barangay 905", ],
            "Santa Cruz": ["Barangay 297", "Barangay 298", "Barangay 299", "Barangay 300", "Barangay 301", "Barangay 302", "Barangay 303", "Barangay 304", "Barangay 305", "Barangay 306", "Barangay 307", "Barangay 308", "Barangay 309", "Barangay 310", "Barangay 311", "Barangay 312", "Barangay 313", "Barangay 314", "Barangay 315", "Barangay 316", "Barangay 317", "Barangay 318", "Barangay 319", "Barangay 320", "Barangay 321", "Barangay 322", "Barangay 323", "Barangay 324", "Barangay 325", "Barangay 326", "Barangay 327", "Barangay 328", "Barangay 329", "Barangay 330", "Barangay 331", "Barangay 332", "Barangay 333", "Barangay 334", "Barangay 335", "Barangay 336", "Barangay 337", "Barangay 338", "Barangay 339", "Barangay 340", "Barangay 341", "Barangay 342", "Barangay 343", "Barangay 344", "Barangay 345", "Barangay 346", "Barangay 347", "Barangay 348", "Barangay 349", "Barangay 350", "Barangay 351", "Barangay 352", "Barangay 353", "Barangay 354", "Barangay 355", "Barangay 356", "Barangay 357", "Barangay 358", "Barangay 359", "Barangay 360", "Barangay 361", "Barangay 362", "Barangay 363", "Barangay 364", "Barangay 365", "Barangay 366", "Barangay 367", "Barangay 368", "Barangay 369", "Barangay 370", "Barangay 371", "Barangay 372", "Barangay 373", "Barangay 374", "Barangay 375", "Barangay 376", "Barangay 377", "Barangay 378", "Barangay 379", "Barangay 380", "Barangay 381", "Barangay 382", ],
            "Santa Mesa": ["Barangay 587", "Barangay 587-A", "Barangay 588", "Barangay 589", "Barangay 590", "Barangay 591", "Barangay 592", "Barangay 593", "Barangay 594", "Barangay 595", "Barangay 596", "Barangay 597", "Barangay 598", "Barangay 599", "Barangay 600", "Barangay 601", "Barangay 602", "Barangay 603", "Barangay 604", "Barangay 605", "Barangay 606", "Barangay 607", "Barangay 608", "Barangay 609", "Barangay 610", "Barangay 611", "Barangay 612", "Barangay 613", "Barangay 614", "Barangay 615", "Barangay 617", "Barangay 618", "Barangay 619", "Barangay 620", "Barangay 621", "Barangay 622", "Barangay 623", "Barangay 624", "Barangay 625", "Barangay 626", "Barangay 627", "Barangay 628", "Barangay 629", "Barangay 630", "Barangay 631", "Barangay 632", "Barangay 633", "Barangay 634", "Barangay 635", "Barangay 636", ],

            "Marikina City": ["Barangka", "Calumpang", "Concepcion Dos", "Concepcion Uno", "Fortune", "Industrial Valley", "Jesus De La Pena", "Malanday", "Marikina Heights (Concepcion)", "Nangka", "Parang", "San Roque", "Santa Elena", "Santo Nino", "Tanong", "Tumana", ],
            "Muntinlupa City": ["Alabang", "Ayala Alabang", "Bayanan", "Buli", "Cupang", "Poblacion", "Putatan", "Sucat", "Tunasan", ],
            "Navotas City": ["Bagumbayan North", "Bagumbayan South", "Bangculasi", "Daanghari", "Navotas East", "Navotas West", "North Bay blvd.", "San Jose", "San Rafael Village", "San Roque", "Barangay 390", "Sipac-Almacen", "Tangos", "Tanza"],
            "Parañaque City": ["B. F. Homes", "Baclaran", "Don Bosco", "Don Galo", "La Huerta", "Marcelo Green Village", "Merville", "Moonwalk", "San Antonio", "San Dionisio", "San Isidro", "San Martin De Porres", "Santo Nino", "Sun Valley", "Tambo", "Vitalez", ],
            "Pasay City": ["Barangay 1", "Barangay 10", "Barangay 100", "Barangay 101", "Barangay 102", "Barangay 103", "Barangay 104", "Barangay 105", "Barangay 106", "Barangay 107", "Barangay 108", "Barangay 109 ", "Barangay 11 ", "Barangay 110 ", "Barangay 111 ", "Barangay 112", "Barangay 113", "Barangay 114", "Barangay 115", "Barangay 116", "Barangay 117", "Barangay 118", "Barangay 119", "Barangay 12", "Barangay 120", "Barangay 121", "Barangay 122", "Barangay 123", "Barangay 124", "Barangay 125", "Barangay 126", "Barangay 127", "Barangay 128", "Barangay 129", "Barangay 13", "Barangay 130", "Barangay 131", "Barangay 132", "Barangay 133", "Barangay 134", "Barangay 135", "Barangay 136", "Barangay 137", "Barangay 138", "Barangay 139", "Barangay 14", "Barangay 14", "Barangay 140", "Barangay 141", "Barangay 142", "Barangay 143", "Barangay 144", "Barangay 145", "Barangay 146", "Barangay 147", "Barangay 148", "Barangay 149", "Barangay 15", "Barangay 150", "Barangay 151", "Barangay 152", "Barangay 153", "Barangay 154", "Barangay 155", "Barangay 156", "Barangay 157", "Barangay 158", "Barangay 159", "Barangay 16", "Barangay 160", "Barangay 161", "Barangay 162", "Barangay 163", "Barangay 164", "Barangay 165", "Barangay 166", "Barangay 167", "Barangay 168", "Barangay 169", "Barangay 17", "Barangay 170", "Barangay 171", "Barangay 172", "Barangay 173", "Barangay 174", "Barangay 175", "Barangay 176", "Barangay 177", "Barangay 178", "Barangay 179", "Barangay 18", "Barangay 180", "Barangay 181", "Barangay 182", "Barangay 183", "Barangay 184", "Barangay 185", "Barangay 186", "Barangay 187", "Barangay 188", "Barangay 189", "Barangay 19", "Barangay 190", "Barangay 191", "Barangay 192", "Barangay 193", "Barangay 194", "Barangay 195", "Barangay 196", "Barangay 197", "Barangay 198", "Barangay 199", "Barangay 2", "Barangay 20", "Barangay 200", "Barangay 201", "Barangay 21", "Barangay 22", "Barangay 23", "Barangay 24", "Barangay 25", "Barangay 26", "Barangay 27", "Barangay 28", "Barangay 29", "Barangay 3", "Barangay 30", "Barangay 31", "Barangay 32", "Barangay 33", "Barangay 34", "Barangay 35", "Barangay 36", "Barangay 37", "Barangay 38", "Barangay 39", "Barangay 4", "Barangay 40", "Barangay 41", "Barangay 42", "Barangay 43", "Barangay 44", "Barangay 45", "Barangay 46", "Barangay 47", "Barangay 48", "Barangay 49", "Barangay 5", "Barangay 50", "Barangay 51", "Barangay 52", "Barangay 53", "Barangay 54", "Barangay 55", "Barangay 56", "Barangay 57", "Barangay 58", "Barangay 59", "Barangay 6", "Barangay 60", "Barangay 61", "Barangay 62", "Barangay 63", "Barangay 64", "Barangay 65", "Barangay 66", "Barangay 67", "Barangay 68", "Barangay 69", "Barangay 7", "Barangay 70", "Barangay 71", "Barangay 72", "Barangay 73", "Barangay 74", "Barangay 75", "Barangay 76", "Barangay 77", "Barangay 78", "Barangay 79", "Barangay 8", "Barangay 80", "Barangay 81", "Barangay 82", "Barangay 83", "Barangay 84", "Barangay 85", "Barangay 86", "Barangay 87", "Barangay 88", "Barangay 89", "Barangay 9", "Barangay 90", "Barangay 91", "Barangay 92", "Barangay 93", "Barangay 94", "Barangay 95", "Barangay 96", "Barangay 97", "Barangay 98", "Barangay 99", ],
            "Pasig City": ["Bagong Ilog", "Bagong Katipunan", "Bambang", "Buting", "Caniogan", "Dela Paz", "Kalawaan", "Kasipagan", "Kapitolyo", "Malinao", "Manggahan", "Maybunga", "Oranbo", "Palatiw", "Pinagbuhatan", "Pineda", "Rosario", "Sagad", "San Antonio", "San Joaquin", "San Jose", "San Miguel", "San Nicolas", "Santa Cruz", "Santa Lucia", "Santa Rosa", "Santo Tomas", "Santolan", "Sumilang", "Ugong", ],
            "Pateros City": ["Aguho", "Magtanggol", "Martires Del 96", "Poblacion", "San Pedro", "San Roque", "Santa Ana", "Santo Rosario-Kanluran", "Santo Rosario-Silangan", "Tabacalera", ],
            "Quezon City": ["Agdangan", "Alabat", "Atimonan", "Buenavista",
                "Burdeos",
                "Calauag",
                "Candelaria",
                "Dolores",
                "General Luna",
                "General Nakar",
                "Guinayangan",
                "Infanta",
                "Jomalig",
                "Lopez",
                "Lucban",
                "Lucena",
                "Macalelon",
                "Mauban",
                "Mulanay",
                "Padre Burgos",
                "Pagbilao",
                "Panukulan",
                "Patnanungan",
                "Perez",
                "Pitogo", "Plaridel", "Polillo", "Quezon", "Real", "Sampaloc", "San Andres", "San Antonio", "San Francisco", "Sariaya", "Tagkawayan", "Tayabas", "Tiaong", "Unisan",
            ],
            "Taguig City": ["Bagumbayan",
                "Bambang",
                "Calzada",
                "Central Bicutan",
                "Central Signal Village",
                "Fort Bonifacio",
                "Hagonoy",
                "Ibayo Tipas",
                "Katuparan",
                "Ligid Tipas",
                "Lower Bicutan",
                "Napindan",
                "New Lower Bicutan",
                "North Signal Village",
                "Palingon",
                "Pinagsama",
                "San Miguel",
                "Santa Ana",
                "South Daan Hari",
                "South Signal Village",
                "Tanyag",
                "Tuktukan",
                "Upper Bicutan",
                "Ususan",
                "Wawa",
                "Western Bicutan",
            ],
            "San Juan City": ["Addition Hills",
                "Balong bato",
                "Batis",
                "Corazon De Jesus",
                "Ermitano",
                "Greenhills",
                "Halo-halo St. Joseph",
                "Isabelita",
                "Kabayanan",
                "Little Baguio",
                "Maytunas",
                "Onse",
                "Pasadena",
                "Pedro Cruz",
                "Progreso",
                "Rivera",
                "Salapan",
                "San Perfecto",
                "Santa Lucia",
                "Tibagan",
                "West Crame",
            ],
            "Valenzuela City": ["Arkong Bato",
                "Bagbaguin",
                "Balangkas",
                "Bignay",
                "Bisig",
                "Canumay East",
                "Canumay West",
                "Coloong",
                "Dalandanan",
                "Hen.T.Delon",
                "Isla",
                "Karuhatan",
                "Lawang Bato",
                "Lingunan",
                "Mabolo",
                "Malanday",
                "Malinta",
                "Mapulang Lupa",
                "Marulas",
                "Maysan",
                "Palasan",
                "Parada",
                "Pariancillo Villa",
                "Paso De Blas",
                "Pasolo",
                "Poblacion",
                "Pulo",
                "Punturin",
                "Rincon",
                "Tagalag",
                "Ugong",
                "Viente Reales",
                "Wawang Pulo",
            ],
        };

        // Function to update the city options based on the selected province
        function updateCityOptions() {
            var selectedProvince = provinceDropdown.value;
            var cities = cityOptions[selectedProvince] || [];

            // Clear the current options
            cityDropdown.innerHTML = "";

            // Add new options
            for (var i = 0; i < cities.length; i++) {
                var option = document.createElement("option");
                option.value = cities[i];
                option.textContent = cities[i];
                cityDropdown.appendChild(option);
            }

            // Update the barangay options when the city changes
            updateBarangayOptions();
        }

        // Function to update the barangay options based on the selected city
        function updateBarangayOptions() {
            var selectedCity = cityDropdown.value;
            var barangays = barangayOptions[selectedCity] || [];

            // Clear the current options
            barangayDropdown.innerHTML = "";

            // Add new options
            for (var i = 0; i < barangays.length; i++) {
                var option = document.createElement("option");
                option.value = barangays[i];
                option.textContent = barangays[i];
                barangayDropdown.appendChild(option);
            }
        }

        // Add event listeners to update the city and barangay options
        provinceDropdown.addEventListener("change", updateCityOptions);
        cityDropdown.addEventListener("change", updateBarangayOptions);

        // Initially update the city options based on the default selected province
        updateCityOptions();
    });
</script>


</html>