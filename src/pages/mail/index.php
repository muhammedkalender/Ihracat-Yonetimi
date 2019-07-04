<?php

include "../../include.php";
if($_POST["islem"]=="linkKaldir")
{
	
	unlink("mailing_list/".$_POST["link"]);
	
	exit;
}else if($_POST["islem"]=="mailEkle")
{
	$a = explode(";",trim($_POST["emailler"]));
	foreach($a as $s)
	{
		$mail =trim($s);
		if(strstr($mail,"@") AND strstr($mail,"."))
		{
			if(mysql_query("insert into bultenDisaridanEmail set email='".$mail."'"))
			{
				echo $mail." - Eklendi";
			}else
				echo $mail." - <font color='red'>Eklenemedi<font>";
		}else
			echo $mail." - <font color='red'>Eklenemedi. Lütfen maili düzgün girin<font>";
	}
	//bultenDisaridanEmail
	exit;
}else if($_POST["islem"]=="grupKaldir")
{
if($_POST["tip"]==1 || $_POST["tip"]==2){
	if(mysql_query("delete from bultenGrupEmail where gid='".$_POST["id"]."' AND email='".$_POST["email"]."'"));
	{
		echo "OK";

	}
}else if($_POST["tip"]==3){
	if(mysql_query("delete from bultenGrup where id='".$_POST["id"]."'"));
	{
		echo "OK";

	}
}
	exit;

}else if($_POST["islem"]=="testGonder"){


	echo MailGonder($session->userinfo["email"],$_POST["subject"],$_POST["mesaj"]."<img border='0' src='".BASEURL."/mailchecker?"."subject=".$_POST["subject"]."&mail=".$session->userinfo["email"]."&mailId=".$_POST["gid"]."&id=".rand(111, 999).rand(111, 999)."' width='1' height='1' alt='image for email' >");
	exit; 

	
}else if($_POST["islem"]=="grubaGonder"){

	$d=mysql_query("select * from bultenGrupEmail where gid='".$_POST["gid"]."'");

	$toplamMail=mysql_num_rows($d);

	while($o=mysql_fetch_object($d))
	{
		$dds=mysql_query("select * from bultenGidenMail where tarih>".(time()-5*60)." AND gidenMail='".$o->email."'");
		if(mysql_num_rows($dds)==0)
			if(MailGonder($o->email,$_POST["subject"],$_POST["mesaj"]."<br><br><div class='mail-footer'><a href='https://www.novasta.com.tr' target='_blank'>Novasta® e-Bülten sistemi</a> tarafından gönderilmiş bu mail, 6663 sayılı Elektronik Ticareti Düzenleme<br> kanununa uygun olarak sizlere gönderilmiştir. Bülten aboneliğinizi istediğiniz zaman iptal edebilirsiniz. <br><strong>e-Bülten aboneliğinden çıkmak için <a href='".BASEURL."/ebulten-cikis?".URL::encode("?epos=".$o->email)."'>tıklayınız.</a></strong></div><img border='0' src='".BASEURL."/mailchecker?"."subject=".$_POST["subject"]."&mail=".$o->email."&mailId=".$_POST["gid"]."&tm=".$toplamMail."&tarih=".date("Ymd-Hi")."&id=".rand(111, 999).rand(111, 999)."' width='1' height='1' alt='image for email' >"))
			{
				if(mysql_query("insert into bultenGidenMail set tarih=".time().", gidenMail='".$o->email."', subject='".strip_tags($_POST["subject"])."'"))
				{
					
				}
			}
	}

	

	echo "OK";

	exit;

}



$lang=$session->userinfo["dil"];



unset($sayfaActive);

$sayfaActive["mail"]="page-header-active";

include "../../inc.header.php";

include "../../inc.menu.php";



// Önce şifrelenmiş linkten değerleri al

foreach($_REQUEST as $input=>$value) {

	 $_REQUEST[$input] = $value;

}

// Aldığın değerleri tanımın adına döşe

foreach ($_REQUEST AS $k=>$v) $$k=$v;



if($_POST["islem"]=="grupKayit")

