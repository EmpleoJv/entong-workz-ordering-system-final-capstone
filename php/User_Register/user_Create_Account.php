<?php
include('../connection/dbConnection.php');
include('../connection/dbConnection.php');
$email = $_GET['passedEmail']; //this is from adminAddUser.php
$number = $_GET['number']; //this is from adminAddUser.php


// if (isset($_REQUEST['signup_Submit'])) {
//     $regFN = $_POST['regFirstname'];
//     $regLN = $_POST['regLastname'];
//     $regEM = $_POST['regEmailTrue'];
//     $regPW = $_POST['regPassword'];
//     $regAG = $_POST['regAge'];
//     $regGD = $_POST['regGender'];
//     $regAD = $_POST['regAddition'];
//     $regPR = $_POST['regProvince'];
//     $regCT = $_POST['regCity'];
//     $regBR = $_POST['regBarangay'];
//     $insert_query = mysqli_query($conn, "INSERT INTO userlogin SET 
//         FIRSTNAME='$regFN', 
//         LASTNAME='$regLN', 
//         EMAIL='$regEM', 
//         PASSWORD='$regPW', 
//         AGE='$regAG',
//         GENDER='$regGD',
//         ADDITIONAL_INFORMATION='$regAD', 
//         PROVINCE='$regPR',
//         CITY_MUNICIPALITY='$regCT',
//         BARANGAY='$regBR';");
//     if ($insert_query > 0) {
//         header("Location: ../../user_Dashboard.php?addMsg=Registered Successfully");
//     } else {
//         header("Location: ../../user_Create_Account_Email.php?msgerror=Can't Register, Try Again");
//     }
// }

