<?

$dbKur = mysql_connect("localhost","",""); 

								if (!$dbKur) 

								{ 

								die("Bağlantı Hatası"); 

								} 

								mysql_select_db("ihracaty_kurlar", $dbKur); 

?>