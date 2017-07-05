<?php
require_once  ('../Include/initialize.php');


// post save
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  // session_start();

  $id = $_SESSION['profile_id'];

  try
  {

    $country = filter_input(INPUT_POST, 'country');
    if (!$country)
    {
      throw new Exception('Invalid country or too short');
    }

    $gender = filter_input(INPUT_POST, 'gender');
    if (!$gender )
    {
      throw new Exception('Invalid gender or too short');
    }


    $birthday = filter_input(INPUT_POST, 'birthday');
    if (!$birthday || strlen($birthday) < 2 )
    {
      throw new Exception('Invalid birthday');
    }


    if (!User::updateUserProfile( $id, $country, $gender, $birthday ))
    {
      throw new Exception('Update failed');
    }


    // Redirect to profile page
    header('HTTP/1.1 302 Redirect');

    //todo  header
    header("Location: userProfile.php?user_id=$id");

  } catch (Exception $e)
  {
    // Report error
    header('HTTP/1.1 400 Bad request');
    echo $e->getMessage();
  }




}



