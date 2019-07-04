<?php

include "include.php";
$lang=$session->userinfo["dil"];

/* cron olarak kurulamayan ama arada çalışması gereken kodlar */











/* */















































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
                <h5>Novasta<small>İhracat Yönetimi</small></h5>
                <div class="btn-group">
                    
                </div>
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

if($_POST["islem"]=="gorusmeGuncelle")
{
	$query = $dbpdo->prepare("INSERT INTO firma SET
firma = :firma,
kayitTarihi = :kt,
adres = :adres,
ulke = :ulke,
telefon = :telefon,
sahibi = :sahibi");
$insert = $query->execute(array(
      "firma" => $firma,
      "telefon" => $telefon,
      "ulke" => $ulke,
	  "adres" => $adres,
	  "kt" => time(),
	  "sahibi" => $session->username,
));
	if ( $insert ){
		$last_id = $dbpdo->lastInsertId();
		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir. FirmaId: ".$last_id);
	}
}




?> 
	 <!-- Condensed datatable inside panel -->
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Görüşme Detayları</h6>
				
				</div>
                <div class="datatable">
                   <?
				   echo '<div class="gorusmeEkle">
													
							<div class="panel-body">
							
								<div class="form-group has-feedback">
									<label >Görüşme Tarihi</label>
									<input type="text" name="tarih" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >
									 
								</div>
								
								<div class="form-group has-feedback">
									<label >Görüşme Detayları</label>
									<textarea  rows="5" cols="5" class="form-control" name="aciklama" placeholder="Açıklama"></textarea>
								<br>	
								<button type="submit" class="btn btn-primary dropdown-toggle '.$kendimi.'">Kaydet</button>
									 
								</div>
								
								
								
							</div>

						</div>'
				   ?>
                </div>
            </div>

 	
<?php
include "inc.footer.php";
?>