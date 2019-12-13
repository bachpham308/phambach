<?php
// Разработчик: Артем Кошкин 
// Версия 0.39
require_once 'core/config.php';
require_once 'core/db.php';
require_once 'core/utils.php';

saveFile($_GET['user']);
foreach ($cgChats as $chat) {
    sendMessage($cgToken,$chat,answer($_GET['user']));
}



$a = answer($_GET['user']);
echo $a."<br>";
	$pos1 = (int)strpos($a,"ФИО: </b>"); 
	$pos1N = (int)strpos($a, "\n",$pos1);
	
	$pos2 = (int)strpos($a,"Город: </b>"); 
	$pos2N = (int)strpos($a, "\n",$pos2);
	
	$pos3 = (int)strpos($a,"Номер телефона: </b>"); 
	$pos3N = (int)strpos($a, "\n",$pos3);
	
	$parameters['name'] = mb_strcut($a,$pos1+13,$pos1N-$pos1-12);
	$parameters['city'] = mb_strcut($a,$pos2+17,$pos2N-$pos2-16);
	$parameters['phone'] = mb_strcut($a,$pos3+33,$pos3N-$pos3-33);
	$parameters['app'] = "1";
	
	echo $parameters['name']."<br>";
	echo $parameters['city']."<br>";
	echo $parameters['phone']."<br>";
	
	if(isset($_GET['app'])) $parameters['app'] = $_GET['app'];

	if($a!="Только что на сервер упала тестовая заявка!" && !empty($parameters['phone'])) {try{
$result = $pdo->prepare('INSERT INTO Заявки(id,NAME,CITY,PHONE,APP) VALUES (NULL, :name,:city,:phone,:app)');
$result->execute($parameters);
	echo "Добавили в БД: OK<br>";
} catch (PDOException $e) {
	echo "<b>Ошибка добавления в БД: </b>FAIL<br>";
} } else
	echo "<b>Ошибка добавления в БД: </b>Empty!<br>";

?>