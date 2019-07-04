<?php



include "../../include.php";

$lang=$session->userinfo["dil"];



if($_POST["islem"]=="fuarKaldir")
{
	if(mysql_query("delete from fuar where id='".$_POST["id"]."'"))
	{
		if(mysql_query("delete from fuarDetay where fid='".$_POST["id"]."'"))
		{

		}
		echo "OK";
	}

	exit;

}else if($_POST["islem"]=="katilim")

{

	$d=mysql_query("select katilim from fuar where id='".$_POST["id"]."'");

	$ok=mysql_fetch_object($d);

	

	$query = $dbpdo->prepare("UPDATE fuar SET

katilim = :katilim

where id= :id");

$insert = $query->execute(array(

     "katilim" => intval(($ok->katilim)+1)%2,

       "id" => $_POST["id"]

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo intval(($ok->katilim)+1)%2;

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo "</pre>";

	}

	exit;

}







unset($sayfaActive);

$sayfaActive["fuar"]="page-header-active";

include "../../inc.header.php";

include "../../inc.menu.php";

 



// Önce şifrelenmiş linkten değerleri al

foreach($_REQUEST as $input=>$value) {

	 $_REQUEST[$input] = $value;

}

// Aldığın değerleri tanımın adına döşe

foreach ($_REQUEST AS $k=>$v) $$k=$v;

 

 

if($_POST["islem"]=="fuarKayit")

{

	

	$query = $dbpdo->prepare("INSERT INTO fuar SET

adi = :adi,

ulke = :ulke,

sehir = :sehir");

$insert = $query->execute(array(

      "adi" => $adi,

      "ulke" => $ulke,

      "sehir" => $sehir

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Fuar başarıyla kaydedilmiştir.");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo "</pre>";

	}

}elseif($_POST["islem"]=="fuarGuncelle")

{ 

	

	$query = $dbpdo->prepare("UPDATE fuar SET

adi = :adi,

ulke = :ulke,

sehir = :sehir

where id= :id");

$insert = $query->execute(array(

     "adi" => $adi,

      "ulke" => $ulke,

      "sehir" => $sehir,

	  "id" => $id

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Fuar başarıyla kaydedilmiştir. ");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($dbpdo->errorInfo());

		echo "</pre>";

	}

}else if($_POST["islem"]=="fuarDetayEkle")

{

	

	

	$query = $dbpdo->prepare("INSERT INTO fuarDetay SET

fid = :fid,

baslamaTarihi = :baslamaTarihi,

bitisTarihi = :bitisTarihi,

fiyat = :fiyat,

ekleyen = :ekleyen,

aciklama = :aciklama");

$insert = $query->execute(array(

      "fid" => $id,

      "baslamaTarihi" => strtotime(str_replace("/","-",$_POST["baslamaTarihi"])),

      "bitisTarihi" => strtotime(str_replace("/","-",$_POST["bitisTarihi"])),

	  "fiyat" => $fiyat,

	  "ekleyen" => $session->username,

	  "aciklama" => $aciklama

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Fuar detayı başarıyla kaydedilmiştir. ");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($_POST);

		echo var_dump($dbpdo->errorInfo());

		echo "</pre>";

	}

}else if($_POST["islem"]=="fuarDetayGuncelle")

{

	

	

	$query = $dbpdo->prepare("UPDATE fuarDetay SET

fid = :fid,

baslamaTarihi = :baslamaTarihi,

bitisTarihi = :bitisTarihi,

fiyat = :fiyat,

aciklama = :aciklama

where id = :id");

$insert = $query->execute(array(

      "fid" => $id,

      "baslamaTarihi" => strtotime(str_replace("/","-",$_POST["baslamaTarihi"])),

      "bitisTarihi" => strtotime(str_replace("/","-",$_POST["bitisTarihi"])),

	  "fiyat" => $fiyat,

	   "aciklama" => $aciklama,

	  "id" => $fid

));

	if ( $insert ){

		$last_id = $dbpdo->lastInsertId();

		echo $uyari->Basarili("Fuar detayı başarıyla kaydedilmiştir. ");

	}else

	{

		$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

		echo "<pre>";

		echo var_dump($_POST);

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

	

	$d=mysql_query("select   a.* from fuar a where a.id='".$id."'"); 

	$o=mysql_fetch_object($d);

	 

	echo '<form action="fuarlarim?'.URL::encode("?islem=detay&id=".$id).'" class="form-horizontal " role="form" method="post">

              <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Fuar Detay</h6><span style="float:right;"><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick="guncelleButon()"><i class="fa  fa-minus-square-o"></i> Güncelle</button><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick=" window.location.href=\''.BASEURL.'/fuarlarim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="fuarGuncelle">

                        <div class="form-group">

                             <div class="col-md-2">

                                 <b>Fuar Adı</b>

                            </div>

                            <div class="col-sm-4">

								<span class="form-span">

									'.$o->adi.'

								</span>

                                <input type="text" class="form-control gizle" name="adi" required value="'.$o->adi.'">

                            </div>

							 <div class="col-md-2">

                                 <b>Ülke</b>

                            </div>

							<div class="col-md-4">

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

                                       echo '  </span>

									   <select data-placeholder="Ülke seçin..." name="ulke" class="select-search form-input gizle" tabindex="2">

										'.$ulkeler.'

									   </select>

                            </div>

						</div>	

						<div class="form-group">

							<label class="col-sm-2 control-label">Şehir: </label>

									<div class="col-sm-4">

										<span class="form-span">

											'.$o->sehir.'

										</span>

										 <input type="text" class="form-control gizle" name="sehir" value="'.$o->sehir.'">

									</div>

                        </div>

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>';

}else if($islem=="fuarTarihElke")

{

	if($islem2=="fuarTarihGuncelle")

	{

		$o=mysql_fetch_object(mysql_query("select * from fuarDetay where id='$fid'"));

		

		echo '<form action="fuarlarim?'.URL::encode("?islem=fuarTarihElke&id=".$id."&fid=".$fid).'" class="form-horizontal" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Fuar Tarih Ekle</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="fuarDetayGuncelle">

                        <div class="form-group">

                             <div class="col-md-2">

                                 <b>Başlangıç Tarihi</b>

                            </div>

                            <div class="col-sm-2">

                                <input type="text" name="baslamaTarihi" id="baslamaTarihi" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y",$o->baslamaTarihi).'" >

                            </div>

							 <div class="col-md-2">

                                 <b>Bitiş Tarihi</b>

                            </div>

							<div class="col-md-2">

                                  <input type="text" name="bitisTarihi" id="bitisTarihi" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y",$o->bitisTarihi).'" >

                            </div>

							 <div class="col-md-2">

                                 <b>M2 Fiyatı</b>

                            </div>

							<div class="col-md-2">

                                  <input type="text" class="form-control" name="fiyat" required value="'.$o->fiyat.'">

                            </div>

						</div>	

						<div class="form-group">

							<label class="col-sm-2 control-label">Not: </label>

									<div class="col-sm-10">

										 <textarea name="aciklama" class="form-control">'.$o->aciklama.'</textarea>

									</div>

									

                                

                            

                        </div>

						

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>

			

			';

	}else

	{

	echo '<form action="fuarlarim?'.URL::encode("?islem=fuarTarihElke&id=".$id).'" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Fuar Tarih Ekle</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="fuarDetayEkle">

                        <div class="form-group">

                             <div class="col-md-2">

                                 <b>Başlangıç Tarihi</b>

                            </div>

                            <div class="col-sm-2">

                                <input type="text" name="baslamaTarihi" id="baslamaTarihi" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >

                            </div>

							 <div class="col-md-2">

                                 <b>Bitiş Tarihi</b>

                            </div>

							<div class="col-md-2">

                                  <input type="text" name="bitisTarihi" id="bitisTarihi" class="datepicker form-control" placeholder="Tarih Giriniz" value="'.date("d/m/Y").'" >

                            </div>

							 <div class="col-md-2">

                                 <b>M2 Fiyatı</b>

                            </div>

							<div class="col-md-2">

                                  <input type="text" class="form-control" name="fiyat" required>

                            </div>

						</div>	

						<div class="form-group">

							<label class="col-sm-2 control-label">Not: </label>

									<div class="col-sm-10">

										 <textarea name="aciklama" class="form-control"></textarea>

									</div>
 
                        </div>
 

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>

			<div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Fuar Tarihleri</h6><span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Tarih Ekle</button><button type="button" class="btn btn-info btn-icon  dropdown-toggle" onclick=" window.location.href=\''.BASEURL.'/fuarlarim\';"><i class="fa  fa-minus-square-o"></i> Kapat</button></span></div>

                    <div class="panel-body">

			';

			

			?>

			 <table class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-md-1">Başlangıç Tarihi</th>

								<th class="col-md-1">Bitiş Tarihi</th>

                                <th>M2/Fiyatı</th> 

								<th class="col-md-1">İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?

							

							$query = $dbpdo->query("SELECT a.* FROM fuarDetay a where fid='$id' ", PDO::FETCH_ASSOC);

											

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

													 

													 if(intval($row["baslamaTarihi"])!=0)

													 {

														 $baslamaTarihi=date("d.m.Y",$row["baslamaTarihi"]);

														 

													 }else

														 $baslamaTarihi="-";

													 

													 if(intval($row["bitisTarihi"])!=0)

													 {

														 $bitisTarihi=date("d.m.Y",$row["bitisTarihi"]);

														 

													 }else

														 $bitisTarihi="-";

													 

													  echo '<tr id="row_'.$row["id"].'">

															<td>'.$baslamaTarihi.'</td>

															<td>'.$bitisTarihi.'</td>

															<td>'.$row["fiyat"].'</td>

															<td>

															<a href="javascript:;" class="btn btn-info btn-icon btn-xs tip " onclick="Detay('.$row["id"].')" title="Görüşmeleri Göster" data-original-title="Görüşmeleri Göster"><i class="fa fa-eye"></i></a>

															<a href="fuarlarim?'.URL::encode("?islem=fuarTarihElke&islem2=fuarTarihGuncelle&fid=".$row["id"]."&id=".$row["fid"]).'" class="btn btn-info btn-icon btn-xs tip " title="Düzenle" data-original-title="Düzenle"><i class="fa fa-edit"></i></a>

															</td> 

														</tr><tr id="detay_'.$row["id"].'" class="gizle">

															<td colspan="4">'.$row["aciklama"].'</td>

															

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

}else

{

 echo '<form action="fuarlarim" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Fuar Oluştur</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="fuarKayit">

                        <div class="form-group">

                             <div class="col-md-2">

                                 <b>Fuar Adı</b>

                            </div>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="adi" required>

                            </div>

							 <div class="col-md-2">

                                 <b>Ülke</b>

                            </div>

							<div class="col-md-4">

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

                                       echo '  </span>

									   <select data-placeholder="Ülke seçin..." name="ulke" class="select-search form-input" tabindex="2">

										'.$ulkeler.'

									   </select>

                            </div>

						</div>	

						<div class="form-group">

							<label class="col-sm-2 control-label">Şehir: </label>

									<div class="col-sm-4">

										 <input type="text" class="form-control" name="sehir">

									</div>

									

                                

                            

                        </div>

						

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>';

			

}

if(!in_array($_REQUEST["islem"],array("detay","GorusmeYap","fuarTarihElke")))

{

 ?>        



	 <!-- Condensed datatable inside panel -->

            <div class="panel panel-default">

                <div class="panel-heading"><h6 class="panel-title">Fuarlarlar</h6>

					<?='<span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Fuar Ekle</button>'?>

				</div>

                <div class="datatable">

                    <table class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-md-1" nowrap>Başlangıç Tarihi</th>

								<th class="col-md-1" nowrap>Bitiş Tarihi</th>

                                <th>Fuar Adı</th>

                                <th class="col-md-1">M2/Fiyatı</th> 

								<th class="col-md-1">Ülke</th>

								<th  class="col-md-1">Şehir</th>

                                <th  class="col-md-1">İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?

							

							$query = $dbpdo->query("SELECT (select ulke from Ulke where id=a.ulke) as ulkeAdi, a.* FROM fuar a  ", PDO::FETCH_ASSOC);

											

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

													 $d=mysql_query("select a.* from fuarDetay a where a.fid='".$row["id"]."' order by a.baslamaTarihi DESC limit 1");

													 $o=mysql_fetch_object($d);

													 

													 if(intval($o->baslamaTarihi)!=0)

													 {

														 $baslamaTarihi=date("d.m.Y",$o->baslamaTarihi);

														 

													 }else

														 $baslamaTarihi="-";

													 

													 if(intval($o->bitisTarihi)!=0)

													 {

														 $bitisTarihi=date("d.m.Y",$o->bitisTarihi);

														 

													 }else

														 $bitisTarihi="-";

													 

													 if($row["katilim"]==0){

														 $katilimButon='<a href="javascript:;" id="katilimButon" class="btn btn-primary btn-icon btn-xs tip " onclick="Katilim('.$row["id"].')" title="Fuara Katıl" data-original-title="Katılım Güncelle"><i class="fa fa-ellipsis-h"></i></a>';

													 }else

													 {

														 $katilimButon='<a href="javascript:;" id="katilimButon" class="btn btn-info btn-icon btn-xs tip " onclick="Katilim('.$row["id"].')" title="Fuara Katıldık" data-original-title="Katılım Güncelle"><i class="fa fa-check"></i></a>';

													 }
														if(((strtotime(str_replace("/",".",$baslamaTarihi))-time())/(60*60*24))<30 AND time()<strtotime(str_replace("/",".",$bitisTarihi)))
														{
															if(time()>strtotime(str_replace("/",".",$baslamaTarihi)) AND time()<strtotime(str_replace("/",".",$bitisTarihi)))
															{
																$mesaj="Fuar Başladı";
															}else
															{
																$mesaj="Fuar Yaklaşıyor";
															}
															$baslamaTarihi .='<a class="btn tip" href="javascript:;" title="" data-original-title="'.$mesaj.'"><span class="blink tip" data-original-title="" title="">
																	<i class="fa fa-bell"></i></span></a>';
														}
													  echo '<tr id="row_'.$row["id"].'">

															<td>'.$baslamaTarihi.'</td>

															<td>'.$bitisTarihi.'</td>

															<td>'.$row["adi"].'</td>

															<td>'.$o->fiyat.'</td>

															<td>'.$row["ulkeAdi"].'</td>

															<td>'.$row["sehir"].'</td>

															<td nowrap><a href="fuarlarim?'.URL::encode("?islem=detay&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip detay" title="Firma Detayı" data-original-title="Detay"><i class="fa fa-info"></i></a> 

															<a href="fuarlarim?'.URL::encode("?islem=fuarTarihElke".$ekkullanici."&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip " onclick="$(\'.gorusmeEkle\').slideToggle();" title="Tarih Ekle" data-original-title="Arama Yap"><i class="fa fa-plus"></i></a>

															'.$katilimButon.'
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirId\').val('.$row["id"].'); $(\'#kaldirTip\').val(1);" title="Bu fuarı kaldır" data-original-title="Bu fuarı kaldır"><i class="fa fa-trash"></i></a>
															

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
			$.post("fuarlarim",{islem: "fuarKaldir", id: id, ajax: 'true'},function(result){
					if(result=="OK")
					{
						$("#row_"+id).fadeOut("slow");

					}
				});

		}
		$(".KaldirButton").click();
	}

	function yorumGetir(id)
	{
		$('#rowd_'+id).slideToggle();
	}

	function guncelleButon(){
		$(".form-span").slideToggle();
		$(".form-control").slideToggle();
		$(".form-input").slideToggle();
	}

	function Detay(id){

		$("#detay_"+id).slideToggle();

	}

	function Katilim(id){

		

		

		$.post("fuarlarim",{islem: "katilim", id: id, ajax: 'true'},function(result){

				

		if(result==1)

		$("#katilimButon").removeClass( "btn-primary" ).html('<i class="fa fa-check"></i>').attr("data-original-title", "Fuara Katıldık.").attr("title", "Fuara Katıldık.").addClass( "btn-info" );

		else

		$("#katilimButon").removeClass( "btn-info" ).html('<i class="fa fa-ellipsis-h"></i>').attr("data-original-title", "Fuara Katıl.").attr("title", "Fuara Katıl.").addClass( "btn-primary" );

					

				});

		

		

	}

</script>

<?



include "../../inc.footer.php";

?>