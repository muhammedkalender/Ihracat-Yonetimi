<?php
//https://stackoverflow.com/a/5100206
//[DEGISIM]05:59 11.05.2018 Muhammed Kalender
//SSL yönllendirmesi
if(empty($_SERVER['HTTPS'])){
	header('Location: https://viscotex.ihracatyonetimi.com/');
	exit;
}

include "include.php";
if ($session->logged_in) {
	header("Location: index");
}

if (isset($_REQUEST["u"])) {
	
	$u = $_REQUEST["u"];
	$p = $_REQUEST["p"];

	header("Location: /process.php?login=1&user=".$u."&pass=".$p."&lang=".$_REQUEST["lang"]."&remmeber=1");
	
	exit();

}
$ch1=$ch2="";
if($_COOKIE['sigmanetlang']=="tr" || $_COOKIE['sigmanetlang']=="")
$ch1="checked";
else
$ch2="checked";
$Logo = GetTableValue("value","ayarlar","WHERE name = 'Logo'");
if($Logo=="")
{
	$Logo='https://ihracatyonetimi.com/wp-content/uploads/2016/04/ihracat-yonetimi-logo.png';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>İhracat Yönetimi® <?php echo date("Y");?></title>

<?php include "inc.css.php";?>
<?php include "inc.js.php";?>
	

</head>

<body class="full-width animation-true">



   <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="hidden-lg pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-left-custom">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" href="https://www.novasta.com.tr" data-toggle="dropdown">
                            
							<img src="https://novasta.com.tr/file/novasta-web-tasarim-kurumsal-logo.svg" width="50px" alt="novasta-logo">
                            <span>İhracat Yönetimi</span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                        	<li><a class="https://www.ihracatyonetimi.com/iletisim">Teklif Al</a></li>
                            <li><a class="https://www.ihracatyonetimi.com/sss">Yardım</a></li>
                            
                        </ul>
                    </li>
                </ul>
            </div>

           <!-- <ul class="nav navbar-nav navbar-right collapse" id="navbar-right">
                <li>
                    <a href="#">
                        <i class="fa fa-rotate-right"></i>
                        <span>Kullanan Firma Sayısı</span>
                        <strong class="label label-danger">15</strong>
                    </a>
                </li>
            </ul>-->
        </div>
    </div>
    <!-- /navbar -->


    <!-- Page container -->
    <div class="page-container container">

        <!-- Page content -->
        <div class="page-content">    
    	<p align="center" style="margin-top:55px;">
     
    <img src="<?=$Logo?>" width="250"/>
	</p>

            <!-- Login wrapper -->
            <div class="login-wrapper" style="margin:0 auto;">
                <form action="/check-login" method="post" role="form">

                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-user"></i> Yönetim Paneli</h6></div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label>Kullanıcı Adı</label>
                                <input type="text" class="form-control" placeholder="Kullanıcı Adı" name="user">
                                <i class="fa fa-user form-control-feedback"></i>
                            </div>

                            <div class="form-group has-feedback">
                                <label>Şifre</label>
                                <input type="password" class="form-control" placeholder="Şifre" name="pass">
                                <i class="fa fa-lock form-control-feedback"></i>
                            </div>

                            <div class="row form-actions">
                                <div class="col-xs-6">
                                    <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" value="1" class="styled">
                                        Beni Hatırla
                                    </label>
                                    </div>
                                </div>
								<input type="hidden" name="lang" value="tr" />
								<input type="hidden" name="sublogin" value="1" />
		<input type="hidden" name="git" value="<?php if (isset($_REQUEST["git"])) { echo $_REQUEST["git"];}else{ echo "index";}?>" />
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-bars"></i> Giriş</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>  
            <!-- /login wrapper -->      
<h1 align="center">İhracat Yönetimi V.1.1</h1>
        
        </div>
        <!-- /page content -->

    </div>
    <!-- page container -->

</body>
</html>

