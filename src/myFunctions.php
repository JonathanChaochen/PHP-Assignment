<?php
/*
* forum function     index  /**
* search function      searchResult
*/



function getForum($db , $theWords="")
{
  global $per_page;
  global $pagination;
  $sql = "SELECT t.topic_id, t.topic_subject, u.user_id, Concat(u.user_firstname, ' ', u.user_lastname) as'username', t.topic_date, COUNT(r.reply_id) AS replies
  FROM topics t
  INNER JOIN users u ON u.user_id = t.user_id
  LEFT JOIN replies r ON t.topic_id = r.topic_id
  WHERE topic_subject LIKE '%$theWords%'
  GROUP BY t.topic_id
  ORDER BY topic_date DESC
  ";
  $sql .= "LIMIT {$per_page} ";
  $sql .= "OFFSET {$pagination->offset()}";
  $result = $db->query($sql);

  return $result;
}

function getForum2($db , $theWords="")
{
  $sql = "SELECT t.topic_id, t.topic_subject, u.user_id, Concat(u.user_firstname,
  ' ', u.user_lastname) as'username', t.topic_date, COUNT(r.reply_id) AS replies
  FROM topics t
  INNER JOIN users u ON u.user_id = t.user_id
  LEFT JOIN replies r ON t.topic_id = r.topic_id
  WHERE topic_subject LIKE '%$theWords%'
  GROUP BY t.topic_id
  ORDER BY topic_date DESC
  ";
  $result = $db->query($sql);
  echo "there were " . $result->size() . " rows <br />";
  return $result;
}

function displayForum($products)
{
  global $lang;
  $outputhead = '<tr><th>'.$lang->translateWord('Topic').'</th>';
  $outputhead .= '<th>'.$lang->translateWord('Author').'</th>';
  $outputhead .= '<th>'.$lang->translateWord('Reply').'</th>';
  $outputhead .= '<th>'.$lang->translateSentence('Post time').'</th></tr>';
  echo $outputhead;
  while ( $aRow =  $products->fetch() )
  {
      $outputLine = "<tr><td>";

      if (isset($_SESSION['level'])) {
      $outputLine .= "<a class='btn btn-xs btn-danger' href='src/Topic/deleteTopic.php?topic_id=$aRow[topic_id]' >Delete</a>";
      }

      $outputLine .=" <a  href='src/Topic/topicPage.php?$aRow[topic_id]'>". htmlspecialchars($aRow['topic_subject'] )."</a></td>";
      $outputLine .= "<td> <a  href='src/Profile/userProfile.php?user_id=$aRow[user_id]'>
              $aRow[username]</td>";
      $outputLine .= "<td>$aRow[replies]</td>";
      $outputLine .= "<td>$aRow[topic_date]</td></tr>";
      echo $outputLine;
  }

}

function displayForum2($products)
{
  global $lang;
  $outputhead = '<tr><th>'.$lang->translateWord('Topic').'</th>';
  $outputhead .= '<th>'.$lang->translateWord('Author').'</th>';
  $outputhead .= '<th>'.$lang->translateWord('Reply').'</th>';
  $outputhead .= '<th>'.$lang->translateSentence('Post time').'</th></tr>';
  echo $outputhead;
  while ( $aRow =  $products->fetch() )
  {
      $outputLine = "<tr><td>";

      if (isset($_SESSION['level'])) {
      $outputLine .= "<a class='btn btn-xs btn-danger' href='src/Topic/deleteTopic.php?topic_id=$aRow[topic_id]' >Delete</a>";
      }

      $outputLine .=" <a  href='../Topic/topicPage.php?$aRow[topic_id]'> $aRow[topic_subject] </a></td>";
      $outputLine .= "<td> <a  href='../Profile/userProfile.php?user_id=$aRow[user_id]'>
              $aRow[username]</td>";
      $outputLine .= "<td>$aRow[replies]</td>";
      $outputLine .= "<td>$aRow[topic_date]</td></tr>";
      echo $outputLine;
  }

}

/*
 * topic function      topicPage
 */
