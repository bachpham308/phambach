<html><?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
function is_empty(&$var)
{
    return !($var || (is_scalar($var) && strlen($var)));
}
$lat=51.768199;
$lon=55.096955;
session_start();
require_once 'core/db.php';
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$sql = "SELECT * FROM Preparat WHERE ID ='$id' LIMIT 1";
$sql2 = "SELECT * FROM Apteka INNER JOIN 2PreparatApteka on Apteka.id=id_apteka where id_preparat=$id ORDER BY 2PreparatApteka.COUNT desc";
$result = $pdo->prepare($sql);
$result->execute();
$result2 = $pdo->prepare($sql2);
$result2->execute();

$apteks=$result2->fetchAll();
$item = $result->fetchAll()[0];
?>
<head>
    <meta charset="utf-8">

<title><?php echo $item['TITLE'];?></title>
<link rel="stylesheet" 
href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
    <!-- Custom styles for this template -->
    <!--<link href="form-validation.css" rel="stylesheet">-->
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
     <!--   <a class="nav-link text-light " href="/">Все лекарства</a>-->
     <!-- </li> -->
     <!-- <li class="nav-item">-->
     <!--   <a class="nav-link text-light" href="places">Аптеки</a>-->
     <!-- </li>-->
  	</ul>
    <form action="/" class="form-inline my-2 my-lg-0">
      <input name="search" class="form-control mr-sm-2" type="search" placeholder="Введите название.." aria-label="Search">
      <button formmethod="get" class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>
  </div>
</nav>
    	
  <div class="py-3 text-center">
    <img class="d-block mx-auto mb-4" src="<?php echo "res/drug/".$item['IMG'];?>" alt="Loading" width="112" height="112">
    <h2 class="text-success"><?php echo $item['TITLE'];?></h2>
    <p class="lead"><?php echo $item['DES'];?></p>
  </div>

  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Аптеки</span>
        <span class="badge badge-secondary badge-pill"><?php echo count($apteks);?></span>
      </h4>
      
      <ul class="list-group mb-3">
      <?php 
      for ($i = 0; $i < count($apteks); $i++) {
      		$row = $apteks[$i];
      		$style = "text-muted";
      		$address = $row['Address'];
      		$count = $row['COUNT'];
      		$price = $row['PRICE'];
      		if($count<3) $style="text-danger";
      		
      			echo <<<END
      		<li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">$address</h6>
            <small class="$style">$count уп.</small>
          </div>
          <span class="text-muted">$price ₽</span>
        </li>
END;
		}
      ?>
            </ul>


      <form class="card p-2 ">
      	<?php
      	if(count($apteks)>0) {
      		echo <<<END
      	<p class="text-muted">Где вы хотите купить?</p>
        <div class="input-group" >
        <select class="selector form-control form-control-sm">
END;
      for ($i = 0; $i < count($apteks); $i++) {
      	        			echo "<option>".$apteks[$i]['Address']."</option>";
      }
      echo <<<END
      </select>
      </div>
      <br><p class="route alert alert-secondary"></p>
END;
      echo "<a title=\"Посмотреть на карте\" class=\"url mx-auto d-block\" target=\"_blank\"><img class=\"map rounded float-left\" alt=\"Map\"></a>";
      echo "<br/><p align=center><a class=\"ya btn btn-danger btn-block\" target=\"_blank\" role=\"button\">Построить маршрут</a></p>";

} else {
echo "<p class=\"text-center text-danger font-weight-bold\">Данное лекарство пока что нельзя нигде купить</p>";	
}
?>
	</form>
      
