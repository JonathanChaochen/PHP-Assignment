<?php
require_once  ('../Include/initialize.php');
include_once('../Layout/langSetting.php');

$newMessage = new Message($db);

// session_start();
 ?>

<html>
<head>

 <?php include '../../css/css.html'; ?>

  <title><?= $lang->translateWord('My Messages') ?></title>

  <style type="text/css">

  </style>

</head>
<body>
  <div class="container">
  <h2><?= $lang->translateWord('My Messages') ?></h2>

  <h4><?= $lang->translateWord('All the messages') ?></h4>
  <div class="row">
    <div class="example col-sm-6">
    <?php
    $results = $newMessage->get_all_messages();
    $newMessage->displayAllMessage ($results);
   ?>

   </div>
 </div>


 <?php  include_layout_template('footer.php') ?>
  </div>
</body>


</html>
