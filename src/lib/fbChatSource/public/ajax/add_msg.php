<?php
session_start();

if (isset($_POST['msg'])) {
  require_once __DIR__ . '/lib/fbChatSource/core/FbChatMock.php';
  
  $userId = $_SESSION['username'];
  // Escape the message string
  $msg = htmlentities($_POST['msg'],  ENT_NOQUOTES);
  
  $chat = new FbChatMock();
  $result = $chat->addMessage($userId, $msg);
}
?>