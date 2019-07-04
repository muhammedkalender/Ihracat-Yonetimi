<?php

/* GZIP SİTE HIZLANDIRMA - Mutlu ARICI www.mutluarici.com */

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();





/*header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");

header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

header("Cache-Control: post-check=0, pre-check=0", false);

header("Pragma: no-cache");

*/

include("dbKur.php");

include("database.php");

include("mailer.php");

include("form.php");



class Session

{

   var $username;     //Username given on sign-up

   var $userid;       //Random value generated on current login

   var $userlevel;    //The level to which the user pertains

   var $time;         //Time user was last active (page loaded)

   var $logged_in;    //True if user is logged in, false otherwise

   var $userinfo = array();  //The array holding all user info

   var $url;          //The page url current being viewed

   var $referrer;     //Last recorded site page viewed

   var $chash;



   function Session(){

      $this->time = time();

      $this->startSession();

   }



   function startSession(){

      global $database;  //The database connection

      session_start();   //Tell PHP to start the session



      /* Determine if user is logged in */

      $this->logged_in = $this->checkLogin();



      /**

       * Set guest value to users not logged in, and update

       * active guests table accordingly.

       */

      if(!$this->logged_in){

         $this->username = $_SESSION['username'] = GUEST_NAME;

         $this->userlevel = GUEST_LEVEL;

         $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);

      }

      /* Update users last active timestamp */

      else{

         $database->addActiveUser($this->username, $this->time);

      }

      

      /* Remove inactive visitors from database */

      $database->removeInactiveUsers();

      $database->removeInactiveGuests();

      

      /* Set referrer page */

      if(isset($_SESSION['url'])){

         $this->referrer = $_SESSION['url'];

      }else{

         $this->referrer = "/";

      }



      /* Set current url */

