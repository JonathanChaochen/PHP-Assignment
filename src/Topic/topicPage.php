<?php
require_once  ('../Include/initialize.php');


  // if ( User::checkLevel($email) ) {
  //   $level = true;
  //   $_SESSION['level'] = $level;
  // }

include_once('../Layout/langSetting.php');

  if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
  {
    try
    {

      if (!isset($_SESSION['user_logged_in']))
      {
        throw new Exception('Please log in first');
      }



    // get user  by email

    $t_id = $_SESSION['t_id'];

    if(! $user=User::getByID($_SESSION['user_id']) )
    {
      throw new Exception('Invalid user id');
    }




    // reset bans table by checking date
    banValue($db);

    // if ban == 1 cannot post
    $sql="SELECT ban, unban_date FROM bans
    WHERE user_id = " . $user->id . "
    LIMIT 1";
    $result = $db->query($sql);
    $row = $result->fetch();

    if($row['ban'] == 1)
    {
        throw new Exception('YOU are banned, you can not reply now');
    }



    // get topic id by current subject
    $topic = Topic::getById($t_id);

    if( !$topic->id )
    {
      throw new Exception('Invalid Topic');
    }

    $reply = new Reply($db);

    // grab the variables from the form
    $reply_content  = filter_input(INPUT_POST, 'reply_content', FILTER_SANITIZE_STRING);

    if (!$reply_content)
    {
      throw new Exception('Invalid content');
    }


    $reply->setReply($reply_content , $topic->id, $user->id);
    $reply->save();



     // Redirect to topicPage.php
     // header('HTTP/1.1 302 Redirect');
     // header ("Location:topicPage.php") ;
     // die();

   }

   catch (Exception $e)
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
  <meta charset="utf-8">
  <title><?= $lang->translateWord('Reply') ?></title>


</head>

<body class="pic">
  <div class="container">
    <h1><?= $lang->translateSentence('Theseus and Minotaur forum') ?></h1>

    <div class="topic_content row">

        <div class="userface col-sm-1">
          <a href=""><img src="../../images/atomix_user31.png"></a>
        </div>
        <div class="col-sm-6">
        <?php
        // session_start();
        if($_SERVER[ 'QUERY_STRING' ]) {
          // $subject =  urldecode($_SERVER[ 'QUERY_STRING' ]);
          $t_id = $_SERVER[ 'QUERY_STRING' ];
          $_SESSION['t_id'] = $t_id;
        } else {
          $t_id = $_SESSION['t_id'];
        }

        $topic = getTopic($db, $t_id);
        displayTopic($topic);

        ?>
<!--  <p>From:John 19/04/2017 15:13:11</p>


    <h3>Hello, How to solve the level 7</h3>
    <p>I feel I am not good at this game, This level is still
    hard for me. I cannot get out of the maze before killed by minotaur. Anyone can help me, please</p> -->
    </div>

  </div>
  <br>

    <?php
      $re = getReply($db, $t_id);
      displayReply($re);


     ?>


  <br>

  <form class="row" action="topicPage.php" method="POST">
    <textarea rows="5" class="col-sm-7" name="reply_content"></textarea>

    <div id="submit" class="col-sm-offset-6 col-sm-1">
      <input class="btn btn-success align-self-end" type="submit" name="submit" value="<?= $lang->translateWord('Reply')  ?>">
      </div>
  </form>


  <?php  include_layout_template('footer.php') ?>




</body>
</head>
