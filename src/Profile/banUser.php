<?php
require_once  ('../Include/initialize.php');

if (isset($_GET['user_id'], $_GET['days']))
{
  $user_id = $_GET['user_id'];
  $days = (int)$_GET['days'];

  ban($db, $user_id, $days);
}

// Redirect to topicPage.php
header('HTTP/1.1 302 Redirect');
header ("Location: userProfile.php?user_id=$user_id") ;