      $this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];

   }



  function checkLogin(){     

      global $database;  //The database connection

     

   

     // 86400 = 1 day$_SESSION["chash"] = md5(md5(md5($this->userid). $pre) . $this->ip());

     

      /* Check if user has been remembered */

      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){

         $this->username = $_SESSION['username'] = $_COOKIE['cookname'];

         $this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];

      }


      /* Username and userid have been set and not guest */

      if(isset($_SESSION['username']) && isset($_SESSION['userid']) &&

         $_SESSION['username'] != GUEST_NAME){

         /* Confirm that username and userid are valid */

         if($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0){

            /* Variables are incorrect, user not logged in */

            unset($_SESSION['username']);

            unset($_SESSION['userid']);

            return false;

         }

        


         /* User is logged in, set class variables */

         $this->userinfo  = $database->getUserInfo($_SESSION['username']);

         $this->username  = $this->userinfo['username'];

         $this->userid    = $this->userinfo['userid'];

         $this->userlevel = $this->userinfo['userlevel'];

         $this->adi = $this->userinfo['adi'];

         $this->soyadi = $this->userinfo['soyadi'];

         $this->alan = $this->userinfo['alan'];

          

         /* auto login hash expires in three days */

         if($this->userinfo['hash_generated'] < (time() - (60*60*3))){

            /* Update the hash */

            $database->updateUserField($this->userinfo['username'], 'hash', $this->generateRandID());

            $database->updateUserField($this->userinfo['username'], 'hash_generated', time());

         }

       

      //[MK]-0001
      if(!isset($_COOKIE["chash"]) || !isset($_COOKIE["clevel"]) || !isset($_COOKIE["crand"])){
        return false;
      }

      if($_COOKIE["chash"] != $this->fgeneratehash()){
        return false;
      }

      if(!$this->fcheckhash()){
        return false;
      }

         

         return true;

      }

      /* User not logged in */

      else{

         return false;

      }

   }


    //[MK] - 0003
    function fcheckcash(){
      $hash = fgeneratehash();
      $q = "SELECT * FROM ".TBL_USERS." WHERE hash='$hash'";
      $valid = $database->query($q);
      $valid = mysql_fetch_array($valid);

      if(fgeneratehash($valid['rand'], $valid['level'], $valid['ip']) == $hash){
        if($valid['ip'] != $_COOKIE["cip"] && $valid['ip'] != $this->ip()){
          return false;
        }

        if($valid['level'] != $_COOKIE["clevel"]){
          return false;
        }

        if($valid['rand'] != $_COOKIE['crand']){
          return false;
        }

        return true;
      }else{
        return false;
      }
    }

    //[MK] - 0002
    function fgeneratehash($prand = $_COOKIE["crand"], $plevel = $_COOKIE["clevel"], $pip = $this->ip()){
      $pre = "4A8DSG569J789K-893GJ4,876846.";
      $sessionid = session_id();

      $generatedhash = sha1(md5(sha1(md5(sha1($pip) . $prand) . $pre) . $plevel) . $sessionid);

      return $generatedhash;
    }

   function login($subuser, $subpass, $subremember){

      global $database, $form;  //The database and form object



      /* Username error checking */

      $field = "user";  //Use field name for username

     

     //[DEGISIM] 16:37 18.05.2018

     //SELECT valid FROM ".TBL_USERS." WHERE email='$subuser'

     //username değilde, sadece mail sorgusu

     //DEGISIM 15:15 20.07.2018 EMAİL OLARAK DEĞİŞTİ

     

     $q = "SELECT valid FROM ".TBL_USERS." WHERE username='$subuser'";

     $valid = $database->query($q);

     $valid = mysql_fetch_array($valid);

            

      if(!$subuser || strlen($subuser = trim($subuser)) == 0){

         $form->setError($field, "* Kullanıcı Adını Giriniz");

      }

      else{

         /* Check if username is not alphanumeric */

        /* if(!ctype_alnum($subuser)){

            $form->setError($field, "* Username not alphanumeric");

         }*/

      }    



      /* Password error checking */

      $field = "pass";  //Use field name for password

      if(!$subpass){

         $form->setError($field, "* Şifrenizi Giriniz");

      }

      

      /* Return if form errors exist */

      if($form->num_errors > 0){

         return false;

      }



      /* Checks that username is in database and password is correct */

      $subuser = stripslashes($subuser);

      $result = $database->confirmUserPass($subuser, md5($subpass));



      /* Check error codes */

      if($result == 1){

         $field = "user";

         $form->setError($field, "* Kullanıcı Bulunamadı");

      }

      else if($result == 2){

         $field = "pass";

         $form->setError($field, "* Geçersiz Şifre");

      }

      

      /* Return if form errors exist */

      if($form->num_errors > 0){

         return false;

      }



      

      if(EMAIL_WELCOME){

         if($valid['valid'] == 0){

            $form->setError($field, "* Kullanıcı Hesabınız Henüz Onaylanmadı.");

         }

      }

                  

      /* Return if form errors exist */

      if($form->num_errors > 0){

         return false;

      }

      





      /* Username and password correct, register session variables */

      $this->userinfo  = $database->getUserInfo($subuser);

      $this->username  = $_SESSION['username'] = $this->userinfo['username'];

      $this->userid    = $_SESSION['userid']   = $this->generateRandID();

      $this->adi = $_SESSION['adi'] = $this->userinfo['adi'];

     $this->soyadi = $_SESSION['soyadi'] = $this->userinfo['soyadi'];

     $this->alan = $_SESSION['alan'] = $this->userinfo['alan'];

      

      /* Insert userid into database and update active users table */

      
      
		//[MK] - 0006
     	$rand = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,32);
      	$ip = $this->ip();
      	$hash = $this->fgeneratehash($rand, $this->userlevel, $ip);
      	
