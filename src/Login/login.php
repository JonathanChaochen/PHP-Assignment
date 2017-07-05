<?php
require_once  ('../Include/initialize.php');
include_once('../Layout/langSetting.php');

// session_start();

// if (isset($_SESSION['user_logged_in']))
// {
//     User::changeStatus($_SESSION['user_email'], 0);
//     session_destroy();
// }

if ( isset($_SESSION['user_logged_in']) )
{
    echo 'You already logged in .You need to <a href="logout.php" class="btn btn-success">Log out</a> before log another account.<br>';
}



if ($_SERVER['REQUEST_METHOD'] == 'POST')
{


    try{

        if ( isset($_SESSION['user_logged_in']) )
        {
        throw new Exception('You are already logged in. You need to log out before logging in as different user.');
        }


        // Find account with email address
        // $user = User::findByEmail($email);
        $user = new User($db);
        // Get email address from request body
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email || !$user->getByEmail($email))
        {
          throw new Exception('Invalid email or not exists');
        }

        // Get password from request body
        $password = filter_input(INPUT_POST, 'password');

        $password_hash = $user->getPassword($email);

        // Verify password with account password hash
        if (password_verify($password, $password_hash) === false) {
            throw new Exception('Invalid password');
        }

        $user->setByEmail($email);
        $session->login($user);

        // Re-hash password if necessary(see not below)
        // $currentHashAlgorithm = PASSWORD_DEFAULT;
        // $currentHashOptions = array('cost' => 15);
        // $passwordNeedsRehash = password_needs_rehash(
        //     $user->password_hash,
        //     $currentHashAlgorithm,
        //     $currentHashOptions
        // );

        // if ($passwordNeedsRehash === true) {
        //     // Save new password hash (THIS IS PSUEDO-CODE)

        //     $user->password_hash = password_hash(
        //         $password,
        //         $currentHashAlgorithm,
        //         $currentHashOptions
        //     );
        //     $user->save();
        // }

        // Save login status to session
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $email;
        // $row = $user->getByEmail($email);
        // if (!$row)
        // {
        //   throw new Exception('Invalid user or user not exit');
        // }
        // $_SESSION['user_id'] = $row['user_id'];



        $_SESSION['last_activity'] = time();// Taking now logged in time.
        // Ending a session in 1 minutes from the starting time.
        $_SESSION['expire'] = $_SESSION['last_activity'] + (20 * 60);

        User::changeStatus($_SESSION['user_email'], 1);

        if ( User::checkLevel($email) ) {
          $level = true;
          $_SESSION['level'] = $level;
        }

        // Redirect to profile page
        header('HTTP/1.1 302 Redirect');

        //todo  header
        header('Location: ../../index.php');
    } catch (Exception $e) {
        header('HTTP/1.1 401 Unauthorized');
        echo $e->getMessage();
    }
}




?>

<!doctype html>
<html>
<head>
    <title><?= $lang->translateWord('Login') ?></title>
    <?php include '../../css/css.html'; ?>

</head>
<body class="container">
    <h1><?= $lang->translateWord('Login') ?></h1>
    <form action="login.php" method="POST">
        <div id="account"  class="form-group row">
            <div class="col-sm-2">
                <label for="email"><?= $lang->translateWord('Email') ?> ：</label>
            </div>
            <div class="col-sm-4">
            <input class="form-control" type="text" name="email" id ="email">
            </div>
        </div>

        <div id="password"  class="form-group row">
            <div class="col-sm-2">
            <label for="password"><?= $lang->translateWord('Password') ?> : </label>
            </div>
            <div class="col-sm-4">
            <input class="form-control" type="password" name="password" id="password">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            <input class="btn btn-success pull-right" type="submit" value="<?= $lang->translateSentence('Login') ?>">
            <a class="btn btn-primary" href="register.php"><?= $lang->translateWord('New User') ?> </a>
            </div>
        </div>
    </form>

    <?php  include_layout_template('footer.php') ?>
</body>
</html>
