<?php
include "include/session.php";

include "lib/db.php"; // bunu kullanmayacağız, yavaş yavaş bunu sistemden kaldırıyoruz db class olmayacak.
try {
				 $dbpdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USER, DB_PASS);
			} catch ( PDOException $e ){
				 print $e->getMessage();
			}
include "lib/functions.php";
URL::decode();

## Dil kontrolü
$dil = $HTTP_COOKIE_VARS["sigmanetlang"];
if($session->userinfo["dil"]=="")
$dil="tr";
else
$dil=$session->userinfo["dil"];

?>