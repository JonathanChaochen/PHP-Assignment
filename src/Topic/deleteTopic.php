<?php
require_once  ('../Include/initialize.php');

try
{
  if(isset($_GET['topic_id']) ){
    $t_id = filter_var($_GET['topic_id'], FILTER_SANITIZE_STRING);
    // $_SESSION['send_to'] = $id;
  } else   {
    throw new Exception('Not valid request');
  }



  Topic::delete($t_id);


  // Redirect to topicPage.php
  header('HTTP/1.1 302 Redirect');
  header ("Location: ../../index.php") ;

} catch (Exception $e)
{
  // Report error
  $_SESSION['message'] = $e->getMessage();
  header("location: ../Error/error.php");
}



