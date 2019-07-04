<?php
include "include.php";
$lang=$session->userinfo["dil"];

unset($sayfaActive);
$sayfaActive["gorusmelerim"]="page-header-active";
include "inc.header.php";
include "inc.menu.php";
 
 foreach($_REQUEST as $input=>$value) {

	 $_REQUEST[$input] = $value;

}

// Aldığın değerleri tanımın adına döşe

foreach ($_REQUEST AS $k=>$v) $$k=$v;
?>

<div class="page-title">
    <h5 class="alert">İhracat Haberleri :</h5>

 <?php   
echo ' </div>';

	if(isset($_POST["header"]))
	{
		include("lib/class_mpdf/mpdf.php");
		
		$mpdf=new mPDF('','A4',0,'',15,15,80,25,2,10,'L');
				$header=base64_decode($_POST["header"]);
		
		$mpdf->setHTMLHeader($header);
		

			$html ='<table width="100%" border="1" cellspacing="0">
			<thead>
												<tr>
													<th colspan="6">PROFORMA INVOICE</th>
												</tr>
												<tr>
													<th>Item No</th>
													<th>Picture</th>
													<th>Description of Material</th>
													<th>Quantity</th>
													<th>Unit Price <br>('.$currency.')</th>
													<th>Amount <br>('.$currency.')</th>
												</tr>
											</thead>
											<tbody>
				';
			
			$i=1;
			$toplam=0;
				foreach($productNo as $key=>$value){
					
					if($picture[$key]!="")
						$resim='<a href="'.$picture[$key].'"><img src="'.$picture[$key].'" width="100px"></a>';
					else
						$resim="";
					
					$html .= '<tr>
						<td align="center">'.($i++).'</td>
						<td>'.$resim.'</td>
						<td>'.$description[$key].'</td>
						<td align="center">'.$quantity[$key].'</td>
						<td align="center">'.$unit[$key].'</td>
						<td align="center">'.floatval($quantity[$key]*$unit[$key]).'</td>
					</tr>';
					$toplam +=floatval($quantity[$key]*$unit[$key]);
				}
				$html .= '<tr>
						<td align="right" colspan="5">TOTAL FCA/ ( '.$currency.' )</td>
						<td align="center">'.$toplam.'</td>
					</tr>';
				$html .='<tbody></table>';
				
				
				$html .='<table width="100%">
							<tr>
								<td><br>'.$footer.'
								</td>
							</tr>
						</table>';
		$mpdf->setFooter('');
		$mpdf->WriteHTML($html);
		$dosyaAdi="Proforma_".time();
		
		
		$mpdf->Output("upload/".$dosyaAdi.".pdf", "F");
		echo '<iframe src="upload/'.$dosyaAdi.'.pdf" width=100% height="800px;">';
		
	}
include "inc.footer.php";
?>