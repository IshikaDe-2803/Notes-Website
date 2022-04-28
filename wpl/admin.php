<?php
session_start();
$server = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($server, $username, $password);
if(!$con){
    die("connection to this database failed due to" . mysqli_connect_error());
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
function upload($id) {
    global $con;
    $sql = "UPDATE `registration`.`notes` SET `published`=1 WHERE `Sno` ='$id'";
    if($con->query($sql) == true){
        // echo "Upload successful";
    }
    else {
        // echo "Upload unsuccessful";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .wrapper{
            width: 100%;
            margin: 5% auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        td{
            max-width: 120px;
            overflow-wrap: break-word;
        }
        .navbar {
            background-color: black;
            margin: 0px 0px 0px 0px;
        }

        .navbar-light .navbar-nav .active>.nav-link {
            color: rgb(125, 186, 255);
        }

        .navbar-light .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-light .navbar-nav .nav-link:focus,
        .navbar-light .navbar-nav .nav-link:hover {
            color: rgb(172, 209, 252);
            text-decoration: underline;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a  class="brand" href="./home.php"> <img src="./4.png" style="width: 185px;" alt="logo"></a>
        </div>
        <?php
            if(isset($_SESSION["username"])) {
                echo "logout";
            ?>
            <a class="logout" href="./logout.php"><span id="logout"><i class="fas fa-sign-out-alt" style="color: aliceblue; font-size:xx-large; padding: 5px; margin-left:-40%;"></i></span></a>
            <?php
            }else echo "";
        ?>
    </nav>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-5 mb-3 clearfix">
                            <h2 class="pull-left">Note Details</h2>
                            </div>
                                <?php
                                    $sql = "SELECT * FROM `registration`.`notes` WHERE public=1 and published <> 1;";
                                    if($result = mysqli_query($con, $sql)){
                                        if(mysqli_num_rows($result) > 0){
                                            echo '<table class="table table-bordered table-striped">';
                                                echo "<thead>";
                                                    echo "<tr>";
                                                        echo "<th>#</th>";
                                                        echo "<th>User Name</th>";
                                                        echo "<th>Date</th>";
                                                        echo "<th>Note Title</th>";
                                                        echo "<th>Note Content</th>";
                                                        echo "<th>Action</th>";
                                                    echo "</tr>";
                                                echo "</thead>";
                                                echo "<tbody>";
                                                while($row = mysqli_fetch_array($result)){
                                                    echo "<tr>";
                                                        echo "<td>" . $row['Sno'] . "</td>";
                                                        echo "<td>" . $row['username'] . "</td>";
                                                        echo "<td>" . $row['date'] . "</td>";
                                                        echo "<td>" . $row['title'] . "</td>";
                                                        echo "<td>" . $row['note'] . "</td>";
                                                        echo "<td>";
                                                            $currentID = $row['Sno'];
                                                            if (isset($_GET['name'])) {
                                                                // echo $_GET['name'];
                                                                delete($_GET['name']);
                                                            }
                                                            if (isset($_GET['name2'])) {
                                                                // echo $_GET['name'];
                                                                upload($_GET['name2']);
                                                            }
                                                            // echo $currentID;
                                                            echo '<a href="?name='. $row['Sno'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                                        
                                                            echo '&nbsp&nbsp&nbsp<a href="?name2='. $row['Sno'] .'" title="Publish Record" data-toggle="tooltip"><span class="fa fa-upload"></span></a>';
                
                                                            echo "</td>";
                                                    echo "</tr>";
                                                }
                                                echo "</tbody>";                            
                                            echo "</table>";
                                        } else {
                                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                                        }
                                    } else {
                                        echo "Oops! Something went wrong. Please try again later.";
                                    }
                                    // Close connection
                                mysqli_close($con);
                            ?>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>