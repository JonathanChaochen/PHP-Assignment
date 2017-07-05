<?php
// require('../Database/db.php');
// include_once('../Database/MySQLDB.php');



class User extends DatabaseObject implements SavableInterface, InsertInterface
{
  protected static $table_name = "users";
  protected static $table_id = "user_id" ;
  // protected static $db_fields = array('id', 'email', 'firstname', 'lastname');
  protected  $db;
  public    $id;
  public    $firstname;
  public    $lastname;
  public    $fullname;
  protected $password;
  public    $email;

  public    $country;
  public    $gender;
  public    $birthday;

  function __construct(IDatabase $db)
  {
    $this->db = $db;
  }

  //override super class method
  protected static function instantiate ($row)
  {
    global $db;
    $object = new self($db);

    //regular expression replace 'user_'
    $patterns = '/user_/';
    $replacements = '';

    foreach ($row as $attribute=> $value) {
      $attribute = preg_replace($patterns, $replacements, $attribute);
      if($object->has_attribute($attribute))
        $object->$attribute = $value;
    }
    return $object;
  }

  public function full_name()
  {
    if( isset($this->firstname) && ($this->lastname) ){
      $this->fullname = $this->firstname . " " .$this->lastname;
    } else {
      $this->fullname = "";
    }
    return $this->fullname;
  }








  public function insert($firstname, $lastname, $password, $email)
  {
    return "insert into users values
        (
           null,
          '$firstname',
          '$lastname',
          '$password',
          '$email',
           now(),
           0
        )";
  }

  public function setInfo($firstname, $lastname, $password, $email)
  {
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->password = $password;
    $this->email = $email;
  }


  public function save()
  {
    $sql = "insert into users ( user_firstname, user_lastname, user_password,
                            user_email, user_date, user_status, level) values
        (

          '$this->firstname',
          '$this->lastname',
          '$this->password',
          '$this->email',
           NOW() ,
           0,
           0
        )";
    $result = $this->db->query($sql);
    if ($result) {
    echo "<br>User saved ,
    $this->email,
    $this->password<br>";
    }
  }

  public function getByEmail($email)
  {
    $sql = "select * from users
        where user_email = '$email'";
    $result = $this->db->query($sql);
    $row = $result->fetch();
    return $row;
  }

  public function setByEmail($email)
  {
    $sql = "select * from users
        where user_email = '$email'";
    $result = $this->db->query($sql);
    $row = $result->fetch();
    $this->id         = $row['user_id'];
    $this->email      = $row['user_email'];
    $this->firstname  = $row['user_firstname'];
    $this->lastname   = $row['user_lastname'];
    $this->full_name();
    // return $row;
  }





  public function getPassword($email)
  {

    $sql = "select user_password from users
        where user_email = '$email'";
    $result = $this->db->query($sql);
    $row = $result->fetch();
    return $row['user_password'];
  }




  public static function changeStatus($email, $status)
  {
    global $db;
    $sql = "UPDATE users
            SET user_status = '$status'
            WHERE user_email = '$email'";
    $result = $db->query($sql);
  }

  public static function checkLevel($email)
  {
    global $db;
    $sql = "SELECT level
            FROM  users
            WHERE user_email = '$email'";
    $result = $db->query($sql);
    $data = $result->fetch();

    if ($data['level']){
      return true;
    } else {
      return false;
    }
  }


  public static  function getActiveUser()
  {
    global $db;

    return self::find_by_sql("
            SELECT *
            FROM ".self::$table_name
            ." WHERE user_status = 1 ");
  }


  public static  function searchUser($theWords)
  {
    global $db;
    $sql = "SELECT user_id, Concat(user_firstname, ' ', user_lastname) as'username'
        FROM users
    WHERE user_firstname LIKE '%$theWords%' OR user_lastname LIKE '%$theWords%'
    ";
      $result = $db->query($sql);


      while ( $aRow =  $result->fetch() )
      {

          $outputLine = "<p>ID: $aRow[user_id]</p>";
          $outputLine .= "<p>User: <a  href='../Profile/userProfile.php?user_id=$aRow[user_id]'>$aRow[username]</a></p>";

          echo $outputLine;
      }
  }

  /*
  * profile update function      edit
  */


  public static function updateUserProfile( $id, $country, $gender, $birthday )
  {
    global $db;
    $sql = "UPDATE users
    SET country = '$country', gender = '$gender', birthday = '$birthday'
    WHERE user_id = '$id'
    ";
      $result = $db->query($sql);
      return ($result)? true: false;

  }



}
