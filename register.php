<?php 
include "connection.php";
if(isset($_POST['submit'])){
    session_start();
    $name = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $_SESSION['usernameerror'] = NULL;
    $_SESSION['emailerror'] = NULL;
    $_SESSION['phoneerror'] = NULL;
    $_SESSION['passworderror'] = NULL;
    if(empty($name)){
        header('location:register.php');
       $_SESSION['usernameerror'] = "Enter name";
    }else if(empty($phone)){
        header('location:register.php');
       $_SESSION['phoneerror'] = "Enter phone number";
    }else if(empty($email)){
        header('location:register.php');
       $_SESSION['emailerror'] = "Enter email";
    }else if(empty($pass)){
        header('location:register.php');
       $_SESSION['passworderror'] = "Enter password";
    }

    if(!preg_match("/^[A-Za-z.]{3,40}$/",$name)){
       $_SESSION['usernameerror'] = "user characters only";
       header('location:register.php');
       exit();
    }
    
    $sql = "INSERT INTO `user` (`name`, `phone`, `Email`, `Pass`) VALUES ('$name', '$phone', '$email', '$pass');";
    
    if(mysqli_query($conn,$sql)){
        header('location:login.php');
    }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        // header('location:Registration.html');
    }
    mysqli_close($conn);
}
if(isset($_POST['login'])){
    session_start();
    $useremail = $_POST['email'];
    $pass = $_POST['password'];
    $_SESSION['username'] = NULL;
    $_SESSION['pass'] = NULL;
    $_SESSION['userinf'] = NULL;

    if(empty($useremail)){
        header('location:login.php');
        $_SESSION['username'] = "User mail is required";
        exit();
    }else if(empty($pass)){
        $_SESSION['pass'] = "Correct password is required";
        header('location:login.php');
        exit();
    }
    $sql = "SELECT * FROM `user` WHERE `Email` = '$useremail' AND `Pass` = '$pass'";
    $result = mysqli_query($conn,$sql);
    $row =  mysqli_fetch_assoc($result);
    if($row['Email'] === $useremail && $row['Pass'] === $pass){
        header('location:userinterface.php');
        $_SESSION['userinf'] = $row['name'];
    }else if($row['Email'] != $useremail && $row['Pass'] === $pass){
        header('location:login.php');
        $_SESSION['username'] = "User mail is wrong";
        exit();
    }else if($row['Pass'] != $pass && $row['Email'] === $useremail){
        header('location:login.php');
        $_SESSION['pass'] = "password is wrong";
        exit();
    }
    else{
        // die(mysqli_error($conn));
        $_SESSION['username'] = "User mail is required";
        $_SESSION['pass'] = "password is required";
        header('location:login.php');
        // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit();
    }
    mysqli_close($conn);

    
}
?>