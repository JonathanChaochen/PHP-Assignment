<?php
require_once  ('../Include/initialize.php');
include_once('../Layout/langSetting.php');

// session_save_path("/tmp") ;
// ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/session'));
// session_start();

  if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
  {
      // grab the variables from the form
       $theWords = filter_input(INPUT_POST, 'theWords', FILTER_SANITIZE_STRING);
       // $theWords = htmlentities($theWords, ENT_QUOTES, 'UTF-8');
       $_SESSION['theWords'] = $theWords;

        echo "Words to search for: $theWords";
   // $products = getSearchResult($db, $theWords) ;
   // displaySearchResult($products);
  }
  if( $_SESSION['theWords'] ) {
    $theWords = $_SESSION['theWords'];
  }


?>


<!DOCTYPE html>
<html>
<head>
  <?php include '../../css/css.html'; ?>
  <title>Search Result </title>

</head>
<body class="container">

  <h1>Search result</h1>
  <table class="table">
  <?php
  $products = getForum2($db, $theWords) ;
  displayForum2($products)
   ?>
   </table>

   <?php  include_layout_template('footer.php') ?>
</body>
</html>
