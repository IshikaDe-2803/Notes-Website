<?php
session_start();
$insert = false;
$server = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($server, $username, $password);
if(!$con){
    die("connection to this database failed due to" . mysqli_connect_error());
}
if(isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = date('Y-m-d H:i:s');
    $check = 0;
    $user = $_SESSION["username"];
    if (isset($_POST['check'])) {
        $check = 1;
    }
    else {
        $check = 0;
    }
    $sql = "INSERT INTO `registration`.`notes` (`username`, `title`, `note`, `date`, `public`) VALUES ('$user','$title', '$content', '$date', '$check');";
    if($con->query($sql) == true){
        $insert = true;
    }
    else {
        $insert = false;
    }
}

function delete($id) {
    global $con;
    $sql = "DELETE FROM `registration`.`notes` WHERE `Sno` ='$id'";
    if($con->query($sql) == true){
        // echo "Delete successful";
    }
    else {
        // echo "Delete unsuccessful";
    }
}

function download($id) {
    global $con;
    $sql = "SELECT * FROM `registration`.`notes` WHERE `Sno` ='$id';";
    if($result = mysqli_query($con, $sql)) {
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $content = $row['note'];
        $date = $row['date'];
        $myfile = fopen("note.txt", "w") or die("Unable to open file!");
        $txt = "Title:$title\nNote:$content\nDate:$date\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        $fileName = basename('note.txt');
        $filePath = './'.$fileName;
        if(!empty($fileName) && file_exists($filePath)){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="./note.txt"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            ob_clean();
            flush();
            readfile('note.txt');
            exit();
        }
        else{
            echo 'The file does not exist.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<link rel="stylesheet" href="style.css">
<title>My Notes</title>
</head>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="padding: 0.5% 0% 0.5% 7.5%;">
<div class="container">
<a class="brand" href="./home.php"> <img src="./4.png" style="width: 185px;" alt="logo"></a>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav ms-auto">
<li class="nav-item">
<a class="nav-link" href="home.php">Home</a>
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
<a class="nav-link" href="contact.php">Contact</a>
</li>
<li class="nav-item">
<a class="nav-link" href="publicNotes.php">Public Notes</a>
</li>
<?php
if(isset($_SESSION["username"])) {
    ?>
    <li class="nav-item  active">
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
<div class="container" style="margin-top: 4%;">
<div class="row">
<div class="col" style="padding: 0px 0px 0px 0px;">
<div class="row-half" style="padding: 0px 0px 0px 0px; ">
</div>
<div class="body">
<?php
$user = $_SESSION["username"];
$sql2 = "SELECT * FROM `registration`.`notes` WHERE username = '$user' ;";
if($result = mysqli_query($con, $sql2)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)) {
            if ($row['public'] == 1) {
                echo "<div class='note-selected'>";                                          
            }
            else {
                echo "<div class='note'>";
            }
            $currentID = $row['Sno'];
            if (isset($_GET['name2'])) {
                // echo $_GET['name'];
                download($_GET['name2']);
            }
            if (isset($_GET['name'])) {
                // echo $_GET['name'];
                delete($_GET['name']);
            }
            echo "<h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['note'] . "</p>";
            echo "<span class='date'>" . $row['date'] . "</span>";
            echo
            "<div id='icon'>";
            echo '&nbsp <span id="icon1"><a id = "trash" href="?name='. $row['Sno'] .'"><i class="fas fa-trash"></i></a></span>&nbsp &nbsp';
            echo '&nbsp &nbsp <span id="icon1"><a id = "trash" href="?name2='. $row['Sno'] .'"><i class="fas fa-download"></i></a></span>&nbsp &nbsp';
            // echo "<span id='icon2'><i class='fas fa-download' ></i></span> &nbsp &nbsp";
            if ($row['public'] == 1) {
                echo "&nbsp &nbsp <span style='color: rgb(41, 189, 189);'><i class='fas fa-globe'></i></span>";
            }                                     
            echo "</div>";
            echo "</div>";
        }
    } 
    else{
        echo "";
    }
} else {
    echo "Oops! Something went wrong. Please try again later.";
}

?>
</div>
</div>
<div class="col-6" style="margin-top: 0%;">
<form class="note-form" action="note.php" method="POST">
<?php 
if($insert == true) {
    $message = "Note created successfully.";
    echo 
    "<script>alert('$message');
    </script>";
}     
?>
<input placeholder="Add a title..." id="title" name="title" style="height: 5%; width: 100%; padding: 10px; font-weight: bold;" required/>
<textarea placeholder="Content" id="content" name="content" style="width: 100%; height: 70vh;"></textarea>
<span style="padding: 1%;"><input type="checkbox" name="check" value="Yes">&nbsp Do you want to share this note publicly?</span>
<br>
<button type="submit" class="btn shadow-none" style="color: white; margin-top: 5px;">Create Note</button>
</form>
</div>
</div>
</body>
</html>