<?php
session_start();
if( isset($_SESSION['user_logged_in']))
{
  header('Location: ../Topic/postPage.php');
} else
{
  header('Location: ./login.php');
}


