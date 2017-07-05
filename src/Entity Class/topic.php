<?php
// include_once('../Database/db.php');
// include_once('../Database/MySQLDB.php');



class Topic  extends DatabaseObject implements SavableInterface, CountableMyInterface
{
  protected static $table_name = "topics";
  protected static $table_id = "topic_id" ;
  protected $db;
  public    $id;
  public    $subject;
  public    $content;
  public    $user_id;


  public function __construct(IDatabase  $db)
  {
    //database
    $this->db = $db;
    //content
  }

  //override super class method
  protected static function instantiate ($row)
  {
    global $db;
    $object = new static($db);

    //regular expression replace 'topic_'
    $patterns = '/topic_/';
    $replacements = '';

    foreach ($row as $attribute=> $value) {
      $attribute = preg_replace($patterns, $replacements, $attribute);
      if($object->has_attribute($attribute))
        $object->$attribute = $value;
    }
    return $object;
  }

  public function setTopic($subject, $content, $user_id)
  {
    $this->subject = $subject;
    $this->content = $content;
    $this->user_id = $user_id;
  }

  // public function get($t_id)
  // {
  //   global $db;
  //   $sql = "select * from topics
  //       where topic_id = '$t_id'";
  //   $result = $db->query($sql);
  //   $row = $result->fetch();
  //   return $row;
  // }



  public static function count_my($id)
  {
    global $db;
    $sql = "SELECT  COUNT(*)
          from topics
          WHERE user_id = $id
    ";
    $result = $db->query($sql);
    $row = $result->fetch();
    return array_shift($row);
  }



  public function save()
  {
    $sql = "insert into topics values
        (
          null,
          '$this->subject',
          '$this->content',
          now(),
          '$this->user_id'
        )";
    $result = $this->db->query($sql);
  }

  /**
    * delete topic   index by admin
  */


}
