<?php 
session_start(); 
if(isset($_SESSION['login'])) header("Location: index.php"); else
if(isset($_POST["login"]) && !empty($_POST['code']) && $_POST['code']=="admin") {
	$_SESSION['login']="moreman";
	header("Location: index.php");
}
?>
<html>
  <head>
  	<title>Авторизация</title>
  	<link href="res/style.css" rel="stylesheet">
  	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<link rel="icon" href="favicon.ico" type="image/x-icon">
  	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
  </head>
<body id="LoginForm">
<div class="container">
<div class="login-form">
<div class="main-div">
    <div class="panel">
   <?php 
   if(isset($_POST["login"]) && !empty($_POST['code'])) {
   	if($_POST['code']!="admin") echo "<p style=\"color:red;\">Ошибка доступа!</p>";
   } else echo "<p>Введите код доступа</p>";
   
   ?>
   </div>
    <form id="login" method="post">
        <div class="form-group">
            <input  class="form-control" name="code" placeholder="Code">
        </div>
        <button type="submit" name="login" class="btn btn-primary">Вход</button>
    </form>
    <a href="index.php">У меня нету кода доступа</a>
    </div>
</div></div></div>


</body>
</html>
