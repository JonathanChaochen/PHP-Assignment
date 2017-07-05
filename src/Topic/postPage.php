<?php
require_once  ('../Include/initialize.php');
include_once('../Layout/langSetting.php');

if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
   // session_start();

      try
      {
        if (!isset($_SESSION['user_logged_in']))
        {
          throw new Exception('Please log in first');
        }


        if(! $user = User::getByID($_SESSION['user_id']) )
        {
          throw new Exception('Invalid user id');
        }


      // reset bans table by checking date
      banValue($db);

      $sql="SELECT ban, unban_date FROM bans
      WHERE user_id = " . $user->id . "
      LIMIT 1";
      $result = $db->query($sql);
      $row = $result->fetch();
      if($row['ban'] == 1)
      {
          throw new Exception('YOU are banned, you can not post now');
      }


      $topic = new Topic($db);

      // grab the variables from the form
      $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
      // $title  = htmlentities($title , ENT_QUOTES, 'UTF-8');
      if (!$title )
      {
        throw new Exception('Invalid title');
      }

      $content  = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
      // $content   = htmlentities($content , ENT_QUOTES, 'UTF-8');
      if (!$content )
      {
        throw new Exception('Invalid content');
      }

          $topic->setTopic($title , $content, $user->id);
          $topic->save();

          // Redirect to longin.php
          header('HTTP/1.1 302 Redirect');
          header ("Location: ../../index.php") ;
          die();
      }  catch (Exception $e)
      {
        // Report error
        header('HTTP/1.1 400 Bad request');
        echo $e->getMessage();
      }
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>

   <?php include '../../css/css.html'; ?>
   <title>Post</title>
</head>
<body>
  <div class="container">
    <h1>Theseus and Minotaur forum</h1>
    <header>
    </header>


      <form action="postPage.php" method="post">
<!--       <div class="form-group row">
        <div class="col-sm-2 ">
          <label for="exampleSelect1" class="col-form-label">Category select</label>
        </div>
        <div class="col-sm-4">
          <select class="form-control" id="select"  name="selectOption">
            <option>Game discussion</option>
            <option>Solution sharing</option>
            <option>Friends making</option>
          </select>

        </div>
      </div> -->
      <br>
      <div class="form-group row">
        <label for="title" class="col-sm-1 col-form-label">Title:</label>
        <div class="col-sm-6">
          <input class="form-control" type="text"  id="title" name="title">
        </div>
      </div>

      <div class="form-group row">
        <label for="content" class="col-sm-1 col-form-label">Cont:</label>
        <div class="col-sm-6">
          <textarea class="form-control"  rows="10"  id="content" name="content"></textarea>
        </div>
      </div>
        <div class="row">
        <div id="submit" class="col-sm-offset-6">
          <input class="btn btn-success" type="submit" name="submit" value="Post">
        </div>
        </div>
      </form>

    <?php  include_layout_template('footer.php') ?>

  </div>
</body>
</head>
