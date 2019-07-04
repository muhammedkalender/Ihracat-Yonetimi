<?php
include "include/session.php";
$lang = trim($_GET["l"]);
$return = base64_decode(trim($_GET["return"]));
if ($lang == "tr") {
	$_SESSION["lang"] = "tr";
	unset($_COOKIE['sigmanetlang']); 
	setcookie("sigmanetlang", "tr", time()+10800);
}elseif ($lang == "en") {
	$_SESSION["lang"] = "en";
	unset($_COOKIE['sigmanetlang']); 
	setcookie("sigmanetlang", "en", time()+10800);
}else{
	// default lang
	$lang="tr";
	unset($_COOKIE['sigmanetlang']); 
	setcookie("sigmanetlang", "tr", time()+10800);
}

if(mysql_query("update users set dil='".$lang."' WHERE username='".$session->username."'"))
{
}

header("Location: $return");
?>