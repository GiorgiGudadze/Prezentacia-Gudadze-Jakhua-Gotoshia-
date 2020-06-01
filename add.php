<?php
session_start();
$error="";
$phoneEr='';
if(isset($_POST['submit'])){

    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $error="Invalid email";
    }

    if(!preg_match("^[0-9]+$^",$_POST["phone"])){
        $phoneEr='Invalid Phone Number';
    }


    if(empty($error) && empty($phoneEr)){
        unset($_SESSION['shopping_cart']);
        echo '<script type="text/javascript">'; 
        echo 'alert("Your Details Has Been Sent");'; 
        echo 'window.location.href = "index.php";';
        echo '</script>';

    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    input{
        width:100%;
        border:none;
        border-bottom:1px solid #9e9e9e;
        outline:none;
        background:#f5f5f5;
        color:#9e9e9e;
        font-family: fantasy;
    }
    input:focus{
       border-bottom:1px solid #26a69a;
    }
    label{
        display:block;
        margin:5px 0;
        color:#9e9e9e;
    }
    .center{
        text-align:center;
        padding:10px;
    }
    .execute{
        padding:10px;
        width: 90px;
        font-family:sans-serif;
        border:1px solid #9e9e9e;
        padding: 8px;
        transition:1s;
        cursor:pointer;
        background:#cbb09c;
        color:#fff;
    }
    .execute:hover{
        background:#bd630a;
        color:#fff;
        border:1px solid #bd630a;
    }
    section{
        margin: auto;
        max-width: 460px;
    }
    body{
        background:#f5f5f5;
    }
    .red-text{
        font-size: 10px;
        color: red;
        margin-top: 3px;
    }
    </style>
</head> 
<body>
 
<section class="container grey-text">

    <h1 style="color:#000;font-size:35px;" class="center">Details</h1>
    <form action="#" method="POST">


    <label>Email</label>
    <input type="text" name="email">
    <div class="red-text"><?php echo $error; ?></div>

    <label>Phone Number</label>
    <input type="text" name="phone">
    <div class="red-text"><?php echo $phoneEr; ?></div>

    <div class="center">

    <input type="submit" name="submit" value="submit" class="execute">

    </div>
    </form>
</section>

</body>
</html>  