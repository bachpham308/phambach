<?php
session_start();
//if(!isset($_SESSION["login"])) header("location:login.php");
require_once 'core/db.php';
$count = isset($_GET['count']) ? $_GET['count'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$startPoint = ($page-1) *$count;

try{
$query = "SELECT * FROM Preparat ORDER BY ID desc LIMIT $startPoint,$count";
$result = $pdo->prepare($query);
$result->execute();
$rowCount = $result->rowCount();
} catch (PDOException $e) {
echo "Error";
echo $e->getMessage();
}
$n = date("Y-m-d");
$y = date('Y-m-d', strtotime($date .' -1 day'));

?>
<html>
<head>
<meta charset="utf-8">
<title>Результаты поиска</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
crossorigin="anonymous">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
</head>
<body class="bg-light">

<div class="container">
	
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <a class="navbar-brand text-success" style="color:#ff6e40" href="/" title="На главную">
  	 <img src="res/img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
  	Каталог лекарств<sup> β</sup></a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  	<ul class="navbar-nav mr-auto">
  		 <!--<li class="nav-item">-->
     <!--   <a class="nav-link text-light" href="/">Все лекарства</a>-->
     <!-- </li> -->
     <!-- <li class="nav-item">-->
     <!--   <a class="nav-link text-light " href="places">Аптеки</a>-->
     <!-- </li>-->
  	</ul>
    <form action="search" class="form-inline my-2 my-lg-0">
      <input name="query" class="form-control mr-sm-2" type="search" placeholder="Введите название.." aria-label="Search">
      <button formmethod="get" class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>
  </div>
</nav>

<div class="py-3 row">
<div class="col"  align="left">
<nav aria-label="...">
  <ul class="pagination pagination-sm">
    <li class="page-item <?php if($page<2) echo "disabled";?>">
      <a class="page-link" href="<?php echo "?page=".($page - 1)."&count=$count"; ?>">←Пред</a>
    </li>
    <li class="page-item active">
      <a class="page-link"><?php echo $page ?></a>
    </li>
    <li class="page-item <?php if($rowCount<$count) echo "disabled";?>">
      <a class="page-link" href="<?php echo "?page=".($page + 1)."&count=$count"; ?>">След→</a>
    </li>
  </ul>
</nav>
</div>

<div class="col" align="right">
 
  Выводить по:
  <div class="btn-group">
  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo $count;?>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="<?php echo "?page=1&count=5";?>">5</a>
    <a class="dropdown-item" href="<?php echo "?page=1&count=10";?>">10</a>
    <a class="dropdown-item" href="<?php echo "?page=1&count=25";?>">25</a>
    <a class="dropdown-item" href="<?php echo "?page=1&count=50";?>">50</a>
    <a class="dropdown-item" href="<?php echo "?page=1&count=100";?>">100</a>
  </div>
  </div> 
  </div>
    </div>

<table class="table table-bordered">
 <!--<thead>-->
 <!--<tr>-->

 <!--<th width="2%">#</th>-->
 <!--<th width="30%">Название</th>-->
 <!--<th>Описание</th>-->
 <!--</tr>-->
 <!-- </thead>-->
 <tbody>
<?php
while ($row =$result->fetch()) {

	$i = $row['ID'];
	$title = $row['TITLE'];
	$des = $row['DES'];
	$img= "res/drug/".$row['IMG'];
	
	echo <<<END
	<tr bgcolor="$color" >
	<td width="10%"  class="align-middle" align="center" style="padding:5px;"><img width="75px" src="$img" title="$title"/></td>
	<td width="30%" class="align-middle"><p class="h4">$title</a></td>
	<td class="align-middle">$des</td> 
	<td width="10%" align="midle" class="align-middle">
<a href="view?id=$i"><button width=100% type="button" class="btn btn-info btn-sm">Информация</button></a>
</td> 
	</tr>
END;

$pdo = null;
}
?>
</table>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>