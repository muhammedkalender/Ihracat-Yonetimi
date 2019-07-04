<?php
include "../include.php";
if($_POST["islem"]=="kaynakKaldir")
{
	if(mysql_query("delete from kaynak where id='".intval($_POST["id"])."'"))
	{
		echo "OK";
	}
	exit;
}
$lang=$session->userinfo["dil"];



/* cron olarak kurulamayan ama arada çalışması gereken kodlar */























/* */



















	



































































	

include "../inc.header.php";

include "../inc.menu.php";

 



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



<?
$d=mysql_query("select * from ayarlar where name='logo'");
$o=mysql_fetch_object($d);
if($_POST["dusuk"]!="")
{
	$d2=mysql_query("select * from ayarlar where name='dusuk'");
	if(mysql_num_rows($d2)>0)
	{
		$query = $dbpdo->prepare("update ayarlar SET
		value = :value 
		where name = :name");
		$insert = $query->execute(array(
			  "name" => "dusuk",
			  "value" => $dusuk
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Düşük öncelik için belirlenen gün sayısı başarıyla kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}else
	{
		$query = $dbpdo->prepare("insert into ayarlar SET
		value = :value, 
		name = :name");
		$insert = $query->execute(array(
			  "name" => "dusuk",
			  "value" => $dusuk
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Düşük öncelik için belirlenen gün sayısı başarıyla kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}
}
if($_POST["orta"]!="")
{
	$d2=mysql_query("select * from ayarlar where name='orta'");
	if(mysql_num_rows($d2)>0)
	{
		$query = $dbpdo->prepare("update ayarlar SET
		value = :value 
		where name = :name");
		$insert = $query->execute(array(
			  "name" => "orta",
			  "value" => $orta
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Orta öncelik için belirlenen gün sayısı başarıyla kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}else
	{
		$query = $dbpdo->prepare("insert into ayarlar SET
		value = :value, 
		name = :name");
		$insert = $query->execute(array(
			  "name" => "orta",
			  "value" => $orta
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Orta öncelik için belirlenen gün sayısı başarıyla kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}
}
if($_POST["yuksek"]!="")
{
	$d2=mysql_query("select * from ayarlar where name='yuksek'");
	if(mysql_num_rows($d2)>0)
	{
		$query = $dbpdo->prepare("update ayarlar SET
		value = :value 
		where name = :name");
		$insert = $query->execute(array(
			  "name" => "yuksek",
			  "value" => $yuksek
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Yüksek öncelik için belirlenen gün sayısı başarıyla kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}else
	{
		$query = $dbpdo->prepare("insert into ayarlar SET
		value = :value, 
		name = :name");
		$insert = $query->execute(array(
			  "name" => "yuksek",
			  "value" => $yuksek
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Yüksek öncelik için belirlenen gün sayısı başarıyla kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}
}
if($_POST["mailFrom"]!="" || $_POST["mailFromName"]!="")
{
	
	$d2=mysql_query("select * from ayarlar where name='mailFrom'");
	if(mysql_num_rows($d2)>0)
	{
		$query = $dbpdo->prepare("update ayarlar SET
		value = :value 
		where name = :name");
		$insert = $query->execute(array(
			  "name" => "mailFrom",
			  "value" => $mailFrom
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Mail From Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}else
	{
		$query = $dbpdo->prepare("insert into ayarlar SET
		value = :value, 
		name = :name");
		$insert = $query->execute(array(
			  "name" => "mailFrom",
			  "value" => $mailFrom
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Mail From Name Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}
	
	$d3=mysql_query("select * from ayarlar where name='mailFromName'");
	if(mysql_num_rows($d3)>0)
	{
		$query = $dbpdo->prepare("update ayarlar SET
		value = :value 
		where name = :name");
		$insert = $query->execute(array(
			  "name" => "mailFrom",
			  "value" => $mailFrom
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Mail From Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	}else
	{
		
		$query = $dbpdo->prepare("insert into ayarlar SET
		value = :value, 
		name = :name");
		$insert = $query->execute(array(
			  "name" => "mailFromName",
			  "value" => $mailFromName
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Mail From Name Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
	
	}
}else if($_POST["islem"]=="KaynakEkle"){
	
	$query = $dbpdo->prepare("insert into kaynak SET
		adi = :adi");
		$insert = $query->execute(array(
			  "adi" => $kaynak
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Kaynak Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
}else if($_POST["islem"]=="KaynakGuncelle"){
	
	$query = $dbpdo->prepare("UPDATE kaynak SET
		adi = :adi
		where id = :id");
		$insert = $query->execute(array(
			  "adi" => $kaynak,
			  "id" => $id
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Kaynak Başarıyla Güncellenmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
}
if($_FILES["file"]["name"]!="")
{

		$file="";
			if($_FILES["file"]["name"]!="")
				{
					include "../lib/upload.php";
						$up = new UPLOAD( $_FILES['file'] ); 
						$up->yolDizin('../upload'); 
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
				
				
		
		if(mysql_num_rows($d)>0)
		{
			
			unset($o->value);
			
			
			$query = $dbpdo->prepare("update ayarlar SET
		value = :value 
		where name = :name");
		$insert = $query->execute(array(
			  "name" => "logo",
			  "value" => $file
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Logonuz Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
			
		}else
		{
			
				$query = $dbpdo->prepare("insert into ayarlar SET
		name = :name,
		value = :value");
		$insert = $query->execute(array(
			  "name" => "logo",
			  "value" => $file
			  
		));
			if ( $insert ){
				 
				echo $uyari->Basarili("Logonuz Başarıyla Kaydedilmiştir.");
			}else
			{
				$dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
				echo "<pre>";
				echo var_dump($dbpdo->errorInfo());
				echo var_dump($_POST);
				echo "</pre>";
			}
		}

}else{

	
echo '<form class="form-horizontal" id="rakipFiyatEkle" enctype="multipart/form-data" role="form" method="post" >
               <!-- Basic inputs -->
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Liste Ekle</h6></div>
                    <div class="panel-body">
						<input type="hidden" name="islem" value="rakipFiyatEkle">
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo: </label>
                            <div class="col-sm-4">
                               <input type="file" name="file"> 
                            </div>
							 
                              <img src="'.$o->value.'" class="col-sm-6">
                            
							
                           
						</div>	
						<div class="form-group">
                            <label class="col-sm-2 control-label">Gönderen Mail Adresi: </label>
                            <div class="col-sm-4">
                               <input type="text" class="form-control" name="mailFrom" placeholder="Gidecek Mail adresi" value="'.GetTableValue("value","ayarlar","WHERE name = 'mailFrom'").'"> 
                            </div>
							 <label class="col-sm-2 control-label">Gönderen: </label>
                            <div class="col-sm-4">
                               <input type="text" class="form-control" name="mailFromName" placeholder="Gidecek İsim" value="'.GetTableValue("value","ayarlar","WHERE name = 'mailFromName'").'"> 
                            </div>
						</div>
						<div class="form-group">
                            <label class="col-sm-2 control-label">Düşük: </label>
                            <div class="col-sm-2">
                               <input type="number" class="form-control" name="dusuk" value="'.GetTableValue("value","ayarlar","WHERE name = 'dusuk'").'"> 
                            </div>
							<label class="col-sm-2 control-label">Orta: </label>
                            <div class="col-sm-2">
                               <input type="number" class="form-control" name="orta" value="'.GetTableValue("value","ayarlar","WHERE name = 'orta'").'"> 
                            </div>
							<label class="col-sm-2 control-label">Yüksek: </label>
                            <div class="col-sm-2">
                               <input type="number" class="form-control" name="yuksek" value="'.GetTableValue("value","ayarlar","WHERE name = 'yuksek'").'"> 
                            </div>
						</div>
						<div class="form-actions text-right">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
						
					
					</div>
				</div>
			</form>';

if($islem=="kaynakDuzenle")
{
	$d=mysql_query("select * from kaynak where id='$id'");
	$o=mysql_fetch_object($d);
	$ek='<input type="hidden" name="id" value="'.$o->id.'">		
	<input type="hidden" name="islem" value="KaynakGuncelle">';
}else
	$ek='<input type="hidden" name="islem" value="KaynakEkle">		';

echo '<form class="form-horizontal" id="KaynakEkle" enctype="multipart/form-data" role="form" method="post" action="ayarlar">
               <div class="row">
                    <div class="col-md-6">
								 <!-- Basic inputs -->
						<div class="panel panel-default">
							<div class="panel-heading"><h6 class="panel-title">Kaynak</h6></div>
							<div class="panel-body">
								'.$ek.'
								<div class="form-group">
									<label class="col-sm-4 control-label">Kaynak: </label>
									<div class="col-sm-8">
									   <input type="text" class="form-control" name="kaynak" placeholder="Kaynak Adı" value="'.$o->adi.'"> 
									</div>
									
								</div>
								
								<div class="form-actions text-right">
									<button type="submit" class="btn btn-primary">Kaydet</button>
								</div>
								
							
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading"><h6 class="panel-title">Kaynak Listesi</h6></div>
							<div class="panel-body">
						<table class="table">
                        <thead>
                            <tr>
                                <th>Kaynak</th>
                                <th class="col-md-1">İşlem</th>
                                
                            </tr>
                        </thead>
                        <tbody>
						';
						$ds=mysql_query("select * from kaynak");
						while($ok=mysql_fetch_object($ds)){
							$buton = '<a class="btn btn-primary btn-icon dropdown-toggle tip" title="Kaynak Düzenle" href="ayarlar?'.URL::encode("?islem=kaynakDuzenle&id=".$ok->id).'"><i class="fa fa-edit"></i></a>';
						 echo' <tr id="row_'.$ok->id.'">
                                <td>'.$ok->adi.'</td>
                                <td>
								'.$buton.'
								';
								if($session->userlevel==9)
								{
									echo '<button class="btn btn-primary btn-icon dropdown-toggle tip" title="Kaynak Sil" onclick="Kaldir('.$ok->id.');" data-toggle="dropdown"><i class="fa fa-trash-o"></i></button>';
								}
								echo'
								</td>
                            </tr>
                             ';
						}	
						echo '
						</body>
					</table>
					</div>
					</div>
					</div>
				</div>
			  
			</form>';
}

?>
<script>
	function Kaldir(id){
		
		if(confirm("Silme işlemini onaylamak için Tamam butonuna basınız!"))
		{
			$.post("ayarlar",{islem:"kaynakKaldir", id: id, ajax:'true'},function(res){
				if(res=="OK")
				$("#row_"+id).fadeOut();
			})
		}
	}
</script>
<?
include "../inc.footer.php";

?>