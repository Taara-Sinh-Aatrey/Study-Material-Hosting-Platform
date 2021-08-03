<?php
    require("authentication.php");
?>
<!DOCTYPE html>
<html>
    <head>
         <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
        <style type = "text/css">
            
            .navbar, .navbar-brand{
                color: #ddd;
                font-weight: bold;
                font-size: 20px;
            }
            
            .navbar a:hover{
                color: #ddd;
                font-weight: bold;
            }
            
            .navbar a{
                color: #ddd;
                font-weight: bold;
            }
            
            .container{
                margin-top: 50px;
                text-align: center;
                width: 600px;
            }
            
/*
            .myButton{
                margin-top: 30px;
                width: 500px;
            }
*/
            
            .btn-toolbar{
                margin-top: 200px;
                margin-left: 300px;
                margin-right: 300px;
            }

        </style>
    </head>
    <body>
        <nav class="navbar navbar-faded bg-dark navbar-fixed-top">
          <a class="navbar-brand" href="#">Study Material Hosting Platform </a>
            <span class="navbar-text">
              Welcome <?php echo $_SESSION['name']; ?>
            </span>
            <div class="pull-xs-right">
                <a class="nav-link" href="login.php?logout=1"><button type="submit" class="btn btn-outline-success">Logout</button></a>
            </div>
        </nav>
        
        <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
          <div class="btn-group" role="group" aria-label="First group">
            <a class="nav-link" href="search.php"><button type="button" class="btn btn-primary">Search Book</button></a>
          </div>
            
          <div class="btn-group" role="group" aria-label="First group">
            <a class="nav-link" href="upload.php"><button type="button" class="btn btn-primary">Upload Book</button></a>
          </div>
            
          <div class="btn-group" role="group" aria-label="First group">
            <a class="nav-link" href="myBook.php"><button type="button" class="btn btn-primary">My Uploaded Books</button></a>
          </div>
          
        </div>
        
        
    </body>
</html>