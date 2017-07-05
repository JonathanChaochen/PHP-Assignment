<?php
// require('../Database/db.php');
// include_once('../Database/MySQLDB.php');



class Reply  extends DatabaseObject implements SavableInterface, CountableMyInterface
{
  protected static $table_name = "replies";
  protected static $table_id = "reply_id" ;
  protected $db;
  public    $id;
  public    $content;
  public    $topic_id;
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

    //regular expression replace 'reply_'
    $patterns = '/reply_/';
    $replacements = '';

    foreach ($row as $attribute=> $value) {
      $attribute = preg_replace($patterns, $replacements, $attribute);
      if($object->has_attribute($attribute))
        $object->$attribute = $value;
    }
    return $object;
  }

  public function setReply($content, $topic_id, $user_id)
  {
    $this->content = $content;
    $this->topic_id = $topic_id;
    $this->user_id = $user_id;
  }


  public static function count_my($id)
  {
    global $db;
    $sql = "SELECT  COUNT(*)
          from replies
          WHERE user_id = $id
    ";
    $result = $db->query($sql);
    $row = $result->fetch();
    return array_shift($row);
  }


  public function save()
  {
    $sql = "insert into replies values
        (
          null,
          '$this->content',
          now(),
          '$this->topic_id',
          '$this->user_id'

        )";
    $result = $this->db->query($sql);
  }

  /**
    * delete reply    topicPage by admin
  */



}
