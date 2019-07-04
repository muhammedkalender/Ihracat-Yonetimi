<?php
include BASE_DIR."/include/constants.php";


///
// http://kjventura.com/2011/11/kickass-php-database-class-for-simple-web-apps/

class Database {
    var $Host     = DB_SERVER;        // Hostname of our MySQL server.
    var $Database = DB_NAME;         // Logical database name on that server.
    var $User     = DB_USER;             // User and Password for login.
    var $Password = DB_PASS;
 
    var $Link_ID  = 0;                  // Result of mysql_connect().
    var $Query_ID = 0;                  // Result of most recent mysql_query().
    var $Record   = array();            // current mysql_fetch_array()-result.
    var $Row;                           // current row number.
    var $LoginError = "";
 
    var $Errno    = 0;                  // error state of query...
    var $Error    = "";
 
 
//-------------------------------------------
//    Connects to the database
//-------------------------------------------
    function connect()
        {
			
			
			
        if( 0 == $this->Link_ID )
            $this->Link_ID=mysql_connect( $this->Host, $this->User, $this->Password );
        if( !$this->Link_ID )
            $this->halt( "Link-ID == false, connect failed" );
        if( !mysql_query( sprintf( "use %s", $this->Database ), $this->Link_ID ) )
            $this->halt( "cannot use database ".$this->Database );
        } // end function connect
 
//-------------------------------------------
//    Queries the database
//-------------------------------------------
    function query( $Query_String )
        {
        $this->connect();
        $this->Query_ID = mysql_query( $Query_String,$this->Link_ID );
        $this->Row = 0;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        if( !$this->Query_ID )
            $this->halt($Query_String);
        return $this->Query_ID;
        } // end function query
 
//-------------------------------------------
//    If error, halts the program
//-------------------------------------------
    function halt( $msg )
        {
		$hata = "";
        $hata .= "<strong>Database error:</strong>".$msg;
        $hata .= "<br /><strong>MySQL Error</strong>: ".$this->Errno." - ".$this->Error;
		$hata .= "<br /><strong>Adres:</strong> ".base64_decode(Adres());
			try {
				$mail = new PHPMailer(true); //New instance, with exceptions enabled

				$body				= preg_replace('/\\\\/','', $hata); //Strip backslashes

				$mail->IsSMTP();                           // tell the class to use SMTP
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->Port       = 25;                    // set the SMTP server port
				$mail->Host       = MAIL_HOST; // SMTP server
				$mail->Username   = MAIL_FROM;     // SMTP server username
				$mail->Password   = MAIL_PASSWORD;            // SMTP server password

				$mail->IsSendmail();  // tell the class to use Sendmail

				$mail->From       = MAIL_FROM;
				$mail->FromName   = MAIL_FROM_NAME;
				$mail->AddAddress(EMAIL_FROM_ADDR);
				$mail->Subject  = "Veritabanı hatası";
				$mail->WordWrap   = 80; // set word wrap
				$mail->MsgHTML($body);
				$mail->IsHTML(true); // send as HTML
				$mail->Send();
			} catch (phpmailerException $e) {
				echo $e->errorMessage();
			}
        } // end function halt
 
//-------------------------------------------
//    Retrieves the next record in a recordset
//-------------------------------------------
    function nextRecord()
        {
        @ $this->Record = mysql_fetch_array( $this->Query_ID );
        $this->Row += 1;
        $this->Errno = mysql_errno();
        $this->Error = mysql_error();
        $stat = is_array( $this->Record );
        if( !$stat )
            {
            @ mysql_free_result( $this->Query_ID );
            $this->Query_ID = 0;
            }
        return $stat;
        } // end function nextRecord
 
//-------------------------------------------
//    Retrieves a single record
//-------------------------------------------
    function singleRecord()
        {
        $this->Record = mysql_fetch_array( $this->Query_ID );
        $stat = is_array( $this->Record );
        return $stat;
        } // end function singleRecord
	
	function mysql_fields() {
		return $this->Record = mysql_fetch_row($this->Query_ID);
	}
 
//-------------------------------------------
//    Returns the number of rows  in a recordset
//-------------------------------------------
    function numRows()
        {
        return mysql_num_rows( $this->Query_ID );
        } // end function numRows
 
//-------------------------------------------
//    Returns the Last Insert Id
//-------------------------------------------
    function lastId()
        {
        return mysql_insert_id();
        } // end function numRows
 
//-------------------------------------------
//    Returns Escaped string
//-------------------------------------------
    function mysql_escape_mimic($inp)
        {
        if(is_array($inp))
            return array_map(__METHOD__, $inp);
        if(!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }
        return $inp;
        }
//-------------------------------------------
//    Returns the number of rows  in a recordset
//-------------------------------------------
    function affectedRows()
        {
            return mysql_affected_rows();
        } // end function numRows
 
//-------------------------------------------
//    Returns the number of fields in a recordset
//-------------------------------------------
    function numFields()
        {
            return mysql_num_fields($this->Query_ID);
        } // end function numRows

} // end class Database

	
/* From: kjventura.com */

$db = new Database();
?>