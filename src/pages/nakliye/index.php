<?php



include "../../include.php";

$lang=$session->userinfo["dil"];



if($_POST["islem"]=="firmaKaldir")
{
	if(mysql_query("delete from nakliyeFirma where id='".$_POST["id"]."'"))
	{
		if(mysql_query("delete from nakliyeTeklif where fid='".$_POST["id"]."'"))
		{

		}
		echo "OK";
	}
	exit;

}else if($_POST["islem"]=="fiyatKaldir")
{
	if(mysql_query("delete from nakliyeTeklif where id='".$_POST["id"]."'"))
		{
			echo "OK";
		}
		exit;
}







unset($sayfaActive);

$sayfaActive["nakliye"]="page-header-active";

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

	

	$query = $dbpdo->prepare("INSERT INTO nakliyeFirma SET

firma = :firma,

tel = :tel,

email = :email,

yetkili = :yetkili,

adres = :adres,

website = :website");

$insert = $query->execute(array(

      "firma" => $firma,

      "tel" => $tel,

      "email" => $email,

	  "yetkili" => $yetkili,

	  "adres" => $adres,

	  "website" => $website

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir. FirmaId: ".$last_id);

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo "</pre>";

	}

}elseif($_POST["islem"]=="firmaGuncelle")

{ 

	

	$query = $dbpdo->prepare("UPDATE nakliyeFirma SET

firma = :firma,

tel = :tel,

email = :email,

yetkili = :yetkili,

adres = :adres,

website= :website,

yorum= :yorum

where id= :id");

$insert = $query->execute(array(

      "firma" => $firma,

      "tel" => $tel,

      "email" => $email,

	  "yetkili" => $yetkili,

	  "adres" => $adres,

	  "website" => $website,

	  "yorum" => $yorum,

	  "id" => $id

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir. ");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo "</pre>";

	}

}else if($_POST["islem"]=="teklifEkle")

{

	

	

	$query = $dbpdo->prepare("INSERT INTO nakliyeTeklif SET

fid = :fid,

tarih = :tarih,

navlun = :navlun,

fiyat = :fiyat,

birim = :birim,

nakliyeTipi = :nakliyeTipi,

gonderiTipi = :gonderiTipi,

yorum = :yorum");

$insert = $query->execute(array(

      "fid" => $id,

      "tarih" => strtotime(str_replace("/","-",$_POST["tarih"])),

      "navlun" => intval($ulke),

	  "fiyat" => floatval($fiyat),

	  "birim" => $birim,

	  "nakliyeTipi" => $nakliyeTipi,

	  "gonderiTipi" => $gonderiTipi,

	  "yorum" => $yorum

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Firma başarıyla kaydedilmiştir. FirmaId: ".$last_id);

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

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

	

	$d=mysql_query("select   a.* from nakliyeFirma a where a.id='".$id."'"); 

	$o=mysql_fetch_object($d);

	 

	echo '<form action="nakliyecilerim?'.URL::encode("?islem=detay&id=".$id).'" class="form-horizontal " role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Nakliye Firması Düzenle</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(\'slow\'); window.location.href=\'nakliyecilerim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="firmaGuncelle">

                        <div class="alert alert-info fade in widget-inner">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            Bu form üzerinden yeni firma kaydı oluşturabilirsiniz

                        </div>



                        <div class="form-group">

                            <label class="col-sm-2 control-label">Firma Adı: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="firma" value="'.$o->firma.'" required>

                            </div>

							 <label class="col-sm-2 control-label">Telefon: </label>

                            <div class="col-sm-4">

                               <input type="text" class="form-control" name="tel" value="'.$o->tel.'">

                            </div>

						</div>	

						<div class="form-group">

									<label class="col-sm-2 control-label">Email: </label>

                            <div class="col-sm-4">

                                <input type="email" class="form-control" name="email" value="'.$o->email.'">

                            </div>

                                    <label class="col-sm-2 control-label">Yetkili: </label>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="yetkili" value="'.$o->yetkili.'">

                                    </div>

						

                         </div>

						<div class="form-group">

							<label class="col-sm-2 control-label">Adres: </label>

									<div class="col-sm-4">

										 <textarea class="form-control" name="adres" rows="3">'.$o->adres.'</textarea>

									</div>

									<div class="col-md-2">

                                <b>Website</b>

                            </div>

							<div class="col-md-4">

                                 <input type="text" class="form-control" name="website">

                            </div>

							

                        </div>

						<div class="form-group">

							<label class="col-sm-2 control-label">Yorum: </label>

									<div class="col-sm-10">

										 <textarea class="form-control" name="yorum" rows="3">'.$o->yorum.'</textarea>

									</div>

							

							

							

                        </div>

						

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>';

}else if($islem=="GorusmeYap")

{

	 

	echo '<form action="nakliyecilerim?'.URL::encode("?islem=GorusmeYap&id=".$id).'" class="form-horizontal gizle" id="teklifEkle" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Teklif Ekle</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="teklifEkle">

                        <div class="alert alert-info fade in widget-inner">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            Bu form üzerinden yeni firma kaydı oluşturabilirsiniz

                        </div>



                        <div class="form-group">

                            <label class="col-sm-2 control-label">Tarih: </label>

                            <div class="col-sm-4">

                                <input type="text" name="tarih" id="gorusmeTarih" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >

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

									   <select   data-placeholder="Ülke seçin..." name="ulke" class="select-search form-input" tabindex="2">

										'.$ulkeler.'

									   </select>

									   ';

							   echo'

                            </div>

						</div>	

						<div class="form-group">

									<label class="col-sm-2 control-label">Fiyat: </label>

                            <div class="col-sm-2">

                                <input type="text" class="form-control" name="fiyat">

								

                            </div>

							<div class="col-sm-2">

                               

								<select   data-placeholder="Birim seçin..." name="birim" class="form-control" >

											<option>Euro</option>

											<option>Dolar</option>

											<option>TL</option>

									   </select>

                            </div>

                                    <label class="col-sm-2 control-label">Gönderi Tipi: </label>

                                    <div class="col-sm-4">

                                        <select name="gonderiTipi" class="form-control" >

											<option>Ürün</option>

											<option>Numune</option>

										</select>

                                    </div>

						

                         </div>

						<div class="form-group">

							<label class="col-sm-2 control-label">Nakliye Tipi: </label>

									<div class="col-sm-10">

										 <select name="nakliyeTipi" class="form-control" >

											<option>Kara</option>

											<option>Deniz</option>

											<option>Hava</option>

											<option>Demir</option>

										</select>

									</div>

							

							

                        </div>

						<div class="form-group">

							<label class="col-sm-2 control-label">Yorum: </label>

									<div class="col-sm-10">

										 <textarea name="yorum" class="form-control"></textarea>

									</div>

							

							

                        </div>

						

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

						

						';

						

						

						echo'

					</div>

				</div>

			</form>';

			echo '<div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Teklif Listesi</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'#teklifEkle\').slideToggle();"><i class="fa  fa-minus-square-o"></i> Teklif Ekle</button><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\'nakliyecilerim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						  

                        <div class="form-group">';

			$d=mysql_query("select (select ulke from Ulke where id=a.navlun) as ulkeAdi, (select sahibi from firma where id=a.fid) as sahibi, a.* from nakliyeTeklif a where a.fid='$id'  ");

						if(mysql_num_rows($d)>0)

						{

						echo

						'

						<table class="table">

                        <thead>

                            <tr>

                                <th>Tarih</th>

                                <th>Navlun</th>

                                <th>Fiyat</th>

                                <th>Nakliye Tipi</th>

								<th>Gönderi Tipi</th>

								<th class="col-md-1">İşlem</th>

                            </tr>

                        </thead>

                        <tbody>

						';

						

						while($ok=mysql_fetch_object($d)){

							$buton="";

							

							if($ok->sahibi==$session->userinfo["username"])
							$buton = '<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Görüşme Düzenle" onclick="gorusmeForm('.$ok->id.',\''.date("d-m-Y",$ok->tarih).'\');" data-toggle="dropdown"><i class="fa fa-edit"></i></button>';

						$yorumButon="";

							
						if($session->userlevel==9)
							$yorumButon .='<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirId\').val('.$ok->id.'); $(\'#kaldirTip\').val(2);" title="Bu fiyatı kaldır" data-original-title="Bu fiyatı kaldır"><i class="fa fa-trash"></i></a>
						';
						
						if($ok->yorum!="")
							$yorumButon .='<a class="btn btn-info btn-icon btn-xs tip "  href="javascript:;" onclick="yorumGetir('.$ok->id.')" title="Yorum Göster" data-original-title="Bu fiyatı kaldır"><i class="fa fa-info"></i></a>';
					
						echo' <tr id="rows_'.$ok->id.'">

                                <td>'.date("d.m.Y",$ok->tarih).'</td>

                                <td>'.$ok->ulkeAdi.'</td>

								 <td>'.number_format($ok->fiyat, 0, ',', '.')." ".$ok->birim.'</td>

								 <td>'.$ok->nakliyeTipi.'</td>

                                <td>'.$ok->gonderiTipi.'</td>

								<td nowrap>'.$yorumButon.'</td>

                            </tr>

							<tr id="rowd_'.$ok->id.'" class="gizle">

                                <td colspan="6">'.($ok->yorum).'</td>

                                

                            </tr>

							

                             ';

						}	 

							 echo'

                        </tbody>

                    </table>

					';

						}else

						{

							echo $uyari->Bilgi("Lütfen teklif ekleyin!");

						}

				echo '</div></div></div>';

}

 echo '<form action="nakliyecilerim" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Nakliye Firması Oluştur</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="firmaKayit">

                        <div class="alert alert-info fade in widget-inner">

                            <button type="button" class="close" data-dismiss="alert">×</button>

                            Bu form üzerinden yeni firma kaydı oluşturabilirsiniz

                        </div>



                        <div class="form-group">

                            <label class="col-sm-2 control-label">Firma Adı: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="firma" required>

                            </div>

							 <label class="col-sm-2 control-label">Telefon: </label>

                            <div class="col-sm-4">

                               <input type="text" class="form-control" name="tel">

                            </div>

						</div>	

						<div class="form-group">

									<label class="col-sm-2 control-label">Email: </label>

                            <div class="col-sm-4">

                                <input type="email" class="form-control" name="email">

                            </div>

                                    <label class="col-sm-2 control-label">Yetkili: </label>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="yetkili">

                                    </div>

						

                         </div>

						<div class="form-group">

							<label class="col-sm-2 control-label">Adres: </label>

									<div class="col-sm-4">

										 <textarea class="form-control" name="adres" rows="3"></textarea>

									</div>

									<div class="col-md-2">

                                <b>Website</b>

                            </div>

							<div class="col-md-4">

                                 <input type="text" class="form-control" name="website">

                            </div>

							

                        </div>

						

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>';

if(!in_array($_REQUEST["islem"],array("detay","GorusmeYap")))

{

 ?>        



	 <!-- Condensed datatable inside panel -->

            <div class="panel panel-default">

                <div class="panel-heading"><h6 class="panel-title">Nakliye Firmaları</h6>

					<?='<span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Firma Ekle</button>'?>

				</div>

                <div class="datatable">

                    <table class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-md-1">Son Teklif</th>

                                <th>Firma Adı</th>

                                <th class="col-md-1">Navlun</th> 

								<th class="col-md-1">Alınan Fiyat</th>
								
								<th class="col-md-1">Ürün Tipi</th>
								
                                <th class="col-md-1">İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?

							

							$query = $dbpdo->query("SELECT  a.* FROM nakliyeFirma a where a.active=1 ", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

													 $d=mysql_query("select (select ulke from Ulke where id=a.navlun) as ulkeAdi, a.* from nakliyeTeklif a where a.fid='".$row["id"]."' order by a.tarih DESC limit 1");

													 $o=mysql_fetch_object($d);

													 

													 if(intval($o->tarih)!=0)

													 {

														 $sonTeklif=date("d.m.Y",$o->tarih);

														 

													 }else

														 $sonTeklif="-";

													  echo '<tr id="row_'.$row["id"].'">

															<td>'.$sonTeklif.'</td>

															<td>'.$row["firma"].'</td>

															<td>'.$o->ulkeAdi.'</td>

															<td>'.number_format($o->fiyat, 0, ',', '.')." ".$o->birim.'</td>
															<td>'.$o->gonderiTipi.'</td>
															<td><a href="nakliyecilerim?'.URL::encode("?islem=detay&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a>

															<a href="nakliyecilerim?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " onclick="$(\'.gorusmeEkle\').slideToggle();" title="Teklifler" data-original-title="Arama Yap"><i class="fa fa-plus"></i></a>

															
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirId\').val('.$row["id"].'); $(\'#kaldirTip\').val(1);" title="Bu firmayı kaldır" data-original-title="Bu firmayı kaldır"><i class="fa fa-trash"></i></a>
															
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
                            <button type="button" onclick="Kaldir($(\'#kaldirTip\').val(),$(\'#kaldirId\').val());" class="btn btn-warning">Evet</button>
                        </div>
                    </div>
                </div>
            </div>';
?>

<script>



	function Kaldir(tip,id)
	{
			
				if(tip==1)
				{
					$.post("nakliyecilerim",{islem: "firmaKaldir", id: id, ajax: 'true'},function(result){
						if(result=="OK")
						{
							$("#row_"+id).fadeOut("slow");
						}
					});
				}else if(tip==2)
				{
					$.post("nakliyecilerim",{islem: "fiyatKaldir", id: id, ajax: 'true'},function(result){
						if(result=="OK")
						{
							$("#rows_"+id).fadeOut("slow");
						}
						
					});
				}
			

		$(".KaldirButton").click();

	}

	function yorumGetir(id)

	{

		

		$('#rowd_'+id).slideToggle();

	}

</script>

<?



include "../../inc.footer.php";

?>