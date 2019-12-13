<?php
session_start();
require_once 'core/db.php';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$id=0;
$sql = "SELECT * FROM Preparat WHERE ID ='$id'";
$result = $pdo->prepare($sql);
$result->execute();
while ($row =$result->fetch()) {
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Добавление</title>
<link rel="stylesheet" 
href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
crossorigin="anonymous">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
</head>
<body>

<div class="container" align="center">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" style="color:#ff6e40" href="/">
  	 <img src="res/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
  	Каталог лекарств<sup> β</sup></a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
    	 
        <?php if(isset($_SESSION["login"])) {
        	echo "<li class=\"nav-item\"><a class=\"nav-link text-success\" href=\"add.php\">Добавить лекарство</a></li>";
        	echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Выйти из системы</a></li>";
        
        }
        else echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"login.php\">Авторизоваться</a> </li>";
        ?>
     
    </ul>
    <span class="navbar-text">
    </span>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Введите название.." aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>
  </div>
</nav>
<br>


<p class="h2">Ошибка! База данных подключается только..</p>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>