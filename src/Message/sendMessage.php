<?php
require_once  ('../Include/initialize.php');
include_once('../Layout/langSetting.php');

// $user_email = $_SESSION['user_email'];
try
{
  // session_start();
  if(isset($_GET['to_id']) ){
    $id = filter_input(INPUT_GET, 'to_id');
    $_SESSION['receiver_id'] = $id;

  } else   {
    throw new Exception('Not valid request');
  }

  /*
  *   check send to  is not self
  **/

  if($id == $_SESSION['user_id'])
  {
      throw new Exception('Can not send message to yourslef');
  }



  $user = User::getById($id);
  if (!$user)
  {
    throw new Exception('Invalid user or user not exit');
  }

  $profile_username = $user->full_name();




} catch (Exception $e)
{
  // Report error
  $_SESSION['message'] = $e->getMessage();
  header("location: ../Error/error.php");
}

?>


 <!DOCTYPE html>
 <html>
 <head>

 <?php include '../../css/css.html'; ?>

   <title>User Profile</title>


 </head>
 <body>
    <div class="container">
    <h2><?= $lang->translateWord('Send message to') ?> <?= $profile_username; ?></h2>
    <img style="width:5em" src="../../images/atomix_user31.png">

    <br>

  <form action="send.php" method="POST">

  <div class="form-group row">
    <label for="title" class="col-sm-1 col-form-label"><?= $lang->translateWord('subject') ?>:</label>
    <div class="col-sm-6">
      <input class="form-control" type="text"  id="title" name="subject">
    </div>
  </div>

  <div class="form-group row">
    <label for="content" class="col-sm-1 col-form-label"><?= $lang->translateWord('Message') ?>:</label>
    <div class="col-sm-6">
      <textarea class="form-control"  rows="10"  id="content" name="message"></textarea>
    </div>
  </div>


  <div class="col-sm-offset-6">
    <input class="btn btn-success" type="submit" name="m_submit" value="<?= $lang->translateWord('Send') ?>">
  </div>

  </form>


  <?php  include_layout_template('footer.php') ?>

    </div>



 </body>
 </html>
