<?php
session_start();
unset($_SESSION['tdbAdminFirstname']);
unset($_SESSION['tdbAdminEmail']);
unset($_SESSION['tdbAdminImage']);
session_destroy();
header("location: ../../adminLogin.php");
