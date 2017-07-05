<?php
// require('../Database/db.php');
// include_once('../Database/MySQLDB.php');

define("TBL_MESSAGES", "messages");

// session_start();

class Message  implements DeletableInterface
{
  protected $db;

  public function __construct(IDatabase $db)
  {
    //database
    $this->db = $db;
    //content
  }

  /**
  * $TO = USER_ID for which the message is meant
  * $MESSAGE = message that is sent to a user
  * $SUBJECT = subject of a message
  * $RESPOND = ID of conversation to which this message is a part of
  **/
  public function send_message($to, $message, $subject, $respond = 0)
  {
    $from = $_SESSION['user_id']; // ID of a user sending a message
    $message = $this->validate_message($message); // validate message to see if it safe, to be passed to the database

    // $sql = " INSERT INTO replies VALUES(200, 'Remeber that Minotaur moving across before down', '2016-09-04 17:15:25',1000, 102);";
    //  $result = $db->query($sql);


    if($respond == 0){
      $sql = "INSERT INTO messages
      (user_to, user_from, subject, message, message_date)
      VALUES( '$to' ,
              '$from',
              '$subject' ,
              '$message',
                NOW()
            )";
    }else{
      $sql = "INSERT INTO messages
       (user_to, user_from, subject, message, respond, message_date)
       VALUES( '$to' ,
               '$from',
               '$subject' ,
               '$message',
               '$respond',
                 NOW()
             )";
    }
    if($this->validate_message($message)){
      $this->db->query($sql);

      return TRUE;
    }else{
      return FALSE;
    }
  } // END send_message

  public function get_number_of_unread_messages(){
    $id = $_SESSION['user_id'];
    $sql = "SELECT COUNT(id) AS unread FROM messages
    WHERE user_to = '$id' AND respond = '0'";
    return $this->db->query($sql);
  } // END get_number_of_unread_messages



  public function get_all_messages()
  {
    $role = "sender_delete";
    $id = $_SESSION['user_id'];
    // $results = $this->db->query("
    //   SELECT user_to
    //   FROM messages
    //   WHERE id = '$id'
    //   ");

    //   while($data = $results->fetch($results)){
    //   if($data->user_to != $id){
    //     $role = "receiver_delete";
    //   }
    // }
    $query = "SELECT m.id, m.subject, m.message, m.respond, m.message_date, u.user_id,
     Concat(u.user_firstname, ' ', u.user_lastname) as'username' FROM messages m
    INNER JOIN users u ON u.user_id = m.user_from
    WHERE m.user_to = '$id'  AND m.respond = 0 AND '$role' != 'n'
    order by m.message_date DESC ";
    return $this->db->query($query);
  } // END get_all_messages


  /**
    * displayMessage function      messagePage
  */
   function displayAllMessage ($results)
   {
      global $lang;
      $number = 0;
      while( $data = $results->fetch() ){
        $number += 1;
        $outputLine = "<div class='message'><h4> ". $lang->translateWord('Message')." $number</h4>";
        $outputLine .=  $lang->translateWord('From').": <a  href='../Profile/userProfile.php?user_id=$data[user_id]'> $data[username]</a>";
        $outputLine .= "<p> ".$lang->translateWord('Send time').": $data[message_date]</p>";
        $outputLine .= "<p> ".$lang->translateWord('subject').": $data[subject]</p>";
        $outputLine .= "<p> ".$lang->translateWord('content').": $data[message]</p>";
        $outputLine .= "<a class='btn btn-danger' href='editMessage.php?message_id=$data[id]'>".$lang->translateWord('Delete')."</a></div> ";
        echo $outputLine;
      }
   }

  public function get_message($message_id)
  {
    $role = "sender_delete";
    $id = $_SESSION['user_id'];
    $results = $this->db->query("SELECT user_to FROM " . TBL_MESSAGES . " WHERE id = '" . $message_id . "'");
    while( $data = $results->fetch() ){
      if($data['user_to'] != $id){
        $role = "receiver_delete";
      }
    }
    $results = $this->db->query("SELECT * FROM " . TBL_MESSAGES . " WHERE id = '" . $message_id . "' AND (user_to = '" . $id . "' OR user_from = '" . $id . "') OR respond = '" . $message_id . "' AND " . $role . " != 'n'");
    return $results;
  } // END get_message



  public static function delete($id)
  {
    global $db;
    $results = $db->query("DELETE FROM messages
    WHERE id = '$id'");
  }


  private function check_for_deleted_messages(){
    $this->db->query("DELETE FROM messages WHERE sender_delete = 'y' AND receiver_delete 'y'"); // removes messages from DB if both sender and receiver have deleted it.
  } // END _check_for_deleted_messages



  /**
  * $message = message that will be validate for security purposes
  **/
  private function validate_message($message){
    $return = trim($message); // trims all the white space at the beginning and the end of string
    $return = filter_var($message, FILTER_SANITIZE_STRING); // strips tags
    $return = filter_var($message, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Equivalent to calling htmlspecialchars()
    return $return;
  } // END _validate_message
} // END class