{

	

	$query = $dbpdo->prepare("INSERT INTO bultenGrup SET

adi = :adi,

sira = :sira");

$insert = $query->execute(array(

      "adi" => $adi,

      "sira" => $sira

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

}else if($_POST["islem"]=="grupEmailKayit")

{

	mysql_query("delete from bultenGrupEmail where gid='$id'");

	

	if(count($emails)>0)

	{

		foreach($emails as $s){

			

			$query = $dbpdo->prepare("INSERT INTO bultenGrupEmail SET

			gid = :gid,

			email = :email");

			$insert = $query->execute(array(

				  "gid" => $id,

				  "email" => $s

			));

				if ( $insert ){

					$last_id = $dbpdo->lastInsertId();

					echo $uyari->Basarili("Email başarıyla kaydedilmiştir. (".$s.")");

				}

		}

	}

}else if($_POST["islem"]=="emailGonder")

{

	MailGonder("ozkan@novasta.com.tr","Ebülten", $ebulten);

}

//MailGonder("ozkan@novasta.com.tr","test","test2",false,15);



?>



<script src="../../js/tinymce/tinymce.dev.js"></script>

<script src="../../js/tinymce/plugins/table/plugin.dev.js"></script>

<script src="../../js/tinymce/plugins/paste/plugin.dev.js"></script>

<script src="../../js/tinymce/plugins/spellchecker/plugin.dev.js"></script>

<script type="text/javascript" src="../../js/plugins/charts/flot.pie.js"></script>

<script type="text/javascript" src="../../js/plugins/charts/pie.js"></script>

<script>

	tinymce.init({

		selector: "textarea#ebulten2",

		theme: "modern",

		plugins: [

			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",

			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",

			"save table contextmenu directionality emoticons template paste textcolor importcss"

		],

		content_css: "css/development.css",

		add_unload_trigger: false,



		toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons table",

		toolbar2: "custompanelbutton textbutton spellchecker",



		image_advtab: true,



		style_formats: [

			{title: 'Bold text', format: 'h1'},

			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},

			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},

			{title: 'Example 1', inline: 'span', classes: 'example1'},

			{title: 'Example 2', inline: 'span', classes: 'example2'},

			{title: 'Table styles'},

			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}

		],



		template_replace_values : {

			username : "Jack Black"

		},



		template_preview_replace_values : {

			username : "Preview user name"

		},



		//file_browser_callback: function() {},



		templates: [ 

			{title: 'Some title 1', description: 'Some desc 1', content: '<strong class="red">My content: {$username}</strong>'}, 

			{title: 'Some title 2', description: 'Some desc 2', url: 'development.html'} 

		],



		setup: function(ed) {

			ed.addButton('custompanelbutton', {

				type: 'panelbutton',

				text: 'Panel',

				panel: {

					type: 'form',

					items: [

						{type: 'button', text: 'Ok'},

						{type: 'button', text: 'Cancel'}

					]

				}

			});



			ed.addButton('textbutton', {

				type: 'button',

				text: 'Text'

			});

		},



		spellchecker_callback: function(method, words, callback) {

			if (method == "spellcheck") {

				var suggestions = {};



				for (var i = 0; i < words.length; i++) {

					suggestions[words[i]] = ["First", "second"];

				}



				callback(suggestions);

			}

		}

	});

</script>

<div class="page-title">
    <h5 class="alert">İhracat Haberleri :</h5>
 <?php
 include "../../inc.news.php"
?>
            </div>

			<?

			

			if($islem=="detay")

			{

				

				?>

				

				<form class="form-horizontal" id="firmaKayitForm" role="form" method="post">

				<div class="panel panel-default">

                <div class="panel-heading"><h6 class="panel-title"><?=EmailGrupAdi($id)?> - Mail Listeleri</h6>

				<div class="form-actions text-right">
							
                            <button type="submit" class="btn btn-info">Kaydet</button>
							<?='<a href="mail?'.URL::encode("?islem=ebultenEdit&id=".$id).'" class="btn btn-success btn-icon btn-xs tip" title="Ebülten Oluştur" data-original-title="Ebülten Oluştur">Ebülten Oluştur</a>'?>
							<?='<a href="mail" class="btn btn-success btn-icon btn-xs tip" title="Kapat" data-original-title="Kapat">Kapat</a>'?>

                        </div>

				</div>

				<input type="hidden" name="islem" value="grupEmailKayit">

				<div class="datatable">

                    <table class="table table-condensed" id="tablo1">

                        <thead>

                            <tr>

                                <th class="col-sm-1"># <input type="checkbox" id="checkAll" ></th>

                                <th>Email</th> 
								<th class="col-sm-1">Durum</th>
								<th class="col-sm-1">Ülke</th>
								<th class="col-sm-1">İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?
							if(MODUL_EBULTEN==1)
							{
							$query0 = $dbpdo->query("SELECT  (select count(*) as sayi from banned_emails where email=a.email) as bvarmi,(select count(*) as sayi from bultenGrupEmail where gid='".$id."' AND email=a.email) as varmi, a.* FROM bultenDisaridanEmail a where email LIKE '%@%'", PDO::FETCH_ASSOC);
							if ( $query0->rowCount() ){

												 foreach( $query0 as $row ){
													
														$durum="Disaridan Ekleme";
													

													if(intval($row["bvarmi"])>0)
													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox" disable value="'.$row["email"].'"></td>

															<td title="Ebülten aboneliğinden çıktı"><font color="red">'.$row["email"].'</font></td>
															<td></td>
															<td></td>
															
															<td></td> 

														</tr>';

													}else if(intval($row["varmi"])>0)
													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox"  checked="true" class="checks" name="emails[]" value="'.$row["email"].'"></td>

															<td>'.$row["email"].'</td>
															<td></td>
															<td></td>
															<td>
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirTip\').val(\'1\'); $(\'#kaldirId\').val(\''.$id.'\'); $(\'#kaldirEmail\').val(\''.$row["email"].'\');" title="Bu fuarı kaldır" data-original-title="Bu fuarı kaldır"><i class="fa fa-trash"></i></a>
															</td> 

														</tr>';

													}else

													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox" class="checks" name="emails[]" value="'.$row["email"].'"></td>

															<td>'.$row["email"].'</td>
															<td></td>
															<td></td>
															<td></td> 

														</tr>';

													}

													  

												 }

											}
							}
							$query = $dbpdo->query("SELECT  (select count(*) as sayi from banned_emails where email=a.email) as bvarmi,(select count(*) as sayi from bultenGrupEmail where gid='".$id."' AND email=a.email) as varmi, (select ulke from Ulke where id=a.ulke) as ulkeAdi, a.* FROM firma a where email LIKE '%@%'", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												 foreach( $query as $row ){
													if($row["musteri"]==1)
													{
														$durum="Müşteri";
													}else
														$durum="Görüşme";

													if(intval($row["bvarmi"])>0)

													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox" disable value="'.$row["email"].'"></td>

															<td title="Ebülten aboneliğinden çıktı"><font color="red">'.$row["email"].'</font></td>
															<td>'.$durum.'</td>
															<td>'.$row["ulkeAdi"].'</td>
															
															<td></td> 

														</tr>';

													}else if(intval($row["varmi"])>0)

													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox"  checked="true" class="checks" name="emails[]" value="'.$row["email"].'"></td>

															<td>'.$row["email"].'</td>
															<td>'.$durum.'</td>
															<td>'.$row["ulkeAdi"].'</td>
															<td>
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirTip\').val(\'1\'); $(\'#kaldirId\').val(\''.$id.'\'); $(\'#kaldirEmail\').val(\''.$row["email"].'\');" title="Bu fuarı kaldır" data-original-title="Bu fuarı kaldır"><i class="fa fa-trash"></i></a>
															</td> 

														</tr>';

													}else

													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox" class="checks" name="emails[]" value="'.$row["email"].'"></td>

															<td>'.$row["email"].'</td>
															<td>'.$durum.'</td>
															<td>'.$row["ulkeAdi"].'</td>
															<td></td> 

														</tr>';

													}

													  

												 }

											}

								

											

								$query = $dbpdo->query("SELECT  (select count(*) as sayi from banned_emails where email=a.email) as bvarmi,(select count(*) as sayi from bultenGrupEmail where gid='".$id."' AND email=a.email) as varmi,a.* FROM users a where email LIKE '%@%'", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

													

													if(intval($row["bvarmi"])>0)

													{

														echo '<tr id="row_'.$row["id"].'">

															<td><input type="checkbox" disabled value="'.$row["email"].'"></td>

															<td title="Ebülten aboneliğinden çıktı"><font color="red">'.$row["email"].'</font></td>

															<td></td> 
															<td></td>
															<td></td> 

														</tr>';

													}else if(intval($row["varmi"])>0)

													{

														echo '<tr id="row_'.$row["username"].'">

															<td><input type="checkbox" class="checks" checked="true" name="emails[]" value="'.$row["email"].'"></td>

															<td>'.$row["email"].'</td>
															<td></td> 
															<td></td>

													<td>
													<a class="btn btn-danger btn-icon btn-xs tip" data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirTip\').val(\'2\'); $(\'#kaldirId\').val(\''.$id.'\'); $(\'#kaldirEmail\').val(\''.$row["username"].'\');" title="Bu fuarı kaldır" data-original-title="Bu fuarı kaldır"><i class="fa fa-trash"></i></a>
													
													</td> 

														</tr>';

													}else

													{

														echo '<tr id="row_'.$row["username"].'">

															<td><input type="checkbox" class="checks" name="emails[]" value="'.$row["email"].'"></td>

															<td>'.$row["email"].'</td>
															<td></td> 
															<td></td>
															<td></td> 

														</tr>';

													}

													  

												 }

											}

								

							?>

                            

                             

                        </tbody>

                    </table>

					<div class="form-actions text-right">

                            <button type="submit" class="btn btn-info">Kaydet</button>

                        </div>

				</div>
				<?
				if(MODUL_EBULTEN==1)
				{
				?>
				<textarea name="emailler" id="emailler" class="form-control"></textarea>
				<button type="button" onclick="mailEkle();" class="btn btn-success">Ekle</button>
				<?
				}
				?>
				</div>

					</form>
