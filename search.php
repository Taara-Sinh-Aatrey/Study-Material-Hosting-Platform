<?php
require("authentication.php");
$error = "";
$suc = "";
if(isset($_POST['submit'])){
    require("connection.php");
    $qry = "SELECT id FROM books";
    $temp = mysqli_query($link, $qry);
    
    $result = array();
    while($row = mysqli_fetch_assoc($temp)){
          array_push($result, $row['id']);
    }
    
    if($_POST["title"] != ""){
      $words = explode(" ", $_POST["title"]);
      $qry = "SELECT id FROM books WHERE ";
        $cnt = 0;
      foreach($words as $word){
          if($cnt > 0){
              $qry .= "AND ";
          }
          $qry .= "name LIKE '%".$word."%' ";
          $cnt++;
      }
      $qry .= ";";
//      echo $qry;
      $temp = mysqli_query($link, $qry);
      $res=array();
      while($row = mysqli_fetch_assoc($temp)){
          array_push($res, $row['id']);
      }
      $result = array_intersect($result, $res);
    }
    
    if($_POST["author"] != ""){
      $words = explode(" ", $_POST["author"]);
      $qry = "SELECT id FROM author WHERE ";
        $cnt = 0;
      foreach($words as $word){
          if($cnt > 0){
              $qry .= "AND ";
          }
          $qry .= "name LIKE '%".$word."%' ";
          $cnt++;
      }
      $qry .= ";";
//      echo $qry;
      $temp = mysqli_query($link, $qry);
      $res=array();
      while($row = mysqli_fetch_assoc($temp)){
          array_push($res, $row['id']);
      }
      $res = array_unique($res);
      $result = array_intersect($result, $res);
    }
    
    if($_POST["subject"] != "0"){
      $qry = "SELECT id FROM books WHERE subject = '". $_POST["subject"] ."';";
//      echo $qry;
      $temp = mysqli_query($link, $qry);
      $res=array();
      while($row = mysqli_fetch_assoc($temp)){
          array_push($res, $row['id']);
      }
      $result = array_intersect($result, $res);
    }
    
    if($_POST["sem"] != "0"){
      $qry = "SELECT id FROM books WHERE sem = '". $_POST["sem"] ."';";
//      echo $qry;
      $temp = mysqli_query($link, $qry);
      $res=array();
      while($row = mysqli_fetch_assoc($temp)){
          array_push($res, $row['id']);
      }
      $result = array_intersect($result, $res);
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
/*                background-color: #EAE7DC;*/
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
            
            .navbar a{
                color: #ddd;
                font-weight: bold;
            }
            
            .btn{
                margin: 0 auto;
                color: #ddd;
                font-weight: bold;
            }
            
            .error{
                text-align: center;
            }
            
            p{
                margin-bottom: 0px;
            }
            
            .navbar, .navbar-brand{
                padding-top: 30px;
                padding-bottom: 30px;
                color: #ddd;
                font-weight: bold;
                font-size: 20px;
            }
            
        </style>
    </head>
   
    <body>
        
<!--       <nav class="navbar navbar-light bg-light justify-content-between navbar-fixed-top">-->
        <nav class="navbar navbar-faded bg-dark justify-content-between navbar-fixed-top">
          <button name="submit" class="btn btn-outline-success" type="submit"><a href="menu.php">Home</a></button>
          <form method="post" class = "form-inline">
            <input name="title" class="form-control mr-sm-5" type="search" placeholder="Book's Title" aria-label="Search">
            <input name="author" class="form-control mr-sm-5" type="search" placeholder="Book's Author" aria-label="Search">
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
            <select name="sem" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option value="0" selected>Choose Semester</option>
                <option value="1">I</option>
                <option value="2">II</option>
                <option value="3">III</option>
            </select>
              <button name="submit" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </nav>
        
        
        <?php
              if(isset($_POST["submit"])){
                  echo '<div class="container">
                        <h4>Search Result</h4>
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

    //                print_r($result);

                    foreach($result as $id){
                        $qry = "SELECT name, sem, subject, loc FROM books WHERE id='"."$id"."'";
    //                    echo $qry;
                        $temp = mysqli_query($link, $qry);
                        while($row = mysqli_fetch_assoc($temp)){
                            echo'<tr>
                              <td>'.$row["name"].'</td>
                              <td>'.$row["sem"].'</td>
                              <td>'.$row["subject"].'</td>
                              <td><a href="./'.$row['loc'].'" download>Link</a></td>
                            </tr>';
                        }
                    }
                    echo '</tbody></table></div>';
              }
        ?>  
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>