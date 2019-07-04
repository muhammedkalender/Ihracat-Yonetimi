<?php
include "../../include.php";
$lang=$session->userinfo["dil"];
unset($sayfaActive);
$sayfaActive["musterilerim"]="page-header-active";
include "../../inc.header.php";
include "../../inc.menu.php";

// Önce şifrelenmiş linkten değerleri al
foreach($_REQUEST as $input=>$value) {
	 $_REQUEST[$input] = $value;
}
// Aldığın değerleri tanımın adına döşe
foreach ($_REQUEST AS $k=>$v) $$k=$v;
?>


<link rel="stylesheet" type="text/css" href="<?=BASEURL."/assets/"?>styles.css" />
<link rel="stylesheet" type="text/css" href="<?=BASEURL."/assets/"?>fancybox/jquery.fancybox-1.2.6.css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=BASEURL."/assets/"?>fancybox/jquery.fancybox-1.2.6.pack.js"></script>

<script type="text/javascript" src="<?=BASEURL."/assets/"?>script.js"></script>
	 <!-- Condensed datatable inside panel -->
				<div id="main">
					<a id="addButton" class="green-button" href="add_note.html">Not Ekle</a>
					
					<?php 
					
$query = mysql_query("SELECT * FROM notes ORDER BY id DESC");
$notes = '';
$left='';
$top='';
$zindex='';
while($row=mysql_fetch_assoc($query))
{
	// The xyz column holds the position and z-index in the form 200x100x10:
	list($left,$top,$zindex) = explode('x',$row['xyz']);
	$notes.= '
	<div class="note '.$row['color'].'" style="left:'.$left.'px;top:'.$top.'px;z-index:'.$zindex.'">
		'.htmlspecialchars($row['text']).'
		<div class="author">'.htmlspecialchars($row['name']).'</div>
		<span class="data">'.$row['id'].'</span>
	</div>';
}
					echo $notes;
					
?>
					
				</div>
  
<?



include "../../inc.footer.php";

?>