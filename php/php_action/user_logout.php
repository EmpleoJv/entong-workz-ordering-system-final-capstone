<?php
session_start();
unset($_SESSION['tdbAdminFirstname']);
unset($_SESSION['tdbAdminEmail']);
unset($_SESSION['tdbAdminImage']);
session_destroy();
header("location: ../../user_Dashboard.php");
