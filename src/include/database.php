<?php
include("constants.php");
      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
      
      $this->num_members = -1;
      
      if(TRACK_VISITORS){
         /* Calculate number of users at site */
         $this->calcNumActiveUsers();
      
         /* Calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   }

   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = sprintf("SELECT password FROM ".TBL_USERS." where username = '%s'",
            mysql_real_escape_string($username));
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);

      /* Validate that password is correct */
      if($password == $dbarray['password']){
         return 0; //Success! Username and password confirmed
      }
      else{
         return 2; //Indicates password failure
      }
   }
   

   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = sprintf("SELECT userid FROM ".TBL_USERS." WHERE username= '%s'",
            mysql_real_escape_string($username));
      $result = mysql_query($q, $this->connection);
      if(!$result || (mysql_numrows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysql_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }

   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = sprintf("SELECT username FROM ".TBL_USERS." WHERE username = '%s'",
            mysql_real_escape_string($username));
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }

    function emailTaken($email){
       if(!get_magic_quotes_gpc()){
          $email = addslashes($email);
       }
       $q = sprintf("SELECT email FROM ".TBL_USERS." WHERE email = '%s'",
            mysql_real_escape_string($email));
       $result = mysql_query($q, $this->connection);
       return (mysql_num_rows($result) > 0);
    }

   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = sprintf("SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '%s'",
            mysql_real_escape_string($username));
      $result = mysql_query($q, $this->connection);
      return (mysql_numrows($result) > 0);
   }
   
   function addNewUser($username, $password, $email, $userid, $name){
      $time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }else{
         $ulevel = USER_LEVEL;
      }
       $q = sprintf("INSERT INTO ".TBL_USERS." VALUES ('%s', '%s', '%s', '%s', '%s', $time, '0', '%s', '0', '0')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($password),
            mysql_real_escape_string($userid),
            mysql_real_escape_string($ulevel),
            mysql_real_escape_string($email),
            mysql_real_escape_string($name));
      return mysql_query($q, $this->connection);
   }

   function updateUserField($username, $field, $value){
      $q = sprintf("UPDATE ".TBL_USERS." SET %s = '%s' WHERE username = '%s'",
            mysql_real_escape_string($field),
            mysql_real_escape_string($value),
            mysql_real_escape_string($username));
      return mysql_query($q, $this->connection);
   }

   function getUserInfo($username){
      $q = sprintf("SELECT * FROM ".TBL_USERS." WHERE username = '%s'",
            mysql_real_escape_string($username));
      $result = mysql_query($q, $this->connection);
      /* Error occurred, return given name by default */
      if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysql_fetch_array($result);
      return $dbarray;
   }
   
   function getUserInfoFromHash($hash){
   		$q = sprintf("SELECT * FROM ".TBL_USERS." WHERE hash = '%s'",
   				mysql_real_escape_string($hash));
   		$result = mysql_query($q, $this->connection);
   		if(!$result || (mysql_num_rows($result) < 1)){
   			return NULL;
   		}
   		$dbarray = mysql_fetch_array($result);
   		return $dbarray;
   }

   function getNumMembers(){
      if($this->num_members < 0){
         $q = "SELECT * FROM ".TBL_USERS;
         $result = mysql_query($q, $this->connection);
         $this->num_members = mysql_numrows($result);
      }
      return $this->num_members;
   }

   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_users = mysql_numrows($result);
   }

   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = mysql_query($q, $this->connection);
      $this->num_active_guests = mysql_numrows($result);
   }

   function addActiveUser($username, $time){
      $q = sprintf("UPDATE ".TBL_USERS." SET timestamp = '%s' WHERE username = '%s'",
            mysql_real_escape_string($time),
            mysql_real_escape_string($username));
      mysql_query($q, $this->connection);
      
      if(!TRACK_VISITORS) return;
      $q = sprintf("REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('%s', '%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($time));
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = sprintf("REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('%s', '%s')",
            mysql_real_escape_string($ip),
            mysql_real_escape_string($time));
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }

   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = sprintf("DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '%s'",
            mysql_real_escape_string($username));
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }
   
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = sprintf("DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'",
            mysql_real_escape_string($ip));
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }
   
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-USER_TIMEOUT*60;
      $q = sprintf("DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < %s", 
            mysql_real_escape_string($timeout));
      mysql_query($q, $this->connection);
      $this->calcNumActiveUsers();
   }

   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = sprintf("DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < %s",
            mysql_real_escape_string($timeout));
      mysql_query($q, $this->connection);
      $this->calcNumActiveGuests();
   }

   function query($query){
      return mysql_query($query, $this->connection);
   }
};

$database = new MySQLDB;
?>