//todo tablo ypaılacak
      $q = "INSERT INTO tokens (USER_ID, HASH, LEVEL, RAND, IP) VALUES (".$this->userid.", '$hash', ".$this->userlevel.", '$rand', '$ip')");
	  if(!$database->query($q)){
	  	return 0;
	  }

   
      setcookie("chash", $hash); // 86400 = 1 day$_SESSION["chash"] = 
      setcookie("clevel", $this->userlevel);
      setcookie("crand", $rand);
    $database->updateUserField($this->username, "userid", $this->userid);

      $database->addActiveUser($this->username, $this->time);

      $database->removeActiveGuest($_SERVER['REMOTE_ADDR']);


      if($subremember){

         setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);

         setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);

      }



      /* Login completed successfully */

      return true;

   }

   
    //[MK] - 0005
    function ip(){
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
        return $_SERVER['REMOTE_ADDR'];
      }
    }





   function logout(){

      global $database;  //The database connection

      /**

       * Delete cookies - the time must be in the past,

       * so just negate what you added when creating the

       * cookie.

       */

      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){

         setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);

         setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);

      }



      /* Unset PHP session variables */

      unset($_SESSION['username']);

      unset($_SESSION['userid']);



      /* Reflect fact that user has logged out */

      $this->logged_in = false;

      

      /**

       * Remove from active users table and add to

       * active guests tables.

       */

      $database->removeActiveUser($this->username);

      $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);

      

      /* Set user level to guest */

      $this->username  = GUEST_NAME;

      $this->userlevel = GUEST_LEVEL;

   }



   function register($subuser, $subpass, $subemail, $subname){

   

      global $database, $form, $mailer;  //The database, form and mailer object

      

      /* Username error checking */

      $field = "user";  //Use field name for username

      if(!$subuser || strlen($subuser = trim($subuser)) == 0){

         $form->setError($field, "* Kullanıcı Adını Giriniz");

      }

      else{

         /* Spruce up username, check length */

         $subuser = stripslashes($subuser);

         if(strlen($subuser) < 5){

            $form->setError($field, "* Kullanıcı Adı En Az 5 Karakterden Oluşmalı");

         }

         else if(strlen($subuser) > 30){

            $form->setError($field, "* Kullanıcı Adı En Fazla 30 Karakterden Oluşmalı");

         }

         /* Check if username is not alphanumeric */

         else if(!ctype_alnum($subuser)){

            $form->setError($field, "* Username not alphanumeric");

         }

         /* Check if username is reserved */

         else if(strcasecmp($subuser, GUEST_NAME) == 0){

            $form->setError($field, "* Username reserved word");

         }

         /* Check if username is already in use */

         else if($database->usernameTaken($subuser)){

            $form->setError($field, "* Girdiğiniz Kullanıcı Adı Kayıtlı");

         }

         /* Check if username is banned */

         else if($database->usernameBanned($subuser)){

            $form->setError($field, "* Kullanıcı Engellendi");

         }

      }



      /* Password error checking */

      $field = "pass";  //Use field name for password

      if(!$subpass){

         $form->setError($field, "* Şifre Girilmedi");

      }

      else{

         /* Spruce up password and check length*/

         $subpass = stripslashes($subpass);

         if(strlen($subpass) < 4){

            $form->setError($field, "* Şifre En Az 4 Karakterden Oluşmalı!");

         }

         /* Check if password is not alphanumeric */

         else if(!ctype_alnum(($subpass = trim($subpass)))){

            $form->setError($field, "* Password not alphanumeric");

         }

         /**

          * Note: I trimmed the password only after I checked the length

          * because if you fill the password field up with spaces

          * it looks like a lot more characters than 4, so it looks

          * kind of stupid to report "password too short".

          */

      }

      

      /* Email error checking */

      $field = "email";  //Use field name for email

      if(!$subemail || strlen($subemail = trim($subemail)) == 0){

         $form->setError($field, "* Email Adresi Girilmedi");

      }

      else{

         /* Check if valid email address */

         if(filter_var($subemail, FILTER_VALIDATE_EMAIL) == FALSE){

            $form->setError($field, "* Email Kullanılamaz");

         }

         /* Check if email is already in use */

         if($database->emailTaken($subemail)){

            $form->setError($field, "* Email Daha Önce Kaydedilmiş");

         }



         $subemail = stripslashes($subemail);

      }

      

      /* Name error checking */

     $field = "name";

     if(!$subname || strlen($subname = trim($subname)) == 0){

        $form->setError($field, "* İsim Girilmedi");

     } else {

        $subname = stripslashes($subname);

     }

      

      $randid = $this->generateRandID();

      

      /* Errors exist, have user correct them */

      if($form->num_errors > 0){

         return 1;  //Errors with form

      }

      /* No errors, add the new account to the */

      else{

         if($database->addNewUser($subuser, md5($subpass), $subemail, $randid, $subname)){

            if(EMAIL_WELCOME){               

               $mailer->sendWelcome($subuser,$subemail,$subpass,$randid);

            }

            return 0;  //New user added succesfully

         }else{

            return 2;  //Registration attempt failed

         }

      }

   }

   



   function editAccount($subcurpass, $subnewpass, $subemail, $subname){

      global $database, $form;  //The database and form object

      /* New password entered */

      if($subnewpass){

         /* Current Password error checking */

         $field = "curpass";  //Use field name for current password

         if(!$subcurpass){

            $form->setError($field, "* Current Password not entered");

         }

         else{

            /* Check if password too short or is not alphanumeric */

            $subcurpass = stripslashes($subcurpass);

            if(strlen($subcurpass) < 4 ||

               !preg_match("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))){

               $form->setError($field, "* Current Password incorrect");

            }

            /* Password entered is incorrect */

            if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){

               $form->setError($field, "* Current Password incorrect");

            }

         }

         

         /* New Password error checking */

         $field = "newpass";  //Use field name for new password

         /* Spruce up password and check length*/

         $subpass = stripslashes($subnewpass);

         if(strlen($subnewpass) < 4){

            $form->setError($field, "* Yeni Şifre Çok Kısa");

         }

         /* Check if password is not alphanumeric */

         else if(!preg_match("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))){

            $form->setError($field, "* New Password not alphanumeric");

         }

      }

      /* Change password attempted */

      else if($subcurpass){

         /* New Password error reporting */

         $field = "newpass";  //Use field name for new password

         $form->setError($field, "* Yeni Şifre Girilmedi");

      }

      

      /* Email error checking */

      $field = "email";  //Use field name for email

      if($subemail && strlen($subemail = trim($subemail)) > 0){

         /* Check if valid email address */

         if(filter_var($subemail, FILTER_VALIDATE_EMAIL) == FALSE){

            $form->setError($field, "* Email Kullanılamaz");

         }

         $subemail = stripslashes($subemail);

      }

      

      /* Name error checking */

     $field = "name";

     if(!$subname || strlen($subname = trim($subname)) == 0){

        $form->setError($field, "* İsim Girilmedi");

     } else {

        $subname = stripslashes($subname);

     }

      

      /* Errors exist, have user correct them */

      if($form->num_errors > 0){

         return false;  //Errors with form

      }

      

      /* Update password since there were no errors */

      if($subcurpass && $subnewpass){

         $database->updateUserField($this->username,"password",md5($subnewpass));

      }

      

      /* Change Email */

      if($subemail){

         $database->updateUserField($this->username,"email",$subemail);

      }

      

      /* Change Name */

      if($subname){

         $database->updateUserField($this->username,"name",$subname);

      }

      

      /* Success! */

      return true;

   }

   



   function isAdmin(){

      return ($this->userlevel == ADMIN_LEVEL ||

              $this->username  == ADMIN_NAME);

   }

   



   function isAuthor(){

      return ($this->userlevel == AUTHOR_LEVEL ||

              $this->userlevel == ADMIN_LEVEL);

   }

   



   function generateRandID(){

      return md5($this->generateRandStr(16));

   }



   function generateRandStr($length){

      $randstr = "";

      for($i=0; $i<$length; $i++){

         $randnum = mt_rand(0,61);

         if($randnum < 10){

            $randstr .= chr($randnum+48);

         }else if($randnum < 36){

            $randstr .= chr($randnum+55);

         }else{

            $randstr .= chr($randnum+61);

         }

      }

      return $randstr;

   }

   

   function cleanInput($post = array()) {

       foreach($post as $k => $v){

            $post[$k] = trim(htmlspecialchars($v));

         }

         return $post;

   }

   function post($post) {

      foreach($post as $k=>$v) $$k=$v;

      return $post;

   }

};





$session = new Session;

$form = new Form;

?>