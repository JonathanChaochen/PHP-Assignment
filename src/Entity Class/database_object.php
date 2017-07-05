<?php

//super class
class DatabaseObject implements DeletableInterface, CountableAllInterface, GetableAllInterface
{


  public static function getAll()
  {
    global $db;
    return static::find_by_sql("
            SELECT *
            FROM ".static::$table_name);
  }

  public static function find_by_sql($sql="")
  {
    global $db;
    $result = $db->query($sql);
    $object_array = array();
    while( $row = $result->fetch() ){
      $object_array[] = static::instantiate($row);
    }
    return $object_array;
  }

  public static function getById($id)
  {
    // global $db;
    $sql = "SELECT *
    FROM ".static::$table_name."
    WHERE ". static::$table_id ." = '$id'
    LIMIT 1";
    $result = static::find_by_sql($sql);
    return !empty($result) ? array_shift( $result ) : false;

    // $row = $result->fetch();
    // return $row;
  }

  protected static function instantiate ($row)
  {
    global $db;
    $object = new static($db);

    //country gender birthday instantiate by this method
    foreach ($row as $attribute=> $value) {
      if($object->has_attribute($attribute))
        $object->$attribute = $value;
    }

    return $object;
  }

  protected function has_attribute($attribute)
  {
    $object_vars = get_object_vars($this);
    return array_key_exists($attribute, $object_vars);
  }

  public static function count_all()
  {
    global $db;
    $sql = "SELECT  COUNT(*)
          from " . static::$table_name;
    $result = $db->query($sql);
    $row = $result->fetch();
    return array_shift($row);
  }

  public static function delete($id)
  {
    global $db;
    $sql = "DELETE FROM " .static::$table_name ."
           WHERE ". static::$table_id ." = ".$id ." LIMIT 1";
    $result = $db->query($sql);
    return $result ? true: false;
  }

}



