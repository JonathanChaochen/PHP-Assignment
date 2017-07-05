<?php
require_once  ('src/Include/initialize.php');

// include_once "src/Entity Class/topic.php";

//1. the current page
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;


//2. record per page ($per_page)
$per_page = 4;

//3. total record count ($total_count)
$topic_number = $total_count = Topic::count_all();
// // use pagination

$pagination = new Pagination($page, $per_page, $total_count);

// $sql = "SELECT * FROM users ";
// $sql .= "LIMIT {$per_page} ";
// $sql .= "OFFSET {$pagination->offset()}";
// $users= User::find_by_sql($sql);

//laguage selection
if( isset($_SESSION['lang']) ){
  $locale = $_SESSION['lang'];
} else {
  $locale = 'en';
}

$allowed_lang = array('en', 'ma', 'ch');

if( isset($_GET['language']) && in_array($_GET['language'],$allowed_lang) ){
  $locale = $_GET['language'];
  $_SESSION['lang'] = $_GET['language'];
}

$lang = new LanguageParser($locale);


// $sentence = 'hello my name is elliot';
// $lang->translateSentence($sentence);

// echo $word;

 ?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="css/stylesheets.css">

   <title><?= $lang->translateWord('forum') ?></title>
</head>
<body>
  <div class="container">

  <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Language
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <li><a href="index.php?language=en">English</a></li>
      <li><a href="index.php?language=ma">Maori</a></li>
      <li><a href="index.php?language=ch">Chinese</a></li>
    </ul>
  </div>


  <div class="row">


    <h1 id="id" ><?= $lang->translateSentence('Theseus and Minotaur forum') ?></h1>
    <?php
      // session_start();
      if(isset($_SESSION['level'])) {
        echo "<a class='btn btn-success' href='src/Admin/dashboard.php'>Dashboard</a>";
      }

     ?>

      <p>
        <?php

        /*
         *  session expire management
         */
        if(isset($_SESSION['expire']) ) {
          $now = time(); // Checking the time now when home page starts.

          if ($now > $_SESSION['expire']) {
              session_unset();
              session_destroy();
              echo "Your session has been timed out!  Please <a href='Login/login.php'>Login here</a>";
          } else {
            $_SESSION['expire'] = $now  + (10 * 60);
          }



        /*
         *  show login username
         */
        if(isset($_SESSION['user_logged_in']) ){
          $email =  $_SESSION['user_email'];
          $user = new User($db);

          // $user->getUsername($email) ;

          $user->setByEmail($email) ;

          echo "<p>  <a href='src/Profile/userProfile.php?user_id=$user->id'>$user->fullname </a></p>";

        }

        }

        ?>
      </p>
    <div class="btn-group  pull-right">
      <?php
      if(isset($_SESSION['user_logged_in']) )
       {
        echo "<a href='src/Login/logout.php' class='btn btn-success'>".$lang->translateWord('Log Out')."</a>";
       }
       else
       {
        echo "<a href='src/Login/login.php' class='btn btn-success'>".$lang->translateWord('Log In')."</a>";
       }

      ?>


      <a href="src/Login/register.php" class="btn btn-primary"><?= $lang->translateWord('Sign Up') ?></a>

    </div>
    <br>

  </div>
    <header>



    <a class="btn btn-success" href="src/Login/loginBeforePost.php"><?=$lang->translateWord('Post a new topic') ?></a>
    </header>


  <br>
    <?php echo "$topic_number ".  $lang->translateWord('topics in total. You are at page') ."  $pagination->current_page ". $lang->translateWord('of') ." ";
    echo $pagination->total_pages();?>

    <div class="row">
    <table class="table">

        <?php
        $products = getForum($db) ;
        displayForum($products);
         ?>

    </table>


    <?php
        include('src/Layout/paginator.php');
     ?>



<!-- search form -->
    <form action="src/Search/searchResult.php" method="post">
    <div class="input-group">
      <input type="text" class="form-control" name='theWords' value='<?php if (isset($theWords))  echo htmlentities($theWords, ENT_QUOTES, 'UTF-8');?>' placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-info" type="submit">
          <?= $lang->translateWord('Search') ?>
        </button>
      </span>
    </div>

    </form>




  </div>

  <footer>
    <p>&copy; <?=$lang->translateWord('Chao Chen') ?>, Ara, <?= date('Y', time()); ?></p>
  </footer>
</body>
</html>
