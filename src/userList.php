<?php
include "include.php";
$lang=$session->userinfo["dil"];



/* cron olarak kurulamayan ama arada çalışması gereken kodlar */
































if($_POST["islem"]=="gorusSil") 
{
	if(mysql_query("delete from firmaGorusme where id='".$_POST["id"]."'"))
	{
		echo "OK";
	}else
		echo mysql_error();
	exit;
}else if($_POST["islem"]=="ulkeLinkGetir")
{
	echo BASEURL."?".URL::encode("?ulke=".$_POST["ulke"]);
	exit;
}else if($_POST["islem"]=="KullaniciKaldir")
{
	if(mysql_query("delete from users where username='".$_POST["username"]."'"))
	{
		if(mysql_query("delete from users_Ulke where username='".$_POST["username"]."'")){}
		echo "OK";
	}else
		echo mysql_error();
	exit;
}

// Önce şifrelenmiş linkten değerleri al
foreach($_REQUEST as $input=>$value) {
$_REQUEST[$input] = $value;
}
// Aldığın değerleri tanımın adına döşe
foreach ($_REQUEST AS $k=>$v) $$k=$v;


if($_POST["uid"]!="")
{
	if($tip=="A")
		$userlevel="9";
	else if($tip=="YK")
		$userlevel="5";
	else
		$userlevel="1";

	if(mysql_query("delete from users_Ulke where username='".$uid."'")){
		$u_c=0;
		$liste2=$liste="";
		foreach($ulke as $s)
		{
			if($u_c++>0)
				$liste.= ", ";
			$liste .= $s;
		}
		$u_c=0;
		foreach($bolge as $s)
		{
			if($u_c++>0)
				$liste2.= ", ";
			$liste2 .= $s;
		}

		$query = $dbpdo->prepare("INSERT INTO users_Ulke SET
				username = :username,
				ulke = :ulke,
				bolge = :bolge
				");
				$insert = $query->execute(array(
					  "username" => $username,
					  "ulke" => $liste,
					  "bolge" => $liste2
				));
	}
		$query = $dbpdo->prepare("UPDATE users SET
	adi = :adi,
	soyadi = :soyadi,
	email = :email,
	tckn = :tckn,
	userlevel = :userlevel
	WHERE username = :uid");

	$update = $query->execute(array(
		 "adi" => $adi,
		 "soyadi" => $soyadi,
		 "email" => $email,
		 "tckn" => $tckn,
		 "userlevel" => $userlevel,
		 "uid" => $uid,
	));

		if ( $update ){
			 echo $uyari->Basarili("Kullanıcı detayları başarıyla kaydedilmiştir.");
		}

		if($password!="")
		{
			$query = $dbpdo->prepare("UPDATE users SET
			password = :password,
			password_salt = :password_salt
			WHERE username = :uid");

			$update = $query->execute(array(
				 "password" => md5($password),
				 "password_salt" => $password,
				  "uid" => $uid,
			));

			if ( $update ){
				 echo $uyari->Basarili("Kullanıcı Şifresi başarıyla kaydedilmiştir.");
				}
		}

}else if($_POST["adi"]!="" AND $_POST["password"]!=""){

	if($tip=="A")
		$userlevel=9;
	else if($tip=="YK")
		$userlevel=5;
	else
		$userlevel=1;

	$query = $dbpdo->prepare("insert into users SET
	username = :username,
	adi = :adi,
	soyadi = :soyadi,
	password = :password,
	email = :email,
	userlevel = :userlevel");

	$kayit = $query->execute(array(
		 "username" => $email,
		 "adi" => $adi,
		 "soyadi" => $soyadi,
		 "password" => md5($password),
		 "email" => $email,
		 "userlevel" => $userlevel
	));

		$u_c=0;
		$liste2=$liste="";

		foreach($ulke as $s)
		{
			if($u_c++>0)
				$liste.= ", ";
			$liste .= $s;
		}
		$u_c=0;
		foreach($bolge as $s)
		{
			if($u_c++>0)
				$liste2.= ", ";
			$liste2 .= $s;
		}

		$query = $dbpdo->prepare("INSERT INTO users_Ulke SET
				username = :username,
				ulke = :ulke,
				bolge = :bolge
				");

				$insert = $query->execute(array(
					  "username" => $email,
					  "ulke" => $liste,
					  "bolge" => $liste2
				));
				
	if ( $kayit ){
		 echo $uyari->Basarili("Kullanıcı başarıyla kaydedilmiştir.");
				}else
		 echo $uyari->Hata(print_r($dbpdo->errorInfo()));

}

include "inc.header.php";
include "inc.menu.php";


?> 
<div class="page-title">
    <h5><i class="fa fa-bars"></i> Kullanıcı <small>Yönetimi</small></h5>
        <div class="btn-group">
        </div>
</div>
<!-- Condensed datatable inside panel -->

<?
 if($username!="")
 {
	 $d=mysql_query("select * from users where username='".$username."'");
	 $o=mysql_fetch_object($d);
	 $sl9=$sl5=$sl1="";
		 if($o->userlevel==5)
		 {
			$sl5="selected";
		 }else if($o->userlevel==1)
		 {
			$sl1="selected";
		 }else if($o->userlevel==9)
			 $sl9="selected";
		 $ekinput='<input type="hidden" name="uid" value="'.$username.'">';
 		 $css="";
		 $ps='';
	 }else if($yeniKul==1)
	 {
		 $ps='';
		$css="";
		$ekinput="required";
	 }else
	 {
		 $ps='';
		$css="gizle";
		$ekinput="required";
	 }
	 echo '<form method="post" class="form-horizontal"  role="form">
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Kullanıcı Bilgileri</h6><span style="float:right;"><button type="button" class="btn btn-danger btn-icon dropdown-toggle" onclick="
					';
					if($username=="")
						echo '$(\'#kullaniciEkle\').slideToggle();';
					else
						echo 'window.location.href=\''.BASEURL.'/users?'.URL::encode("?yeniKul=1").'\'';
					echo '"><i class="fa fa-plus"></i> Yeni Kullanıcı Ekle</button></span></div>
                    <div class="panel-body '.$css.'" id="kullaniciEkle" style="width: 99.0%;">
						<div class="form-group">
                            <div class="col-md-4">
                                <b>Adı</b>
                            </div>
                            <div class="col-md-4">
                                <b>Soyadı</b>
                            </div>
							<div class="col-md-4">
                                <b>Şifre</b>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="text" required name="adi" class="form-control" placeholder="Adı" value="'.$o->adi.'">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="soyadi" class="form-control" placeholder="Soyadı" value="'.$o->soyadi.'">
                            </div>
							<div class="col-md-4">
                                <input type="password" '.$ps.' name="password" class="form-control" placeholder="Şifre"">
                            </div>
                        </div>
						<div class="form-group">
                            <div class="col-md-4">
                                <b>Email / Username</b>
                            </div>
						<div class="col-md-8">
                                <b>Kullanıcı Tipi</b>
                            </div>
                        </div>
						<div class="form-group">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="email" required placeholder="Email / Username" value="'.$o->email.'">
                            </div>
                    ';
								
                                       $d=mysql_query("select * from users_Ulke where username='".$username."'");
									   $u=mysql_fetch_object($d);

											$bolgeList=$ulkeList=array();
										   $ulkeList=explode(", ",$u->ulke);
										   $bolgeList=explode(", ",$u->bolge);
										   $bolgeSelect=array();
											foreach($bolgeList as $s)
											{
												$bolgeSelect[$s]="checked";
											}

								echo'
							<div class="col-md-8">
                                <select name="tip" class="form-control" >
									<option '.$sl9.' value="A">Admin</option>
									<option '.$sl5.' value="YK">Yetkili Kullanıcı</option>
									<option '.$sl1.' value="K">Kullanıcı</option>
								</select>
                            </div><br><br>
      				<div class="col-md-12">
                                <b>Görevli Olduğu Ülkeler</b><br><br>
                            </div>
				  	<!--SORUMLU OLDUĞU ÜLKELER-->
					<div class="form-group">				
					<div class="col-md-12">
					<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                    <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["avrupa"].' class="styled" name="bolge[]" value="avrupa"></span></div>
                                        Avrupa
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
								<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                       
                                            <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["rusya"].' class="styled" name="bolge[]" value="rusya"></span></div>
                                        Rusya/BDT
                                    </label>
                                        
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
								<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                        <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["ortadogu"].' class="styled" name="bolge[]" value="ortadogu"></span></div>
                                        Ortadoğu
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
								<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                        <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["afrika"].' class="styled" name="bolge[]" value="afrika"></span></div>
                                        Afrika
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
				</div>
				</div><!--form-group-->
				<!--SORUMLU OLDUĞU ÜLKELER-->
								  	<!--SORUMLU OLDUĞU ÜLKELER-->
					<div class="form-group">				
					<div class="col-md-12">
					<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                        <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["asya"].' class="styled" name="bolge[]" value="asya"></span></div>
                                        Asya/Uzakdoğu
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
								<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                         <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["guneyAmerika"].' class="styled" name="bolge[]" value="guneyAmerika"></span></div>
                                        Güney Amerika
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
								<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                        <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["kuzeyAmerika"].' class="styled" name="bolge[]" value="kuzeyAmerika"></span></div>
                                        Kuzey Amerika
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
								<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
					<div class="col-md-3">
                                         <label class="checkbox-inline">
                                        <div class="checker"><span class=""><input type="checkbox" '.$bolgeSelect["avustralya"].' class="styled" name="bolge[]" value="avustralya"></span></div>
                                        Avustralya
                                    </label>
                                    </div>
			<!--SORUMLU OLDUĞU ÜLKE BLOKLARI-->
				</div>
				</div><!--form-group-->
				<!--SORUMLU OLDUĞU ÜLKELER-->
                        </div>
						<button type="submit" class="btn btn-primary btn-icon dropdown-toggle">Kaydet</button>
					</div>	
				</div>
				'.$ekinput.'
			</form>';
	 ?>
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Kullanıcılar</h6></div>
                <div class="datatable">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Kullanıcı Adı</th>
                                <th>Email</th>
								<th>Adı Soyadı</th>
                                <th  class="col-md-1">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
							<?
							$eksql="";
							/*
								[DEGISIM] 06:30 11.05.2018 Muhammed Kalender
								Orjinal Hali if($session->userlevel!="9"){ $eksql="where userlevel != 9"; }
											 else if($session->userlevel<5){ $eksql="where username = '".$session->username."'"; }
								
							*/
							
							if($session->userlevel != "9"){
								$eksql="where userlevel < ".$session->userlevel; 
							}else if($session->userlevel< 5){
								$eksql="where username = '".$session->username."'"; 
							}
							
							$query = $dbpdo->query("SELECT * FROM users ".$eksql, PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												 foreach( $query as $row ){
													  echo '<tr id="row_'.$row["username"].'">
															<td>'.$row["username"].'</td>
															<td>'.$row["email"].'</td>
															<td>'.$row["adi"]." ".$row["soyadi"].'</td>
															<td nowrap><a href="users?'.URL::encode("?username=".$row["username"]).'" class="btn btn-info btn-icon btn-xs detay"><i class="fa fa-bars"></i> Detay</a>
															';
															if($session->userlevel>=5)
															echo '<a href="#kullaniciSilModel" onclick="$(\'#kullaniciSilId\').val(\''.$row["username"].'\');" onclick=""  class="btn btn-danger btn-icon btn-xs" data-toggle="modal" role="button" ><i class="fa fa-trash"></i></a>';
															echo'</td>
														</tr>';
												 }
											}
							?>
                        </tbody>
                    </table>
                </div>
            </div>
<div id="kullaniciSilModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="kullaniciSilId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Kullanıcı kaldırılacaktır.</h5>
                            <p>Kullanıcıyı silmek için <b>Onayla</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default KullaniciSilButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="KullaniciKaldir($('#kullaniciSilId').val());" class="btn btn-warning">Onayla</button>
							
                        </div>
                    </div>
                </div>
            </div>
		
<script>
	$( ".firmaOlustur" ).click(function() {
		$("#firmaKayitForm").fadeIn("slow");
});
function Kaldir(islem,id)
{
	if(islem==1)
	{
		if(confirm("Silmek istediğinize emin misiniz?"))
		{
			$.post("?",{islem: "gorusSil", id: id, ajax: 'true'},function(result){
				if(result=="OK")
				{
					$("#row_"+id).fadeOut("slow");
				}else
				{
					alert(result);
				}
			});
		}
	}
}
function KullaniciKaldir(username){
	
			$.post("users?",{islem: "KullaniciKaldir", username: username, ajax: 'true'},function(result){
				if(result=="OK")
				{
					$("#row_"+username).fadeOut("slow");
					$(".KullaniciSilButon").click();
				}else
				{
					alert(result);
				}
			});
		
}
</script>	
<?php
include "inc.footer.php";
?>