<?php
include('../connection/dbConnection.php');
include('../connection/dbTemporary.php');

if (!isset($_SESSION['tdbAdminEmail'])) {
    header('location: adminLogin.php');
}

include '../connection/dbConnection.php';
// Include the database configuration file 
$photosHasBeenUploaded = 0;
$mainID = $_GET['id']; //this is from adminAddUser.php

if (isset($_POST['submit'])) {
    // File upload configuration 
    $targetDir = "../../img/itemPhotos/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    $fileNames = array_filter($_FILES['files']['name']);
    if (!empty($fileNames)) {
        foreach ($_FILES['files']['name'] as $key => $val) {
            // File upload path 
            $fileName = basename($_FILES['files']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server 
                if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                    // Image db insert sql 
                    // $insertValuesSQL .= "('" . $fileName . "'),";
                    $insertValuesSQL .= "('" . $fileName . "', '" . $mainID . "'),";
                } else {
                    $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
                }
            } else {
                $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
            }
        }

        $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
        $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
        $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;

        if (!empty($insertValuesSQL)) {
            $insertValuesSQL = trim($insertValuesSQL, ',');
            // Insert image file name into database 
            $insert = $conn->query("INSERT INTO itemimages (ITEM_FILENAME, ITEM_ID) VALUES $insertValuesSQL");

            if ($insert > 0) {
                // $statusMsg = "Files are uploaded successfully." . $errorMsg;
                header("Location: ../../admin_Dashboard_Inventory.php?msg=Images are uploaded successfully." . $errorMsg);
            } else {
                // $statusMsg = "Sorry, there was an error uploading your file.";
                header("Location: ../../admin_Dashboard_Inventory.php?msg=There's an error while uploading image" . $insertValuesSQL);
            }
        } else {
            // $statusMsg = "Upload failed! " . $errorMsg;
            header("Location: ../../admin_Dashboard_Inventory.php?msg=The Error is. " . $errorMsg);
        }
    } else {
        // $statusMsg = 'Please select a file to upload.';
        header("Location: ../../admin_Dashboard_Inventory.php?msg=You didn't Upload anything");
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
    <link rel="stylesheet" href="../../css/add_Item_Image.css">

    <title>Document</title>

</head>

<body>
    <div class="sideNav" id="sideNav">
        <h1>Admin</h1>
        <div class="profile">
            <a href="../../admin_Dashboard.php">
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
            <div style="background-color: #16324E;">
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
        <a href="../admin_Dasboard_ChatBox/admin_Dashboard_ChatBox.php" class="list">
            <div>
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
            <h1>ADD ITEM IMAGE</h1>
            <a href="../php_action/admin_logout.php" class="logout">logout</a>

        </nav>
        <?php
        if (isset($_GET['msg'])) { ?>
            <p class="msg"><?php echo $_GET['msg']; ?></p>
        <?php } ?>
        <div class="container">
            <div class="form_Container">
                <h2>Upload Images:</h2>
                <form action="#" method="post" enctype="multipart/form-data">
                    Select Image Files to Upload:
                    <input type="file" name="files[]" id="files" onChange="makeFileList();" accept=".jpg, .jpeg, .png" multiple>
                    <br>
                    <input type="submit" name="submit" value="UPLOAD">
                </form>
                <p>
                    <strong>Files You Selected:</strong>
                </p>
                <ul id="fileList">
                    <li>No Files Selected</li>
                </ul>
            </div>
            <div class="gallery_Container">
                <h2>Item Images</h2>
                <div class="main_Gallery">
                    <form action="../php_action/delete_Image_From_Add_Item_Image.php" method="POST">
                        <table class="table" width="600">
                            <tr>
                                <th>IMAGE</th>
                                <th>ITEM_ID</th>
                                <th><button type="submit" name="start_Delete" style="background-color: #16324E; color:aliceblue;">DELETE</button></th>
                            </tr>
                            <?php
                            $sqlQuery = "SELECT * FROM itemimages WHERE ITEM_ID = $mainID";
                            $sendQuery = $conn->query($sqlQuery);

                            if ($sendQuery->num_rows > 0) {
                                while ($row = $sendQuery->fetch_assoc()) {
                                    $imageUrl = '../../img/itemPhotos/' . $row["ITEM_FILENAME"];
                            ?>
                                    <tr>
                                        <td><img src="<?php echo $imageUrl; ?>" alt="images"></td>
                                        <td class="file_name"><?php echo $row["ITEM_FILENAME"]; ?></td>
                                        <td>
                                            <input type="checkbox" name="deleted_Checked_Id[]" value="<?php echo $row["ID"]; ?>">
                                        </td>
                                    </tr>
                                <?php

                                }
                            } else {
                                ?>
                                <p><?php echo 'No image has been found'; ?></p>
                            <?php
                            }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <script>
        function makeFileList() {
            var input = document.getElementById("files");
            var ul = document.getElementById("fileList");
            while (ul.hasChildNodes()) {
                ul.removeChild(ul.firstChild);
            }
            for (var i = 0; i < input.files.length; i++) {
                var li = document.createElement("li");
                li.innerHTML = input.files[i].name;
                ul.appendChild(li);
            }
            if (!ul.hasChildNodes()) {
                var li = document.createElement("li");
                li.innerHTML = 'No Files Selected';
                ul.appendChild(li);
            }
        }
    </script>
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