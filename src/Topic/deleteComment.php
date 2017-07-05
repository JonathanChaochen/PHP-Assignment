<?php
require_once  ('../Include/initialize.php');

try
{
  if(isset($_GET['reply_id']) ){
    $r_id = filter_var($_GET['reply_id'], FILTER_SANITIZE_EMAIL);
    // $_SESSION['send_to'] = $id;
  } else   {
    throw new Exception('Not valid request');
  }

  Reply::delete($r_id);


  // Redirect to topicPage.php
  header('HTTP/1.1 302 Redirect');
  header ("Location: topicPage.php") ;

} catch (Exception $e)
{
  // Report error
  $_SESSION['message'] = $e->getMessage();
  header("location: ../Error/error.php");
}



