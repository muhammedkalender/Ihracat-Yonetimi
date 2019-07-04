<!DOCTYPE html>
<?php
if(empty($_SERVER['HTTPS'])){
	//http://webcheatsheet.com/PHP/get_current_page_url.php
	$pageURL = "https://";
	
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	header('Location: '.$pageURL);
	exit;
}

GirisYapmisMi();
$GirisYapan = GirisYapan();
?>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$title;?>İhracat Yönetmi®<?php echo date("Y");?></title>
<meta name="keywords" content="ihracat yönetimi, dış ticaret yönetimi"/>
<meta name="description" content="İhracat yönetimi, dış ticaret ihracat süreçlerinizi online olarak kolayca yönetebileceğiniz mobil uyumlu bir takip programıdır."/>
<base href="<?=BASEURL;?>" />
<?php include "inc.css.php";?>
	<?php include "inc.js.php";?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" /> 

<link rel="manifest" href="manifest.json" />
</head>	
<body>

<!-- Preloader -->
<div id="preloader">
	<div id="status">&nbsp;</div>
</div>
    <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="hidden-lg pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                        <span class="sr-only">Yan menüyü kapat</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                        <span class="sr-only">Yan menüyü kapat</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
				
                <ul class="nav navbar-nav navbar-left-custom">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <?php
						/*if (empty($GirisYapan["fotograf"])) {
							$GirisYapan["fotograf"] = "0";
						}

						$GirisYapan["fotograf"] = str_replace(array("../upload/user_profil/", "upload/user_profil/"), array("", ""), $GirisYapan["fotograf"]);

						if ($GirisYapan["fotograf"] != "0") {
							echo "<img src='/upload/user_profil/".$GirisYapan["fotograf"]."' width='25' height='25' style='-webkit-border-radius: 2px 0 0 2px; -moz-border-radius: 2px 0 0 2px; border-radius: 2px 0 0 2px;' border='0' />";
						}else{
							echo "<img src='https://novasta.com.tr/file/novasta-web-tasarim-kurumsal-logo.svg' width='28' height='25' />";
						}*/
						
						echo '<span>'.$session->userinfo["adi"]." ".$session->userinfo["soyadi"].'</span>';
						
							
							
							$dk=mysql_query("select * from kurlar order by tarih DESC limit 2",$dbKur);
						$usdEuro=$usdTr=$euroTr=array();
						
						while($kurs=mysql_fetch_object($dk))
						{
							$usdEuro[]=$kurs->usdEuro;
							$usdTr[]=$kurs->usdTr;
							$euroTr[]=$kurs->euroTr;
						}
						
							$usdEuro[2]=floatval($usdEuro[0])-floatval($usdEuro[1]);
							$usdTr[2]=floatval($usdTr[0])-floatval($usdTr[1]);
							$euroTr[2]=floatval($euroTr[0])-floatval($euroTr[1]);
						
						
						
						
					?>
                            
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <!--<li><a href="#"><i class="fa fa-user"></i> Profil</a></li>-->
                            <li><a href="/process.php"><i class="fa fa-mail-forward"></i> Çıkış</a></li>
                        </ul> 
                    </li>
                    <li><a class="nav-icon sidebar-toggle" title="Yan Meneyü Kapat"><i class="fa fa-bars"></i></a></li>
					<li><a href="./"><i class="fa fa-home" aria-hidden="true"></i> Anasayfa'ya Dön</a></li>
					
                </ul>
            </div>

            <ul class="nav navbar-nav navbar-right collapse" id="navbar-right">
				<li><a class="nav-icon"><i class="fa fa-dollar"></i>/<i class="fa fa-eur"></i> <?=$usdEuro[0]?> <? if($usdEuro[2]>0) echo '<i class="fa fa-caret-up green"></i>'; else if($usdEuro[2]<0) echo '<i class="fa fa-caret-down red"></i>'; else if($usdEuro[2]==0) echo '<i class="fa fa-minus"></i>';?></a></li>
				<li><a class="nav-icon"><i class="fa fa-dollar"></i>/<i class="fa fa-try"></i> <?=$usdTr[0]?> <? if($usdTr[2]>0) echo '<i class="fa fa-caret-up green"></i>'; else if($usdTr[2]<0) echo '<i class="fa fa-caret-down red"></i>'; else if($usdTr[2]==0) echo '<i class="fa fa-minus"></i>';?></a></li>
				<li><a class="nav-icon"><i class="fa fa-eur"></i>/<i class="fa fa-try"></i> <?=$euroTr[0]?> <? if($euroTr[2]>0) echo '<i class="fa fa-caret-up green"></i>'; else if($euroTr[2]<0) echo '<i class="fa fa-caret-down red"></i>'; else if($euroTr[2]==0) echo '<i class="fa fa-minus"></i>';?></a></li>
                <?
				if($session->userlevel>=5)
				{
				?>
				<li>
                    <a href="users">
                        <i class="fa fa-male"></i>
                        <span>Kullanıcılar</span>
                       
                    </a>
                </li>
				<?php
				}
				?>
                <li>
                    <a href="feedback">
                        <i class="fa fa-comments"></i>
                        <span>Geri Bildirim</span>
                        
                    </a>
                </li>
				<li>
					<a href="ayarlar">
						<i class="fa fa-cog"></i>
					</a>
				</li>

               
            </ul>
        </div>
    </div>
    <!-- /navbar -->

				<div class="container-fluid">
              
				<div class="page-header ">
                <ul class="middle-nav pull-left">
				<?php
				/*  Resim http üzerinden çekilmiş
					05:33 11.05.2018 Muhammed Kalender 
					Orjinal Kod
					
					<img src="http://ihracatyonetimi.com/wp-content/uploads/2016/04/ihracat-yonetimi-logo.png" width="230" />
				*/
				?>
                <li><a href="./"><img src="https://ihracatyonetimi.com/wp-content/uploads/2016/04/ihracat-yonetimi-logo.png" width="230" /></a></li>
                </ul>
					<ul class="middle-nav">
                    
						<li><a href="./" class="btn btn-default <?=$sayfaActive["gorusmelerim"]?>"><i class="fa fa-users"></i> <span>Görüşmelerim</span></a></li>
						<li><a href="musterilerim" class="btn btn-default <?=$sayfaActive["musterilerim"]?>"><i class="fa fa-diamond"></i> <span>Müşterilerim</span></a></li>
						<li><a href="rakiplerim" class="btn btn-default <?=$sayfaActive["rakip"]?>"><i class="fa fa-user-secret"></i> <span>Rakiplerim</span></a></li>
						<li><a href="nakliyecilerim" class="btn btn-default <?=$sayfaActive["nakliye"]?>"><i class="fa fa-truck"></i> <span>Nakliyecilerim</span></a></li>
						<li><a href="gumrukcu" class="btn btn-default <?=$sayfaActive["gumruk"]?>"><i class="fa fa-exchange"></i> <span>Gümrükçüm</span></a></li>
						<li><a href="fuarlarim" class="btn btn-default <?=$sayfaActive["fuar"]?>"><i class="fa fa-globe"></i> <span>Fuarlarım</span></a></li>
						<!--<li><a href="mail" class="btn btn-default <?=$sayfaActive["mail"]?>"><i class="fa fa-envelope-o"></i> <span>e-Bülten</span></a></li>-->
					</ul>
				</div>
			</div>
            <!-- Page title -->
    <!-- Page header -->
    <div class="container-fluid">
        <div class="page-header">
            
        </div>
    </div>
    <!-- /page header -->


    <!-- Page container -->
    <div class="page-container container-fluid">
 
			<?php 
function tirnak($par)
{
	return str_replace(
		array(
			"'", "\""
			),
		array(
			"&#39;", "&quot;"
		),
		$par
	);
}
$_POST=array_map("tirnak", $_POST);
$_GET = array_map('tirnak', $_GET);
$_REQUEST = array_map('tirnak', $_REQUEST);


if($_REQUEST["username"]!="")
{
	$session->username=$_REQUEST["username"];
	$ekkullanici="&username=".$_REQUEST["username"];
}

			?>
