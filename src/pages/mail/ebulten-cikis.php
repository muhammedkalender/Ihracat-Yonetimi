<?php
include "../../include.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Novasta İhracat Yönetimi</title>

<?php include "../../inc.css.php";?>
<?php include "../../inc.js.php";?>
	

</head>

<body class="full-width">
    <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <div class="hidden-lg pull-right">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-right">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-chevron-down"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-left-custom">
                    <li class="user dropdown">
                        <a class="dropdown-toggle" href="http://www.novasta.com.tr" data-toggle="dropdown">
                            <img src="https://novasta.com.tr/file/novasta-web-tasarim-kurumsal-logo.svg" width="50px" alt="novasta-logo">
                            <span><a href="https://www.novasta.com.tr">Teklif Al</a></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            
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


            <!-- Login wrapper -->
            <div class="login-wrapper">
				<?
					if($_REQUEST["islem"]=="kaldir")
					{
						$d=mysql_query("select * from banned_emails where email='".$_REQUEST["epos"]."'");
						if(mysql_num_rows($d)>0)
						{
							$o=mysql_fetch_object($d);
							echo $uyari->Bilgi("Mail adresinizi ".date("d.m.Y H:i",$o->tarih)." tarihinde kaldırdınız!");
						}else{
							if(mysql_query("insert into banned_emails set email='".$_REQUEST["epos"]."', tarih='".time()."'"))
							{
								echo $uyari->Basarili("Email adresiniz başarıyla kaldırılmıştır. Tarafımızdan email alamayacaksınız!");
							}else{
								echo $uyari->Hata("Kaldırma aşamasında problem oluştu. lütfen telefonla iletişime geçiniz.");
							}
						}
					}else{
						?>
						<form action="/ebulten-cikis?<?=URL::encode("?islem=kaldir&epos=".$_REQUEST["epos"])?>" method="post" role="form">
							<button type="submit" class="btn btn-warning pull-right"><i class="fa fa-sign-out"></i> Ebülten Aboneliğinden Çıkmak İçin Tıklayınız</button>
						</form>
						<?
					}
				?>
                
            </div>  
            <!-- /login wrapper -->      

        
        </div>
        <!-- /page content -->

    </div>
    <!-- page container -->

</body>
</html>