<script>
function mailEkle(){
	$.post("mail",{islem: "mailEkle", emailler: $("#emailler").val(), ajax: 'true'},function(result){
		
		alert(result);
	});
	
}
$("#checkAll").change(function () {
    $(".checks").prop('checked', $(this).prop("checked"));
});
$('#tablo1').dataTable({
    aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: -1
});
</script>

				<?

			}else if($islem=="ebultenEdit"){

				

				echo '<form class="form-horizontal" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Ebülten Oluştur</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="emailGonder">

                        

						<div class="form-group">

                             <label class="col-sm-2 control-label">Konu: </label>

							<div class="col-sm-10">

                               <input type="text" class="form-control" name="subject" id="subject" required>

                            </div>

							 

						</div>	

                        <div class="form-group">

                            <div class="col-sm-12">

                                <textarea id="ebulten2" name="ebulten" rows="20"></textarea>

                            </div>

							 

						</div>	

						

						<div class="form-actions text-right">

                            <button type="button" onclick="TestGonder('.$id.')" class="btn btn-primary">Test Gönder</button>

							<button type="button" onclick="grubaGonder('.$id.')" class="btn btn-info">Gruba Gönder</button>

                        </div>

					</div>

				</div>

			</form>';



?>
<a data-toggle="modal" role="button" href="#default_modal" id="default_modal_a"></a>
<div id="default_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h5 class="modal-title">İhracat Yönetimi Mesaj</h5>
                        </div>

                        <div class="modal-body has-padding">
                            <h5 class="text-error">Mail gönderim talebiniz başarıyla gerçekleştirildi</h5>
                            <p>İşleminize devam etmek istediğiniz menüleri aşağıdaki alandan seçebilirsiniz.</p>

                            
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                            <button type="button" class="btn btn-primary">Raporu Görüntüle</button>
							<button type="button" class="btn btn-info">Gruplara Dön</button>
                        </div>
                    </div>
                </div>
            </div>
<script>



	function TestGonder(gid)
	{
		var subject=document.getElementById("subject").value;
		var ebulten = document.getElementById("ebulten2_ifr").contentWindow.document.body.innerHTML;

		if(subject!="" && ebulten!="")
		{
			if(confirm("Test Maili Göndermek İstediğinizden Emin misiniz?"))
			{				
				$.post("mail",{islem: "testGonder",gid: gid, subject: subject, mesaj: ebulten, ajax: 'true'},function(result){

						

						if(result=="OK")

						{

							$("#default_modal_a").click();

						}else

						{

							alert(result);

						}

						

					});

			}

		}else

		{

			alert("Lütfen başlık ve bülten içeriği girin");

		}

		

	}

	function grubaGonder(gid)
	{
		var subject=$("#subject").val();

		var ebulten = document.getElementById("ebulten2_ifr").contentWindow.document.body.innerHTML;

		

		if(subject!="" && ebulten!="")

		{

			if(confirm("Gruba Mail Göndermek İstediğinizden Emin misiniz?"))

			{

				$("#preloader").fadeIn("fast");
				$("#status").fadeIn("fast");

				$.post("mail",{islem: "grubaGonder",gid: gid, subject: subject, mesaj: ebulten, ajax: 'true'},function(result){

						

						if(result=="OK")

						{

							alert("Gönderildi");
							window.location.href='<?='mail?'.URL::encode("?islem=ebultenRapor&id=".$id).''?>';

						}else

						{

							alert(result);

						}

						$("#preloader").fadeOut("fast");
						$("#status").fadeOut("fast");

					});

			}

		}else

		{

			alert("Lütfen başlık ve bülten içeriği girin");

		}

		

	}

	

</script>

<?			

			}else if($islem=="ebultenRapor"){

				

				$imgspath    = 'mailing_list/';

				$files = scandir($imgspath); 

				$total = count($files); 

				$liste = array(); 

				if($total>0)

				{

					 

					

					echo '<div class="panel panel-default">

								<div class="panel-heading"><h6 class="panel-title">Ebülten Listesi</h6></div>

									<div class="panel-body"><table class="table table-condensed">

                        <thead>
                            <tr>
                                <th>Tarih</th>
								<th>Konu</th>
								<th>Toplam Mail</th>
                                <th class="col-sm-1">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>';

					for($x = 0; $x <= $total; $x++){

						if ($files[$x] != '.' && $files[$x] != '..')

						{ 

							$grupBul = explode("_",$files[$x]);

							if($grupBul[1]==$id)

							{

								$baslik = substr($grupBul[4],0,-4);
								
								echo "<tr id='row_".$x."'>
										<td>".date("d.m.Y H:i",strtotime($grupBul[2]))."</td>
										<td>".$baslik."</td>
										<td>".$grupBul[3].'</td>
										<td>
										<a href="mail?'.URL::encode("?islem=ebultenRapor&id=".$id."&toplamMail=".$grupBul[3]."&islem2=".$files[$x]."").'" class="btn btn-success btn-icon btn-xs tip"><i class="fa fa-eye"></i></a>
										<a href="javascript:;" onclick="RaporKaldir(\''.$files[$x].'\','.$x.')" class="btn btn-danger btn-icon btn-xs tip"><i class="fa fa-trash"></i></a>
										</td>
								';

							}

						}	

					}

					echo "</tbody>
					</table>
					
				</div>
			</div>";

					

					if($islem2!="")

					{

						echo '<div class="panel panel-default">

								<div class="panel-heading"><h6 class="panel-title">Ebülten Raporu</h6></div>

									<div class="panel-body">';

						$a=explode("\n",file_get_contents("mailing_list/".$islem2, FILE_USE_INCLUDE_PATH));

						

						$toplamEmail = tabloKayitSayisi("bultenGrupEmail","where gid=".$id);

						

						

						?>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart']});

      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {



        var data = google.visualization.arrayToDataTable([

          ['Task', 'Sayısı'],

          ['Açılmayan Mailler',    parseInt('<?=$toplamMail-(count($a)-1)?>')],

          ['Açılan Mailler',      parseInt('<?=count($a)-1?>')]

        ]);



        var options = {

          title: 'Ebülten Grafik'

        };



        var chart = new google.visualization.PieChart(document.getElementById('piechart'));



        chart.draw(data, options);

      }

    </script>

						

						<div id="piechart" style="width: 900px; height: 500px;"></div>

						<?

						echo ' 

							</div>

						</div>

						';

					}

				}

				

				

				

				

				

				//$file = file_get_contents('mailing_list/email_'.$id.'.txt', FILE_USE_INCLUDE_PATH);

				//$file = explode("\n",$file);

				

				

				

			}

