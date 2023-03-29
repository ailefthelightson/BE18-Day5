
<?php 
// echo $_SERVER['SCRIPT_NAME'];
require_once "components/db_connect.php";
require_once "components/file_upload.php";

function cleanInput($param){
    $clean = trim($param);
    $clean = strip_tags($clean);
    $clean= htmlspecialchars($clean);

    return $clean;
}

$fnameError = $lnameError = $emailError = $dateError = $passError = $first_name = $last_name = $email = "";

if(isset($_POST["register"])){
    // $first_name=trim($_POST["first_name"]);
    // $first_name=strip_tags($first_name);
    // $first_name=htmlspecialchars($first_name);

    $error = false;

    $first_name = cleanInput($_POST["first_name"]);
    $last_name=cleanInput($_POST["last_name"]);
    $password=cleanInput($_POST["password"]);
    $email=cleanInput($_POST["email"]);
    $date_of_birth=cleanInput($_POST["date_of_birth"]);


    if(empty($first_name)){
        $error=true;
        $fnameError = "please enter your first name";
        
    }elseif(strlen($first_name)<3){
        $error=true;
        $fnameError = "first name must have at least 3 characters";
    }elseif(!preg_match("/^[a-zA-Z]+$/",$first_name)){
        $error=true;
        $fnameError="first name must contain only letters and no spaces";
    }

    if(empty($last_name)){
        $error=true;
        $lnameError = "please enter your first name";
    }elseif(strlen($last_name)<3){
        $error=true;
        $lnameError = "first name must have at least 3 characters";
    }elseif(!preg_match("/^[a-zA-Z]+$/",$last_name)){
        $error=true;
        $lnameError="first name must contain only letters and no spaces";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error=true;
        $emailError="Please enter a valid email address";
    }else{
        $query="SELECT email FROM users WHERE email = '$email' ";
        $result=mysqli_query($connect, $query);
        if(mysqli_num_rows($result) != 0){
            $error=true;
            $emailError = "Provided email already exists";
        }
    }
    if (empty($date_of_birth)){
        $error=true;
        $dateError="Please enter your date of birth";
    }

    if(empty($password)){
        $error=true;
        $passError="please enter password.";
    }elseif(strlen($password)<6){
        $error=true;
        $passError="Password must have at least 6 characters";
    }

    // <--security stuff -->

    $password = hash("sha256", $password);

// $picture = file_upload($_FILES["picture"]);

    if(!$error){
$sql= "INSERT INTO users( `first_name`, `last_name`, `password`, `date_of_birth`, `email`, `picture`) VALUES ('$first_name','$last_name','$password','$date_of_birth','$email', '$picture->fileName')";

$res=mysqli_query($connect, $sql);
if($res){
    $errType="success";
    $errMsg = "Successfully registered, you are logged in now.";
    $uploadError=($picture->error != 0) ? $picture->ErrorMessage : "";
}

    }else{
        $errType="danger";
        $errMsg = "Error - try later";
        // $uploadError=($picture->error != 0) ? $picture->ErrorMessage : "";
    
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "components/boot.php";?>
    <title>Document</title>
</head>
<body>
    <div class="container">
<h1>REGISTRATION FORM</h1>

<?php
if(isset($errMsg)){
    ?>


<div class="alert alert-success" role="alert">
  <?=$errMsg?>
  <?=$uploadError?>
</div>
<?php 
}
?>

    <form class="w-75" action="<?= htmlspecialchars($_SERVER['SCRIPT_NAME'])?>" enctype="multipart/form-data" method="post">
        <input type="text" placeholder="Please type your first name" class="form-control" name="first_name" value="<?=$first_name?>">
        <span class="text-danger"><?=$fnameError?></span>

        <input type="text" placeholder="Please type your last name" class="form-control" name="last_name" value="<?=$last_name?>">
        <span class="text-danger"><?=$lnameError?></span>

        <input type="email" placeholder="Please type your email" class="form-control" name="email" value="<?=$email?>">
        <span class="text-danger"><?=$emailError?></span>

        <input type="password" placeholder="Please type your password" class="form-control" name="password">
        <span class="text-danger"><?=$passError?></span>

        <input type="date"  class="form-control" name="date_of_birth">
        <span class="text-danger"><?=$dateError?></span>

        <input type="file"  class="form-control" name="picture">
        <input type="submit"  class="form-control" name="register" value="Register">
    </form>
    </div>  
</body>
</html>