<?php

if(date("D")=="Sat" || date("D")=="Sun")
	exit;

$dbKur = mysql_connect("localhost","","e(x"); 

								if (!$dbKur) 

								{ 

								die("Bağlantı Hatası"); 

								} 

								mysql_select_db("ihracaty_kurlar", $dbKur); 





$content = file_get_contents("http://www.tcmb.gov.tr/kurlar/today.xml"); 



$dolar_bul = explode('</ForexBuying>',$content); 

$dolar_alis = explode('<ForexBuying>',$dolar_bul[0]); 

$dolar_alis = $dolar_alis[1]; 





$euro_bul = explode('</CrossRateOther>',$content); 

$euro_dolar = explode('<CrossRateOther>',$euro_bul[3]); 

$euro_dolar=$euro_dolar[1];





$xml=simplexml_load_string($content);



$euroTr=(round(floatval($dolar_alis)*floatval($euro_dolar),4));

// 02:57 5.5.2018 Tarihinde Değiştirilmiştir
// is_numeric($xml->Currency[3]->CrossRateOther) sürekli false döndürüyor ( Koşulun 2. Maddesi )
// ((float)$xml->Currency[3]->CrossRateOther) eğer değer, float değilse 0 dönüyor
// Koşulun Orjinal Hali if(is_numeric($dolar_alis) AND is_numeric($xml->Currency[3]->CrossRateOther) AND is_numeric($euroTr))

// Orjinal hale dönülürse bu veri gereksizdir
$usdEuro = ((float)$xml->Currency[3]->CrossRateOther);

if(is_numeric($dolar_alis) AND $usdEuro != 0 AND is_numeric($euroTr))

{

	//if(mysql_query("insert into kurlar set tarih='".time()."', usdTr='".$dolar_alis."', usdEuro='".$euro_dolar."', euroTr='".$euroTr."'",$dbKur))

	if(mysql_query("insert into kurlar set tarih='".time()."', usdTr='".$dolar_alis."', usdEuro='".$usdEuro."', euroTr='".$xml->Currency[3]->ForexBuying."'",$dbKur))

	{

		

	}

	

}



?>