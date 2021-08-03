<?php
require("authentication.php");
$error = "";
$suc = "";
if(isset($_POST['submit'])){
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["userfile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($_POST["title"] == ""){
      $error = "<p>Enter the title of the Book</p>";
      $uploadOk = 0;
    }
    
    if($uploadOk == 1 && $_POST["author"] == ""){
      $error = "<p>Enter the author of the Book</p>";
      $uploadOk = 0;
    }
    
    if($uploadOk == 1 && $_POST["subject"] == "0"){
      $error = "<p>Choose subject</p>";
      $uploadOk = 0;
    }
    
    if($uploadOk == 1 && $_POST["sem"] == "0"){
      $error = "<p>Choose semester</p>";
      $uploadOk = 0;
    }

    $file = $_FILES["userfile"];
    if($uploadOk == 1 && $file["name"] == ""){
      $error = "<p>Please choose a file</p>";
      $uploadOk = 0;
    }
    // Check if file already exists
    if ($uploadOk == 1 && file_exists($target_file)) {
      $error .= "<p>File already exists.</p>";
      $uploadOk = 0;
    }


    // Check file size
    if ($uploadOk == 1 && $file["size"] > 2000000) {
      $error .="<p>Your file is too large.</p>";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($uploadOk == 1 && $fileType != "pdf" && $fileType != "docx" && $fileType != "ppt" && $fileType != "pptx") {
      $error .= "<p>Only pdf, docx, ppt and pptx files are allowed.</p>";
      $uploadOk = 0;
    }

    if ($uploadOk == 1){
        require("connection.php");
        $qry = "INSERT INTO books (name, type, size, loc, sem, subject, uploader) VALUES ('" . $_POST["title"]. "', '" . $fileType. "', '" . $file["size"]. "', '" . mysqli_real_escape_string($link, $target_file) . "', '" . $_POST["sem"] ."', '" . $_POST["subject"] . "', '". $_SESSION['id']. "')";
        
//        echo $qry;

        if (move_uploaded_file($file["tmp_name"], $target_file) && mysqli_query($link, $qry)) {
          $id = mysqli_insert_id($link);
          $authors = explode(",", $_POST["author"]);
          foreach($authors as $author){
              $qry2 = "INSERT INTO author (id, name) VALUES ('" . $id. "', '" . $author. "')";
//              echo $qry2;
              mysqli_query($link, $qry2);
          }
          $suc =  "<p>The file ". htmlspecialchars( basename( $file["name"])). " has been uploaded.</p>";
      } else {
        $error = "Sorry, there was an error uploading your file.";
      }
    }
}
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
                background-color: #EAE7DC;
            }
            
            .container {
                margin-top: 120px;
                text-align: center;
                width: 400px;
            }
            
            .navbar, .navbar-brand{
                color: #ddd;
                font-weight: bold;
                font-size: 20px;
            }
            
            .navbar a:hover{
                text-decoration: none;
                color: #ddd;
                font-weight: bold;
            }
            
            .navbar a{
                color: #ddd;
                font-weight: bold;
            }
            
            label{
                font-weight: 500;
            }
            
            a:hover{
                text-decoration: none;
                color: #ddd;
                font-weight: bold;
            }
            
            a{
                color: #ddd;
                font-weight: bold;
            }

            .topic {
                margin-bottom: 30px;
                text-decoration: underline;
            }
            
            .btn{
                margin: 0 auto;
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
<!--        <nav class="navbar navbar-light bg-light">-->
        <nav class="navbar navbar-faded bg-dark navbar-fixed-top">
            <a class="navbar-brand" href="#">Study Material Hosting Platform </a>
            <span class="navbar-text">
              Welcome <?php echo $_SESSION['name']; ?>
            </span>
            <div class="pull-xs-right">
                <button name="submit" class="btn btn-outline-success" type="submit"><a href="menu.php">Home</a></button>
            </div>
        </nav>
        <form method="post" enctype="multipart/form-data" class = "container">
            <div class="form-group">
                  <div class="error"><?php if($error != "" or $suc != "") {echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$error.$suc.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button></div>';}?>
                  </div>
                </div>
            </div>
            
            <fieldset class="form-group">
                  <input name="title" type="text" class="form-control" id="title" placeholder="Title of the Book">
            </fieldset>
            </div>
        
            <fieldset class="form-group">
                      <input name="author" type="text" class="form-control" id="author" placeholder="Author of the Book">
            </fieldset>

             <fieldset class="form-group">
                    <select name="subject" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                        <option value="0" selected>Choose Subject</option>
                        <option value="NS101">Mathematics-I</option>
                        <option value="NS102">Engineering Mechanics</option>
                        <option value="HS101">Effective Communicatio Skills</option>
                        <option value="ES101">Fundamental of Electrical & Electronics Engg.</option>
                        <option value="ES102">Fundamental of Computing</option>
                        <option value="NS103">Mathematics-II</option>
                        <option value="NS104">Electrodynamics and Optics</option>
                        <option value="HS102">Culture and Human values</option>
                        <option value="DS101">Engineering Graphics</option>
                        <option value="ES103">Data structure and Algorithm</option>
                        <option value="CS_2">Database Management System</option>
                        <option value="CS_3">Introduction to Data Science</option>
                        <option value="CS_1">Computer Organization and Architecture</option>
                        <option value="IT1a">OOPs with Java</option>
                        <option value="OE1i">Complex and Linear Algebra</option>
                    </select>
            </fieldset>

            <fieldset class="form-group">
                    <select name="sem" class="custom-select mr-sm-2">
                        <option value="0" selected>Choose Semester</option>
                        <option value="1">I</option>
                        <option value="2">II</option>
                        <option value="3">III</option>
                    </select>
            </fieldset>

            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <fieldset class="form-group">
                  <input name="userfile" type="file" class="form-control-file" id="userfile">
            </fieldset>
        
            <input type="submit" name="submit" class="btn btn-primary" value="upload">
        </form>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>