<?php
require_once  ('../Include/initialize.php');

if(!isset($_SESSION['user_id']))
{
  echo "<h3>Please Login in first before like it.<h3>";
  header('Refresh: 1; URL=topicPage.php');
  // header("Location: ../Login/login.php");
} else {


    if( isset($_GET['type'],$_GET['reply_id']))
    {
      $type = $_GET['type'];
      $id = (int)$_GET['reply_id'];

      switch ($type) {
        case 'comment':
          $sql ="INSERT INTO replies_likes (user_id, reply_id)
                 SELECT {$_SESSION['user_id']}, {$id}
                 FROM replies
                 WHERE EXISTS (
                      SELECT reply_id
                      FROM replies
                      WHERE reply_id = {$id})
                 AND NOT EXISTS (
                      SELECT id
                      FROM replies_likes
                      WHERE user_id = {$_SESSION['user_id']}
                      AND reply_id = {$id})
                      LIMIT 1";
          $db->query($sql);
          break;

        default:
          # code...
          break;
      }

    }

    header("Location: topicPage.php");
}

