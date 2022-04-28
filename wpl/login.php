<?php
session_start();
if(isset($_POST['username'])) {
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

$username = $_POST['username'];
$password = $_POST['password'];
$checkLogin = mysqli_query($con,"select * from registration.register where username='$username' and password='$password'");
$row = mysqli_fetch_array($checkLogin);
if (mysqli_num_rows($checkLogin) > 0) {       
        $_SESSION["username"] = $row['username'];
        $_SESSION["password"] = $row['password'];
        $message = "Login Successful!";
        echo 
        "<script>alert('$message');
        window.location.href='/wpl/note.php';
        </script>";
    
}

else if ($username == "admin" && $password == "admin") {
    $_SESSION["username"] = "admin";
    $_SESSION["password"] = "admin";
    $message = "ADMIN Login Successful!";
    echo 
    "<script>alert('$message');
    window.location.href='/wpl/admin.php';
    </script>";
}
else if(isset($_SESSION["username"]) && $username != "admin") {
    echo 
    "<script>alert('$message');
    window.location.href='/wpl/note.php';
    </script>";
}

else if(isset($_SESSION["username"]) && $username == "admin") {
    echo 
    "<script>alert('$message');
    window.location.href='/wpl/admin.php';
    </script>";
}
else {
    $message = "Username/Password seems incorrect!";
    echo 
    "<script>alert('$message');
    window.location.href='/wpl/login.php';
    </script>";
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
    <title>Login</title>
    <link rel="stylesheet" href="./loginstyle.css">
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
                <li class="nav-item active">
                    <a class="nav-link" href="./login.php">Log In</a>
                </li>
                <li class="nav-item">
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
    <div class="login-page">
        <div class="form">
            <span class="active"> Log In </span>
            <p>Please Log into your account</p>
            <form class="login-form" action='./login.php' method="POST">
                <input type="text" name="username" placeholder="Username" id="username" required/>
                <p id="userEmpty"></p>
                <input type="password" name="password" placeholder="Password" id="password" required/>
                <p id="passEmpty"></p>
                <button>login</button>
                <p class=" message ">Not registered? <a href="./register.php">SignIn</a></p>
            </form>
        </div>
    </div>
</body>

</html>