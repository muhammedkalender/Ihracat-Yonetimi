<?
function seo($s) {
 $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',');
 $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','');
 $s = str_replace($tr,$eng,$s);
 $s = strtolower($s);
 $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
 $s = preg_replace('/\s+/', '-', $s);
 $s = preg_replace('|-+|', '-', $s);
 $s = preg_replace('/#/', '', $s);
 $s = str_replace('.', '', $s);
 $s = trim($s, '-');
 return $s;
}


$id = $_GET['id'];
$checkid = "Id:" . $id;
$email = $_GET['mail'];
$sub = $_GET['subject'];
$date = $_GET['tarih'];
$fh = fopen("mailing_list/email_".$_GET["mailId"]."_".$_GET["tarih"]."_".$_GET["tm"]."_".seo($sub).".txt", "a+"); //file handler
$a = fgets($fh);
$found = false; // init as false
while (($buffer = fgets($fh)) !== false) {
if (strpos($buffer, $checkid) !== false) {
$found = true;
break; // Once you find the string, you should break out the loop.
}
}
if ($found == false) {
$string = $_GET["mailId"]."/".$date."/".$email."/".$sub."/".$date."/".$id."/".$checkid."\n";
fwrite($fh, $string);
}
fclose($fh);

//Get the http URI to the image
$graphic_http = 'http://www.formget.com/tutorial/php-email-tracker/blank.gif';

//Get the filesize of the image for headers
$filesize = filesize('blank.gif');

//Now actually output the image requested, while disregarding if the database was affected
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Disposition: attachment; filename="blank.gif"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . $filesize);
readfile($graphic_http);

//All done, get out!
exit;


?>