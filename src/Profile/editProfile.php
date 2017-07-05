  <?php
  require_once  ('../Include/initialize.php');

  // session_start();
  // $user_email = $_SESSION['user_email'];
  include_once('../Layout/langSetting.php');


  try
  {

    if(isset($_GET['user_id']) ){
      $id = filter_var($_GET['user_id'], FILTER_SANITIZE_STRING);
      $_SESSION['profile_id'] = $id;
    } else   {
      throw new Exception('Not valid request');
    }



    $user = User::getById($id);
    if (!$user )
    {
      throw new Exception('Invalid user or user not exit');
    }

    $profile_username = $user->full_name();
    $profile_country = $user->country;
    $profile_gender = $user->gender;
    $profile_birthday = $user->birthday;
    $profile_email = $user->email;

    if($_SESSION['user_email'] !== $profile_email)
    {
        throw new Exception('Invalid user ');
    }




  } catch (Exception $e)
  {
    // Report error
    $_SESSION['message'] = $e->getMessage();
    header("location: ../Error/error.php");
  }

  ?>
  <!DOCTYPE html>
  <html>
  <head>

  <?php include '../../css/css.html'; ?>

    <title>User Profile</title>
  </head>
  <body>
     <div class="container">

     <h2>
     <?php if(isset($profile_username) )
     {
       echo $profile_username;
     }
     ?>
     </h2>



     <div class="row">
       <div class="col-sm-4">
         <img src="../../images/user.jpeg">

         <table class="table">
         <tr><th>Topics</th><th>Replies</th></tr>
         <tr><td><?= Topic::count_my($id); ?></td><td><?= Reply::count_my($id); ?></td></tr>
         </table>


       </div>

       <div class="col-sm-8">
         <h4>User details</h4>

         <form action="edit.php" method="POST">
         <br>
         <div class="row">
           <div class="col-md-4">
             <p class="profile-details"><span class="glyphicon glyphicon-info-sign"></span> Country</p>
           </div>
           <div class="col-md-8">
               <input type="text" value='<?= $profile_country;?>'  name="country">
           </div>
         </div>
        <div class="row">
         <div class="col-md-4">
           <p class="profile-details"><span class="glyphicon glyphicon-user"></span> Gender</p>
         </div>
         <div class="col-md-8">
             <input type="text" value='<?=  $profile_gender;?>' name="gender">
         </div>
        </div>

        <div class="row">
         <div class="col-md-4">
           <p class="profile-details"><span class="glyphicon glyphicon glyphicon-calendar"></span> Birthday</p>
         </div>
         <div class="col-md-8">
          <input type="date" value='<?= $profile_birthday;?>' name="birthday">
         </div>

        </div>
        <div>
          <input class="btn btn-primary col-md-offset-6" type="submit" name="" Value="save">
        </div>
         </form>

       </div>

     </div>

     <br>

     <?php  include_layout_template('footer.php') ?>

     </div>



  </body>
  </html>