<script>
$( document ).ready(function() {
var arr = [];
var map = [];
var ya = [];
var url = [];
<?php
for ($i = 0; $i < count($apteks); $i++) {
	echo "arr[$i]=\"<b>Директор: </b>".$apteks[$i]['FIO']."<br/><b>Телефон: </b>".$apteks[$i]['PHONE']."<br/><br/>".$apteks[$i]['ROUTE']."\";\n";
	echo "map[$i]=\"https://static-maps.yandex.ru/1.x/?ll=".$apteks[$i]['LON'].",".$apteks[$i]['LAT']."&z=17&l=map&size=310,310\";\n";
	echo "ya[$i]=\"https://yandex.ru/maps/?rtext=".$lat.",".$lon."~".$apteks[$i]['LAT'].",".$apteks[$i]['LON']."&rtt=mt\";\n";
	echo "url[$i]=\"https://yandex.ru/maps/?ll=".$apteks[$i]['LON'].",".$apteks[$i]['LAT']."&z=17.2&l=map\";\n";
}
?>

    $(".route").html(arr[0]);
    $(".map").attr("src",map[0]);
    $(".ya").attr("href",ya[0]);
    $(".url").attr("href",url[0]);

    $('.selector').on('change', function(e){
  //this.selectedIndex
    console.log(arr[this.selectedIndex]);
    $(".route").html(arr[this.selectedIndex]);
    $(".map").attr("src",map[this.selectedIndex]);
    $(".ya").attr("href",ya[this.selectedIndex]);
    $(".url").attr("href",url[this.selectedIndex]);
});
});
</script>

    </div>
    
    <div class="col-md-8 order-md-1">
    	 
        <h4 class="mb-3">Показания к применению</h4>

        <div class="mb-3">
          <?php 
          $action = $item['POKAZ'];
          if(!is_empty($action)) echo "<label>$action</label>";
          else echo "<label class=\"text-muted\">Отсутствует</label>";?>
        </div>
        
        <h4 class="mb-3">Условия отпуска</h4>

        <div class="mb-3">
          <?php 
          $sql = "SELECT * FROM `2PreparatOtpusk` INNER JOIN Otpusk on Otpusk.id=id_otpusk WHERE 2PreparatOtpusk.id_preparat='".$item['ID']."'";
          $result = $pdo->prepare($sql);
          $result->execute();
          $action = $result->fetchAll()[0]['TITLE'];
          if(!is_empty($action)) echo "<label>$action</label>";
          else echo "<label class=\"text-muted\">Отсутствует</label>";?>
        </div>
        
      <h4 class="mb-3">Фармакологическая группа</h4>
        <div class="mb-3">
          <?php
          $sql = "SELECT * FROM 2PreparatGruppa INNER JOIN Gruppa on Gruppa.id=id_gruppa WHERE 2PreparatGruppa.id_preparat=".$item['ID'];
          $result = $pdo->prepare($sql);
          $result->execute();
          $actions=$result->fetchAll();
          
          if(!is_empty($actions)) {
          	echo "<label>";
          	  for ($i = 0; $i < count($actions); $i++) {
        	$action = $actions[$i]['TITLE'];
        	if(!is_empty($actions[$i]['ABBR'])) $action.=" (".$actions[$i]['ABBR'].")";
        	
      echo $action."<br/>";
      }
      echo "</label>";
          }
          else echo "<label class=\"text-muted\">Отсутствует</label>";?>
        </div>  
        
        <h4 class="mb-3">Фармакологическое действие</h4>

        <div class="mb-3">
          <?php 
         $sql = "SELECT * FROM 2PreparatDeistvie INNER JOIN Deistvie on Deistvie.id=id_deistvie WHERE 2PreparatDeistvie.id_preparat=".$item['ID'];
          $result = $pdo->prepare($sql);
          $result->execute();
          $actions=$result->fetchAll();
          
          if(!is_empty($actions)) {
          	echo "<label class=\"font-italic\">";
          	  for ($i = 0; $i < count($actions); $i++) {
        	$action = $actions[$i]['TITLE'];
    		echo $action;
    		if($i!=count($actions)-1) echo ", ";
      }
      echo "</label>";
          }
          else echo "<label class=\"text-muted\">Отсутствует</label>";?>
        </div>  
        
        <h4 class="mb-3">Нозологическая классификация</h4>

        <div class="mb-3">
          <?php 
          $sql = "SELECT * FROM 2PreparatKlassificacia INNER JOIN Klassificacia on Klassificacia.id=ID_KLASSIFICACIA WHERE 2PreparatKlassificacia.id_preparat=".$item['ID'];
          $result = $pdo->prepare($sql);
          $result->execute();
          $actions=$result->fetchAll();
          
          if(!is_empty($actions)) {
          	echo "<label>";
          	  for ($i = 0; $i < count($actions); $i++) {
        	$action = $actions[$i]['TITLE'];
        	if(!is_empty($actions[$i]['ABBR'])) $action=$actions[$i]['ABBR']." ".$actions[$i]['TITLE'];
        	
      echo $action."<br/>";
      }
      echo "</label>";
          } else  echo "<label class=\"text-muted\">Отсутствует</label>";?>
        </div>
       
      </form>
    </div>
  </div>
 <hr class="mb-4">
  <footer class="my-5 pt-5 text-muted text-center text-small">
  
    <!--<ul class="list-inline">-->
    <!--  <li class="list-inline-item"><a href="#">Privacy</a></li>-->
    <!--  <li class="list-inline-item"><a href="#">Terms</a></li>-->
    <!--  <li class="list-inline-item"><a href="#">Support</a></li>-->
    <!--</ul>-->
  </footer>
</div>
        </body>
</html>
