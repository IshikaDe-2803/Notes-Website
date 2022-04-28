<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($server, $username, $password);
if(!$con){
    die("connection to this database failed due to" . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="notes.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Public Notes</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="./contact.php">Contact</a>
                </li>
                <li class="nav-item  active">
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
    <!-- <button id="addNotes" onclick=hi()>Add Notes</button> -->
    <h1 style="color:rgb(45, 167, 167); margin-top: 5%; margin-left: 45%;">Public Notes</h1>
        <?php
        $sql2 = "SELECT * FROM `registration`.`notes` WHERE published = 1 ;";
        if($result = mysqli_query($con, $sql2)){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)) {
                    $title = $row['title'];
                    $content = $row['note'];
                    echo "<div class='container' id='stickyNote'>
                    <div id='title'>$title</div>
                    <div id='content'>$content</div>
                    </div>";
                }
            } 
            else{
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        ?>    
</body