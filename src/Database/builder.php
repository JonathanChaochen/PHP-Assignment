<?php
include_once 'MySQLDB.php';
require 'db.php';


class Builder
{
  public function buildDatabase()
  {
    global $db;
    $db->dropDatabase();
    //  create the database again
    $db->createDatabase(); // worked
    // select the database
    $db->selectDatabase(); // worked

    // drop the tables
    $sql = "drop table if exists users";
    $result = $db->query($sql);

    $sql = "drop table if exists topics";
    $result = $db->query($sql);

    $sql = "drop table if exists replies";
    $result = $db->query($sql);

    $sql = "drop table if exists messages";
    $result = $db->query($sql);

    $sql = "drop table if exists replies_likes";
    $result = $db->query($sql);

    $sql = "drop table if exists bans";
    $result = $db->query($sql);

    // create the tables
    /* USERS */
    $sql = "CREATE TABLE users
    (
      user_id     INT(10) NOT NULL AUTO_INCREMENT,
      user_firstname   VARCHAR(30) NOT NULL,
      user_lastname   VARCHAR(30) NOT NULL,
      user_password   VARCHAR(255) NOT NULL,
      user_email  VARCHAR(255) NOT NULL,
      user_date   DATETIME NOT NULL,
      user_status  INT(20) NOT NULL,
      country     VARCHAR(255),
      gender      VARCHAR(255),
      birthday    DATE,
      level      INT(20) NOT NULL,
      -- UNIQUE INDEX user_name_unique (user_name),
      PRIMARY KEY (user_id)
    )";

    $result = $db->query($sql);
    if ($result)
    {
      echo 'the users table was added<br>';
    }
    else
    {
      echo 'the users table was not added<br>';
    }


    /* TOPICS */
    $sql = "CREATE TABLE topics
    (
      topic_id        INT(10) NOT NULL AUTO_INCREMENT,
      topic_subject       VARCHAR(255) NOT NULL,
      topic_content      TEXT,
      topic_date      DATETIME NOT NULL,
      -- cat_id      INT(10) NOT NULL,
      user_id        INT(10) NOT NULL,
      -- FOREIGN KEY(cat_id) REFERENCES categories(cat_id) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
      PRIMARY KEY (topic_id)

    )";

    //  execute the sql query
    $result = $db->query($sql);
    if ($result)
    {
       echo 'the topics table was added<br>';
    }
    else
    {
       echo 'the topics table was not added<br>';
    }

    /* REPLIES */
    $sql = "CREATE TABLE replies
    (
      reply_id         INT(10) NOT NULL AUTO_INCREMENT,
      reply_content        TEXT NOT NULL,
      reply_date       DATETIME NOT NULL,
      topic_id      INT(10) NOT NULL,
      user_id    INT(10) NOT NULL,

      FOREIGN KEY(topic_id) REFERENCES topics(topic_id) ON DELETE CASCADE ON UPDATE CASCADE,
      FOREIGN KEY(user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
      PRIMARY KEY (reply_id)
    )";

    //  execute the sql query
    $result = $db->query($sql);
    if ($result)
    {
       echo 'the replies table was added<br>';
    }
    else
    {
       echo 'the replies table was not added<br>';
    }


    /* MESSAGE */
    $sql = "CREATE TABLE  `messages` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_to` int(11) NOT NULL,
    `user_from` int(11) NOT NULL,
    `subject` varchar(100) CHARACTER SET latin1 NOT NULL,
    `message` text CHARACTER SET latin1 NOT NULL,
    `respond` int(11) NOT NULL DEFAULT '0',
    `sender_open` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'y',
    `receiver_open` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
    `sender_delete` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
    `receiver_delete` enum('y','n') CHARACTER SET latin1 NOT NULL DEFAULT 'n',
    `message_date` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
    )";

    //  execute the sql query
    $result = $db->query($sql);
    if ($result)
    {
       echo 'the messages table was added<br>';
    }
    else
    {
       echo 'the messages table was not added<br>';
    }


    $sql="CREATE TABLE replies_likes (
    id        INT(10) NOT NULL AUTO_INCREMENT,
    user_id    INT(10) NOT NULL,
    reply_id         INT(10) NOT NULL,
    FOREIGN KEY(user_id ) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(reply_id) REFERENCES replies(reply_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id)
    )";

    //  execute the sql query
    $result = $db->query($sql);
    if ($result)
    {
       echo 'the replies_likes table was added<br>';
    }
    else
    {
       echo 'the replies_likes table was not added<br>';
    }

