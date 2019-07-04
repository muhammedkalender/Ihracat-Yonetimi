<?php



include "../../include.php";

$lang=$session->userinfo["dil"];



if($_POST["islem"]=="firmaKaldir")
{

	if(mysql_query("delete from gumrukFirma where id='".$_POST["id"]."'"))
	{

		if(mysql_query("delete from gumrukTeklif where fid='".$_POST["id"]."'"))

		{

			

			

		}

		echo "OK";

	}

	

	exit;

	

}else if($_POST["islem"]=="musteriSikayetYorum")
{

	$query = $dbpdo->prepare("UPDATE musteriSikayet SET

		yorum = :yorum,

		durum = :durum

		where id = :id");

		$insert = $query->execute(array(

			   "yorum" => $_POST["yorum"],

			   "durum" => $_POST["durum"],

			  "id" => $_POST["id"]

		));

			if ( $insert ){

				

				echo "OK";

		}else

			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");

	

	exit;

}else if($_POST["islem"]=="musteriSikayetKaldir"){
	if(mysql_query("delete from musteriSikayet where id='".$_POST["id"]."'")){
		echo "OK";
	}else
		echo mysql_error();
	exit;
}

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

<div class="page-title">
    <h5 class="alert">İhracat Haberleri :</h5>
 <?php
 include "../../inc.news.php"
?>
            </div>

 <?

if($_POST["islem"]=="GorusmeDetay")

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

}else if($_POST["islem"]=="sikayetEkle")

