<?php
require_once  ('../Include/initialize.php');
/* Log out process, unsets and destroys session variables */
session_start();
if ($_SESSION['user_email']) {
  $user = new User($db);
 User::changeStatus($_SESSION['user_email'], 0);
}
session_unset();
session_destroy();





header ("Location: ../../index.php") ;

