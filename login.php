<?php
    session_start();
    $error = "";
    $suc = "";
    if(isset($_GET['logout']) && $_GET['logout'] == 1){
        unset($_SESSION['id']);
        unset($_SESSION['name']);
        if(isset($_COOKIE['id'])){
            setcookie('id', "" , time() - 60*60);
            setcookie('name', "" , time() - 60*60);
            $_COOKIE['id']="";
            $_COOKIE['name']="";
        }
        header("Location: login.php");
    }
    else if(isset($_COOKIE['id']) or isset($_SESSION['id'])){
        header("Location: menu.php");
    }
    else if(isset($_POST['submit'])){
        require("connection.php");
        if($_POST['submit'] == "Sign Up!"){
            $ok = true;
            $toInsert = " (NULL";
            foreach($_POST as $key => $val){
                if($val == ""){
                    $ok = false;
                    $error .= "<p>".$key." is required</p>";
                }
                if($key != 'submit'){
                        $toInsert .= ", ";
                    $toInsert .= "'".$val."'";
                }
            }
            $toInsert .= ")";
            if($ok){
                $email = $_POST['email'];
                $qry = "SELECT * FROM users WHERE email='$email'";
                $result = mysqli_query($link, $qry);
                if(mysqli_num_rows($result) > 0){
                    $error .= "<p>That email is already taken</p>";
                }else{
                    $qry = "INSERT INTO `users` VALUES".$toInsert;
                    if(!mysqli_query($link, $qry)){
                        $error = "<p>Couldn't Sign you up - please try again </p>".mysqli_error($link);
                    }else{
                        $suc="Sign Up Successful";
                    }
                }
            }else{
                $error = "<p>There were error(s) in your form</p>".$error;
            }
        }else if($_POST['submit'] == "Log In!"){
            $email = $_POST['email'];
            if($email == ""){
                $error .= "<p>email is required to login</p>";
            }
            $password = $_POST['password'];
            if($password == ""){
                $error .= "<p>Enter your password to login</p>";
            }
            
            if($error == ""){
                $qry = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
                $result = mysqli_query($link, $qry);
                if(mysqli_num_rows($result) == 0){
                    $error .= "<p>That email password combination could not be found</p>";
                }else{
                    $row = mysqli_fetch_array($result);
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    if(isset($_POST['rememberMe'])){
                        setcookie('id', $_SESSION['id'], time() + 3600 * 24);
                        setcookie('name', $_SESSION['name'], time() + 3600 * 24);
                    }
                    header("Location: menu.php");
                }
            }else{
                $error = "<p>There were error(s) in your form</p>".$error;
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
        
        <title>Sign Up</title>
        
        <style type = "text/css">
            
            body{
/*                background-color: #dddddd;*/
/*                background-color: #5CBD95;*/
                background-color: #EAE7DC;
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
            
            .btn{
                margin: 0 auto;
            }
            
            .error{
                text-align: center;
            }
            
            #logInForm{
                display: none;
            }
            
            p{
                margin-bottom: 0px;
            }
            
            .toggleClass{
                margin-bottom: 40px;
            }
            
        </style>
    </head>

    <body>
        
        <!--        Sign Up Form        -->
        <form method="post" id="signUpForm" class="container">
           <div class="form-group row">
            <div class="col-sm-4"></div>
            <div class="col-sm-5">
              <div class="error"><?php if($error != "" or $suc != "") {echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$error.$suc.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';}?></div>
            </div>
          </div>
            
          <h2 class="topic">Sign Up</h2>
          <div class="form-group row">
            <div class="col-sm-3"></div>
            <label for="email" class="col-sm-1 col-form-label">Email</label>
            <div class="col-sm-5">
              <input name="email" type="email" class="form-control" id="email" placeholder="email@example.com">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3"></div>
            <label for="name" class="col-sm-1 col-form-label">Name</label>
            <div class="col-sm-5">
              <input name="name" type="text" class="form-control" id="name" placeholder="your name">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3"></div>
            <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
            <div class="col-sm-5">
              <input name="password" accept="" type="password" class="form-control" id="inputPassword">
            </div>
          </div>

          <div class="form-group">
              <input name="submit" type="submit" class="btn btn-success" value="Sign Up!">
          </div>
        
          <br>
          <br>
          <h6>OR</h6>
          <p><a class="toggleClass btn btn-primary">LogIn instead</a></p>
            
        </form>
        
        
         <!--        login Form        -->
        <form method="post" id="logInForm" class="container">
          <h2 class="topic">Log In</h2>
          <div class="form-group row">
            <div class="col-sm-3"></div>
            <label for="email" class="col-sm-1 col-form-label">Email</label>
            <div class="col-sm-5">
              <input name="email" type="email" class="form-control" id="email" placeholder="email@example.com">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-3"></div>
            <label for="inputPassword" class="col-sm-1 col-form-label">Password</label>
            <div class="col-sm-5">
              <input name="password" accept="" type="password" class="form-control" id="inputPassword">
            </div>
          </div>
          <div class="form-group form-check center">
            <input name="rememberMe" type="checkbox" class="form-check-input" id="exampleCheck1" value=1>
            <label class="form-check-label" for="exampleCheck1">Remember Me for a day</label>
          </div>

          <div class="form-group">
              <input name="submit" type="submit" class="btn btn-success" value="Log In!">
          </div>
        
          <br>
          <br>
          <h6>OR</h6>
          <p><a class="toggleClass btn btn-primary">SignUp instead</a></p>
            
        </form>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        
        <script>
            $(".toggleClass").click(function(){
                $("#logInForm").toggle();
                $("#signUpForm").toggle();
                $(".error").hide();
            });
        </script>
        
        
    </body>

</html>