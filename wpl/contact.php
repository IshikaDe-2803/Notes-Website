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
    $email = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];
    $sql = "INSERT INTO `registration`.`contact` (`name`, `email`, `message`) VALUES ('$name', '$email', '$message');";
    // INSERT INTO `register` (`Sno`, `email`, `username`, `password`, `mobile`, `OTP`) VALUES ('1', 'dmishika2002@gmail.com', 'ishika.de', 'ishi28*', '1234567890', '1234');
    $to = "dmishika2002@gmail.com";
    $subject = "User Contact";
    $txt = "Name: $name\nEmail: $email\nMessage: $message";
    $headers = "From: dmishika2002@gmail.com" . "\r\n" ;
    if($con->query($sql) == true){
        $mailed=mail($to,$subject,$txt,$headers);
        $message = "Message successfully sent!";
        echo 
        "<script>alert('$message');
        </script>";
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
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Contact</title>
    <link rel="stylesheet" href="./contactc.css">
</head>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="brand" href="./home.php"> <img src="./4.png" style="width: 185px;" alt="logo"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">Home</a>
                </li>
                <?php
                if(!isset($_SESSION["username"])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./register.php">Sign Up</a>
                </li>
                <?php
                }else echo "";
                ?>
                <li class="nav-item  active">
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
            <span class="active"> Contact Us </span>
            <p>Please fill in your details to connect with us</p>

            <form class="login-form" action='contact.php' method="POST">
                <input type="text" placeholder="Name" name="name" required/>
                <input type="email" placeholder="Email" name="email" id="email" required/>
                <textarea type="usermessage" rows=5 placeholder="Message" name="message" id="Message" required></textarea>
                <button>Send</button>
            </form>
        </div>
    </div>
</body>

</html>