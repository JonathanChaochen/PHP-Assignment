<?php
require_once  ('../Include/initialize.php');

include_once('../Database/builder.php');

include_once('../Layout/langSetting.php');

/*
POST /register.php HTTP/1.1
Content-Length: 43
Content-Type: application/x-www-form-urlencoded

email=john@example.com&password=sekritshhh!
*/
// $build = new Builder();
// $build->buildDatabase();
// $build->insertData();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  try
  {
    $user = new User($db);
    // validate firstname
    $firstname = filter_input(INPUT_POST, 'firstname');
    if (!$firstname || strlen($firstname) < 2 )
    {
      throw new Exception('Invalid firstname or too short');
    }

    if(strlen($firstname) > 30 )
      {
        throw new Exception('firstname too long');
      }

    // validate latname
    $lastname = filter_input(INPUT_POST, 'lastname');
    if (!$lastname || strlen($lastname) < 2)
    {
      throw new Exception('Invalid lastname or too short');
    }

    if(strlen($lastname) > 30 )
      {
        throw new Exception('firstname too long');
      }

    // validate email
    // $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email || $user->getByEmail($email))
    {
      throw new Exception('Invalid email or already exists');
    }

    // validate password
    $password = filter_input(INPUT_POST, 'password');
    if (!$password || strlen($password) < 8) //mb_strlen() :(
    {
      throw new Exception('Password not good. Password must contain 8+ characters');
    }

    // Create password hash
    $passwordHash = password_hash
    (
      $password,
      PASSWORD_DEFAULT,
      ['cost' => 12]
    );
    // var_dump($passwordHash);
    if ($passwordHash === false)
    {
      throw new Exception('Password hash failed');
    }

    // Escape all $_POST variables to protect against SQL injections1
    // $email = mysqli_real_escape_string($db->dbConn, $email);
    // $lastname = mysqli_real_escape_string($lastname);
    // $firstname = mysqli_real_escape_string($firstname);

    // Create user account

    $user->setInfo($firstname, $lastname, $passwordHash, $email);
    $user->save();

    $user->setByEmail($email);

    $sql = "INSERT INTO bans( user_id ) values (
               $user->id )";

    $db->query($sql);

    // Redirect to longin.php
    header('HTTP/1.1 302 Redirect');
    header('Location: ./login.php');
    die();
  }
  catch (Exception $e)
  {
    // Report error
    header('HTTP/1.1 400 Bad request');
    echo $e->getMessage();
  }
}

?>

<!doctype html>
<html>
<head>

  <title><?= $lang->translateWord('Registration') ?></title>
  <?php include '../../css/css.html'; ?>

</head>
<body class="container">
  <h1><?= $lang->translateWord('Registration') ?></h1>
  <form action="register.php" method="POST">

    <div  class="form-group row">
      <label for="firstname" class="col-sm-2">
        <?= $lang->translateWord('First Name') ?>: <span class="req">*</span>
      </label>
      <div class="col-sm-4">
       <input class="form-control" type="text" name="firstname" id="firstname">
      </div>
    </div>

    <div  class="form-group row">
      <label for="lastname" class="col-sm-2">
        <?= $lang->translateWord('Last Name') ?>: <span class="req">*</span>
      </label>
      <div class="col-sm-4">
        <input class="form-control" type="text" name="lastname" id="lastname" required>
      </div>
    </div>

    <div  class="form-group row">
      <label for="email" class="col-sm-2">
        <?= $lang->translateWord('Email') ?>: <span class="req">*</span>
      </label>
      <div class="col-sm-4">
      <input class="form-control" type="email" name="email" id="email" required>
      </div>
    </div>

    <div  class="form-group row">
      <label for="password" class="col-sm-2">
      <?= $lang->translateWord('Password') ?>: <span class="req">*</span>
      </label>
      <div class="col-sm-4">
      <input class="form-control" type="password" name="password" id="password">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-5">
      <a class="btn btn-success" href="login.php"><?= $lang->translateWord('Back to Login') ?></a>
      <input class="btn btn-primary pull-right" type="submit" name="register" value="<?= $lang->translateWord('Sign In') ?>">
      </div>
    </div>
  </form>



  <?php  include_layout_template('footer.php') ?>
</body>
</html>
