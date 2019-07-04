<?php
include "include.php";
$dosya = $_REQUEST["d"];
$isim = $_REQUEST["i"];



if ($dosya) {
	$uzanti=  array();
	$uzanti = explode('.', $dosya);
	$adi=explode('/', $uzanti["0"]);
	$filename = "".$_REQUEST["i"].".".$uzanti["1"]."";
	
	header("Content-type: application/force-download");
	header("Content-Transfer-Encoding: Binary");
	header("Content-length: ".filesize($dosya));
	header("Content-disposition: attachment; filename=".$filename."");
	readfile("http://sigma.onlinekalite.com/".$dosya."");
}else{
	echo "URLden dosya bilgisi gelmiyor";
}
?>