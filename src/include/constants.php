<?php
date_default_timezone_set('Europe/Istanbul');
if($_SERVER["HTTP_HOST"]=="demo.ihracatyonetimi.com")
{
define("BASEURL", "https://demo.ihracatyonetimi.com");
define("ADRES", "demo.ihracatyonetimi.com");

define("DB_SERVER", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
// Modül Yetkileri
define("MODUL_IHRACAT", "1");
}elseif($_SERVER["HTTP_HOST"]=="osmanlipark.ihracatyonetimi.com")
{
define("BASEURL", "https://osmanlipark.ihracatyonetimi.com");
define("ADRES", "osmanlipark.ihracatyonetimi.com");

define("MODUL_PROFORMA", "1");
define("DB_SERVER", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
// Modül Yetkileri
define("MODUL_IHRACAT", "1");
define("IHRACAT_XML", "1");
}elseif($_SERVER["HTTP_HOST"]=="erenler.ihracatyonetimi.com")
{
define("BASEURL", "https://erenler.ihracatyonetimi.com");
define("ADRES", "erenler.ihracatyonetimi.com");

define("DB_SERVER", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
// Modül Yetkileri
define("MODUL_IHRACAT", "1");
}elseif($_SERVER["HTTP_HOST"]=="viscotex.ihracatyonetimi.com")
{
define("BASEURL", "https://viscotex.ihracatyonetimi.com");
define("ADRES", "viscotex.ihracatyonetimi.com");

define("DB_SERVER", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
// Modül Yetkileri
define("MODUL_IHRACAT", "1");
define("MODUL_PROFORMA", "1");
}elseif($_SERVER["HTTP_HOST"]=="kms.ihracatyonetimi.com")
{
define("BASEURL", "https://kms.ihracatyonetimi.com");
define("ADRES", "kms.ihracatyonetimi.com");

define("DB_SERVER", "localhost");
define("DB_USER", "ihracaty_kms");
define("DB_PASS", "kms*2016");
define("DB_NAME", "ihracaty_kms");
// Modül Yetkileri
define("MODUL_IHRACAT", "1");
define("MODUL_PROFORMA", "0");
}elseif($_SERVER["HTTP_HOST"]=="novasta.ihracatyonetimi.com")
{
define("BASEURL", "https://novasta.ihracatyonetimi.com");
define("ADRES", "novasta.ihracatyonetimi.com");

define("DB_SERVER", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
// Modül Yetkileri
define("MODUL_IHRACAT", "1");
define("MODUL_EBULTEN", "1");
}else
{
define("BASEURL", "https://novasta.ihracatyonetimi.com");
define("ADRES", "novasta.ihracatyonetimi.com");

define("DB_SERVER", "localhost");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
}




define("TBL_USERS", "users");
define("TBL_ACTIVE_USERS",  "active_users");
define("TBL_ACTIVE_GUESTS", "active_guests");
define("TBL_BANNED_USERS",  "banned_users");


define("ADMIN_NAME", "admin");
define("GUEST_NAME", "Guest");
define("ADMIN_LEVEL", 9);
define("AUTHOR_LEVEL", 5);
define("USER_LEVEL",  1);
define("GUEST_LEVEL", 0);


define("TRACK_VISITORS", true);

define("USER_TIMEOUT", 100);
define("GUEST_TIMEOUT", 5);


define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain

define("EMAIL_FROM_NAME", "Ozkan CANDAN"); // veritabanı hatalarında, sistem altyapı ile ilgilnecek webmasterın adresi
define("EMAIL_FROM_ADDR", "ozkan@novasta.com.tr"); // veritabanı hatalarında, sistem altyapı ile ilgilnecek webmasterın adresi
define("EMAIL_WELCOME", false);


define("ALL_LOWERCASE", true);

define("ABSPATH", dirname(__FILE__).'/');

define("FIRMA_ADI", "Novasta Web Tasarım LTD ŞTİ");
define("LISANS", "İhracat Yönetimi Standart Paket");
define("SURUM", "V.01");
define("L_SURESI", "02/17/2019");

define("SECRET", "0123456789abc");

define("BASE_DIR", "/home/ihracatyonet/public_html/v1");

define("EMAIL_ADMIN", "ozkan@novasta.com.tr");
define("MAIL_HOST", "smtp.mandrillapp.com");
define("MAIL_PORT", "587");
define("MAIL_FROM", "bilgilendirme@novasta.com.tr");
define("MAIL_USERNAME", "Novasta™ | Tasarım ve Sanat");
define("MAIL_PASSWORD", "");
define("MAIL_FROM_NAME", "Novasta İhracat");

// Alan yönetimi izni - 1 => Doküman yapıları bir üst gruba bağlı değil, 2 => Doküman yapıları bir üst gruba bağlı
// Bu sayede sistemde birden fazla yönetim temsilcisi olacaksa, ALAN'lara temsilci atanabilecek ve temsilciler kendisine atanan alanlara girilen dokümanlardan sorumlu olabilece, yönetebilecek
define("SISTEM_ALAN", "1");






define("MAX_UPLOAD_SIZE", "30720"); // 30mb
define("DOSYA_TURLERI", "gif, jpg, png, doc, docx, pdf, rtf, xls, xlsx, txt, pptx, ppt, zip, rar, odt, fodt, ods, fods, odp, fodp, odb, odg, fodg, odf, ott, odm, otg, ots, odi, oxt, vsdx");
?>