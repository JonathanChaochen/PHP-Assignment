<?php




Interface SavableInterface
{
  public function save();
}


Interface DeletableInterface
{
  public static function delete($id);
}

Interface InsertInterface
{
  public function insert($firstname, $lastname, $password, $email);
}

Interface CountableMyInterface
{
  public static function count_my($id);
}

Interface CountableAllInterface
{
  public static function count_all();
}

Interface GetableAllInterface
{
  public static function getAll();
}



