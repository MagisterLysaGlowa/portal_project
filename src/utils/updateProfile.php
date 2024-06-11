<?php
$user_id = $_GET['user_id'];
$name = $_GET['name'];
$surname = $_GET['surname'];
$email = $_GET['email'];
$phone = $_GET['phone'];
$location = $_GET['location'];
$birthday = $_GET['birthday'];

$update_query = "UPDATE user SET name='$name',surname='$surname',email='$email',location='$location',phone_number='$phone',birth_date='$birthday' WHERE user_id=$user_id";
$connect = @new mysqli("localhost","root","","job_portal_db");
$connect->query($update_query);
$connect->close();
?>