<?php
require_once  ('../Include/initialize.php');

include_once('../Layout/langSetting.php');

$newMessage = new Message($db);
// session_start();

if (isset($_SESSION['user_logged_in'])) {
  $results = $newMessage->get_number_of_unread_messages();
  $aRow =  $results->fetch();
}


// $user_email = $_SESSION['user_email'];


try
{

  if(isset($_GET['user_id']) ){
    $id = filter_input(INPUT_GET, 'user_id');


  } else   {
    throw new Exception('Not valid request');
  }



  $user = User::getById($id);
  if (!$user )
  {
    throw new Exception('Invalid user or user not exit');
  }

  $profile_username = $user->full_name();
  $profile_country = $user->country;
  $profile_gender = $user->gender;
  $profile_birthday = $user->birthday;
  $profile_email = $user->email;


  // var_dump($profile_username );



} catch (Exception $e)
{
  // Report error
  $_SESSION['message'] = $e->getMessage();
  // header("location: ../Error/error.php");
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

    <h2>
    <?php if(isset($profile_username) )
    {
      echo $profile_username;
    }

    ?>
    </h2>



    <div class="row">
      <div class="col-sm-4">
        <img src="../../images/user.jpeg">

        <table class="table">
          <tr><th><?= $lang->translateWord('Topics') ?></th><th><?= $lang->translateWord('Replies') ?></th></tr>
          <tr><td><?= Topic::count_my($id); ?></td><td><?= Reply::count_my($id); ?></td></tr>
        </table>


      </div>

      <div class="col-sm-8">
        <h4><?= $lang->translateWord('User details') ?></h4>



        <br>
        <div class="row">
          <div class="col-md-4">
            <p class="profile-details"><span class="glyphicon glyphicon-info-sign "></span> <?= $lang->translateWord('Country') ?> </p>
          </div>
          <div class="col-md-8">
              <p><?= $profile_country;?></p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="profile-details"><span class="glyphicon glyphicon-user "></span> <?= $lang->translateWord('Gender') ?> </p>
          </div>
          <div class="col-md-8">
              <p><?= $profile_gender;?></p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <p class="profile-details"><span class="glyphicon  glyphicon-calendar "></span> <?= $lang->translateWord('Birthday') ?></p>
          </div>
          <div class="col-md-8">
              <p><?= $profile_birthday;?></p>
          </div>
        </div>

        <div>
        <?php  if (isset($_SESSION['user_logged_in']))
        {
          //  check if current profile is user profile
          if($_SESSION['user_email'] == $profile_email)
          {
            echo "<a class='btn btn-primary col-md-offset-6' href='editProfile.php?user_id=$id'><span class='glyphicon glyphicon-pencil'></span> ".$lang->translateWord('Edit')." </a><br>";

            echo "<a class='btn btn-success' href='../Message/messagePage.php?to_id=$id'><span class='glyphicon glyphicon-envelope'></span> ".$lang->translateWord('Message')." <span class='badge'> $aRow[unread] </span> </a>";
          }
          else
          {
           echo "<a class='btn btn-success' href='../Message/sendMessage.php?to_id=$id'><span class='glyphicon glyphicon-send'></span> ".$lang->translateWord('send message')."  </a>";
          }
        }
        ?>
        </div>


      </div>

    </div>


    <?php

    if (isset($_SESSION['level'])) {
           $outputLine = "<p><a class='btn btn-sm btn-danger' href='banUser.php?user_id=$id&days=1'>Ban This User 1 Day</a></p>";
           echo $outputLine ;

           $outputLine = "<p><a class='btn btn-sm btn-danger' href='banUser.php?user_id=$id&days=7'>Ban This User 7 Days</a></p>";
           echo $outputLine ;

           $outputLine = "<p><a class='btn btn-sm btn-success' href='banUser.php?user_id=$id&days=0'>Cancel Ban</a></p>";
           echo $outputLine ;
    }


    ?>


    <br>


    <?php  include_layout_template('footer.php') ?>

    </div>



 </body>
 </html>
