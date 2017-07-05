<?php
require_once  ('../Include/initialize.php');
include_once('../Layout/langSetting.php');

// session_start();

  if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
  {
      // grab the variables from the form
       $userSearch = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
       $userSearch = htmlentities($userSearch, ENT_QUOTES, 'UTF-8');
  }


 ?>

<html>
<head>

  <?php include '../../css/css.html'; ?>

  <title>My messages</title>

  <link rel="stylesheet" href="../../css/stylesheets.css">

</head>
<body >
  <div class="container">
  <h2>Admin </h2>

  <?php
  $email =  $_SESSION['user_email'];
  $user = new User($db);

  $user->setByEmail($email) ;

  echo "<h4>  <a href='../Profile/userProfile.php?user_id=$user->id'>$user->fullname </a></h4>"; ?>

  <div class="row">
    <div class="col-sm-6">
    <h4>All the users </h4>
    <?php
    echo User::count_all();
    $users = User::getAll();
    foreach ($users as $user) {
      $id = $user->id;
      $username = $user->full_name();
      $outline =  "<div class='users'><p>ID: $user->id";
      $outline .= " <a class='btn btn-xs btn-danger' href=deleteUser.php?user_id=$id> delete </a></p>";
      $outline .=  "<p><a href='../Profile/userProfile.php?user_id=$id'> $username </a></p></div>";


      echo $outline;
    }

    // $topics = Topic::getAll();
    // foreach ($topics  as $topic) {
    //   echo "<p>$topic->subject </p>";
    // }

    // $t = Topic::getById(1005);
    // echo "<p>$t->subject </p>";

    // $replies = Reply::getAll();
    // foreach ($replies  as $reply) {
    //   echo "<p>$reply->content </p>";
    // }
    ?>
    </div>

    <div class="col-sm-6">
    <h4>Active user</h4>
    <?php

    $users = User::getActiveUser();
    echo count($users);
    foreach ($users as $user) {
      $id = $user->id;
      $username = $user->full_name();

      $outline =  "<div class='activeUsers'><p>ID: $user->id";
      $outline .= " <a class='btn btn-xs btn-danger' href=deleteUser.php?user_id=$id> delete </a></p>";
      $outline .=  "<p><a href='../Profile/userProfile.php?user_id=$id'> $username </a></p></div>";

      echo $outline;
    }
    ?>


    </div>
  </div>



  <!-- search form -->
      <form action="dashboard.php" method="post">
      <div class="input-group">
        <input type="text" class="form-control" name='user' value='<?php if (isset($userSearch))  echo htmlentities($userSearch, ENT_QUOTES, 'UTF-8');?>' placeholder="Search User...">
        <span class="input-group-btn">
          <button class="btn btn-info" type="submit">
            Search
          </button>
        </span>
      </div>

      </form>


      <table class="table">
      <?php
      if(!empty($userSearch)){
      User::searchUser($userSearch) ;

      }
      ?>
       </table>

       <?php  include_layout_template('footer.php') ?>
  </div>
</body>


</html>
