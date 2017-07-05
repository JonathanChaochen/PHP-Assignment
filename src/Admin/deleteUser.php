<?php
require_once  ('../Include/initialize.php');



 ?>

 <!doctype html>
 <html>
 <head>
     <title>Login</title>
     <?php include '../../css/css.html'; ?>

 </head>
 <body class="container">

   <?php
   if(isset($_GET['user_id'])){
     $id = $_GET['user_id'];
     filter_var($id,FILTER_SANITIZE_STRING);
   }


   if(User::delete($id))
   {
     echo "<h3>Delete success</h3>";
     echo "<h4>Page will redirect to dashboard soon </h4>";
   } else {
      echo "<h3>Delete Failed</h3>";
   }

   header('Refresh: 2; URL=../Admin/dashboard.php');
    ?>
 </body>

 </html>