if(!in_array($_REQUEST["islem"],array("detay","GorusmeYap","ebultenEdit","ebultenRapor")))

{

				echo '<form action="mail" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">

               <!-- Basic inputs -->

                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Grup Oluştur</h6></div>

                    <div class="panel-body">

						<input type="hidden" name="islem" value="grupKayit">

                        

                        <div class="form-group">

                            <label class="col-sm-2 control-label">Grup Adı: </label>

                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="adi" required>

                            </div>

							 <label class="col-sm-2 control-label">Sıra: </label>

                            <div class="col-sm-4">

                               <input type="text" class="form-control" name="sira">

                            </div>

						</div>	

						

						<div class="form-actions text-right">

                            <button type="submit" class="btn btn-primary">Kaydet</button>

                        </div>

					</div>

				</div>

			</form>'; 

				

			?>

			<div class="panel panel-default">

                <div class="panel-heading"><h6 class="panel-title">Mail Grup Listeleri</h6>

				<?='<span style="float:right"><button type="button" class="btn btn-xs btn-success btn-right-icon dropdown-toggle" onclick="$(\'.firmaKayitForm\').slideToggle();"><i class="fa fa-plus"></i>Grup Ekle</button>'?>

				</div>

				

				

					<div class="datatable">

                    <table class="table table-condensed">

                        <thead>

                            <tr>

                                <th class="col-sm-1">Sıra</th>

                                <th>Grup Adı</th>

                                <th class="col-sm-2">Email Sayısı</th> 

								<th class="col-sm-1">İşlemler</th>

								

                            </tr>

                        </thead>

                        

                        <tbody>

							<?

							

							$query = $dbpdo->query("SELECT (select count(*) as sayi from bultenGrupEmail where gid=a.id) as sayi, a.* FROM bultenGrup a", PDO::FETCH_ASSOC);

											if ( $query->rowCount() ){

												 foreach( $query as $row ){

													

													  echo '<tr id="row_'.$row["id"].'">

															<td>'.$row["sira"].'</td>

															<td>'.$row["adi"].'</td>

															<td>'.$row["sayi"].'</td>

															<td>

															<a href="mail?'.URL::encode("?islem=detay&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip" title="E-mail Listesi" data-original-title="Email Listesi"><i class="fa fa-edit"></i></a>

															<a href="mail?'.URL::encode("?islem=ebultenEdit&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip" title="Ebülten Oluştur" data-original-title="E-mail Gönder"><i class="fa fa-envelope-o"></i></a>

															<a href="mail?'.URL::encode("?islem=ebultenRapor&id=".$row["id"].$ek).'" class="btn btn-success btn-icon btn-xs tip" title="Email Rapor" data-original-title="E-mail Rapor"><i class="fa fa fa-pie-chart"></i></a>
															<a class="btn btn-danger btn-icon btn-xs tip " data-toggle="modal" role="button" href="#kaldirModel" onclick="$(\'#kaldirTip\').val(\'3\'); $(\'#kaldirId\').val(\''.$row["id"].'\'); $(\'#kaldirEmail\').val(\'\');" title="Bu fuarı kaldır" data-original-title="Bu fuarı kaldır"><i class="fa fa-trash"></i></a>
																																							

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
							<input type="hidden" value="" id="kaldirEmail">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default KaldirButton" data-dismiss="modal">Hayır</button>
                            <button type="button" onclick="Kaldir($(\'#kaldirTip\').val(),$(\'#kaldirId\').val(),$(\'#kaldirEmail\').val());" class="btn btn-warning">Evet</button>
                        </div>
                    </div>
                </div>
            </div>';
?>

<script>
function Kaldir(tip, id, email)
	{
			
			$.post("mail",{islem: "grupKaldir", email: email, tip: tip, id: id, ajax: 'true'},function(result){
					if(result=="OK")
					{
						$("#row_"+id).fadeOut("slow");
					}else
						alert(result);
				});
		$(".KaldirButton").click();

	}
function RaporKaldir(link,id)
	{
		if(confirm("Raporu kaldırılacaktır. Devam etmek için tamam butonuna basınız!")){
			
			$.post("mail",{islem: "linkKaldir", link: link, ajax: 'true'},function(result){
				$("#row_"+id).fadeOut("slow");
				//alert(result+" "+id+" "+link);
			})
		}
	}
</script>
<?

include "../../inc.footer.php";

?>