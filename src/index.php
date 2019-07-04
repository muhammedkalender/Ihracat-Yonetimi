<?php

include "include.php";
$lang=$session->userinfo["dil"];

/* cron olarak kurulamayan ama arada çalışması gereken kodlar */











/* */









	



































if($_POST["islem"]=="gorusSil") 
{
	if(mysql_query("UPDATE firmaGorusme set active='0' where id='".$_POST["id"]."'"))
	{
		echo "OK";
	}else
		echo mysql_error();
	
	exit;
}else if($_POST["islem"]=="ulkeLinkGetir")
{
	echo BASEURL."?".URL::encode("?ulke=".$_POST["ulke"]);
	exit;
}else if($_POST["islem"]=="firmaSil")
{
	if(mysql_query("update firma set aktif='0' where id='".$_POST["id"]."'"))
	{
		echo "OK"; 
	}
	 
	exit;
}else if($_POST["islem"]=="aciklamaGetir")
{
	$da=mysql_query("select * from firmaGorusme where id='".$_POST["id"]."'");
	$oa=mysql_fetch_object($da);
	echo  $oa->aciklama;
	exit;
}else if($_POST["islem"]=="firmaGuncelle")
{
	
	$query = $dbpdo->prepare("UPDATE firma SET
		".$_POST["degisken"]." = :".$_POST["degisken"]."
		where id = :id");
		$insert = $query->execute(array(
			   "".$_POST["degisken"]."" => $_POST["value"],
			    "id" => $_POST["id"]
		));
			if ( $insert ){
				
				echo $uyari->Basarili("Firma detayları başarıyla kaydedilmiştir.");
		}else
			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");
		exit;
}else if($_POST["islem"]=="firmaGetir")
{
	if(mysql_query("update firma set aktif='1' where id='".$_POST["id"]."'"))
	{
		echo "OK"; 
	}
	 
	exit;
	
}else if($_POST["islem"]=="firmaKaldir")
{
	if(mysql_query("DELETE FROM firma where id='".$_POST["id"]."'"))
	{
		echo "OK";
	}else
		echo mysql_error();
	
	exit;
}else if($_POST["islem"]=="musteriYap")
{
	$query = $dbpdo->prepare("UPDATE firma SET
		musteri = :musteri
		where id = :id");
		$insert = $query->execute(array(
			   "musteri" => $_POST["musteri"],
			    "id" => $_POST["id"]
		));
			if ( $insert ){
				
				echo "OK";
		}else
			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");
	
	exit;
}else if($_POST["islem"]=="ilgilen")
{
$query = $dbpdo->prepare("UPDATE firma SET
		ilgilen = :ilgilen,
		ilgilenTalepEden = :ilgilenTalepEden,
		ilgilenTalepTarih = :ilgilenTalepTarih
		where id = :id");
		$insert = $query->execute(array(
			   "ilgilen" => 1,
			   "ilgilenTalepEden" => $session->username,
			   "ilgilenTalepTarih" => time(),
			    "id" => $_POST["id"]
		));
			if ( $insert ){
				
				echo "OK";
		}else
			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");
	
	exit;
}
unset($sayfaActive);
$sayfaActive["gorusmelerim"]="page-header-active";
include "inc.header.php";
include "inc.menu.php";
 

// Önce şifrelenmiş linkten değerleri al
foreach($_REQUEST as $input=>$value) {
	 $_REQUEST[$input] = $value;
}
// Aldığın değerleri tanımın adına döşe
foreach ($_REQUEST AS $k=>$v) $$k=$v;
 
?>

<div class="page-title">
    <h5 class="alert">İhracat Haberleri :</h5>

 <?php   
include "inc.news.php"
?>

            </div>
            <!-- /page title -->

            
            <!-- Statistics
            <ul class="row stats">
                <li class="col-xs-3"><a href="javascript:;" class="btn btn-success firmaOlustur"><?//=toplamFirmaSayisi($session->username)?></a> <span class="firmaOlustur">Firma Oluştur</span></li>
                <li class="col-xs-3"><a href="#" class="btn btn-info"><?//=toplamDetaySayisi($session->username)?></a> <span>Görüşme Sayısı</span></li>
                <li class="col-xs-3"><a href="#" class="btn btn-danger"><?//=intval((strtotime("02/17/2017")-time())/(60*60*24))?></a> <span>Kalan Gün Sayısı</span></li>
                <li class="col-xs-3"><a href="#" class="btn btn-default"><?//=KullaniciSayisi()?></a> <span>Toplam Kullanıcı Sayısı</span></li>
            </ul> -->
<?

if($_POST["islem"]=="firmaKayit")
{
	if($sahibi=="")
		$sahibi=$session->username;
		
	$query = $dbpdo->prepare("INSERT INTO firma SET
firma = :firma,
kayitTarihi = :kt,
adres = :adres,
email = :email,
ulke = :ulke,
telefon = :telefon,
sahibi = :sahibi,
derece = :derece,
kaynak= :kaynak,
website= :website,
ilgiliKisi= :ilgiliKisi");
$insert = $query->execute(array(
      "firma" => $firma,
      "telefon" => $telefon,
      "ulke" => $ulke,
	  "email" => $email,
	  "adres" => $adres,
	  "kt" => time(),
	  "sahibi" => $sahibi,
	  "derece" => $derece,
	  "kaynak" => $kaynak,
	  "website" => $website,
	  "ilgiliKisi" => $ilgiliKisi
));
	if ( $insert ){
		$last_id = $dbpdo->lastInsertId();
		
		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir. FirmaId: ".$last_id);
	}else
	{
		echo "<pre>";
		echo var_dump($dbpdo->errorInfo());
		echo "</pre>";
	}
}else if($_POST["islem"]=="GorusmeDetay")
{
	if($_POST["gorusmeId"]=="0")
	{
				$query = $dbpdo->prepare("insert into firmaGorusme SET
		fid = :fid,
		tarih = :tarih,
		termin = :termin,
		aciklama = :aciklama,
		islemiYapan = :islemiYapan
		");
		$insert = $query->execute(array(
				
			  "fid" => $id,
			   "tarih" => strtotime(str_replace("/","-",$_POST["tarih"])),
			  "termin" => strtotime(str_replace("/","-",$_POST["termin"])),
			  "aciklama" => $aciklama,
			  "islemiYapan" => $session->username
		));
			if ( $insert ){
				$last_id = $dbpdo->lastInsertId();
				echo $uyari->Basarili("Firma görüşme detayları başarıyla kaydedilmiştir.");
		}else
			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");
		
		$query = $dbpdo->prepare("UPDATE firma SET
		ilgilen = :ilgilen	
		where id = :id");
		$insert = $query->execute(array(
			   "ilgilen" => 0,
			    "id" => $id
		));
			if ( $insert ){
				
				
		}else
			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");
	}else if(intval($_POST["gorusmeId"])>0)
	{
		
		$query = $dbpdo->prepare("UPDATE firmaGorusme SET
		tarih = :tarih,
		termin = :termin,
		aciklama = :aciklama
		
		where id = :id");
		$insert = $query->execute(array(
			   "tarih" => strtotime(str_replace("/","-",$_POST["tarih"])),
			  "aciklama" => $aciklama,
			  "termin" => strtotime(str_replace("/","-",$_POST["termin"])),
			  "id" => $_POST["gorusmeId"]
		));
			if ( $insert ){
				
				echo $uyari->Basarili("Firma görüşme detayları başarıyla kaydedilmiştir.");
		}else
			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");
		
		
	}else
	{
		
	}
}

echo firmaKayit();


if($islem=="detay")
{

if(isset($_POST["firmaGuncelle"]))
{
		$query = $dbpdo->prepare("UPDATE firma SET
	firma = :firma,
	adres = :adres,
	email = :email,
	ulke = :ulke,
	telefon = :telefon,
	derece = :derece,
	kaynak= :kaynak,
	yorum= :yorum,
	website= :website,
	ilgiliKisi= :ilgiliKisi
	where id= :id");
	$insert = $query->execute(array(
		  "firma" => $firma,
		  "telefon" => $telefon,
		  "ulke" => $ulke,
		  "email" => $email,
		  "adres" => $adres,
		  "derece" => $derece,
		  "kaynak" => $kaynak,
		  "yorum" => $yorum,
		  "ilgiliKisi" => $ilgiliKisi,
		  "website" => $website,
		  "id" => $id,
	));
		if ( $insert ){
				if($sahibi!="")
				{
					$query = $dbpdo->prepare("UPDATE firma SET
			sahibi= :sahibi
			where id= :id");
				$insert2 = $query->execute(array(
					  "sahibi" => $sahibi,
					  "id" => $id
				));
				if($insert2)
				{
					
				}
		}
			echo $uyari->Basarili("Firma başarıyla güncellenmiştir.");
		}else
		{
			echo "<pre>";
			echo var_dump($dbpdo->errorInfo());
			echo "</pre>";
		}
}

	$d=mysql_query("select (select adi from kaynak where id=a.kaynak) as kaynakAdi, a.* from firma a where a.id='".$id."'"); 
	$o=mysql_fetch_object($d);
	$guncelleButon="";
	if($session->username==$session->userinfo["username"])
	{$guncelleButon='<button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="formGoruntule();"><i class="fa  fa-minus-square-o"></i> Güncelle</button>';
		$ekurl="";
	}else
	{
		$ekurl="?".URL::encode("?username=".$_REQUEST["username"]);
	}

	echo '<form action="?'.URL::encode("?islem=detay&id=".$id).'" method="post" class="form-horizontal" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Firma Bilgileri</h6><span style="float:right;"><a class="btn btn-info" href="?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$id).'">Görüşmelerim</a>'.$guncelleButon.'<button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\''.BASEURL.$ekurl.'\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>
                    <div class="panel-body">
						<div class="form-group">
                            <div class="col-md-2">
                                <b>Firma</b>
                            </div>
							<div class="col-md-4">
                                <span class="form-span">'.$o->firma.'</span>
								<input type="text" name="firma" value="'.$o->firma.'" class="form-control form-input gizle">
                            </div>
							 <div class="col-md-1">
                                <b>Kaynak</b>
                            </div>
							<div class="col-md-5">
                                <span class="form-span">'.$o->kaynakAdi.'</span>
								';
								
								$query = $dbpdo->query("SELECT * FROM kaynak", PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												$kaynaklar="";
												 foreach( $query as $row ){
													  if($o->kaynak==$row["id"])
													  {
										
														 $sel="selected";
													  }else 
														  $sel="";
													   $kaynaklar .= '<option '.$sel.' value="'.$row['id'].'">'.$row['adi'].'</option> ';
												 }
											}
											
                                       echo '   
									   <select data-placeholder="Kaynak seçin..." name="kaynak" class="select-search form-input gizle" tabindex="2">
										<option value="">Lütfen Seçiniz</option>
										'.$kaynaklar.'
									   </select>';
								echo'
                            </div>
						</div>
						<div class="form-group">
							<div class="col-md-2">
                                <b>Telefon</b>
                            </div>
							<div class="col-md-4">
                                <span class="form-span"><a href="tel:'.$o->telefon.'">'.$o->telefon.'</a></span>
								<input type="text" name="telefon" onchange="firmaGuncelle(\'telefon\','.$id.',this.value);" value="'.$o->telefon.'" class="form-control form-input gizle">
                            </div>
							<div class="col-md-1">
                                 <b>Ülke</b>
                            </div>
							<div class="col-md-5">
                                  <span class="form-span">';
                                           
											$query = $dbpdo->query("SELECT * FROM Ulke", PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												$ulkeler="";
												 foreach( $query as $row ){
													  if($o->ulke==$row["id"])
													  {
														  echo $row['ulke'];
														 $sel="selected";
													  }else 
														  $sel="";
													   $ulkeler .= '<option '.$sel.' value="'.$row['id'].'">'.$row['ulke'].'</option> ';
												 }
											}
											$op=array();
											if($o->derece==0)
												$op[1]="selected";
											else if($o->derece==5)
												$op[2]="selected";
											else if($o->derece==10)
												$op[3]="selected";
											

                                       echo '  </span>
									   <select data-placeholder="Ülke seçin..." name="ulke" class="select-search form-input gizle" tabindex="2">
										'.$ulkeler.'
									   </select>
                            </div>
                        </div>
						<div class="form-group">
						 <div class="col-md-2">
                                <b>Email</b>
                            </div>
                            <div class="col-md-4">
                                <span class="form-span"><a href="mailto:'.$o->email.'">'.$o->email.'</a></span>
								<input type="text" name="email" value="'.$o->email.'" class="form-control form-input gizle">
                            </div>
							<div class="col-md-1">
                                <b>Önem</b>
                            </div>
                            <div class="col-md-5">
                                <span class="form-span">'.OnemDerece($o->derece).'</span>
								 <select name="derece"  data-placeholder="Önem Derece seçin..." class="select-search form-input gizle" tabindex="2">
										<option '.$op[1].' value="0">Düşük</option>
										<option '.$op[2].' value="5">Orta</option>
										<option '.$op[3].' value="10">Yüksek</option>
									   </select>
                            </div>

                            
                        </div>
						<div class="form-group">
							<div class="col-md-2">
                                <b>İlgili Kişi</b>
                            </div>
                            <div class="col-md-4">
                                <span class="form-span">'.$o->ilgiliKisi.'</span>
								<input type="text" name="ilgiliKisi"  value="'.$o->ilgiliKisi.'" class="form-control form-input gizle">
                            </div>
							<div class="col-md-1">
                                <b>Websitesi</b>
                            </div>
                            <div class="col-md-5">
                                <span class="form-span"><a href="http://'.$o->website.'" rel="nofollow" target="blank_">'.$o->website.'</a></span>
								<input type="text" name="website"  value="'.$o->website.'" class="form-control form-input gizle">
                            </div>
                        </div>
						';
						
						if($session->userlevel>=5){
							echo '<div class="form-group">
							<div class="col-md-2">
                                <b>Sahibi</b>
                            </div>
                            <div class="col-md-4">
                                <span class="form-span">'.adsoyadgorevbul($o->sahibi).'</span>
								<select name="sahibi" class="select-search form-input gizle">
									<option value="">Lütfen Seçiniz</option>
									';
										$dd=mysql_query("select * from users");
										while($ou=mysql_fetch_object($dd))
										{
												if($o->sahibi==$ou->username)
													$sel="selected";
												else
													$sel="";
											echo '<option '.$sel.' value="'.$ou->username.'">'.$ou->adi." ".$ou->soyadi.'</option>';
										}
									echo'
								</select>
								
                            </div>
							
                        </div>';
						}
						echo'
                        <div class="form-group">
						 <div class="col-md-2">
                                <b>Adres</b>
                            </div>
                            <div class="col-md-10">
                                <span class="form-span">'.$o->adres.'</span>
								<textarea name="adres"  class="form-control form-input gizle">'.$o->adres.'</textarea>
                            </div>

                            
                        </div>
						<div class="form-group">
						 <div class="col-md-2">
                                <b>Yorum</b>
                            </div>
                            <div class="col-md-10">
                                <span class="form-span">'.$o->yorum.'</span>
								<textarea name="yorum"  class="form-control form-input gizle">'.$o->yorum.'</textarea>
                            </div>

                            
                        </div>
						<input type="hidden" name="firmaGuncelle" value="1">
						<div class="form-actions text-right form-input gizle">
                            <button type="submit" class="btn btn-primary ">Kaydet</button>
                        </div>
                      </div>
                </div>
            </form>
			
			
			';
}else if($islem=="GorusmeYap")
{
	$d=mysql_query("select * from firma where id='".$id."'"); 
	$o=mysql_fetch_object($d);
	$kendimi="";
	if($_REQUEST["username"]!="")
	{
		$kendimi=" gizle ";
		
	}
	$linkk="";
	
	if($username!="")
		$linkk=URL::encode("?username=".$username);
	echo '<form action="?'.URL::encode("?islem=GorusmeYap&id=".$id).'" method="post" class="form-horizontal" role="form">
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Görüşme Bilgileri</h6>
					<span style="float:right;">
					<button type="button" class="btn btn-xs btn-info dropdown-toggle '.$kendimi.'" onclick="gorusmeForm(0,0,0);">Görüşme Ekle</button> 
					';
					if($session->userlevel>=5 AND $o->ilgilen==0)
					{
						echo '<a class="btn btn-xs btn-info dropdown-toggle uyari" data-toggle="modal" role="button" onclick="$(\'#uyariId\').val('.$id.');" href="#ilgili_modal">Firmayla İlgilen</a> ';
					}
					
					echo'
					<a class="btn btn-xs btn-info" href="?'.URL::encode("?islem=detay&id=".$id.$ek).'">Firma Detayı</a>
					<button type="button" class="btn btn-xs btn-info dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut();window.location.href=\'?'.$linkk.'\';"">Kapat</button>
					</span>
					</div>
					
                    <div class="panel-body">
						
						<input type="hidden" name="islem" value="GorusmeDetay">
						
						<div class="gorusmeEkle gizle">
													
							<div class="panel-body">
							 
								<div class="form-group has-feedback">
									<label >Görüşme Tarihi</label>
									<input type="text" name="tarih" id="gorusmeTarih" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >
									 
								</div>
							
								<div class="form-group has-feedback">
									<label >Termin</label>
									<input type="text" name="termin" id="termin" class="datepicker form-control" placeholder="Tarih Giriniz" value="" >
								</div>
							
								<div class="form-group has-feedback">
									<label >Görüşme Detayları</label>
									<textarea  rows="5" cols="5" class="form-control" id="gorusmeAciklama" name="aciklama" placeholder="Açıklama"></textarea>
								<br>	
								<button type="submit" class="btn btn-primary dropdown-toggle '.$kendimi.'">Kaydet</button>
									 
								</div>
								<input type="hidden" name="gorusmeId" id="gorusmeId" value="0">
								
								
							</div>

						</div>
						';
						$d=mysql_query("select (select sahibi from firma where id=a.fid) as sahibi, a.* from firmaGorusme a where a.fid='$id' and a.active='1' order by id DESC");
						if(mysql_num_rows($d)>0)
						{
						echo
						'
						<table class="table">
                        <thead>
                            <tr>
                                <th class="col-md-1">Tarih</th>
                                <th>Görüşme Özeti</th>
                                <th class="col-md-1">İşlem</th>
                                
                            </tr>
                        </thead>
                        <tbody>
						';
						
						while($ok=mysql_fetch_object($d)){
							$buton="";
							
							if($ok->sahibi==$session->userinfo["username"])
							$buton = '<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Düzenle" onclick="gorusmeForm('.$ok->id.',\''.date("d-m-Y",$ok->tarih).'\',\''.date("d-m-Y",$ok->termin).'\');" data-toggle="dropdown"><i class="fa fa-edit"></i></button>';
						 echo' <tr id="row_'.$ok->id.'">
                                <td>'.date("d.m.Y",$ok->tarih).'</td>
                                <td>'.$ok->aciklama.'</td>
                                <td>
								'.$buton.'
								<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Detayını Göster" onclick="$(\'#detay_'.$ok->id.'\').slideToggle(\'slow\');" data-toggle="dropdown"><i class="fa fa-eye"></i></button>
								';
								if($session->userlevel==9)
								{
									echo '<a class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Detayını Sil"  data-toggle="modal" role="button" href="#default_modal" onclick="$(\'#deleteId\').val('.$ok->id.');"><i class="fa fa-trash-o"></i></a>';
								}
								echo'
								</td>
                            </tr><tr id="detay_'.$ok->id.'" style="display:none;" class="danger">
                                <td colspan="3">
									'.str_replace("\n","<br>",$ok->aciklama).'
								</td>
                            </tr>
							
                             ';
						}	 
							 echo'
                        </tbody>
                    </table>
					';
						}else
						{
							echo $uyari->Bilgi("Lütfen görüşme ekleyin!");
						}
					echo'
                      </div>
                </div>
            </form>
			<div id="default_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="deleteId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Belirtmiş olduğunuz kayıt silinecektir.</h5>
                            <p>Silme işlemine devam etmek için aşağıdaki <b>Sil</b> butonuna basınız. İşlemi iptal etmek için lütfen <b>Kapat</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default kapatButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="Kaldir(1,$(\'#deleteId\').val());" class="btn btn-warning">Sil</button>
                        </div>
                    </div>
                </div>
            </div>
			<div id="ilgili_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="uyariId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Kullanıcıya bu firmayla ilgilenmesi için uyarı gönderilecektir.</h5>
                            <p>Devam etmek için <b>Onayla</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default ilgiKapatButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="ilgiGonder($(\'#uyariId\').val());" class="btn btn-warning">Onayla</button>
                        </div>
                    </div>
                </div>
            </div>
			';
}
if(isset($_REQUEST["gizlifirma"])){
	
	?>
	 <!-- Condensed datatable inside panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">İlgilenmeyen Firmalar</h6>
				</div>
                <div class="datatable">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Görüşme Tarihi</th>
                                <?
								if($session->userlevel>=5)
								{
									echo '<th>Sahibi</th>';
								}
								?>
								<th>Firma Adı</th>
                                <th>Ülke</th> 
								<th>Önem Derecesi</th>
                                <th>İşlemler</th>
								
                            </tr>
                        </thead>
                        
                        <tbody>
							<?
							if(isset($_POST["ulke"]))
							{
								$ulke="";
							}
							if($ulke!="")
							{
								$ek="&ulke=".$ulke;
								$eksql=" AND a.ulke='".$ulke."'";
							}
							else
								$eksql=$ek="";
							
							if($session->userlevel<5)
							{
								$eksql="AND sahibi='".$session->username."'";
							}
							$query = $dbpdo->query("SELECT (select tarih from firmaGorusme where fid=a.id order by tarih desc limit 1) as sonGorusme, a.*, b.ulke, b.icon FROM firma a inner join Ulke b ON a.ulke=b.id  AND a.aktif=0 ".$eksql, PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												 foreach( $query as $row ){
													 
													 if($row["sonGorusme"]!=0)
													 {
														 $sonGorusme=date("d.m.Y",$row["sonGorusme"]);
														 
													 }else
														 $sonGorusme="-";
													 
													 if($session->userlevel==9)
													 {
														 $silButon='<a href="javascript:;" class="btn btn-danger btn-icon btn-xs tip " onclick="TumdenKaldir('.$row["id"].')" title="Bu firmayı sistemden kaldır" data-original-title="Getir"><i class="fa fa-trash"></i></a>';
													 }else
														 $silButon="";
													 if($session->userlevel>=5)
													 {
														 $Sahibi="<td>".adsoyadgorevbul($row["sahibi"])."</td>";
													 }else
													 {
														 $Sahibi="";
													 }
													  echo '<tr id="row_'.$row["id"].'">
															<td>'.$sonGorusme.'</td>
															'.$Sahibi.'
															<td>'.$row["firma"].'</td>
															<td>'.$row["ulke"]." ".BayrakGetir($row["icon"]).'</td>
															<td>
																<div class="rating">'.OnemDerece($row["derece"]).' 
																	<a class="btn tip" href="#" title="Arama Yap"><span class="blink tip">
																	'.OnemDereceTarih($sonGorusme,$row["derece"]).'<span class="blink tip"></a></span>
																</div>			
															</td>
															
															<td><a href="?'.URL::encode("?islem=detay".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a>
															<a href="?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " onclick="$(\'.gorusmeEkle\').slideToggle();" title="Görüşmeler" data-original-title="Arama Yap"><i class="fa fa-plus"></i></a>
															
															<a href="javascript:;" class="btn btn-info btn-icon btn-xs tip " onclick="Getir(2,'.$row["id"].')" title="Bu firma bizle ilgilenmiyor" data-original-title="Getir"><i class="fa fa-check"></i></a>
																	'.$silButon.'												
																																										
															</td> 
															
															
														</tr>';
												 }
											}
							?>
                            
                             
                        </tbody>
                    </table>
                </div>
            </div>
	<?
}else if(!in_array($islem,array("GorusmeYap","detay")))
{
?> 
	 <!-- Condensed datatable inside panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Görüşme Yapılan Firmalar</h6>
				<?
				if($_REQUEST["username"]=="")
				{
					echo '<span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Firma Ekle
					</button>';
				}
				?>
				</div>
                <div class="datatable">
                    <table id="gorusmeTarihiTable" class="table table-condensed">
                        <thead>
                            <tr>
                                <th class="col-md-1" nowrap title="Görüşme Tarihi">G.Tarihi</th>
                                <th >Firma Adı<br></th>
                                <th class="col-md-1">Ülke</th> 
								<th class="col-md-1">Önem</th>
								<th class="col-md-1">Kaynak</th>
                                <th class="col-md-1">İşlemler</th>
								
                            </tr>
                        </thead>
                        
                        <tbody>
							<?
							if(isset($_POST["ulke"]))
							{
								$ulke="";
							}
							if($ulke!="")
							{
								$ek="&ulke=".$ulke;
								$eksql=" AND a.ulke='".$ulke."'";
							}
							else
								$eksql=$ek="";
							
							$query = $dbpdo->query("SELECT (select termin from firmaGorusme where fid=a.id AND termin between ".strtotime(date("d.m.Y")." 00:00:00")." AND ".strtotime(date("d.m.Y")." 23:59:59")." order by tarih desc limit 1) as terminli, (select tarih from firmaGorusme where fid=a.id order by tarih desc limit 1) as sonGorusme, a.*, b.ulke, b.icon FROM firma a inner join Ulke b ON a.ulke=b.id AND sahibi='".$session->username."' AND a.musteri=0 AND a.aktif=1 ".$eksql, PDO::FETCH_ASSOC);
											$liste=array();
											if ( $query->rowCount() ){
												
												 foreach( $query as $row ){
													 
													 if($row["sonGorusme"]!=0)
													 {
														 //$sonGorusme=date("Y.m.d",$row["sonGorusme"]);
														 $sonGorusme=date("Y/m/d",$row["sonGorusme"]);
														 
													 }else
														 $sonGorusme="-";
													 
													 if($row["musteri"]=="0")
													 $musteriButon='<a href="#musteriYapModel" id="buton_'.$row["id"].'" onclick="$(\'#firmaMusteriOlId\').val('.$row["id"].')" class="btn btn-primary btn-icon btn-xs tip" data-toggle="modal" role="button" title="Firmayı Müşterimiz Yap" data-original-title="Firmayı Müşterimiz Yap"><i id="buton_i_'.$row["id"].'" class="fa fa-ellipsis-h"></i></a>
												 <a href="#firmaKaldirModel"  onclick="$(\'#firmaKaldirId\').val('.$row["id"].');" class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" title="Bu firma bizle ilgilenmiyor" data-original-title="Arama Yap"><i class="fa fa-times"></i></a>';
													/* else
														 $musteriButon='<a href="javascript:;"  onclick="MusteriYap(0, '.$row["id"].')"  class="btn btn-info btn-icon btn-xs tip" title="Firma Müşterimiz" data-original-title="Firma Müşterimiz"><i class="fa fa-check"></i></a>';
													 */
													 if($row["ilgilen"]==1)
													 {
														 $ilgilenButon='<a class="tip" href="javascript:;" title="'.adsoyadnoktali($row["ilgilenTalepEden"]).' uyarı gönderdi"><span class="blink tip"><i class="fa fa-exclamation-triangle"></i></span></a>';
													 }else{
														 $ilgilenButon='';
													 }
													 
													 if(date("d.m.Y",$row["terminli"])==date("d.m.Y"))
													 {
														 $ilgilenButon .='<a class="tip" href="javascript:;" title="'.date("d.m.Y",$row["terminli"]).' Termin tarihi geldi."><span class="blink tip"><i class="fa fa-clock-o "></i></span></a>';
													 }
													 
													 $onemDereceButon = OnemDereceTarih(date("d.m.Y",$row["sonGorusme"]),$row["derece"]);
													 
													 if($onemDereceButon!="" AND intval($row["derece"])>0)
													 {
														 $onemDereceButon = '<a class="btn tip" href="javascript:;" title="Arama Yap"><span class="blink">
																	'.$onemDereceButon.'</span></a>';
													 }else
													 {
														 $onemDereceButon = '<a class="btn tip" href="javascript:;" title="Arama Yap"><span class="tip">
																	'.$onemDereceButon.'</span></a>';
													 }
													 $liste[$row["sonGorusme"]] = $liste[$row["sonGorusme"]].'<tr id="row_'.$row["id"].'">
															<td>'.$sonGorusme.'</td>
															<td class="w150">'.$row["firma"].'</td>
															<td>'.BayrakGetir($row["icon"])." ".$row["ulke"].'</td>
															<td>
																<div class="rating">'.OnemDerece($row["derece"]).$onemDereceButon.'
																	
																		'.$ilgilenButon.'
																	
																</div>			
															</td>
															<td>'.kaynakBul($row["kaynak"]).'</td>
															<td>
															<a href="?'.URL::encode("?islem=detay".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a>
															<a href="?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " onclick="$(\'.gorusmeEkle\').slideToggle();" title="Görüşmeler" data-original-title="Arama Yap"><i class="fa fa-plus"></i></a>
																																																									
															'.$musteriButon.'
															</td> 
															
															 
														</tr>';
												 }
												 
												 ksort($liste);
													
												 foreach($liste as $s)
												 echo $s;
											}
							?>
                            
                             
                        </tbody>
                    </table>
                </div>
            </div>
			
			<div id="firmaKaldirModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="firmaKaldirId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Firma tarafınızla ilgilenmediğini belirttiniz.</h5>
                            <p>Firmayı ilgilenmeyen firmalar listesine aktarmak için <b>Onayla</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default firmaKaldirButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="Kaldir(2,$('#firmaKaldirId').val())" class="btn btn-warning">Onayla</button>
							
                        </div>
                    </div>
                </div>
            </div>
			<div id="musteriYapModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="firmaMusteriOlId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Firma müşteri listesine aktarılacaktır.</h5>
                            <p>Aktarmak için <b>Onayla</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default firmaMusteriYapButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="MusteriYap(1, $('#firmaMusteriOlId').val());" class="btn btn-warning">Onayla</button>
							
                        </div>
                    </div>
                </div>
            </div>
<?php
}
?>
<div id="span"></div>
<script>


	$( ".firmaOlustur" ).click(function() {
		$("#firmaKayitForm").fadeIn("slow");
});
function Kaldir(islem,id)
{
	$(".kapatButon").click();
	if(islem==1)
	{
		
			$.post("?",{islem: "gorusSil", id: id, ajax: 'true'},function(result){
				if(result=="OK")
				{
					$("#row_"+id).fadeOut("slow");
					$("#detay_"+id).fadeOut("slow");
					
				}else
				{
					alert(result);
				}
			});
		
	}else if(islem==2)
	{
		
			$.post("?",{islem: "firmaSil", id: id, ajax: 'true'},function(result){
				if(result=="OK")
				{
					$("#row_"+id).fadeOut("slow");
					if(id=="<?=$_REQUEST["id"]?>")
						window.location.href="<?=BASEURL?>"; 
				}else
				{
					alert(result);
				}
			});
			$(".firmaKaldirButon").click();
		
	}else
	{
		alert("Lütfen geçerli bir işlem yapınız!");
	}
	
	
}
function Getir(islem,id)
{
	if(islem==2)
	{
		if(confirm("Firmayı aktif etmek istediğinize emin misiniz?"))
		{
			$.post("?",{islem: "firmaGetir", id: id, ajax: 'true'},function(result){
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
function gorusmeForm(id,tarih,termin)
{
	if(id==0){
			$("#gorusmeId").val("0");
			$("#gorusmeTarih").val("");
			$("#gorusmeAciklama").val("");
			$("#termin").val("");
			
		$('.gorusmeEkle').slideToggle();
		
	}else{
		var aciklama="";
		$.post("index.php",{islem: "aciklamaGetir", id:id, ajax:"true"},function(result){
			$("#gorusmeId").val(id);
			$("#gorusmeTarih").val(tarih);
			if(termin=="01-01-1970")
				termin="";
			$("#termin").val(termin);
			result = result.replace("&#39;","'");
			result = result.replace("&quot;",'"');
			$("#gorusmeAciklama").val(result);
			$('.gorusmeEkle').fadeIn("slow");
			
		});
		
	}
}
function formGoruntule()
{
	$('.form-input').toggle();
	$('.form-span').toggle();
	
}
function firmaGuncelle(degisken, id, value)
{
	
	$.post("index.php", {islem: "firmaGuncelle", degisken: degisken, id: id, value: value, ajax:'true'},function(result){
		
		   location.reload();

	});
}
function TumdenKaldir(id)
{
	if(confirm("Firmayı silmek istediğinize emin misiniz?"))
		{
			$.post("?",{islem: "firmaKaldir", id: id, ajax: 'true'},function(result){
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
function MusteriYap(i, id)
{
	if(i==1)
	{
	 
			$.post("?",{islem: "musteriYap", id: id, musteri: 1, ajax: 'true'},function(result){
				if(result=="OK")
				{
					$(".firmaMusteriYapButon").click();
					$("#buton_"+id).fadeOut("slow");
					$("#row_"+id).fadeOut("slow");
					
					//$("#buton_"+id).removeClass("btn-primary").addClass("btn-info");
					//$("#buton_i_"+id).removeClass("fa-ellipsis-h").addClass("fa-check");
					//window.location.href="./";
				}else
				{
					alert(result);
				}
			});
		 
	}else
	{
		if(confirm("Firmayı müşteri olmaktan çıkarıyorsunuz. Onaylıyor musunuz?"))
		{
			$.post("?",{islem: "musteriYap", id: id, musteri: 0, ajax: 'true'},function(result){
				if(result=="OK")
				{
					$("#buton_"+id).removeClass("btn-info").addClass("btn-primary");
					$("#buton_i_"+id).removeClass("fa-check").addClass("fa-ellipsis-h");
					window.location.href="./"; 
				}else
				{
					alert(result);
				}
			});
		}
	}
	
	
}
<?

if($session->userlevel>=5)
{
	?>
	function ilgiGonder(id)
	{
			
			$.post("?",{islem: "ilgilen", id: id, ajax: 'true'},function(result){
				if(result=="OK")
				{
					alert("Uyarınız kullanıcıyla paylaşılmıştır.");
					$(".uyari").fadeOut("slow");
					
				}else
				{
					alert(result);
				}
			});
		$(".ilgiKapatButon").click();
	}
	<?
}

?>

</script>	
  
<?php
include "inc.footer.php";
?>