function getTopic($db,$id)
{
    $sql = "SELECT t.topic_subject, t.topic_content, u.user_id, u.user_firstname, u.user_lastname, t.topic_date
    FROM topics t
    INNER JOIN users u ON u.user_id = t.user_id
    WHERE topic_id = '$id'
    ";
    $result = $db->query($sql);
    // echo "there were " . $result->size() . " rows <br />";
    return $result;
}

function displayTopic($products)
{
  global $lang;
  while ( $aRow =  $products->fetch() )
  {
      $outputLine = "<p>". $lang->translateWord('From') .": <a href=../Profile/userProfile.php?user_id=$aRow[user_id]> $aRow[user_firstname] $aRow[user_lastname]</a>";
      $outputLine .= " $aRow[topic_date]</p>";
      $outputLine .= "<h3>". htmlspecialchars($aRow['topic_subject'] )."</h3>";
      $outputLine .= "<p>$aRow[topic_content]</p>";
      echo $outputLine;
  }
}


/*
 * reply function       topicPage
 */
function getReply($db,$t_id)
{
    $sql = "SELECT  r.reply_id, r.reply_content, u.user_firstname, u.user_id,
    u.user_lastname, r.reply_date, t.topic_subject, COUNT(rl.id) AS likes,
     GROUP_CONCAT(u.user_firstname separator '|') AS like_by
    FROM replies r
    INNER JOIN users u ON u.user_id = r.user_id
    INNER JOIN topics t ON r.topic_id = t.topic_id
    LEFT  JOIN   replies_likes rl ON r.reply_id = rl.reply_id
    WHERE t.topic_id = '$t_id'
    GROUP BY r.reply_id
    ORDER BY reply_date
    ";
    $result = $db->query($sql);
    // echo "there were " . $result->size() . " rows <br />";
    return $result;
}

function displayReply($products)
{
  global $lang;
  while ( $aRow =  $products->fetch() )
  {
      $outputLine = "
  <div class='row'>
    <div class='col-sm-1'>
      <img src='../../images/atomix_user31.png'>
    </div>

    <div class='col-sm-6'>";
      $outputLine .= "<p class='example'>". $lang->translateWord('From') .": <a href=../Profile/userProfile.php?user_id=$aRow[user_id]> $aRow[user_firstname] $aRow[user_lastname] </a> $aRow[reply_date] ";
      $outputLine .= " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp";
      $outputLine .= "<a href='likes.php?type=comment&reply_id=$aRow[reply_id]'><span class='glyphicon glyphicon-thumbs-up'></span></a> $aRow[likes] ". $lang->translateWord('people like this') ."</p>";
      $outputLine .= "<p>$aRow[reply_content]</p>";
      if (isset($_SESSION['level'])) {
      $outputLine .= "<p><a class='btn btn-xs btn-danger' href='deleteComment.php?reply_id=$aRow[reply_id]'' >Delete</a></p>";
      }

      $outputLine .= "
    </div>
  </div>";
      echo $outputLine;
  }
}

//ban user
function ban($db, $user_id, $days)
{
  $sql = "UPDATE bans
          SET unban_date = DATE_ADD(NOW(), INTERVAL $days DAY)
          WHERE user_id = $user_id
          ";

  $result = $db->query($sql);
  return $result;
}

function banValue($db)
{
  global $user;
  $sql="UPDATE bans SET ban = 1 WHERE unban_date >= NOW() ";
  $db->query($sql);

  $sql="UPDATE bans SET ban = 0 WHERE unban_date < NOW() ";
  $db->query($sql);


  // if ban == 1 cannot post
  $sql="SELECT ban, unban_date FROM bans
  WHERE user_id = " . $user->id . "
  LIMIT 1";
  $result = $db->query($sql);
  $row = $result->fetch();
  return $row;
}


//auload class file
function __autoload( $class_name ) {
  $class_name = strtolower($class_name);
  $path = Class_PATH . DS ."{$class_name}.php";


  if( file_exists($path) ){
    require_once($path);
  } else{
    die("The File {$class_name}.php could not be found");
  }

}

//including layout
function include_layout_template($template="")
{
  include(SITE_ROOT.DS.'src'.DS.'Layout'.DS.$template);
}


