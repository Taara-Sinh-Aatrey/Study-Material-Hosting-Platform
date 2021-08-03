<?php
require("authentication.php");
require("connection.php");
echo '
<nav class="navbar navbar-faded bg-dark navbar-fixed-top">
  <a class="navbar-brand" href="#">Study Material Hosting Platform </a>
    <span class="navbar-text">
      Welcome '.$_SESSION['name'].'
    </span>
    <div class="pull-xs-right">
        <button name="submit" class="btn btn-outline-success" type="submit"><a href="menu.php">Home</a></button>
    </div>
</nav>


<div class="container">
    <h4>Your Uploaded Books</h4>
    <br>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Semester</th>
          <th scope="col">Subject</th>
          <th scope="col">Download</th>
        </tr>
      </thead>
      <tbody>
';

$qry = "SELECT name, sem, subject, loc FROM books WHERE uploader ='".$_SESSION['id']."'";
$result = mysqli_query($link, $qry);
//                echo $qry;
//                print_r($result);
while($row = mysqli_fetch_assoc($result)){
    echo'<tr>
      <td>'.$row["name"].'</td>
      <td>'.$row["sem"].'</td>
      <td>'.$row["subject"].'</td>
      <td><a href="./'.$row['loc'].'" download>Link</a></td>
    </tr>';
}
echo '</tbody></table></div>';
?>


<!DOCTYPE html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
        <title>Upload file</title>
        
        <style type = "text/css">
            
            body{
/*                background-color: #dddddd;*/
/*                background-color: #5CBD95;*/
/*                background-color: #EAE7DC;*/
            }
            
            .navbar, .navbar-brand{
                color: #ddd;
                font-weight: bold;
                font-size: 20px;
            }
            
            .navbar a{
                color: #ddd;
                font-weight: bold;
            }
            
            .container {
                margin-top: 120px;
                text-align: center;
            }
            
            label{
                font-weight: 500;
            }

            .topic {
                margin-bottom: 30px;
                text-decoration: underline;
            }
            
            .navbar a:hover{
                text-decoration: none;
                color: #ddd;
                font-weight: bold;
            }
            
            .btn{
                margin: 0 auto;
                color: #ddd;
            }
            
            .error{
                text-align: center;
            }
            
            p{
                margin-bottom: 0px;
            }
            
        </style>
    </head>
   
    <body>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>