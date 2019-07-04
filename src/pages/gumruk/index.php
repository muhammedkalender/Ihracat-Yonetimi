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

}







unset($sayfaActive);

$sayfaActive["gumruk"]="page-header-active";

include "../../inc.header.php";

include "../../inc.menu.php";

 



// Önce şifrelenmiş linkten değerleri al

foreach($_REQUEST as $input=>$value) {

	 $_REQUEST[$input] = $value;

}

// Aldığın değerleri tanımın adına döşe

foreach ($_REQUEST AS $k=>$v) $$k=$v;

 

 

if($_POST["islem"]=="gumrukKayit")

{

	

	$query = $dbpdo->prepare("INSERT INTO gumrukFirma SET

firma = :firma,

tel = :tel,

sehir = :sehir,

irtibatKisi = :irtibatKisi,

ekleyen = :ekleyen");

$insert = $query->execute(array(

      "firma" => $firma,

      "tel" => $tel,

      "sehir" => $sehir,

	  "irtibatKisi" => $irtibatKisi,

	  "ekleyen" => $session->username

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

	

	$query = $dbpdo->prepare("UPDATE gumrukFirma SET

firma = :firma,

tel = :tel,

sehir = :sehir,

irtibatKisi = :irtibatKisi

where id= :id");

$insert = $query->execute(array(

      "firma" => $firma,

      "tel" => $tel,

      "sehir" => $sehir,

	  "irtibatKisi" => $irtibatKisi,

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

	

	

	$query = $dbpdo->prepare("INSERT INTO gumrukTeklif SET

fid = :fid,

tarih = :tarih,

fiyat = :fiyat,

birim = :birim,

aciklama = :aciklama,

ekleyen = :ekleyen

");

$insert = $query->execute(array(

      "fid" => $id,

      "tarih" => strtotime(str_replace("/","-",$_POST["tarih"])),

      "fiyat" => $fiyat,

	  "birim" => $birim,
	  
	  "aciklama" => $aciklama,

	  "ekleyen" => $session->username

	  

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

	

	$d=mysql_query("select   a.* from gumrukFirma a where a.id='".$id."'"); 

	$o=mysql_fetch_object($d);

	 

	echo '<form action="gumrukcu?'.URL::encode("?islem=detay&id=".$id).'" class="form-horizontal " role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Gümrük Firması Düzenle</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(\'slow\'); window.location.href=\'gumrukcu\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

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

									<label class="col-sm-2 control-label">Şehir: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="sehir" value="'.$o->sehir.'">

                            </div>

                                    <label class="col-sm-2 control-label">İrtibat Kişi: </label>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="irtibatKisi" value="'.$o->irtibatKisi.'">

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

	 

	echo '<form action="gumrukcu?'.URL::encode("?islem=GorusmeYap&id=".$id).'" class="form-horizontal gizle" id="teklifEkle" role="form" method="post">

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

                            <div class="col-sm-2">

                                <input type="text" name="tarih" id="gorusmeTarih" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >

                            </div>

							 <label class="col-sm-2 control-label">Fiyat: </label>

                            <div class="col-sm-4">

                               <input type="text" name="fiyat" class="form-control" required placeholder="Fiyat Giriniz" value="" >

                            </div>

							<div class="col-sm-2">

                               '.select_paraBirimList("birim").'

                            </div>

							

						</div>	
						<div class="form-group">
							 <label class="col-sm-2 control-label">Açıklama: </label>

                            <div class="col-sm-10">

                                <textarea name="aciklama" class="form-control" placeholder="Alınan teklif detayını giriniz"></textarea>

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

                    <div class="panel-heading"><h6 class="panel-title">Fiyat Listesi</h6><span class="title-right"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'#teklifEkle\').slideToggle();"><i class="fa  fa-minus-square-o"></i> Teklif Ekle</button><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="$(\'.form-horizontal\').fadeOut(); window.location.href=\'gumrukcu\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						  

                        <div class="form-group">';

			$d=mysql_query("select  a.* from gumrukTeklif a where a.fid='$id'  ");

						if(mysql_num_rows($d)>0)

						{

						echo

						'

						<table class="table">

                        <thead>

                            <tr>
								<th>Tarih</th>
								<th>Açıklama</th>
								<th>Fiyat</th>
                            </tr>

                        </thead>

                        <tbody>

						';

						

						while($ok=mysql_fetch_object($d)){

							$buton="";

							

							echo' <tr id="row_'.$ok->id.'">

                                <td class="col-sm-1">'.date("d.m.Y",$ok->tarih).'</td>
								<td>'.$ok->aciklama.'</td>
                                <td class="col-sm-1">'.number_format($ok->fiyat, 0, ',', '.')." ".$ok->birim.'</td>
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

 echo '<form action="gumrukcu" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Gümrükçü Firma Oluştur</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="gumrukKayit">

                        

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

									<label class="col-sm-2 control-label">Şehir: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="sehir">

                            </div>

                                    <label class="col-sm-2 control-label">İrtibat Kişi: </label>

                                    <div class="col-sm-4">

                                        <input type="text" class="form-control" name="irtibatKisi">

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

                <div class="panel-heading"><h6 class="panel-title">Gümrükçü Firmaları</h6>

					<?='<span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Firma Ekle</button>'?>

				</div>

                <div class="datatable">

                    <table class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-sm-1">Son Teklif</th>

                                <th>Firma Adı</th>

                                <th class="col-sm-1">Şehir</th> 

								<th class="col-sm-2">Fiyat</th>

                                <th class="col-sm-1" nowrap>İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?

							

							$query = $dbpdo->query("SELECT  a.* FROM gumrukFirma a", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

													 $d=mysql_query("select a.* from gumrukTeklif a where a.fid='".$row["id"]."' order by a.tarih DESC limit 1");

													 $o=mysql_fetch_object($d);

													 

													 if(intval($o->tarih)!=0)

													 {

														 $sonTeklif=date("d.m.Y",$o->tarih);

														 $sonTeklifFiyat=$o->fiyat." ".$o->birim;

														 

													 }else

														 $sonTeklifFiyat=$sonTeklif="-";

													  echo '<tr id="row_'.$row["id"].'">

															<td>'.$sonTeklif.'</td>

															<td>'.$row["firma"].'</td>

															<td>'.$row["sehir"].'</td>

															<td>'.$sonTeklifFiyat.'</td>

															<td  nowrap><a href="gumrukcu?'.URL::encode("?islem=detay&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a>

															<a href="gumrukcu?'.URL::encode("?islem=GorusmeYap".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " onclick="$(\'.gorusmeEkle\').slideToggle();" title="Görüşmeler" data-original-title="Arama Yap"><i class="fa fa-plus"></i></a>
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirId\').val('.$row["id"].');" title="Bu firmayı kaldır" data-original-title="Bu firmayı kaldır"><i class="fa fa-trash"></i></a>
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
							
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default KaldirButton" data-dismiss="modal">Hayır</button>
                            <button type="button" onclick="Kaldir($(\'#kaldirId\').val());" class="btn btn-warning">Evet</button>
                        </div>
                    </div>
                </div>
            </div>';

?>

<script>

	function Kaldir(id)
	{
			$.post("gumrukcu",{islem: "firmaKaldir", id: id, ajax: 'true'},function(result){
					if(result=="OK")
					{
						$("#row_"+id).fadeOut("slow");
					}
				});		
		$(".KaldirButton").click();
	}

</script>

<?



include "../../inc.footer.php";

?>