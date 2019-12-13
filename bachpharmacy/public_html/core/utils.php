<?php

function answer($a) 
{
  $a = str_replace("ФИО:", "<b>ФИО: </b>", $a);
  $a = str_replace("Город:", "<b>Город: </b>", $a);
  $a = str_replace("Номер телефона:", "<b>Номер телефона: </b>", $a);
  
  $a = str_replace("Серия и номер прав:", "<b>Серия и номер прав: </b>", $a);
  $a = str_replace("Водительский стаж:", "<b>Водительский стаж: </b>", $a);
  $a = str_replace("Марка авто:", "<b>Марка авто: </b>", $a);
  $a = str_replace("Модель авто:", "<b>Модель авто: </b>", $a);
  $a = str_replace("Год выпуска авто:", "<b>Год выпуска авто: </b>", $a);
  $a = str_replace("Гос.номер:", "<b>Гос.номер: </b>", $a);
  
  if(strpos(strtolower($a), "test")>-1)  $a = "Только что на сервер упала тестовая заявка!";
  return $a;
}

function sendMessage($token,$chat,$answer){
	if(!empty($answer)) {
		file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat&text=".urlencode($answer)."&parse_mode=html");
		echo "Отправили в Telegram: OK<br>";
	} else echo "<b>Ошибка отправки в Telegram: </b>Empty!<br>";
}

function saveFile($a){
	if(!empty($a)) {
		$file = 'csv.txt';
	$cur = file_get_contents($file);
	$text =iconv("UTF-8","cp1251",$a).$cur;
	file_put_contents($file, $text);
	echo "Сохранили в txt: OK<br>";
} else echo "<b>Ошибка сохранения в txt: </b>Empty!<br>";
}
?>