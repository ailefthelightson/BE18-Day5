<?php
session_start();


if(isset($_SESSION["adm"])){
    header("Location: dashboard.php");
}elseif(!isset($_SESSION["user"])){
    header("Location: index.php");
}

require_once "components/db_connect.php";

$sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome <?php echo $row['first_name'];?> </title>
    <?php require_once 'components/boot.php'?>
    
        
</head>
<body>
    <p class="text-purple">hello <?php echo $row['first_name'];?></p>hello world
    <a href="logout.php?logout">sign out</a>
    <a href="update.php?id=<?php echo $_SESSION['user']?>">update your profile</a>
</body>
</html>