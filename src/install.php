<?php
include "include.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Novasta İhracat Yönetimi</title>

<?php include "inc.css.php";?>
<?php include "inc.js.php";?>
	

</head>

<body class="full-width">


<?php
foreach($_REQUEST as $input=>$value) {
	 $_REQUEST[$input] = $value;
}
// Aldığın değerleri tanımın adına döşe
foreach ($_REQUEST AS $k=>$v) $$k=$v;
if (isset($_POST["user"])) {
	$kayitId=0;
	if(mysql_query("insert into firma set firma='$firma', kayitTarihi='".time()."'"))
	{
		$kayitId=mysql_insert_id();
	}else
		echo mysql_error();
	if($kayitId>0)
	{
		$q = mysql_query("insert into users (username, password, userid, userlevel, email, adi, soyadi, firma) VALUES ('$user', '".md5($pass)."', '0', '9', '$email', '$isim', '$soyisim', '$kayitId')");
		if ($q) {
			echo "Kurulum tamam.. Lütfen bekleyin";
			echo "<meta http-equiv='refresh' content='1;URL=./' />";
		}
	}else
		echo "!!! Firma kaydı alınamadı";
	
	
}
?>
  
    <div class="page-container container">
    
        <!-- Page content -->
        <div class="page-content">


            <!-- Login wrapper -->
            <div class="login-wrapper">
                <form  method="post" role="form">

                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title"><i class="fa fa-user"></i> Yönetim Paneli</h6></div>
                        <div class="panel-body">
                            <div class="form-group has-feedback">
                                <label>Firma Adı</label>
                                <input type="text" class="form-control" placeholder="Firma Adı" name="firma">
                                <i class="fa fa-suitcase form-control-feedback"></i>
                            </div>
							
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
							
							<div class="form-group has-feedback">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Email" name="email">
                                <i class="fa fa-envelope-o form-control-feedback"></i>
                            </div>
							
							<div class="form-group has-feedback">
                                <label>Adı</label>
                                <input type="text" class="form-control" placeholder="Adı" name="isim">
                                <i class="fa fa-user form-control-feedback"></i>
                            </div>
							
							<div class="form-group has-feedback">
                                <label>Soyadı</label>
                                <input type="text" class="form-control" placeholder="Soyadı" name="soyisim">
                                <i class="fa fa-user form-control-feedback"></i>
                            </div>
                            <div class="row form-actions">
                                 <div class="col-xs-6">
                                    <button type="submit" class="btn btn-warning pull-right"><i class="fa fa-plus-square"></i> OLUŞTUR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>  
            <!-- /login wrapper -->      

        
        </div>
        <!-- /page content -->

    </div>
    <!-- page container -->

</body>
</html>
            
