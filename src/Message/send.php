<?php
require_once  ('../Include/initialize.php');


try
{
  // post save
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    session_start();
    $to_id = $_SESSION['receiver_id'];


    $subject = filter_input(INPUT_POST, 'subject');
    if (!$subject || strlen($subject) < 2 )
    {
      throw new Exception('Invalid subject or too short');
    }

    $message = filter_input(INPUT_POST, 'message');
    if (!$message || strlen($message) < 2 )
    {
      throw new Exception('Invalid message or too short');
    }


    $newMessage = new Message($db);
    if(!$newMessage->send_message($to_id, $message, $subject))
    {
      throw new Exception('Message sending failed');
    }

    // Redirect to profile page
    header('HTTP/1.1 302 Redirect');

    //todo  header
    header("Location: ../Profile/userProfile.php?user_id=$to_id");
  }
} catch (Exception $e)
{
  // Report error
  $_SESSION['message'] = $e->getMessage();
  header("location: ../Error/error.php");
}



