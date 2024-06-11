<?php
session_start();
unset($_SESSION['loged']);
unset($_SESSION['loged_user_id']);
header("Location: loginPage.php");
?>