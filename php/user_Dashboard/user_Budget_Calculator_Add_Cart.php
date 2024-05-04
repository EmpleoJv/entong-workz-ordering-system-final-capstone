<?php
include "../connection/dbConnection.php";
include "../connection/dbTemporary.php";
if (isset($_POST['start'])) {
    $serializedArray = $_POST["idStorageInput"];
    $idArray = json_decode($serializedArray); // Decode the JSON array
    // Now you can use the $idArray in your PHP code
    if ($idArray == null) {
        header("Location: user_Budget_Calculator.php");
    }
    $arrayCount = count($idArray);
    // echo "The number of elements in the array is: " . $arrayCount;
    // output data of each row

    for ($i = 0; $i < $arrayCount; $i++) {
        $orderIH_i = $idArray[$i];

        echo "Checking item ID: " . $orderIH_i . "<br>";


        $sqlChecker = "SELECT ITEM_ID FROM usercart WHERE ITEM_ID = '$orderIH_i' AND USER_ID = $tdbAdminId;";
        $resultChecker = $conn->query($sqlChecker);

        if ($resultChecker->num_rows > 0) {
            // Item exists in usercart
            $checker = 1;
            // echo "Same " . $checker . "<br>";
        } else {
            // Item does not exist in usercart
            $checker = 0;
            // echo "Not Same " . $checker . "<br>";
        }

        if ($checker == 1) {
            echo "same <br>";
            $sqlAddingQuantity = "UPDATE usercart SET ORDER_QUANTITY = ORDER_QUANTITY + 1 WHERE ITEM_ID = $orderIH_i AND USER_ID = $tdbAdminId;";
            if ($conn->query($sqlAddingQuantity) === true) {
                echo "good na goods<br>";
            } else {
                echo "good pero hindi na add";
            }
        } else {
            echo "same not <br>";

            $sql = "SELECT * FROM items WHERE ITEM_ID ='$orderIH_i';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) == 1) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $fromDBName = $row['ITEM_NAME'];
                    $fromDBImage = $row['ITEM_IMAGE'];
                    $fromDBDescription = $row['ITEM_DESCRIPTION'];
                    $fromDBQuantity = $row['ITEM_QUANTITY'];
                    $fromDBItemQuan = 1;
                    $fromDBPrice = $row['ITEM_PRICE'];
                    $fromDBCategory = $row['ITEM_CATEGORY'];

                    $sqls = "INSERT INTO usercart (ITEM_ID, USER_ID, ITEM_NAME, ITEM_IMAGE, ITEM_DESCRIPTION, ORDER_QUANTITY, ITEM_CATEGORY, ITEM_PRICE)
                                     VALUES ('$orderIH_i','$tdbAdminId','$fromDBName','$fromDBImage','$fromDBDescription','$fromDBItemQuan','$fromDBCategory','$fromDBPrice');";

                    if ($conn->query($sqls) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sqls . "<br>" . mysqli_error($conn);
                    }
                }
            } else {
                // header("Location: ../../adminLogin.php?error=Incorrect User name or password");
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            // echo $orderIH_i . "<br>";
        }
    }
    header("Location: user_Add_To_Cart.php?selectItemMessage=Item Successfully Added");
}
