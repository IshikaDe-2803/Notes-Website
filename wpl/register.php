<?php
session_start();

$insert = false;
if(isset($_POST['email'])) {
$server = "localhost";

$username = "root";

$password = "";

$con = mysqli_connect($server, $username, $password);
if(!$con){
    die("connection to this database failed due to" . mysqli_connect_error());
}

if(!$con){
    die("connection to this database failed due to" . mysqli_connect_error());
}
// echo "Success connecting to the db";

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$mobile = $_POST['mobile'];
$sql = "INSERT INTO `registration`.`register` (`email`, `username`, `password`, `mobile`) VALUES ('$email', '$username', '$password', '$mobile');";
// INSERT INTO `register` (`Sno`, `email`, `username`, `password`, `mobile`, `OTP`) VALUES ('1', 'dmishika2002@gmail.com', 'ishika.de', 'ishi28*', '1234567890', '1234');
// $result = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
$duplicate=mysqli_query($con,"select * from registration.register where email='$email' or mobile='$mobile'");
if (mysqli_num_rows($duplicate)>0)
{
    $message = "Email/Mobile seems to be already registered! Please head over for Login.";
    echo 
    "<script>alert('$message');
    window.location.href='/wpl/login.php';
    </script>";
}
if($con->query($sql) == true){
    $insert = true;
}
else {
    $insert = false;
}

$con->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Sign Up</title>
    <link rel="stylesheet" href="./registerstyle.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="brand" href="./home.php"> <img src="./4.png" style="width: 185px;" alt="logo"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Log In</a>
                </li>
                <li class="nav-item  active">
                    <a class="nav-link" href="./register.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./publicNotes.php">Public Notes</a>
                </li>
                <?php
                if(isset($_SESSION["username"])) {
                ?>
                <li class="nav-item">
                <a class="nav-link" href="./note.php">My Notes</a>
                </li>
                <li class="nav-item">
                <a class="logout" href="./logout.php"><span id="logout"><i class="fas fa-sign-out-alt" style="color: aliceblue; font-size:xx-large; padding: 5px;"></i></span></a>
                </li>
                <?php
                }else echo "";
                ?>
            </ul>
        </div>
    </div>
</nav>

<body>
    <div class="login-page" style="width:500px;">
        <div class="form">
            <span class="active"> Sign Up </span>
            <p>Please register your account</p>
            <form class="login-form" action='register.php' method="POST">
            <?php 
        if($insert == true) {
            $message = "Sign up was successful.";
            echo 
            "<script>alert('$message');
            window.location.href='/wpl/login.php';
            </script>";
        }       
        ?>
                <input name='email' id="email" type="text" placeholder="Email ID" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Should must follow the standard pattern
                name@domain.com" required/>
                <input id="username" name='username' type="text" placeholder="Set Username" pattern="^[A-Za-z]{6,}" title="Should contain at least 6 character, and all characters should be alphabets" required/>
                <input id="password" name='password' type="password" placeholder="Set Password" pattern=".{6, }" title="Should contain at least 6 characters" required/>
                <input id="mobile" name='mobile' type="text" placeholder="Mobile No" pattern="^[0-9]{10}" title="Should contain at least 10 numbers" required/>
                <button >Register</button>
                <p class="message">Already registered? <a href="./login.php">LogIn</a></p>
            </form>
        </div>
    </div>
</body>

</html>