<?php

$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$connect = new mysqli($localhost, $username, $password, $dbname);

if($connect->connect_error){
    die("connection failed:" . $connect->connect_error);
}else {
    // echo "successfully completed <br>";
}

// echo $_SERVER['PHP_SELF'];