    $sql="CREATE TABLE bans (
    id        INT(10) NOT NULL AUTO_INCREMENT,
    user_id    INT(10) NOT NULL,
    ban         INT(10) NOT NULL DEFAULT 0,
    unban_date  DATETIME NOT NULL DEFAULT  NOW(),
    FOREIGN KEY(user_id ) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id)
    )";

    //  execute the sql query
    $result = $db->query($sql);
    if ($result)
    {
       echo 'the bans table was added<br>';
    }
    else
    {
       echo 'the bans table was not added<br>';
    }


  }

  public function insertData()
  {
    global $db;
    /* INSERT DATA  user */
      $password = password_hash('123456', PASSWORD_DEFAULT);

        $sql = "INSERT INTO users VALUES(101, 'Oliver', 'Maroney', '$password', '123456@gmail.com', '2014-06-18 10:34:09', 0,'USA','Male','1992-09-18', 1);";

        //  execute the sql query
        $result = $db->query($sql);


        $password = password_hash('12345678', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users VALUES(NULL, 'Chris', 'Miller', '$password', '1122334@gmail.com', '2014-07-08 16:38:33', 0, 'UK', 'Male','1991-01-24', 0);";

        //  execute the sql query
        $result = $db->query($sql);

        $password = password_hash('12345678', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users VALUES(NULL, 'Sarah', 'Fisher', '$password', '333333@gmail.com', '2015-12-04 17:24:11', 0, 'UK', 'Female','1994-06-14', 0);";

        //  execute the sql query
        $result = $db->query($sql);




    /* INSERT DATA  topic */

       $sql = " INSERT INTO topics VALUES(1000, 'How to solve the level 5', 'Wow, after level 4, Game becoming difficult for me.
        Always killed by minotaur. Anyone can help me, please', '2016-09-03 19:13:32', 101);";
        $result = $db->query($sql);


        $sql = " INSERT INTO topics VALUES(1001, 'Interesting funny facts about Minotaur', 'Wow, after level 4, Game becoming difficult for me.
         Always killed by minotaur. Anyone can help me, please', '2016-10-03 16:34:29', 102);";
         $result = $db->query($sql);

        $sql = " INSERT INTO topics VALUES(NULL, 'Do you know about Theseus?', 'I am curious about the story of theseus, If anyone know the info
        please share with me', '2016-10-12 13:30:05', 102);";
          $result = $db->query($sql);

        $sql = " INSERT INTO topics VALUES(NULL, 'The Theseus and Minotaur Game', 'I heard this game is from ancient Greek Myth, anyone can tell me
the story.', '2016-11-09 11:02:38', 103);";
          $result = $db->query($sql);

          $sql = " INSERT INTO topics VALUES(NULL, 'Who want to play the game together?', 'I would like to meet some person who like this game too', '2016-12-01 15:02:38', 103);";
            $result = $db->query($sql);

          $sql = " INSERT INTO topics VALUES(NULL, 'Dinner arranged for community members?', 'The location and time will announce later any one who
           want to join just reply below. Thanks', '2016-12-14', 101);";
          $result = $db->query($sql);

          $sql = " INSERT INTO topics VALUES(NULL, 'Hello, How to solve the level 7', 'I feel I am not good at this game, This level is still
 hard for me. I cannot get out of the maze before killed by minotaur. Anyone can help me, please', '2016-10-12 12:09:39', 101);";
           $result = $db->query($sql);

          $sql = " INSERT INTO topics VALUES(NULL, 'How to solve the level 8', 'Looking for help again. This level is still
        hard for me. I cannot get out of the maze before killed by minotaur. Anyone can help me, please', '2016-10-14 12:45:30', 101);";
          $result = $db->query($sql);


    /* INSERT DATA  reply */

       $sql = " INSERT INTO replies VALUES(200, 'Remeber that Minotaur moving across before down', '2016-09-04 17:15:25',1000, 102);";
        $result = $db->query($sql);


        $sql = " INSERT INTO replies VALUES(201, 'Theseus, a genuine Greek hero of the Mythology and Minotaur, one of the most devastating and terrifying monsters are the main protagonists of a myth that involves gods and monsters.', '2016-12-18 15:33:22',1001, 101);";
         $result = $db->query($sql);


         $sql = " INSERT INTO replies VALUES(202, 'Haha, I know it is hard. using your mind, bro.', '2016-12-18 15:33:22',1006, 103);";
          $result = $db->query($sql);


         $sql = " INSERT INTO replies VALUES(NULL, 'I am in.', '2016-12-14 22:39:18',1005, 103);";
          $result = $db->query($sql);

          $sql = " INSERT INTO replies VALUES(NULL, 'I would love to.', '2016-12-15 22:32:55',1005, 102);";
           $result = $db->query($sql);


           $sql = "INSERT INTO bans( user_id ) values ( 101 )";
           $db->query($sql);
           $sql = "INSERT INTO bans( user_id ) values ( 102 )";
           $db->query($sql);
           $sql = "INSERT INTO bans( user_id ) values ( 103 )";
           $db->query($sql);

  }


}

