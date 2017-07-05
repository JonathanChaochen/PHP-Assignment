<?php
require_once  ('../Include/initialize.php');

include_once('../Layout/langSetting.php');

$newMessage = new Message($db);
// session_start();

if(isset($_GET['message_id']))
{
  Message::delete($_GET['message_id']);
}



 ?>

<html>
<head>

  <?php include '../../css/css.html'; ?>

  <title>My messages</title>
</head>
<body >
  <div class="container">
  <h2>My Messages</h2>

  <h4>All the messages</h4>

  <div class="example">
  <?php
  $results = $newMessage->get_all_messages();
 $newMessage->displayAllMessage ($results);
 ?>

 </div>

 <?php  include_layout_template('footer.php') ?>

  </div>
</body>


</html>
