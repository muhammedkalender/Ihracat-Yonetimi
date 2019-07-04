<?php
require 'class.phpmailer.php';
include "functions.runtime.php";
// GENEL Tanımlamalar
function EmailGrupAdi($id)
{
	$d=mysql_query("select * from bultenGrup where id='$id'");
	$og=mysql_fetch_object($d);
	
	return $og->adi;
}
function sikayetDurum($i){
	if($i==0)
		return "Beklemede";
	elseif($i==1)
		return "İşlem Başlatıldı";
	elseif($i==2)
		return "İşlem Tamamlandı";	
	else
		return "Kapatıldı";
	
}
function tabloKayitSayisi($tabloAdi,$eksql){
	$d=mysql_query("select * from ".$tabloAdi." ".$eksql);
	return mysql_num_rows($d);
}
function OnemDerece($i)
{
	if($i==0)
		return "Düşük";
	else if($i==5)
		return "Orta";
	else if($i==10)
		return "Yüksek";
	else
		return "Belirlenmedi";
}
function OnemDereceTarih($tarih,$onem)
{
	$d=mysql_query("select * from ayarlar where name='dusuk'");
	$o1=mysql_fetch_object($d);
	$dusuk=intval($o1->value);
	
	$d=mysql_query("select * from ayarlar where name='orta'");
	$o1=mysql_fetch_object($d);
	$orta=intval($o1->value);
	
	$d=mysql_query("select * from ayarlar where name='yuksek'");
	$o1=mysql_fetch_object($d);
	$yuksek=intval($o1->value);
	
	if($dusuk==0)
		$dusuk=21;
	if($orta==0)
		$orta=14;
	if($yuksek==0)
		$yuksek=7;
	$i=0;
	if($tarih=="-")
		return "";
	if($onem==10 AND ((time()-strtotime($tarih))/(60*60*24))>$yuksek)
		$i=1;
	else if($onem==5 AND ((time()-strtotime($tarih))/(60*60*24))>$orta)
		$i=1;
	else if($onem==0 AND ((time()-strtotime($tarih))/(60*60*24))>$dusuk)
		$i=1;
	if($i==1)
	return '<i class="fa fa-phone-square"></i>';
	else
	return "";
	
}
function toplamFirmaSayisi($sahibi)
{
	$d=mysql_query("select * from firma where sahibi='$sahibi'");
	return mysql_num_rows($d);
}
function paraBirim($i)
{
	if($i=="TL")
	{
		return "&#x20BA;";
	}else if($i=="EURO")
	{
		return "&#8364;";
	}else if($i=="DOLAR")
	{
		return "$";
	}else if($i=="GBP")
	{
		return "&#163;";
	}
	
	
}
function select_paraBirimList($name, $select=false)
{
	$sl=array();
	if($select)
	$sl[$select]="selected";
	return '<select    data-placeholder="Birim seçin..." name="'.$name.'" class="form-control" tabindex="2">
		<option '.$sl["&#x20BA;"].'>&#x20BA;</option>
		<option '.$sl["&#8364;"].'>&#8364;</option>
		<option '.$sl["$"].'>$</option>
		<option '.$sl["&#163;"].'>&#163;</option>
	</select>';

}
function toplamDetaySayisi($sahibi)
{
	$d=mysql_query("select * from firmaGorusme where islemiYapan='$sahibi'");
	return mysql_num_rows($d);
}
function KullaniciSayisi()
{
	return mysql_num_rows(mysql_query("select * from users"));
}
function BayrakGetir($id)
{
	if($id!="")
	{
		return '<img src="/images/bayrak/'.$id.'.png">';
	}
	else
		return "";
}
function kaynakBul($kaynak)
{
	global $dbpdo;	
	$query = $dbpdo->query("SELECT * FROM kaynak", PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												 foreach( $query as $row ){
													  if($row["id"]==$kaynak)
														  return $row["adi"];
													}
											}
											
					return "";
}
function firmaKayit(){
global $dbpdo, $session;	
	$html = '<form action="anasayfa" class="form-horizontal firmaKayitForm" id="firmaKayitForm" role="form" method="post">
               <!-- Basic inputs -->
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Firma Oluştur</h6></div>
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
							 <label class="col-sm-2 control-label">Kaynak: </label>
                            <div class="col-sm-4">
                                <select name="kaynak" class="select-search"  required>
									';
									$query = $dbpdo->query("SELECT * FROM kaynak", PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												 foreach( $query as $row ){
													  $html .= '<option value="'.$row['id'].'">'.$row['adi'].'</option> ';
												 }
											}
									$html .='
								</select>
                            </div>
						</div>	
						<div class="form-group">
									<label class="col-sm-2 control-label">Telefon: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="telefon">
                            </div>
                                    <label class="col-sm-2 control-label">Ülke: </label>
                                    <div class="col-sm-4">
                                        <select data-placeholder="Ülke seçin..." name="ulke" class="select-search" tabindex="2"  required>
                                            <option value=""></option> ';
                                           
											$query = $dbpdo->query("SELECT * FROM Ulke", PDO::FETCH_ASSOC);
											if ( $query->rowCount() ){
												 foreach( $query as $row ){
													  $html .= '<option value="'.$row['id'].'">'.$row['ulke'].'</option> ';
												 }
											}
											
                                        $html .=' </select>
                                    </div>
						
                         </div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Email: </label>
									<div class="col-sm-4">
										<input type="email" class="form-control" name="email">
									</div>
									<div class="col-md-2">
                                <b>Önem</b>
                            </div>
							<div class="col-md-4">
                                 <select data-placeholder="Önem Derece seçin..." name="derece" class="select-search" tabindex="2">
										<option '.$op[1].' value="0">Düşük</option>
										<option '.$op[2].' value="5">Orta</option>
										<option '.$op[3].' value="10">Yüksek</option>
									   </select>
                            </div>
							
                        </div>
						<div class="form-group">
									<label class="col-sm-2 control-label">İlgili Kişi: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="ilgiliKisi">
									</div>
									<label class="col-sm-2 control-label">Websitesi: </label>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="website">
									</div>
                               
                        </div>
						';
						
						if($session->userlevel>=5){
							$html .= '<div class="form-group">
							<div class="col-md-2">
                                <b>Sahibi</b>
                            </div>
                            <div class="col-md-4">
                                <span class="form-span">'.$o->sahibi.'</span>
								<select name="sahibi" class="select-search">
									<option value="">Lütfen Seçiniz</option>
									';
										$dd=mysql_query("select * from users");
										while($ou=mysql_fetch_object($dd))
										{
												
											$html .= '<option  value="'.$ou->username.'">'.$ou->adi." ".$ou->soyadi.'</option>';
										}
									$html .='
								</select>
								
                            </div>
							
                        </div>';
						}
						$html .='
						<div class="form-group">
                            <label class="col-sm-2 control-label">Adres: </label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="adres" rows="3"></textarea>
                            </div>
                        </div>
						<div class="form-actions text-right">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
					</div>
				</div>
			</form>';
			
			
			return $html;
}
 
