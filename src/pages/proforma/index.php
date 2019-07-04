<?php
include "../../include.php";
$lang=$session->userinfo["dil"];


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

if(MODUL_PROFORMA!=1)
{
	echo "Proforma hazırlayabilmek için bu modülü satın almanız gerekmektedir.";
}else
{

if(BASEURL=="http://osmanlipark.ihracatyonetimi.com")
{
	$xml=simplexml_load_file(BASEURL."/osmanliproforma.xml") or die("Hata: Dosya alınamadı");
	
}else{
	$xml=simplexml_load_file(BASEURL."/proforma.xml") or die("Hata: Dosya alınamadı");
}
$header="";
?>
<div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        	<div class="panel-body">
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-md-12 control-label"><?php
										$d=mysql_query("select (select ulke from Ulke where id=a.ulke) as ulkeAdi, a.* from firma a where a.id='$id'");
										$o=mysql_fetch_object($d);
										
										$header.='<table width="100%"><tr><td valign="top"><b style="font-size:24px;">'.$o->firma.'</b><br>'.$o->faturaAdresi.'<br><b>'
													.$o->ulkeAdi."</b><br><br>"
													."<b>Tel : </b>".$o->telefon
													."<br><b>Mobile : </b>".$o->mobile
													."<br><b>Fax : </b>".$o->fax
													."<br><b>E-mail : </b>".$o->email
													."<br><b>Attn. : </b>".$o->ilgiliKisi
													."<br><b>From : </b>".$session->adi." ".$session->soyadi
												.'</td>
												<td><img src="'.$xml->proforma->logo.'" width="150px"></td>
												<td valign="top">'.'<b style="font-size:24px;">'.$xml->proforma->factory."</b><br>".$xml->proforma->adress."<br><b>"
										.$xml->proforma->country
										."</b><br><br><b>Tel : </b>".$xml->proforma->tel
										."<br><b>Mobile : </b>".$xml->proforma->mobile
										."<br><b>Fax : </b>".$xml->proforma->fax
										."<br><b>E-mail : </b>".$xml->proforma->email
										."<br><b>Attn. : </b>".$xml->proforma->attn
										."<br><b>From : </b>".$xml->proforma->from.'
										</td>
										</tr>
										</table>
										';
										echo "<b style='font-size:24px;'>".$o->firma."</b><br>".
										$o->faturaAdresi."<br><b>"
										.$o->ulkeAdi."</b><br><br>"
										."<b>Tel : </b>".$o->telefon
										."<br><b>Mobile : </b>".$o->mobile
										."<br><b>Fax : </b>".$o->fax
										."<br><b>E-mail : </b>".$o->email
										."<br><b>Attn. : </b>".$o->ilgiliKisi
										."<br><b>From : </b>".$session->adi." ".$session->soyadi;?></label>
									</div>
									
									
								</div>
							</div>
					</div>
				</div>
				 <div class="col-md-6">
                    <div class="panel panel-default">
                        
							<div class="panel-body">
								<div class="form-horizontal">
									<div class="form-group">
										
										<div class="col-md-6">
											<img src="<?=$xml->proforma->logo?>">
										</div>
										<div class="col-md-6">
											<?="<b style='font-size:24px;'>".$xml->proforma->factory."</b><br>".$xml->proforma->adress."<br><b>"
										.$xml->proforma->country
										."</b><br>"."<b>Tel : </b>".$xml->proforma->tel
										."<br><b>Mobile : </b>".$xml->proforma->mobile
										."<br><b>Fax : </b>".$xml->proforma->fax
										."<br><b>E-mail : </b>".$xml->proforma->email
										."<br><b>Attn. : </b>".$xml->proforma->attn
										."<br><b>From : </b>".$xml->proforma->from?>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
				
</div>
<form action="pdfOlustur" method="post">
<input type="hidden" name="header" value="<?=base64_encode($header)?>">
<input type="hidden" name="currency" value="<?=$xml->proforma->products->product[$i]->currency?>">

<div class="row">
	<div class="col-md-12">
                   
							
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-md-10 control-label text-right" >Date:</label>
										<div class="col-md-2">
											<input type="text" value="<?=date("d.m.Y")?>"  name="pro_date" class="datepicker form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-10 control-label text-right" >Ref No:</label>
										<div class="col-md-2">
											<input type="text" value="" class=" form-control"  name="pro_no">
										</div>
									</div>
								</div>
							
					
				</div>
</div>
<?
$options="";
							for($i=0; $i<count($xml->proforma->products->product); $i++)
							{
								$url=$xml->proforma->products->product[$i]->productNo."--*--".$xml->proforma->products->product[$i]->picture."--*--".$xml->proforma->products->product[$i]->description."--*--".$xml->proforma->products->product[$i]->price."--*--".$xml->proforma->products->product[$i]->currency;
								$options.='<option id="op_'.str_replace(" ","",$xml->proforma->products->product[$i]->productNo).'" value="'.$url.'">'.$xml->proforma->products->product[$i]->productNo.'</option>';
							}	
?>

<div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">PROFORMA INVOICE</h6><div class="text-right"><?='<select name="productNo" class="select-search select2-offscreen" onclick="getir(this.value);">
												<option value="">Lütfen Seçiniz</option>
												'.$options.'
											</select>'?> </div></div>
                    <div class="panel-body" id="product-list">
						
						
					</div>
</div>
<div class="row">
							<div class="col-md-12">
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-md-2 control-label" >Açıklama:</label>
											<div class="col-md-10">
												<textarea class="form-control" id="aciklama" name="footer"></textarea>
											</div>
									</div>
								</div>
							</div>
						</div>
<button class="btn btn-info">Kaydet</button>
</form>					
<script>	

	function getir(value)
	{
		if(value!="")
		{
			var xml = value.split('--*--');
		
			var picture="";
			if(xml[1]!="")
			picture='<img src="'+xml[1]+'" width=100px>';
				
			$("#product-list").append('<div class="row"><div class="form-group"><div class="col-md-1"><input type="hidden" name="picture[]" value="'+xml[1]+'">'+picture+'</div><div class="form-group"><div class="col-md-1"><input type="text" class="form-control" name="productNo[]" value="'+xml[0]+'"></div><div class="col-md-6"><input type="text" class="form-control" name="description[]" placeholder="Description of Material" value="'+xml[2]+'"></div><div class="col-md-1"><input type="text" class="form-control" name="quantity[]" id="quantity_'+xml[0]+'" onkeyup="hesapla(\''+xml[0]+'\')" placeholder="Quantity"></div><div class="col-md-1"><input type="text" class="form-control" name="unit[]"  onkeyup="hesapla(\''+xml[0]+'\')"  placeholder="Unit Price"  id="unit_'+xml[0]+'" value="'+xml[3]+'"></div><div class="col-md-2"><div class="input-group"><input type="text" class="form-control" placeholder="Amount" readonly id="amount_'+xml[0]+'"><span class="input-group-addon">'+xml[4]+'</span></div></div></div></div>');
			
			$("#op_"+xml[0]).remove();
		}
	}
	function hesapla(Id)
	{
		if($("#quantity_"+Id).val()=="")
			$("#quantity_"+Id).val(0);
		
		if($("#unit_"+Id).val()=="")
			$("#unit_"+Id).val(0);
		
		var quantity = parseFloat($("#quantity_"+Id).val());
		var unit = parseFloat($("#unit_"+Id).val());
		
		$("#amount_"+Id).val(quantity*unit);
		
	}
</script>

<script src="../../js/tinymce/tinymce.dev.js"></script>

<script src="../../js/tinymce/plugins/table/plugin.dev.js"></script>

<script src="../../js/tinymce/plugins/paste/plugin.dev.js"></script>

<script src="../../js/tinymce/plugins/spellchecker/plugin.dev.js"></script>

<script type="text/javascript" src="../../js/plugins/charts/flot.pie.js"></script>

<script type="text/javascript" src="../../js/plugins/charts/pie.js"></script>

<script>

	tinymce.init({

		selector: "textarea#aciklama",

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
<?
}


include "../../inc.footer.php";

?>