{

	

$query = $dbpdo->prepare("insert into musteriSikayet SET

		fid = :fid,

		tarih = :tarih,

		konu = :konu,

		aciklama = :aciklama,

		islemiYapan = :islemiYapan

		");

		$insert = $query->execute(array(

				

			  "fid" => $id,

			   "tarih" => strtotime(str_replace("/","-",$_POST["tarih"])),

			  "konu" => $_POST["konu"],

			  "aciklama" => $aciklama,

			  "islemiYapan" => $session->userinfo["username"]

		));

			if ( $insert ){

				$last_id = $dbpdo->lastInsertId();

				echo $uyari->Basarili("Firma şikayet kaydı başarıyla kaydedilmiştir.");

		}else

			echo $uyari->Hata("<pre>".var_dump($dbpdo->errorInfo())."</pre>");

}



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

	isTelefonu= :isTelefonu,

	fax= :fax,

	website= :website,

	faturaAdresi= :faturaAdres,

	sevkiyatAdresi= :sevkiyatAdres,

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

		  "isTelefonu" => $isTelefonu,

		  "fax" => $fax,

		  "website" => $website,

		  "faturaAdres" => $faturaAdres,

		  "sevkiyatAdres" => $sevkiyatAdres,

		  "ilgiliKisi" => $ilgiliKisi,

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

		$ekurl="/musterilerim";

	}else

	{

		$ekurl="/musterilerim?".URL::encode("?username=".$_REQUEST["username"]);

	}



	echo '<form action="musterilerim?'.URL::encode("?islem=detay&id=".$id).'" method="post" class="form-horizontal" role="form">

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Firma Bilgileri</h6><span style="float:right;"><a class="btn btn-info" href="musterilerim?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$id).'">Görüşmelerim</a>'.$guncelleButon.'<button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\''.BASEURL.$ekurl.'\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

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

                                <span class="form-span">'.$o->telefon.'</span>

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

                                <span class="form-span">'.$o->email.'</span>

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

                                <b>İş Telefonu</b>

                            </div>

                            <div class="col-md-5">

                                <span class="form-span">'.$o->isTelefonu.'</span>

								<input type="text" name="isTelefonu"  value="'.$o->isTelefonu.'" class="form-control form-input gizle">

                            </div>
							

                        </div>
						
						<div class="form-group">

						 <div class="col-md-2">

                                <b>WebSite</b>

                            </div>

                            <div class="col-md-4">

                                <span class="form-span">'.$o->website.'</span>

								<input type="text" name="website"  value="'.$o->website.'" class="form-control form-input gizle">

                            </div>
						 <div class="col-md-1">

                                <b>Fax</b>

                            </div>

                            <div class="col-md-5">

                                <span class="form-span">'.$o->fax.'</span>

								<input type="text" name="fax"  value="'.$o->fax.'" class="form-control form-input gizle">

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
                                <b>Fatura Adresi</b>
                            </div>
                            <div class="col-md-10">
                                <span class="form-span">'.$o->faturaAdres.'</span>
								<textarea name="faturaAdres"  class="form-control form-input gizle">'.$o->faturaAdres.'</textarea>
                            </div>
                        </div>
						<div class="form-group">
						 <div class="col-md-2">
                                <b>Sevkiyat Adresi</b>
                            </div>
                            <div class="col-md-10">
                                <span class="form-span">'.$o->sevkiyatAdres.'</span>
								<textarea name="sevkiyatAdres"  class="form-control form-input gizle">'.$o->sevkiyatAdres.'</textarea>
                            </div>
                        </div>
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

		$linkk="".URL::encode("?username=".$username);

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

					<button type="button" class="btn btn-xs btn-info dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut();window.location.href=\'musterilerim?'.$linkk.'\';"">Kapat</button>

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

                                <td nowrap>

								'.$buton.'

								<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Detayını Göster" onclick="$(\'#detay_'.$ok->id.'\').slideToggle(\'slow\');" data-toggle="dropdown"><i class="fa fa-eye"></i></button>

								';

								if($session->userlevel==9)

								{

									echo '<a class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Detayını Sil" onclick="$(\'#gorusmeKaldirId\').val('.$ok->id.');" data-toggle="modal" role="button" href="#kaldirModel"><i class="fa fa-trash-o"></i></a>';

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
			<div id="kaldirModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirim</h5>
                        </div>

                        <div class="modal-body has-padding">
                            <p>Görüşme detayını kaldırmak üzeresiniz. Devam etmek istiyor musunuz?</p>
                        </div>
							<input type="hidden" value="" id="gorusmeKaldirId">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default gorusmeKaldirButon" data-dismiss="modal">Hayır</button>
                            <button type="button" onclick="Kaldir(1,$(\'#gorusmeKaldirId\').val())" class="btn btn-warning">Evet</button>
                        </div>
                    </div>
                </div>
            </div>

			

			';

}else if($islem=="Sikayetler")

{

	

	echo '<form action="musterilerim?'.URL::encode("?islem=Sikayetler&id=".$id).'" method="post" class="form-horizontal" role="form">

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Şikayet Bilgileri</h6>

					<span style="float:right;">

					<button type="button" class="btn btn-xs btn-info dropdown-toggle '.$kendimi.'" onclick="gorusmeForm(0,0,0);">Şikayet Ekle</button> 

					';

					

					echo'

					<button type="button" class="btn btn-xs btn-info dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut();window.location.href=\'musterilerim?'.$linkk.'\';"">Kapat</button>

					</span>

					</div>

					

                    <div class="panel-body">

						

						<input type="hidden" name="islem" value="sikayetEkle">

						

						<div class="gorusmeEkle gizle">

													

							<div class="panel-body">

							 

								<div class="form-group has-feedback">

									<label >Şikayet Tarihi</label>

									<input type="text" name="tarih" id="gorusmeTarih" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >

									 

								</div>

							

								<div class="form-group has-feedback">

									<label >Konu</label>

									<input type="text" name="konu" class="form-control" placeholder="Konu Giriniz" value="" >

								</div>

							

								<div class="form-group has-feedback">

									<label >Şikayet Detayları</label>

									<textarea  rows="5" cols="5" class="form-control" id="gorusmeAciklama" name="aciklama" placeholder="Açıklama"></textarea>

								<br>	

								<button type="submit" class="btn btn-primary dropdown-toggle '.$kendimi.'">Kaydet</button>

									 

								</div>

								<input type="hidden" name="gorusmeId" id="gorusmeId" value="0">

								

								

							</div>



						</div>

						';

						$d=mysql_query("select  a.* from musteriSikayet a where a.fid='$id' order by id DESC");

						if(mysql_num_rows($d)>0)

						{

						echo

						'

						<table class="table">

                        <thead>

                            <tr>

                                <th class="col-md-2">Oluşturma Tarih</th>

                                <th>Konu</th>

								<th class="col-md-1">Durum</th>

                                <th class="col-md-1">İşlem</th>

                                

                            </tr>

                        </thead>

                        <tbody>

						';

						$durumKontrol=array();

						while($ok=mysql_fetch_object($d)){

							$buton="";

							

							unset($durumKontrol);

							$durumKontrol[$ok->durum]="selected";

							

							

						 echo' <tr id="row_'.$ok->id.'">

                                <td>'.date("d.m.Y",$ok->tarih).'</td>

                                <td>'.$ok->konu.'</td>

								<td>'.sikayetDurum($ok->durum).'</td>

                                <td>

								<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Şikayet Detayını Göster" onclick="$(\'#detay_'.$ok->id.'\').slideToggle();$(\'#detay2_'.$ok->id.'\').slideToggle();" data-toggle="dropdown"><i class="fa fa-eye"></i></button>

								';

								if($session->userlevel==9)

								{

									echo '<a href="#sikayetKaldirModel" class="btn btn-primary btn-icon dropdown-toggle tip" title="Şikayet Detayını Sil" onclick="$(\'#sikayetKaldirId\').val('.$ok->id.')" data-toggle="modal" role="button"><i class="fa fa-trash-o"></i></a>';
							
								}

								echo'

								</td>

                            </tr><tr id="detay2_'.$ok->id.'"  class="danger gizle">

                                <td colspan="3">

									

									<label >Açıklama</label>

									<textarea class="form-control" id="sikayetYorum_'.$ok->id.'">'.$ok->yorum.'</textarea>

									<label >Durum</label>

									<select class="form-control col-md-2" id="sikayetDurum_'.$ok->id.'">

										

										<option '.$durumKontrol[0].' value="0">Beklemede</option>

										<option '.$durumKontrol[1].' value="1">İşlem Başlatıldı</option>

										<option '.$durumKontrol[2].' value="2">İşlem Tamamlandı</option>

										<option '.$durumKontrol[3].' value="3">Kapatıldı</option>

									</select>

								</td>

								<td>

								<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Şikayeti Kaydet" onclick="sikayetYorumGuncelle('.$ok->id.')" data-toggle="dropdown"><i class="fa fa-save"></i></button>

								</td>

								</tr><tr id="detay_'.$ok->id.'" style="display:none;" class="danger">

                                <td colspan="3">

									'.$ok->aciklama.'

								</td>

								<td>

								<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Şikayet Ekle" onclick="$(\'#detay2_'.$ok->id.'\').slideToggle(\'slow\');" data-toggle="dropdown"><i class="fa fa-plus-square"></i></button>

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

							echo $uyari->Basarili("Şikayet Bulunamadı.");

						}

					echo'

                      </div>

                </div>

            </form>

			

			

			';

}



if(!in_array($islem,array("GorusmeYap","detay","Sikayetler")))

{

?> 

	 <!-- Condensed datatable inside panel -->

            <div class="panel panel-default">

                <div class="panel-heading"><h6 class="panel-title">Müşteriler</h6>

				</div>

                <div class="datatable">

                    <table id="gorusmeTarihiTable" class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-md-1" nowrap title="Görüşme Tarihi">G.Tarihi</th>

                                <th >Firma Adı</th>

                                <th class="col-md-1">Ülke</th> 

								<th class="col-md-1">Önem</th>

								<th class="col-md-1">Kaynak</th>

								<?

								if($session->userlevel>=5)

									echo '<th class="col-md-1">Sahibi</th>';

								?>

                                <th class="col-md-1">İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?

							 

								$eksql=$ek="";

							if($session->userlevel<5)

								$kullaniciList="sahibi='".$session->username."' AND";

							else

								$kullaniciList="";

							

							$query = $dbpdo->query("SELECT (select count(*) var from musteriSikayet where fid=a.id AND durum<2) sikayetvarmi, (select termin from firmaGorusme where fid=a.id AND termin between ".strtotime(date("d.m.Y")." 00:00:00")." AND ".strtotime(date("d.m.Y")." 23:59:59")." order by tarih desc limit 1) as terminli, (select tarih from firmaGorusme where fid=a.id order by tarih desc limit 1) as sonGorusme, a.*, b.ulke, b.icon FROM firma a inner join Ulke b ON a.ulke=b.id AND ".$kullaniciList." a.aktif=1 AND musteri=1".$eksql, PDO::FETCH_ASSOC);

											$liste=array();

											if ( $query->rowCount() ){

												

												 foreach( $query as $row ){

													 if($row["sikayetvarmi"]>0)

														{

															$mus="danger";

															$itag="fa-frown-o";

														}else

														{	

															$mus="success";

															$itag="fa-smile-o";

														}

													 

													 if($row["sonGorusme"]!=0)

													 {

														 //$sonGorusme=date("Y.m.d",$row["sonGorusme"]);

														 $sonGorusme=date("Y/m/d",$row["sonGorusme"]);

														 

													 }else

														 $sonGorusme="-";

													 

													

														 $musteriButon='<a href="#firmaKaldirModel"  onclick="$(\'#firmaKaldirId\').val('.$row["id"].')"  class="btn btn-danger btn-icon btn-xs tip" data-toggle="modal" role="button" title="Firma Müşterimiz. Çıkartmak için tıklayın" data-original-title="Firma Müşterimiz. Çıkartmak için tıklayın"><i class="fa fa-ban"></i></a>';

													 

													  

													 if($row["ilgilen"]==1)

													 {

														 $ilgilenButon='<a class="tip" href="javascript:;" title="'.adsoyadnoktali($row["ilgilenTalepEden"]).' uyarı gönderdi"><span class="blink tip"><i class="fa fa-exclamation-triangle"></i></span></a>';

													 }else{

														 $ilgilenButon='';

													 }

													 

													 if(date("d.m.Y",$row["terminli"])==date("d.m.Y"))

													 {

														 $ilgilenButon .='<a class="tip" href="javascript:;" title="Termin tarihi geldi"><span class="blink tip"><i class="fa fa-clock-o "></i></span></a>';

													 }

													 

													 $onemDereceButon = OnemDereceTarih(date("d.m.Y",$row["sonGorusme"]),$row["derece"]);

													 

													 if($onemDereceButon!="")

													 {

														 $onemDereceButon = '<a class="btn tip" href="javascript:;" title="Arama Yap"><span class="blink tip">

																	'.$onemDereceButon.'</span></a>';

													 }

													 

													 if($session->userlevel>=5)

														$sahip='<td class="w150">'.adsoyadgorevbul($row["sahibi"]).'</td>';

													else

														$sahip='';
														
														if($session->username="ozkan@novasta.com.tr")
														$proforma = '<a href="proforma?'.URL::encode("?islem=hazirla&id=".$row["id"]).';" class="btn btn-info btn-icon btn-xs tip" title="Proforma" data-original-title="Proforma"><i class="fa fa-folder-open-o"></i></a>';
													

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

															'.$sahip.'

															<td>

															<a href="musterilerim?'.URL::encode("?islem=detay".$ekkullanici."&id=".$row["id"]).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a>

															<a href="musterilerim?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$row["id"]).'" class="btn btn-success btn-icon btn-xs tip " onclick="$(\'.gorusmeEkle\').slideToggle();" title="Görüşmeler" data-original-title="Arama Yap"><i class="fa fa-plus"></i></a>

															<a href="musterilerim?'.URL::encode("?islem=Sikayetler".$ekkullanici."&id=".$row["id"]).';" class="btn btn-'.$mus.' btn-icon btn-xs tip" title="Şikayetler" data-original-title="Şikayetler"><i class="fa '.$itag.'"></i></a>

															'.$musteriButon.'
															
															'.$proforma.'

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

<?php

}

?>

<div id="span"></div>
<div id="firmaKaldirModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="firmaKaldirId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Firma müşteriler bölümünden çıkarılacak.</h5>
                            <p>Firmayı görüşmelerim listesine aktarmak için <b>Onayla</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default firmaKaldirButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="MusteriYap(0, $('#firmaKaldirId').val())" class="btn btn-warning">Onayla</button>
							
                        </div>
                    </div>
                </div>
            </div>
			<div id="sikayetKaldirModel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">Bildirimler</h5>
                        </div>
						<input type="hidden" value="" id="sikayetKaldirId">
                        <div class="modal-body has-padding">
                            <h5 class="text-error">Müşteri şikayeti silinecektir.</h5>
                            <p>İşleme devam etmek ve silmek için <b>Onayla</b> butonuna basınız</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default sikayetKaldirButon" data-dismiss="modal">Kapat</button>
                            <button type="button" onclick="sikayetKaldir($('#sikayetKaldirId').val())" class="btn btn-warning">Onayla</button>
							
                        </div>
                    </div>
                </div>
            </div>
<script>



function Kaldir(islem,id)

{

	if(islem==1)

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
			$(".gorusmeKaldirButon").click();
		

	}else if(islem==2)

	{

		if(confirm("Silmek istediğinize emin misiniz?"))

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

	if(i==0)

	{

		

			$.post("?",{islem: "musteriYap", id: id, musteri: 0, ajax: 'true'},function(result){

				if(result=="OK")
				{
					
					$(".firmaKaldirButon").click();
					$("#row_"+id).fadeOut("slow");

					

				}else

				{

					alert(result);

				}

			});

		

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
function sikayetKaldir(id){
	
		$.post("musterilerim",{islem: "musteriSikayetKaldir", id: id, ajax: 'true'},function(result){
			$("#row_"+id).fadeOut("slow");
			$("#detay2_"+id).fadeOut("slow");
			$("#detay_"+id).fadeOut("slow");
			$(".sikayetKaldirButon").click();
			
		});
		
	
}
function sikayetYorumGuncelle(id)
{

	var durum=$("#sikayetDurum_"+id).val();

	$.post("musterilerim",{islem: "musteriSikayetYorum", id: id, durum: durum, yorum: $("#sikayetYorum_"+id).val(), ajax: 'true'},function(result){

		$("#detay2_"+id).slideToggle();

		

	});

	

}
</script>	

<?



include "../../inc.footer.php";

?>