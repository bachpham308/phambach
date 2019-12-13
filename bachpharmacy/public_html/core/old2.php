<?php

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
session_start();
//if(!isset($_SESSION["login"])) header("location:login.php");
require_once 'core/db.php';
$count = isset($_GET['count']) ? $_GET['count'] : 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$startPoint = ($page-1) *$count;


$otpusk = isset($_GET['otpusk']) ? $_GET['otpusk'] : 0;
$deistvie = isset($_GET['deistvie']) ? $_GET['deistvie'] : 0;
$klasificacia = isset($_GET['klasificacia']) ? $_GET['klasificacia'] : 0;
$search = isset($_GET['search']) ? $_GET['search'] : null;

try{
$query = "SELECT * FROM Preparat ORDER BY ID LIMIT $startPoint,$count";
if($otpusk!=0) $query="SELECT Preparat.ID, Preparat.TITLE, Preparat.DES, Preparat.IMG, Preparat.POKAZ FROM `2PreparatOtpusk` INNER JOIN Preparat on Preparat.id=ID_PREPARAT WHERE ID_OTPUSK=$otpusk ORDER BY ID LIMIT $startPoint,$count";
if($deistvie!=0) $query="SELECT Preparat.ID, Preparat.TITLE, Preparat.DES, Preparat.IMG, Preparat.POKAZ FROM 2PreparatDeistvie INNER JOIN Preparat on Preparat.id=ID_PREPARAT WHERE ID_DEISTVIE=$deistvie ORDER BY ID LIMIT $startPoint,$count";
if($klasificacia!=0) $query="SELECT Preparat.ID, Preparat.TITLE, Preparat.DES, Preparat.IMG, Preparat.POKAZ FROM 2PreparatKlassificacia INNER JOIN Preparat on Preparat.id=ID_PREPARAT WHERE ID_KLASSIFICACIA=$klasificacia ORDER BY ID LIMIT $startPoint,$count";
if($search!=null) $query="SELECT * FROM Preparat where TITLE LIKE '%$search%' OR DES LIKE '%$search%' OR POKAZ LIKE '%$search%' ORDER BY ID LIMIT $startPoint,$count";

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
	<style>
/*body{*/
/*	background-image:url("http://cdn.desktopwallpapers4.me/wallpapers/abstract/1920x1080/2/14562-blue-gradient-1920x1080-abstract-wallpaper.jpg"); */
/*	background-repeat:no-repeat; */
/*	background-position:center; */
/*	background-size:cover; */
/*	padding:10px;*/
/*}*/
</style>
<meta charset="utf-8">
<?php
$title = "Каталог Лекарств";
if($otpusk!=0) $title="Фильтрация по Отпуску";
if($deistvie!=0) $title="Фильтрация по Действию";
if($klasificacia!=0) $title="Фильтрация по Классификации";
if($search!=null) $title="Поиск по \"$search\"";
echo  "<title>$title</title>";
?>
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
  		 <!--<li class="nav-item active">-->
     <!--   <a class="nav-link text-light font-weight-bold" href="/">Все лекарства</a>-->
     <!-- </li> -->
     <!-- <li class="nav-item">-->
     <!--   <a class="nav-link text-light " href="places">Аптеки</a>-->
     <!-- </li>-->
  	</ul>
    <form action="/" class="form-inline my-2 my-lg-0">
    	<?php
    $placeholder = "Введите название..";
    if($search!=null) $placeholder=$search;
    echo "<input name=\"search\" class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"$placeholder\" aria-label=\"Search\" value=$search>";
      ?>
      <button formmethod="get" class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>
  </div>
</nav>

<div class="py-3 row">
<div class="col"  align="left">
<nav aria-label="...">
  <ul class="pagination pagination-sm">
    <li class="page-item <?php if($page<2) echo "disabled";?>">
      <a class="page-link" href="<?php echo "?page=".($page - 1)."&count=$count&otpusk=$otpusk&deistvie=$deistvie&klasificacia=$klasificacia"; ?>">←Пред</a>
    </li>
    <li class="page-item active">
      <a class="page-link"><?php echo $page ?></a>
    </li>
    <li class="page-item <?php if($rowCount<$count) echo "disabled";?>">
      <a class="page-link" href="<?php echo "?page=".($page + 1)."&count=$count&otpusk=$otpusk&deistvie=$deistvie&klasificacia=$klasificacia"; ?>">След→</a>
    </li>
  </ul>
</nav>
</div>

<div class="col-10" align="right">

  <div class="btn-group">
  	<?php
  	 $style ="btn-primary";
  	 $name ="Отпуск";
  	 
  	 $s = "SELECT * FROM Otpusk";
     $r = $pdo->prepare($s);
     $r->execute();
     $itms=$r->fetchAll();
     for ($i = 0; $i < count($itms); $i++) {
     	if($itms[$i]['ID']==$otpusk) $name=$itms[$i]['TITLE'];
     }
  	if($otpusk!=0) $style="btn-success";
	echo "<button class=\"btn $style btn-sm dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
	echo "$name</button>";
  ?>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  	<?php
     for ($i = 0; $i < count($itms); $i++) {
     	$id = $itms[$i]['ID'];
     	$title = $itms[$i]['TITLE'];
     	echo "<a class=\"dropdown-item\" href=\"?page=1&count=$count&otpusk=$id&deistvie=0&klasificacia=0\">$title</a>";
      }
  	?>
  </div>
  </div> 
  
  <div class="btn-group">
  <?php
  	 $style ="btn-primary";
  	 $name ="Действие";
  	 
  	 $s = "SELECT * FROM Deistvie order by TITLE";
     $r = $pdo->prepare($s);
     $r->execute();
     $itms=$r->fetchAll();
     for ($i = 0; $i < count($itms); $i++) {
     	if($itms[$i]['ID']==$deistvie) $name=$itms[$i]['TITLE'];
     }
  	if($deistvie!=0) $style="btn-success";
	echo "<button class=\"btn text-capitalize $style btn-sm dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
	echo "$name</button>";
  ?>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  		<?php
     for ($i = 0; $i < count($itms); $i++) {
     	$id = $itms[$i]['ID'];
     	$title = $itms[$i]['TITLE'];
     	echo "<a class=\"dropdown-item text-capitalize\" href=\"?page=1&count=$count&otpusk=0&deistvie=$id&klasificacia=0\">$title</a>";
      }
  	?>
  </div>
  </div> 
  
  <div class="btn-group">
  <?php
  	 $style ="btn-primary";
  	 $name ="Классификация";
  	 
  	 $s = "SELECT * FROM Klassificacia order by TITLE";
     $r = $pdo->prepare($s);
     $r->execute();
     $itms=$r->fetchAll();
     for ($i = 0; $i < count($itms); $i++) {
     	if($itms[$i]['ID']==$klasificacia) $name=$itms[$i]['TITLE'];
     }
  	if($klasificacia!=0) $style="btn-success";
	echo "<button class=\"btn $style btn-sm dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
	echo "$name</button>";
  ?>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  			<?php
     for ($i = 0; $i < count($itms); $i++) {
     	$id = $itms[$i]['ID'];
     	$title = $itms[$i]['TITLE'];
     	echo "<a class=\"dropdown-item \" href=\"?page=1&count=$count&otpusk=0&deistvie=0&klasificacia=$id\">$title</a>";
      }
  	?>
  </div>
  </div> 
  
  
  <div class="btn-group">
  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Выводить по
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

$counter=0;
while ($row =$result->fetch()) {
	$counter++;
	$i = $row['ID'];
	$title = $row['TITLE'];
	$des = $row['DES'];
	$img= "res/drug/".$row['IMG'];
	
	echo <<<END
	<tr>
	<td width="10%"  class="align-middle" align="center" style="padding:5px;"><a href="view?id=$i"><img width="75px" src="$img" title="$title"/></a></td>
	<td width="20%" class="align-middle"><p class="h4">$title</a></td>
	<td class="align-middle">$des</td> 
	<td width="10%" align="midle" class="align-middle">
<a href="view?id=$i"><button width=100% type="button" class="btn btn-success btn-sm">Информация</button></a>
</td> 
	</tr>
END;
}
if($counter<1) echo "<h1 align=\"center\">Ничего не найдено!</h1>";
$pdo = null;
?>
</table>

 <hr class="mb-4">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>