if (isset($_REQUEST['signup_Submit'])) {

    $regFN = $_POST['regFirstname'];
    $regLN = $_POST['regLastname'];
    $regNB = $_POST['regNum'];

    $regEM = $_POST['regEmailTrue'];
    $regPW = $_POST['regPassword'];
    $regAG = $_POST['regAge'];
    $regGD = $_POST['regGender'];

    $regAD = $_POST['regAddition'];
    $regPR = $_POST['regProvince'];
    $regCT = $_POST['regCity'];
    $regBR = $_POST['regBarangay'];

    $date = date('Y-m-d');

    $AddUser_image = time() . $_FILES["file_Main_Image"]["name"];



    if (move_uploaded_file($_FILES['file_Main_Image']['tmp_name'], '../../img/userImage/' . $AddUser_image)) {
        $target_file = '../../img/userImage/' . $AddUser_image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $picName = basename($_FILES["file_Main_Image"]["name"]);
        $photo = time() . $picName;
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            header("Location: ../../user_Dashboard.php?msgerror=Wrong File ");
        } else if ($_FILES["file_Main_Image"]["size"] > 20000000) {
            header("Location: ../../user_Dashboard.php?msgerror=To large File");
        } else {
            $picHasBeenUploaded = 1;
        }
    }
    if ($picHasBeenUploaded == 1) {
        $insert_query = mysqli_query($conn, "INSERT INTO userlogin SET 
                IMAGE='$photo',
                FIRSTNAME='$regFN', 
                LASTNAME='$regLN', 
                MOBILE='$regNB', 
                EMAIL='$regEM', 
                PASSWORD='$regPW', 
                AGE='$regAG',
                GENDER='$regGD',
                ADDITIONAL_INFORMATION='$regAD', 
                PROVINCE='$regPR',
                CITY_MUNICIPALITY='$regCT',
                BARANGAY='$regBR',
                DATE='$date';");

        if ($insert_query > 0) {
            header("Location: ../../index.php?failed=Registered Successfully");
        }
    } else {
        unlink("../../img/userImage/" . $AddUser_image);
        header("Location: ../../index.php?failed=an't Register, Try Again");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entong Workz</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <!-- <link rel="stylesheet" href="../../css/footer.css"> -->
    <link rel="stylesheet" href="../../css/user_Create_Account.css">
    <script type="text/javascript">
        window.history.forward();
    </script>
</head>

<body>
    <div class="main_Container">
        <div class="signup_Container">
            <form action="#" method="POST" enctype="multipart/form-data">
                <h3>Sign Up</h3>
                <div class="container_Divider">
                    <div class="img_Input">
                        <h1 class="title">Add Profile Image</h1>
                        <!-- <input type="file" name="file_Main_Image" required>  -->
                        <label for="file_Main_Image" class="file_Main_Image" required>
                            Select Image <br />
                            <!-- <i class="fa fa-2x fa-camera"></i> -->
                            <img src="../../img/icons/im.png" alt="">
                            <input id="file_Main_Image" type="file" name="file_Main_Image" accept=".jpg, .jpeg, .png" required>
                            <br />
                            <span id="imageName"></span>
                        </label>
                    </div>

                    <div class="input_Type">
                        <label for="regFirstname">Firstname</label>
                        <br>
                        <input type="text" name="regFirstname" placeholder="Firstname" required>
                        <br>
                        <label for="regLastname">Lastname</label>
                        <br>
                        <input type="text" name="regLastname" placeholder="Lastname" required>
                        <br>
                        <label for="regEmail">Email</label>
                        <br>
                        <input type="text" name="regEmail" value="<?php echo "$email" ?>" disabled>
                        <input type="hidden" name="regEmailTrue" value="<?php echo "$email" ?>">
                    </div>
                    <div class="input_Type">
                        <label for="regPassword">Password</label>
                        <br>
                        <input type="password" name="regPassword" id="IDpassword" placeholder="Password" minlength="8" maxlength="50" required>
                        <br>
                        <label for="regAge">Age</label>
                        <br>
                        <input type="number" name="regAge" id="regAge" placeholder="Age" minlength="1" maxlength="2" required>
                        <br>
                        <label for="regGender">Sex</label>
                        <br>
                        <select name="regGender" id="idGender" required>
                            <option disabled selected value>-select an option-</option>
                            <option>male</option>
                            <option>female</option>
                        </select>
                        <br>
                        <label for="regNum">Number</label>
                        <br>
                        <input type="text" name="regNum" id="regNum" placeholder="Mobile Number" value="<?php echo $number ?>" maxlength="11" hidden>
                        <input type="text" name="asd" id="asd" placeholder="Mobile Number" value="<?php echo $number ?>" maxlength="11" disabled>
                    </div>
                    <div class="input_Type">
                        <label for="regAddition">House/Unit/Flr #, Bldg Name, Blk or Lot #</label>
                        <br>
                        <input type="text" name="regAddition" placeholder="House# Ex:53 Ayun St." required>
                        <br>
                        <label for="regProvince">Province</label>
                        <br>
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
                        <br>
                        <!-- Add more options as needed -->
                        <!-- </select><br> -->
                        <label for="regCity">City/Municipality</label><br>
                        <select name="regCity" required>

                            <!-- Add more options as needed -->
                        </select><br>
                        <label for="regBarangay">Barangay</label><br>
                        <select name="regBarangay" required>
                            <!-- Add more options as needed -->
                        </select><br>
                    </div>
                </div>
                <br>
                <input type="submit" name="signup_Submit" value="SUBMIT" class="start_Submit">
                <?php
                if (isset($_GET['msg'])) { ?>
                    <p class="msg"><?php echo $_GET['msg']; ?></p>
                <?php } ?>
                <br>
            </form>
        </div>
    </div>
    <footer>
        <div>
            <div class="footLinkLocation">
                <ul>
                    <li><img src="../../img/backgroundImages/icons8-microsoft-admin-64.png" alt=""><a href="../../adminLogin.php">COMPANY LOGIN</a></li>
                    <li><img src="../../img/backgroundImages/icons8-phone-64.png" alt=""><a href="#">+639972957511</a></li>
                </ul>
            </div>
        </div>
    </footer>
    <script>
        // Add an event listener to the input field
        document.getElementById('regNum').addEventListener('input', function() {
            // Get the input value
            var inputValue = this.value;

            // Remove non-digit characters using a regular expression
            var cleanedValue = inputValue.replace(/\D/g, '');

            // Update the input value with the cleaned value
            this.value = cleanedValue;
        });
    </script>
    <script>
        // Add an event listener to the input field
        document.getElementById('regAge').addEventListener('input', function() {
            // Get the input value
            var ageInput = this.value;

            // Check if the input is a negative number
            if (ageInput < 0) {
                // If it's negative, set the input value to 0
                this.value = 0;
            }

            // Check if the input is greater than the maximum allowed value (3)
            if (ageInput > 99) {
                // If it's greater, set the input value to the maximum allowed value (3)
                this.value = 99;
            }
        });

        // Add an event listener to the input fiel
    </script>
    <script>
        let input = document.getElementById("file_Main_Image");
        let imageName = document.getElementById("imageName")

        input.addEventListener("change", () => {
            let inputImage = document.querySelector("input[type=file]").files[0];

            imageName.innerText = inputImage.name;
        })
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
                "Quezon City": ["Agdangan", "Alabat",
                    "Atimonan",
                    "Buenavista",
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



    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get references to the province and city dropdowns
            var provinceDropdown = document.querySelector("select[name='regProvince']");
            var cityDropdown = document.querySelector("select[name='regCity']");

            // Define an object mapping provinces to their corresponding cities
            var cityOptions = {
                "Metro Manila-Caloocan": ["Caloocan City"],
                "Metro Manila-Las Piñas": ["Las Pinas City"],
                "Metro Manila-Makati": ["Makati City"],
                "Metro Manila-Malabon": ["Malabon City"],
                "Metro Manila-Mandaluyong": ["Mandaluyong City"],
                "Metro Manila-Manila": ["Mandaluyong City", "Tondo I / Ii", "Binondo", "Ermita", "Intramuros", "Malate", "Paco", "Pandakan", "Port Area", "Quiapo", "Sampaloc", "San Migeul", "San Nicolas", "Santa Ana", "Santa Cruz", "Santa Meza"],
                "Metro Manila-Marikina": ["Marikina City"],
                "Metro Manila-Muntinlupa": ["Muntinlupa City"],
                "Metro Manila-Navotas": ["Navotas City"],
                "Metro Manila-Parañaque": ["Parañaque City"],
                "Metro Manila-Pasay": ["Pasay City"],
                "Metro Manila-Pateros": ["Pateros City"],
                "Metro Manila-Quezon": ["Quezon City"],
                "Metro Manila-San Juan": ["San Juan City"],
                "Metro Manila-Taguig": ["Taguig City"],
                "Metro Manila-Valenzuela": ["Valenzuela City"],
                // Add more provinces and cities as needed
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
            }

            // Add an event listener to the province dropdown to update city options
            provinceDropdown.addEventListener("change", updateCityOptions);

            // Initially update the city options based on the default selected province
            updateCityOptions();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get references to the province and city dropdowns
            var cityDropdown = document.querySelector("select[name='regCity']");
            var barangayDropdown = document.querySelector("select[name='regBarangay']");

            // Define an object mapping provinces to their corresponding cities
            var barangayDropdown = {
                "Caloocan City": ["Caloocan City"],

                // Add more provinces and cities as needed
            };

            // Function to update the city options based on the selected province
            function updateBarangayOptions() {
                var selectedCity = cityDropdown.value;
                var barangay = barangayOption[selectedCity] || [];

                // Clear the current options
                barangayDropdown.innerHTML = "";

                // Add new options
                for (var i = 0; i < barangay.length; i++) {
                    var option = document.createElement("option");
                    option.value = barangay[i];
                    option.textContent = barangay[i];
                    barangayDropdown.appendChild(option);
                }
            }

            // Add an event listener to the province dropdown to update city options
            cityDropdown.addEventListener("change", updateBarangayOptions);

            // Initially update the city options based on the default selected province
            updateBarangayOptions();
        });
    </script> -->

</body>

</html>