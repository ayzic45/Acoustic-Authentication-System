<?php
//connect to server
$conn = mysqli_connect("localhost","u570667022_ukznacoustic","@94ayzic45M","u570667022_ukznacousticDB");
//check connection error
if (mysqli_connect_errno())
{
 echo "Failed To Connect: " . mysqli_connect_error(); //send error message
 die(); //destroy connection
 }
//set timezone
date_default_timezone_set('Africa/Johannesburg');
?>