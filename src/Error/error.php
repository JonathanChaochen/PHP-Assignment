<?php
/* Displays all error messages */
session_start();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <?php include '../../css/css.html'; ?>
</head>
<body>
<div class="container">
    <div class="form">
        <h1>Error</h1>
        <p>
        <?php
            //print all error messages
        if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
            echo $_SESSION['message'];
        else:
            header( "location: ../../index.php" );
        endif;
        ?>
        </p>
        <a class="btn btn-info" href="../../index.php">Home</a>
    </div>
</div>
</body>
</html>
