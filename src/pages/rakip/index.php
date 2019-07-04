<?php



include "../../include.php";

$lang=$session->userinfo["dil"];



if($_POST["islem"]=="veriKaldir")

{

	if($_POST["tip"]=="fiyatList")

	{

		$d=mysql_query("select * from rakipFiyatList where id='".$_POST["id"]."'");

		$of=mysql_fetch_object($d);

		if(unlink($of->dosya))

		{

			

		}

			if(mysql_query("delete from rakipFiyatList where id='".$_POST["id"]."'"))

			{

					echo "OK";

			}

		

	}else if($_POST["tip"]=="firmaKaldir")

	{

		$d=mysql_query("select * from rakipFiyatList where rid='".$_POST["id"]."'");

		while($of=mysql_fetch_object($d))

		{

			if(unlink($of->dosya))

			{

				

			}

				

		}

		if(mysql_query("delete from rakipFiyatList where rid='".$_POST["id"]."'"))

				{

						

				}else

				{

					echo mysql_error();

				}

		if(mysql_query("delete from rakipRaporList where rid='".$_POST["id"]."'"))

				{

						

				}else

				{

					echo mysql_error();

				}

		if(mysql_query("delete from rakipFirma where id='".$_POST["id"]."'"))

				{

						

				}else

				{

					echo mysql_error();

				}

		

		echo "OK";

	}

	

	

	exit;

}else if($_POST["islem"]=="raporKaydet"){

	

	$query = $dbpdo->prepare("UPDATE rakipRaporList SET

rapor = :rapor

where id = :id");

$insert = $query->execute(array(

      "rapor" => $_POST["rapor"],

      "id" => $_POST["id"]

));

	if ( $insert ){

		echo "OK";

	}

	

	exit;

}

 

unset($sayfaActive);

$sayfaActive["rakip"]="page-header-active";

include "../../inc.header.php";

include "../../inc.menu.php";

 



// Önce şifrelenmiş linkten değerleri al

foreach($_REQUEST as $input=>$value) {

	 $_REQUEST[$input] = $value;

}

// Aldığın değerleri tanımın adına döşe

foreach ($_REQUEST AS $k=>$v) $$k=$v;

 

 

if($_POST["islem"]=="firmaKayit")

{

	

	$query = $dbpdo->prepare("INSERT INTO rakipFirma SET

adi = :adi,

website = :website,

ulke = :ulke,

onem = :onem,

urunGami = :urunGami,

telefon = :telefon,

aciklama = :aciklama,

tarih = :tarih");

$insert = $query->execute(array(

      "adi" => $adi,

      "ulke" => $ulke,

      "urunGami" => $urunGami,

	  "website" => $website,

	  "onem" => $onem,

	  "telefon" => $telefon,

	  "aciklama" => $aciklama,

	  "tarih" => time()

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir. FirmaId: ".$last_id);

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo var_dump($_POST);

		echo "</pre>";

	}

}elseif($_POST["islem"]=="firmaGuncelle")

{ 

	

	$query = $dbpdo->prepare("UPDATE rakipFirma SET

adi = :adi,

website = :website,

ulke = :ulke,

onem = :onem,

urunGami = :urunGami,

telefon = :telefon,

aciklama = :aciklama

where id = :id");

$insert = $query->execute(array(

      "adi" => $adi,

      "ulke" => $ulke,

      "urunGami" => $urunGami,

	  "website" => $website,

	  "onem" => $onem,

	  "telefon" => $telefon,

	  "aciklama" => $aciklama,

	  "id" => $id

));

	if ( $insert ){

		 

		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir.");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo var_dump($_POST);

		echo "</pre>";

	}

}else if($_POST["islem"]=="rakipFiyatEkle")

{

	

	$file="";

		if($_FILES["fiyatListesi"]["name"]!="")

			{

				include "../../lib/upload.php";

					$up = new UPLOAD( $_FILES['fiyatListesi'] ); 

					$up->yolDizin('../../upload/fiyatListesi'); 

					$up->maxBoyut(MAX_UPLOAD_SIZE); 

					$up->tipKabul(DOSYA_TURLERI);

					$up->yeniAd( true );

						if( $up->baslat() === false ) {

							$hata = 1;

						echo $uyari->Hata($up->ilkHata());

						} else {

						$hata = 0;

						// dosyalar ile ilgili bilgiler ver

						foreach( $up->bilgiVer() as $bilgi ) {

							$file = $bilgi["adres"];

						}



						}

			}

		$query = $dbpdo->prepare("insert into rakipFiyatList SET

dosya = :dosya,

dosyaAdi = :dosyaAdi,

tarih = :tarih,

ekleyen = :ekleyen,

rid = :rid");

$insert = $query->execute(array(

      "dosya" => $file,

      "dosyaAdi" => $dosyaAdi,

      "tarih" => time(),

	  "ekleyen" => $session->username,

	  "rid" => $id

));

	if ( $insert ){

		 

		echo $uyari->Basarili("Fiyat Listesi Başarıyla Kaydedilmiştir.");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo var_dump($_POST);

		echo "</pre>";

	}

					

	

}else if($_POST["islem"]=="rakipRaporEkle")

{

	$query = $dbpdo->prepare("insert into rakipRaporList SET

rid = :rid,

rapor = :rapor,

tarih = :tarih

");

$insert = $query->execute(array(

      "rid" => $id,

      "rapor" => $rapor,

      "tarih" => time()

));

	if ( $insert ){

		 

		echo $uyari->Basarili("Fiyat Listesi Başarıyla Kaydedilmiştir.");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo var_dump($_POST);

		echo "</pre>";

	}

}



?>

<div class="page-title">
    <h5 class="alert">İhracat Haberleri :</h5>
 <?php
 include "../../inc.news.php"
?>
            </div>

 <?

 

if($islem=="detay")

{

	

	$d=mysql_query("select   a.* from rakipFirma a where a.id='".$id."'"); 

	$o=mysql_fetch_object($d);

	

	$guncelleButon='<button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="formGoruntule();"><i class="fa  fa-minus-square-o"></i> Güncelle</button>';								

	echo '<form action="rakiplerim?'.URL::encode("?islem=detay&id=".$id).'" class="form-horizontal " role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Rakip Firma Düzenle</h6><span class="title-right">'.$guncelleButon.'<button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(\'slow\'); window.location.href=\'rakiplerim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="firmaGuncelle">

                        



                        <div class="form-group">

                            <div class="col-md-2">

                                <b>Rakip Adı:</b>

                            </div>

							<div class="col-md-4">

                                <span class="form-span">'.$o->adi.'</span>

								<input type="text" name="adi"  value="'.$o->adi.'" class="form-control form-input gizle">

                            </div>

							<div class="col-md-2">

                                <b>Ülke:</b>

                            </div>

							<div class="col-sm-4">

                               ';

							   	$query = $dbpdo->query("SELECT * FROM Ulke", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												$ulkeler="";

												 foreach( $query as $row ){

													  if($o->ulke==$row["id"])

													  {

														  echo '<span class="form-span">'.$row['ulke'].'</span>';

														 $sel="selected";

													  }else 

														  $sel="";

													   $ulkeler .= '<option '.$sel.' value="'.$row['id'].'">'.$row['ulke'].'</option> ';

												 }

											}

											$op=array();

											if($o->onem==0)

												$op[1]="selected";

											else if($o->onem==5)

												$op[2]="selected";

											else if($o->onem==10)

												$op[3]="selected";

											



                                       echo ' 

									   <select data-placeholder="Ülke seçin..." name="ulke" class="select-search form-input gizle" tabindex="2">

										'.$ulkeler.'

									   </select>

                            </div>

						</div>	

						<div class="form-group">

							<div class="col-md-2">

                                <b>Ürün Gamı:</b>

                            </div>

							<div class="col-md-4">

                                <span class="form-span">'.$o->urunGami.'</span>

								<input type="text" name="urunGami"  value="'.$o->urunGami.'" class="form-control form-input gizle">

                            </div>

							<div class="col-md-2">

                                <b>Website:</b>

                            </div>

							<div class="col-md-4">

                                <span class="form-span">'.$o->website.'</span>

								<input type="text" name="website"  value="'.$o->website.'" class="form-control form-input gizle">

                            </div>

							

                         </div>

						<div class="form-group">

							<div class="col-md-2">

                                <b>Önem:</b>

                            </div>

							<div class="col-md-4">

                                <span class="form-span">'.OnemDerece($o->onem).'</span>

								<select name="onem"  data-placeholder="Önem Derece seçin..." class="select-search form-input gizle" tabindex="2">

										<option '.$op[1].' value="0">Düşük</option>

										<option '.$op[2].' value="5">Orta</option>

										<option '.$op[3].' value="10">Yüksek</option>

									   </select>

                            </div>

									

                            <div class="col-md-2">

                                <b>Telefon</b>

                            </div>

							<div class="col-md-4">

                                <span class="form-span">'.$o->telefon.'</span>

								<input type="text" name="telefon" onchange="firmaGuncelle(\'telefon\','.$id.',this.value);" value="'.$o->telefon.'" class="form-control form-input gizle">

                            </div>

						

                         </div>

						<div class="form-group">

							<div class="col-md-2">

                                <b>Website:</b>

                            </div>

							<div class="col-md-10">

                                <span class="form-span">'.$o->aciklama.'</span>

								<textarea class="form-control form-input gizle" name="aciklama" rows="3">'.$o->aciklama.'</textarea>

                            </div>

							

							

                        </div>

						

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary form-input gizle">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>';

}else if($islem=="fiyatEkle")

{

	 

	echo '<form action="rakiplerim?'.URL::encode("?islem=fiyatEkle&id=".$id).'" class="form-horizontal gizle" id="rakipFiyatEkle" enctype="multipart/form-data" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Liste Ekle</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="rakipFiyatEkle">

                        

                        <div class="form-group">

                            <label class="col-sm-2 control-label">Dosya Adı: </label>

                            <div class="col-sm-4">

                                <input type="text" name="dosyaAdi" class="form-control" placeholder="Dosya Adı">

                            </div>

							 <label class="col-sm-2 control-label">Fiyat Listesi: </label>

                            <div class="col-sm-4">

                                <input type="file" name="fiyatListesi" placeholder="Fiyat Listesi">

                            </div>

                           

						</div>	

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Ekle</button>

                        </div>

						

						';

						

						

						echo'

					</div>

				</div>

			</form>';

			echo '<div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Fiyat Listesi</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'#rakipFiyatEkle\').slideToggle();"><i class="fa  fa-minus-square-o"></i> Fiyat Listesi Ekle</button><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\'rakiplerim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						  

                        <div class="form-group">';

			$d=mysql_query("select * from rakipFiyatList  where rid='$id' ");

						if(mysql_num_rows($d)>0)

						{

						echo

						'

						<table class="table">

                        <thead>

                            <tr>

                                <th class="col-md-1">Tarih</th>

                                <th>Dosya Adı</th>

                                <th class="col-md-1">İşlem</th>

                                

                            </tr>

                        </thead>

                        <tbody>

						';

						

						while($ok=mysql_fetch_object($d)){

							$buton="";

							

							if($ok->sahibi==$session->userinfo["username"])

							$buton = '<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Düzenle" onclick="gorusmeForm('.$ok->id.',\''.date("d-m-Y",$ok->tarih).'\');" data-toggle="dropdown"><i class="fa fa-edit"></i></button>';

						 echo' <tr id="row_'.$ok->id.'">

                                <td>'.date("d.m.Y",$ok->tarih).'</td>

                                <td>'.$ok->dosyaAdi.'</td>

								<td><a href="rakiplerim?'.URL::encode("?islem=dokumanGoruntule&dosya=".str_replace("../","",$ok->dosya)).'" class="btn btn-success btn-icon btn-xs tip " title="Dokümanı Görüntüle" data-original-title="Dokümanı Görüntüle"><i class="fa fa-eye"></i></a>

									<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirId\').val('.$ok->id.'); $(\'#kaldirTip\').val(\'fiyatList\');" title="Fiyat Listesini Kaldır" data-original-title="Fiyat Listesini Kaldır"><i class="fa fa-trash"></i></a>																										</td>

							</tr>

							

                             ';

						}	 

							 echo'

                        </tbody>

                    </table>
			

					';

						}else

						{

							echo $uyari->Bilgi("Lütfen fiyat listesi ekleyin!");

						}

				echo '</div></div></div>';

}else if($islem=="raporEkle")

{

	 

	echo '<form action="rakiplerim?'.URL::encode("?islem=raporEkle&id=".$id).'" class="form-horizontal gizle" id="rakipRaporEkle" enctype="multipart/form-data" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Rapor Ekle</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="rakipRaporEkle">

                        

                        <div class="form-group">

                            <label class="col-sm-2 control-label">Rapor: </label>

                            <div class="col-sm-10">

                                <textarea name="rapor" class="form-control" rows="10"></textarea>

                            </div>

						</div>	

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Ekle</button>

                        </div>

						

					</div>

				</div>

			</form>';

			echo '<div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Rapor Listesi</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'#rakipRaporEkle\').slideToggle();"><i class="fa  fa-minus-square-o"></i> Rapor Ekle</button><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\'rakiplerim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						  

                        <div class="form-group">';

			$d=mysql_query("select * from rakipRaporList where rid='$id' order by tarih DESC ");

						if(mysql_num_rows($d)>0)

						{

						echo

						'

						<table class="table">

                        <thead>

                            <tr>

                                <th class="col-md-1">Tarih</th>

                                <th>Rapor</th>

                                <th class="col-md-1">İşlem</th>

                            </tr>

                        </thead>

                        <tbody>

						';

						

						while($ok=mysql_fetch_object($d)){

							

							if($ok->sahibi==$session->userinfo["username"])

							$buton = '<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Düzenle" onclick="gorusmeForm('.$ok->id.',\''.date("d-m-Y",$ok->tarih).'\');" data-toggle="dropdown"><i class="fa fa-edit"></i></button>';

						 echo' <tr id="row_'.$ok->id.'">

                                <td>'.date("d.m.Y",$ok->tarih).'</td>

                                <td><span id="raporTextarea">'.$ok->rapor.'</span>

								<span id="raporTextarea2" class="gizle"><textarea name="rapor" id="rapor" class="form-control" rows="10">'.$ok->rapor.'</textarea><button class="btn btn-success btn-icon right" title="Kaydet" data-toggle="dropdown" onclick="Kaydet('.$ok->id.')"><i class="fa fa-check"></i> Kaydet</button></span></td>

								<td><a href="javascript:;" class="btn btn-danger btn-icon btn-xs tip " onclick="raporDuzenle();" title="Raporu Düzenle" data-original-title="Getir"><i class="fa fa-edit"></i></a>																										</td>

							</tr>

							

                             ';

						}	 

							 echo'

                        </tbody>

                    </table>

					';

						}else

						{

							echo $uyari->Bilgi("Lütfen rapor ekleyin!");

						}

				echo '</div></div></div>';

}else if($islem=="dokumanGoruntule")
{
	echo '<div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Fiyat Listesi</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\'rakiplerim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>
                    <div class="panel-body">
                        ';
	if($dosya!="")
	{		
		if(in_array(end(explode(".",$dosya)),array("jpeg","jpg","png")))
			echo '<iframe src="'.BASEURL.'/'.$dosya.'" style="width:100%; height:800px;" frameborder="0"></iframe>';	
		else
			echo '<iframe src="http://docs.google.com/gview?url='.BASEURL.'/'.$dosya.'&embedded=true" style="width:100%; height:800px;" frameborder="0"></iframe>';
	}else
		echo $uyari->Bilgi("Yüklü Dosya Bulunamadı!");
	echo '</div>
	</div>';
}

 echo '<form action="rakiplerim" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Rakip Firma Oluştur</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="firmaKayit">

                        <div class="alert alert-info fade in widget-inner">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            Bu form üzerinden yeni firma kaydı oluşturabilirsiniz

                        </div>



                        <div class="form-group">

                            <label class="col-sm-2 control-label">Rakip Adı: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="adi" required>

                            </div>

							 <label class="col-sm-2 control-label">Ülke: </label>

                            <div class="col-sm-4">

                                ';

							   	$query = $dbpdo->query("SELECT * FROM Ulke", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												$ulkeler="";

												 foreach( $query as $row ){

													  

													   $ulkeler .= '<option  value="'.$row['id'].'">'.$row['ulke'].'</option> ';

												 }

											}

											

											



                                       echo ' 

									   <select data-placeholder="Ülke seçin..." name="ulke" class="select-search form-input" tabindex="2">

										'.$ulkeler.'

									   </select>

                            </div>

						</div>	

						<div class="form-group">

									<label class="col-sm-2 control-label">Ürün Gamı: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="urunGami">

                            </div>

                                    <label class="col-sm-2 control-label">Web Sitesi: </label>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="website">

                                    </div>

						

                         </div>

						<div class="form-group">

									<label class="col-sm-2 control-label">Önem: </label>

                            <div class="col-sm-4">

                                 <select name="onem"  data-placeholder="Önem Derece seçin..." class="select-search form-input" tabindex="2">

										<option '.$op[1].' value="0">Düşük</option>

										<option '.$op[2].' value="5">Orta</option>

										<option '.$op[3].' value="10">Yüksek</option>

									   </select>

                            </div>

                                    <label class="col-sm-2 control-label">Telefon: </label>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="telefon">

                                    </div>

						

                         </div>

						<div class="form-group">

									<label class="col-sm-2 control-label">Kısa Açıklama: </label>

                            <div class="col-sm-10">

                                <textarea class="form-control" name="aciklama"></textarea>

                            </div>

                         </div>

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>';

if(!in_array($_REQUEST["islem"],array("detay","fiyatEkle","dokumanGoruntule","raporEkle")))

{

 ?>        



	 <!-- Condensed datatable inside panel -->

            <div class="panel panel-default">

                <div class="panel-heading"><h6 class="panel-title">Rakip Firmalar</h6>

					<?='<span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Firma Ekle</button>'?>

				</div>

                <div class="datatable">

                    <table class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-md-1">Tarihi</th>

                                <th>Rakibin Adı</th>

                                <th class="col-md-2">Önem Derecesi</th> 

								<th class="col-md-1">Ülke</th>

                                <th class="col-md-1">İşlemler</th>	

                            </tr>

                        </thead>                        

                        <tbody>

							<?							

							$query = $dbpdo->query("SELECT  (select ulke from Ulke where id=a.ulke) as ulkeAdi, a.* FROM rakipFirma a", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

																										

													  echo '<tr id="row_'.$row["id"].'">

															<td>'.date("d.m.Y",$row["tarih"]).'</td>

															<td>'.$row["adi"].'</td>

															<td>'.OnemDerece($row["onem"]).'</td>

															<td>'.$row["ulkeAdi"].'</td>

															<td><a href="rakiplerim?'.URL::encode("?islem=detay&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a>

															<a href="rakiplerim?'.URL::encode("?islem=fiyatEkle".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " title="Fiyat Listeleri" data-original-title="Fiyat Listeleri"><i class="fa fa-try"></i></a>

															<a href="rakiplerim?'.URL::encode("?islem=raporEkle".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " title="Rapor Ekle" data-original-title="Rapor Ekle"><i class="fa fa-file-text-o"></i></a>
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirId\').val('.$row["id"].'); $(\'#kaldirTip\').val(\'firmaKaldir\');" title="Bu firmayı kaldır" data-original-title="Bu firmayı kaldır"><i class="fa fa-trash"></i></a>
																			

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

}

echo '<div id="kaldirModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirim</h5>
                        </div>

                        <div class="modal-body has-padding">
                            <p>Seçmiş olduğunuz kaydı silme üzeresiniz. Devam etmek istiyor musunuz?</p>
                        </div>
							<input type="hidden" value="" id="kaldirId">
							<input type="hidden" value="" id="kaldirTip">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default KaldirButton" data-dismiss="modal">Hayır</button>
                            <button type="button" onclick="Kaldir($(\'#kaldirTip\').val(),$(\'#kaldirId\').val())" class="btn btn-warning">Evet</button>
                        </div>
                    </div>
                </div>
            </div>';

?>

<script>
	function Kaldir(tip, id)
	{
			$.post("rakiplerim",{islem: "veriKaldir", tip: tip, id: id, ajax: 'true'},function(result){
					if(result=="OK")
					{
						$("#row_"+id).fadeOut("slow");
					}
				});
				$(".KaldirButton").click();
	}
	function formGoruntule()
	{
		$('.form-input').toggle();
		$('.form-span').toggle();
	}
	function raporDuzenle()
	{
		$("#raporTextarea").slideToggle();
		$("#raporTextarea2").slideToggle();
	}
	function Kaydet(id)
	{
		var rapor=document.getElementById("rapor").value;
		$.post("rakiplerim",{islem: "raporKaydet", rapor: rapor, id: id, ajax: 'true'},function(result){
					if(result=="OK")
					{
						document.getElementById("raporTextarea").innerHTML=rapor;
						$("#raporTextarea").slideToggle();
						$("#raporTextarea2").slideToggle();

					}else

					{

						alert("Kaydınız Alınamadı!");

					}

					

				});

	}



</script>

<?



include "../../inc.footer.php";

?>