function GirisYapmisMi() {
	global $session;
	if ($session->logged_in) {
		return true;
	}else{
		header("Location: /login?".URL::encode("?git=".base64_decode(Adres()).""));
		exit();
	}
}
function getRealIpAddr()  
{  
    if (!empty($_SERVER['HTTP_CLIENT_IP']))  
    {  
        $ip=$_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //Proxy den bağlanıyorsa gerçek IP yi alır.
     
    {  
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    else  
    {  
        $ip=$_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}  
function LogTut($yazi)
{
global $session;

	$kullan=$session->username;
	

if (!empty($_SERVER['HTTP_CLIENT_IP']))  
    {  
        $ip=$_SERVER['HTTP_CLIENT_IP'];  
    }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //Proxy den bağlanıyorsa gerçek IP yi alır.
     
    {  
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    else  
    {  
        $ip=$_SERVER['REMOTE_ADDR'];  
    }  


	if(mysql_query("insert into Log_ set log = '$yazi',kullanici='$kullan', zaman = '".time()."', ip = '$ip'"))
	{
	
	}
}


function GirisYapan() {
	global $session;
	if ($session->logged_in) {
		$q = mysql_query("select * from users where username = '".$session->username."'");
		$a = mysql_fetch_array($q);
		return array(
			'email' => $a["email"],
			'adi' => $a["adi"],
			'soyadi' => $a["soyadi"],
			'unvan' => $a["unvan"],
			'gorev' => $a["gorev"],
			'amir' => $a["amir"],
			'cinsiyet' => $a["cinsiyet"],
			'dogumtarihi' => $a["dogumtarihi"],
			'fotograf' => $a["fotograf"],
			'alan' => $a["alan"]
		);
	}
}
 
function AdminAlani() {
	global $session;
	if ($session->userlevel < 5) {
		header("Location: /login");
		exit();
	}
}
function ZorunluAlan($mesaj=false) {
	if ($mesaj !== false) {
		$mesaj = $mesaj;
	}else{
		$mesaj = "Lütfen bu alanı doldurunuz";
	}
	return "{validate:{required:true, messages:{required:'".$mesaj."'}}}";
}
function PhpSelf() {
	return $_SERVER["PHP_SELF"];
}
function Adres() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return base64_encode($pageURL);
}
function SubmitButton($str,$renk="",$disabled="") {
	if ($renk == "yesil") {
		$class = " green";
	}elseif ($renk == "mavi") {
		$class = " blue";
	}elseif ($renk == "turuncu") {
		$class = " orange";
	}elseif ($renk == "kirmizi") {
		$class = " red";
	}else{
		$class = "";
	}
	return '<button type="submit" id="submit" class="loading '.$class.'"'.$disabled.'><span>'.$str.'</span></button>';
}
  
function DeleteButton($href,$onclick,$class,$id,$width="16") {
	
	return '<a href="'.$href.'" onclick="'.$onclick.'" class="item small loading '.$class.'" '.$id.'><img src="/gfx/icons/small/cancel.png" alt="Cancel" width="'.$width.'" /></a>';
}
function OnayButton($href,$onclick,$class,$id,$width="16") {
	
	return '<a href="'.$href.'" onclick="'.$onclick.'" class="item small loading '.$class.'" '.$id.'><img src="/gfx/icons/small/check.png" alt="Cancel" width="'.$width.'" /></a>';
}
function CheckButton($href,$onclick,$class,$id,$width="16") {
	
//return '<a href="'.$href.'" class="item small"  id="'.$id.'"><img src="/gfx/icons/small/edit.png" alt="Cancel" width="'.$width.'" /></a>';	
	return '<a href="'.$href.'"  class="item small" id="'.$id.'"><img src="/gfx/icons/small/check.png" alt="Cancel" width="'.$width.'" /></a>';
}
 
function EditButton($href,$onclick,$class,$id,$width="16") {
	
	
	return '<a href="'.$href.'" onclick="'.$onclick.'" class="item small '.$class.'" id="'.$id.'"><img src="/gfx/icons/small/edit.png" alt="Cancel" width="'.$width.'" /></a>';
}
function SearchButton($href,$onclick,$class,$id,$width="16") {
	
	
	return '<a href="'.$href.'" onclick="'.$onclick.'" class="item small '.$class.'" id="'.$id.'"><img src="/gfx/icons/small/search.png" alt="Cancel" width="'.$width.'" /></a>';
}

 
function adsoyadgorevbul($kullanici)
{
$s = @mysql_query("select adi,soyadi,gorev From users where username='$kullanici'");
$ok=@mysql_fetch_object($s);
$grv=$ok->gorev;
$se = @mysql_query("select adi From gorevler where id='$grv'");
$gorevi=@mysql_fetch_object($se);
$grev=$gorevi->adi;

if($grev!="")
return $ok->adi." ".$ok->soyadi." (".$grev.")";
else
return $ok->adi." ".$ok->soyadi;

}
function adsoyadnoktali($kullanici)
{
$s = @mysql_query("select adi,soyadi,gorev From users where username='$kullanici'");
$ok=@mysql_fetch_object($s);

    $ilkKarakter= mb_substr($ok->adi, 0, 1, "UTF-8");

	return $ilkKarakter.". ".$ok->soyadi;

}
 
function adsoyadbul($kullanici){
$s = @mysql_query("select adi,soyadi,gorev From users where username='$kullanici'");
$ok=@mysql_fetch_object($s);


$strn=$ok->adi." ".$ok->soyadi;

return $strn;
}
 
function gorevbul($surecadi)
{

	$q = mysql_query("select gorev from users WHERE username = '$surecadi'");
		$a = mysql_fetch_object($q);
			$SurecIdx=$a->gorev;

return ($SurecIdx);
		

} 
function ReloadButton() {
	return '<span style="padding-left: 20px;"><a href="'.Phpself().'?" class="loading" ><img src="/gfx/icons/small/reload.png" alt="yenile" width="10" class="tip-s" original-title="'.dil_tabloyuyenile_tip.'" /></a></span>';
}

function BreadCrumb($linkler) {
	return '
	<div id="breadcrumbs">
		<ul>
			<li></li>
			<li><a href="/">Anasayfa</a></li>
			'.$linkler.'
		</ul>
	</div>
	';
}
function UsernameAdiSoyadi($u) {
	$q = mysql_query("select adi, soyadi from users where username = '$u'");
	$a = mysql_fetch_object($q);
	return "".$a->adi." ".$a->soyadi."";
}
function UsernameGorev($u) {
	$q = mysql_query("select gorev from users where username = '$u'");
	$a = mysql_fetch_object($q);
	return "".GorevAdiBul($a->gorev)."";
}
function UnvanAdiBul($id) {
	$q = mysql_query("select adi from unvanlar where id = '$id'");
	$a = mysql_fetch_object($q);
	return $a->adi;
}
function UnvanAdiKisiBul($id) {
	$q = mysql_query("select adi, soyadi from users where unvan = '$id'");
	$a = mysql_fetch_object($q);
	return "".$a->adi." ".$a->soyadi."";
}
function GorevAdiBul($id) {
	$q = mysql_query("select adi from gorevler where id = '$id'");
	$a = mysql_fetch_object($q);
	return $a->adi;
}
function GorevAdiKisiBul($id) {
	$q = mysql_query("select adi, soyadi from users where gorev = '$id'");
	$a = mysql_fetch_object($q);
	return "".$a->adi." ".$a->soyadi."";
}
 
function EncodeUrl($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}

function DecodeUrl($input)
{
    return "&".base64_decode(strtr($input, '-_,', '+/='));
}
function SoruIsareti($str) {
	return "<img src='/gfx/FAQ-icon16px.png' class='tipsari' original-title=\"".$str."\" />";
}
function Tarih($linuxtime,$format="d.m.Y") {
	if ($linuxtime == "0") {
		return "---";
	}else{
		return date($format, $linuxtime);
	}
}
 
Function Mailbul($username)
{

	$vq = mysql_query("select email from users where username = '".$username."'");
	$v = mysql_fetch_object($vq);
	 return $v->email;


}
 function MailGonder2($to,$date,$startTime,$endTime,$subject,$desc,$location)
{
	
	$headers='Content-type: text/calendar; charset=utf-8';
   // $headers = 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
    //$headers .= "Content-Type: text/plain;charset=\"utf-8\"\r\n"; #EDIT: TYPO
	$headers .='Content-Disposition: inline; charset=utf-8; filename=calendar.ics';
	$message ="BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "onlinekalite.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$date."T".$startTime."00Z
DTEND:".$date."T".$endTime."00Z
SUMMARY:".$subject."
DESCRIPTION:".$desc."
LOCATION:".$location.";
END:VEVENT
END:VCALENDAR";

    $headers .= $message;
    mail($to, $subject, $message, $headers);    

}
function MailGonder($to,$subject,$mesaj,$attachement=false,$mailId=false) {
	
	$mail = new PHPMailer;

		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->Host = MAIL_HOST;                 // Specify main and backup server
		$mail->Port = MAIL_PORT;                                    // Set the SMTP port
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = MAIL_USERNAME;                // SMTP username
		$mail->Password = MAIL_PASSWORD;                  // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

		$mail->From = MAIL_FROM;
		$mail->FromName = MAIL_FROM_NAME;
		$mail->AddAddress($to);  // Add a recipient
		$mail->IsHTML(true);                                  // Set email format to HTML
		
		if($mailId)
			$ek="<img border='0' src='".BASEURL."/mailchecker?"."subject=".$subject."&mail=".$to."&mailId=".$mailId."&id=".rand(111, 999).rand(111, 999)."' width='1' height='1' alt='image for email' >";
		else
			$ek="";
			$style='<style>.mail-footer{text-align:center;font-size:12px;color:#333;}.mail-footer a {color:#111; text-decoration:none;}</style>';
		
		$mail->Subject = $subject;
		$mail->Body    = preg_replace('/\\\\/','', $mesaj).$ek.$style;
		$mail->AltBody = "Bu maili görüntülemek için HTML görüntüleyi kullanın";
		
		if ($attachement) {
			$mail->AddAttachment($attachement);
		}
		if(!$mail->Send()) {
		   return 'Message could not be sent.'.'Mailer Error: ' . $mail->ErrorInfo;
		   
		   
		}else
			return "OK";
		
}
function Yonlendir($adres,$saniye) {
	return '
	<script>window.top.location = \''.$adres.'\';</script>
	<meta http-equiv=\'refresh\' content=\''.$saniye.';URL='.$adres.'\' />
	';
}
function Yonlendir_Jquery($url,$time) {
	return '
	 <script type="text/javascript">
		var settimmer = 0;
		$(function(){
				window.setInterval(function() {
					var timeCounter = $("b[id=show-time]").html();
					var updateTime = eval(timeCounter)- eval(1);
					$("b[id=show-time]").html(updateTime);

					if(updateTime <= 0){
						$("#my-timer").hide();
						window.location = "'.$url.'";
					}
					
				}, 1000);

		});
	</script>
	<div id="my-timer"><b id="show-time">'.$time.'</b> saniye içerisinde otomatik olarak yönleneceksiniz.</div>
	';
}
  

function AyAdi($i) {
	if ($i == "1") {
		return "Ocak";
	}elseif ($i == "2") {
		return "Şubat";
	}elseif ($i == "3") {
		return "Mart";
	}elseif ($i == "4") {
		return "Nisan";
	}elseif ($i == "5") {
		return "Mayıs";
	}elseif ($i == "6") {
		return "Haziran";
	}elseif ($i == "7") {
		return "Temmuz";
	}elseif ($i == "8") {
		return "Ağustos";
	}elseif ($i == "9") {
		return "Eylül";
	}elseif ($i == "10") {
		return "Ekim";
	}elseif ($i == "11") {
		return "Kasım";
	} elseif ($i == "12") {
		return "Aralık";
	} 
}
 
function AyAdiniSayiyaCevir($ay) {
	if ($ay == "Ocak") {
		return "1";
	}elseif ($ay == "Şubat") {
		return "2";
	}elseif ($ay == "Mart") {
		return "3";
	}elseif ($ay == "Nisan") {
		return "4";
	}elseif ($ay == "Mayıs") {
		return "5";
	}elseif ($ay == "Haziran") {
		return "6";
	}elseif ($ay == "Temmuz") {
		return "7";
	}elseif ($ay == "Ağustos") {
		return "8";
	}elseif ($ay == "Eylül") {
		return "9";
	}elseif ($ay == "Ekim") {
		return "10";
	}elseif ($ay == "Kasım") {
		return "11";
	}elseif ($ay == "Aralık") {
		return "12";
	}
}
 

class Uyarilar {
	
	function Basarili($str) {
		return '<div class="alert alert-success fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-check"></i> '.$str.'
                    </div>
				';
	}
	function Hata($str) {
		return '<div class="alert alert-danger fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-warning"></i> '.$str.'
                    </div>
				';
	}
	function Uyari($str) {
		return '<div class="alert alert-warning fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-info"></i> '.$str.'
                    </div>
				';
	}
	function Bilgi($str) {
		return '<div class="alert alert-info fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-info"></i> '.$str.'
                    </div>
				';
	}
	function Deger($str)
	{
		if(intval($str)>=75)
			$classes="danger";
		else if(intval($str)<75 and intval($str)>=50)
			$classes="warning";
		else if(intval($str)<50 and intval($str)>=25)
			$classes="info";
		else if(intval($str)<25)
			$classes="success";
		
		return '<div class="progress widget-inner">
                            <div class="progress-bar progress-bar-'.$classes.'" role="progressbar" aria-valuenow="'.$str.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$str.'%;">
                                '.$str.'%
                            </div>
                        </div>';
	}
}

class CssUyari {
	
	function Basarili($str) {
		return '<div class="bg-success has-padding widget-inner">'.$str.'</div>';
	}
	function Hata($str) {
		return '<div class="bg-error has-padding widget-inner">'.$str.'</div>';
	}
	function Uyari($str) {
		return '<div class="bg-warning has-padding widget-inner">'.$str.'</div>';
	}
	function Bilgi($str) {
		return '<div class="bg-info has-padding widget-inner">'.$str.'</div>';
	}
	
}
/**
 * URL şifreleme & güvenlik sınıfı
 * https://github.com/DouglasMedeiros/Encrypt-URL-for-PHP
 * URL::encode("?islem=1&id=2"); mutlaka ? işareti ile başlamalı
**/
class URL {
        private static $key = SECRET;
        private static $size = 16;
        

        static function encode($string)
        {
                $string = gzcompress($string) . "\x13";
                $n = strlen($string);

                if($n % 16)
                {
                        $string .= str_repeat("\0", 16 - ($n % 16));
                }
                
                $i = 0;
                $enc_text = self::randomize();
                $iv = substr(self::$key ^ $enc_text, 0, 512);
                
                while ($i < $n)
                {
                        $block = substr($string, $i, 16) ^ pack('H*', md5($iv));
                        $enc_text .= $block;
                        $iv = substr($block . $iv, 0, 512) ^ self::$key;
                        $i += 16;
                }
                
                return urlencode(base64_encode(base64_encode($enc_text)));
        }
        
        static function decode()
        {
                $string = $_SERVER['QUERY_STRING'];
                
                if(strlen($string) > 0)
                {
                        $string = base64_decode(base64_decode($string));
                        $n = strlen($string);
                        $i = self::$size;
                        $plain_text = '';
                        $iv = substr(self::$key ^ substr($string, 0, self::$size), 0, 512);
                        
                        while ($i < $n)
                        {
                                $block = substr($string, $i, 16);
                                $plain_text .= $block ^ pack('H*', md5($iv));
                                $iv = substr($block . $iv, 0, 512) ^ self::$key;
                                $i += 16;
                        }
                        
                        $plain_text = @gzuncompress( preg_replace( '/\\x13\\x00*$/' , '' , $plain_text ) );
                        
                        if( !$plain_text )
                        {
                                //exit("URL sifrelenmeden bu sayfalar goruntulenemez");
                        }

                        $url = parse_url(urldecode( $plain_text ) );
                        $parametros = explode("&", $url['query']);
                        
                        for($i = 0; $i < count($parametros); $i++)
                        {
                                $valor = explode("=", trim( urldecode( strip_tags( $parametros[$i] ) ) ) );
                                $_REQUEST[ $valor[0] ] = $valor[1];
                        }
                        
                        unset( $_REQUEST[ urldecode($_SERVER['QUERY_STRING']) ] );
                }
        }
        
        private static function randomize()
        {
                $iv = '';
                $i = 0;
                while($i < self::$size)
                {
                        $iv .= chr(mt_rand() & 0xff);
                        $i++;
                }
                return $iv;
        }
}

$uyari = new Uyarilar();
$uyariCss = new CssUyari();







function GetTableValue($column,$table,$where) {
	$q = mysql_query("SELECT $column FROM $table $where");
	$a = mysql_fetch_object($q);
	return $a->$column;
}
function EscapeData($data) { 
	global $database;
	if (ini_get('magic_quotes_gpc')) {
		$data = stripslashes($data);
	}
	return mysql_real_escape_string (trim ($data), $database->connection);
}

 
?>