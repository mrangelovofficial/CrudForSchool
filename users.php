<?php
require_once "header.inc.php";
require_once "assets/core/pageCounter.class.php";

if ( isset( $_GET['name'] ,$_GET['email']  ))
{
  $nameGet      = $_GET['name'];
  $email        = $_GET['email'];
  $name         = "";
  $last         = "";
    // Generate name field
  if ( !empty( $nameGet ) )
  {
    $name = explode(" ",$nameGet);
      if ( isset ( $name[1] ))
        {
          $last = $name[1];
        }

        $name = $name[0];
  }

  // Config
    $pageCounterClass = new PageCounter();
    $pageCounterClass->pageCropOnSet(5);
    $pageCounter = $pageCounterClass->pageCounterGet();
    $main = $host."?name=".$nameGet."&&email=".$email;

    $dataCountQuery = DB::query("SELECT COUNT(*) as number
      FROM `users` WHERE
      `user_fname` LIKE :name &&
      `user_lname` LIKE :last &&
      `user_email` LIKE :email",
      array('name'=>'%'.$name.'%',
      'last'=>'%'.$last.'%',
      'email'=>'%'.$email.'%'));

      // Convert data and create new var
      $dataCount = $pageCounterClass->dataCount($dataCountQuery);

        $maxReachNumber   = $pageCounterClass->maxReachNumberGet();
        $maxReachPage     = $pageCounterClass->maxReachPageGet();

        if ( isset( $_GET['pageNumber'] ))
        {
          $pageCounter = $pageCounterClass->checkNumber($_GET['pageNumber']);
        }
    $pageCounterL = $pageCounterClass->pageCounterCropGet();

    // People Query
    $data = DB::query("SELECT * FROM `users` WHERE
    `user_fname` LIKE :name &&
    `user_lname` LIKE :last &&
    `user_email` LIKE :email
    ORDER BY `users`.`user_id` ASC LIMIT ".$pageCounterClass->pageCropOnGet()." OFFSET ".$pageCounter ,
    array(
    'name'=>'%'.$name.'%',
    'last'=>'%'.$last.'%',
    'email'=>'%'.$email.'%'));
}

if ( isset ( $_POST['Search'] ) )
{
  $name        = htmlentities($_POST['name']);
  $email       = htmlentities($_POST['email']);
  header("Location: ".$host."?name=".$name."&&email=".$email);
  die();
}


  if( isset( $_GET['type'] ))
  {
    $type = htmlentities($_GET['type']);

    if( isset( $_GET['id'] ) )
    {
      $id = htmlentities($_GET['id']);
      $queryCheck = DB::query("SELECT COUNT(*) AS n FROM `users` WHERE `user_id` = :id",array('id'=>$id))[0]->n;
      if($queryCheck == 1)
      {
        if($type == 0)
        {

          $getName = DB::query("SELECT * FROM `users` WHERE `user_id` = :id",array('id'=>$id))[0];

          if(isset($_POST['AddCourse']))
          {
            $username   = htmlentities($_POST['username']);
            $name       = htmlentities($_POST['name']);
            $family     = htmlentities($_POST['family']);
            $pass       = htmlentities($_POST['pass']);
            $email      = htmlentities($_POST['email']);
            $rpass      = htmlentities($_POST['rpass']);
            $oldpass      = htmlentities($_POST['oldpass']);
            $dataArray = array(
              "user"=>$username,
              "name"=>$name,
              "fname"=>$family,
              "email"=>$email,
              "id"=>$id
            );
            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
              if(sha1($oldpass) == $getName->user_password){
                if(empty($pass)){
                    DB::query("UPDATE `users` SET `user_name`=:user,`user_fname`=:name,`user_lname`=:fname,`user_email`=:email WHERE `user_id` = :id",$dataArray);
                }else {
                  if($pass == $rpass){
                    $dataArray['pass'] = sha1($pass);
                    DB::query("UPDATE `users` SET `user_name`=:user,`user_fname`=:name,`user_lname`=:fname,`user_email`=:email,`user_password`=:pass WHERE `user_id` = :id",$dataArray);
                  }
                }

                header("Location: ".$host);
                die();
              }


            }

          }

        }
        else if ($type == 1)
        {
          DB::query("DELETE FROM `users` WHERE `user_id` = :id",array('id'=>$id));
          header("Location: ".$host);
          die();
        }

      }
    }


    if($type == 2)
    {

      if ( isset( $_POST['AddCourse'] ) )
      {
        $username   = htmlentities($_POST['username']);
        $name       = htmlentities($_POST['name']);
        $family     = htmlentities($_POST['family']);
        $pass       = htmlentities($_POST['pass']);
        $email      = htmlentities($_POST['email']);
        $rpass      = htmlentities($_POST['rpass']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          if($pass == $rpass)
            {
            DB::query("INSERT INTO `users`(`user_name`, `user_fname`, `user_lname`, `user_email`, `user_password`) VALUES (:user,:name,:fname,:email,:pass)",
            array(
            'name'=>$name,
            'fname'=>$family,
            'pass'=>sha1($pass),
            'email'=>$email,
            'user'=>$username));
            header("Location: ".$host);
            die();
          }
        }
      }

    }
}
?>
<?php if (!isset($_GET['type'])): ?>

  <div id="addNew"><a href="<?php echo $host; ?>?type=2">Нов</a></div>

<?php else: ?>

  <div id="addNew"><a href="<?php echo $host; ?>">Назад</a> </div>

<?php endif; ?>
<div class="clear"></div>
<!-- Search -->
<div id="searchMain">

<?php if (!isset($_GET['type'])): ?>

  <form  action="" method="post">
    <label class="labelMainForm">Име :</label>
    <input type="text" name="name"><br>
    <label class="labelMainForm">E-mail :</label>
    <input type="text" name="email"><br>
    <input type="submit" name="Search" value="Търси">
  </form>

<?php else: ?>

  <form  action="" method="post">
    <label class="labelMainForm">Потребителско име :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->user_name;}?>" name="username"><br>
    <label class="labelMainForm">Собствено име :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->user_fname;}?>" name="name"><br>
    <label class="labelMainForm">Фамилия :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->user_lname;}?>" name="family"><br>
    <?php if($type == 0){
      echo '<label class="labelMainForm">Стара парола* :</label>
      <input type="password" value="" name="oldpass"><br>';
    }?>
    <label class="labelMainForm">Парола :</label>
    <input type="password" value="" name="pass"><br>
    <label class="labelMainForm">Повтори парола :</label>
    <input type="password" value="" name="rpass"><br>
    <label class="labelMainForm">E-mail :</label>
    <input type="email" value="<?php if($type == 0){echo $getName->user_email;}?>" name="email"><br>
    <input type="submit" name="AddCourse" value="<?php if($type == 0){echo 'Редактирай';}else { echo 'Добави потребител';} ?>">
    <?php if ($type == 0): ?>
      <br><br>Старата парола задължително трябва да се въведе за обновяване на информацията.
    <?php endif; ?>
  </form>

<?php endif; ?>
</div>

<?php
if ( isset( $_GET['name'] ,$_GET['email'] ))
{
  require "assets/bonus/widgetMain.bonus.php";
  require_once "assets/bonus/usersTable.view.php";
  require "assets/bonus/widgetMain.bonus.php";
}

require_once "footer.inc.php";
