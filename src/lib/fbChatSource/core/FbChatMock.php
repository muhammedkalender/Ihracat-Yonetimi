<?php

/**
 * Description of FbChatMock
 *
 * @author Tamil
 */
class FbChatMock {
include "../../../include/constant.php";
  // Holds the database connection
  private $dbConnection;
  
  //----- Database connection details --/
  //-- Change these to your database values

  private $_dbHost = DB_SERVER;
  
  private $_dbUsername = DB_USER;
  
  private $_dbPassword = DB_PASS;
  
  public $_databaseName = DB_NAME;
  
  //----- ----/

  /**
   * Create's the connection to the database and stores it in the dbConnection
   */
  public function __construct() {
    $this->dbConnection = new mysqli($this->_dbHost, $this->_dbUsername, 
        $this->_dbPassword, $this->_databaseName);

    if ($this->dbConnection->connect_error) {
      die('Connection error.');
    }
  }

  /**
   * Get the list of messages from the chat
   * 
   * @return array
   */
  public function getMessages() {
    $messages = array();
    $query = <<<QUERY
        SELECT 
          `chat`.`message`, 
          `chat`.`sent_on`,
          `users`.`username`
        FROM `users`
        JOIN `chat`
          ON `chat`.`from` = `users`.`username`
       
QUERY;
    
    // Execute the query
    $resultObj = $this->dbConnection->query($query);
    // Fetch all the rows at once.
    while ($row = $resultObj->fetch_assoc()) {
      $messages[] = $row;
    }
    
    return $messages;
  }

  /**
   * Add a new message to the chat table
   * 
   * @param Integer $userId The user who sent the message
   * @param String $message The Actual message
   * @return bool|Integer The last inserted id of success and false on faileur
   */
  public function addMessage($userId, $message) {
    $addResult = false;
    
    $cUserId =$userId;
    // Escape the message with mysqli real escape
    $cMessage = $this->dbConnection->real_escape_string($message);
    
    $query = <<<QUERY
      INSERT INTO `chat`(`from`, `message`, `sent`)
      VALUES ({$cUserId}, '{$cMessage}', UNIX_TIMESTAMP())
QUERY;

    $result = $this->dbConnection->query($query);
    
    if ($result !== false) {
      // Get the last inserted row id.
      $addResult = $this->dbConnection->insert_id;
    } else {
      echo $this->dbConnection->error;
    }
    
    return $addResult;
  }

}