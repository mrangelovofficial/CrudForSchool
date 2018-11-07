<?php
require_once "header.inc.php";
require_once "assets/core/pageCounter.class.php";

if ( isset( $_GET['name'] ,$_GET['spec'] ,$_GET['course'],$_GET['fnum'],$_GET['email']  ))
{
  $nameGet      = $_GET['name'];
  $subjects     = $_GET['spec'];
  $course       = $_GET['course'];
  $fnum         = $_GET['fnum'];
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
    $main = $host."?name=".$nameGet."&&spec=".$subjects."&&course=".$course."&&fnum=".$fnum."&&email=".$email;

    $dataCountQuery = DB::query("SELECT COUNT(*) as number
      FROM `students` WHERE
      `student_fname` LIKE :name &&
      `student_lname` LIKE :last &&
      `student_fnumber` LIKE :fnum &&
      `student_email` LIKE :email &&
      `student_course_id` = :cid &&
      `student_speciality_id` = :sid",
      array('name'=>'%'.$name.'%',
      'last'=>'%'.$last.'%',
      'cid'=>$course,
      'sid'=>$subjects,
      'fnum'=>'%'.$fnum.'%',
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
    $data = DB::query("SELECT `student_id`,`course_name`, `speciality_name_short`,`student_fname`, `student_lname`,`student_fnumber`,`student_email`, `student_education_form`,`courses`.`course_name`
    FROM `students`,`courses`,`specialities` WHERE
    `student_fname` LIKE :name &&
    `student_lname` LIKE :last &&
    `student_fnumber` LIKE :fnum &&
    `student_email` LIKE :email &&
    `student_course_id` = :cid &&
    `student_speciality_id` = :sid &&
    `courses`.`course_id` = `students`.`student_course_id` &&
    `specialities`.`speciality_id` = `students`.`student_speciality_id`
    ORDER BY `students`.`student_id` ASC LIMIT ".$pageCounterClass->pageCropOnGet()." OFFSET ".$pageCounter ,
    array('name'=>'%'.$name.'%',
    'last'=>'%'.$last.'%',
    'cid'=>$course,
    'sid'=>$subjects,
    'fnum'=>'%'.$fnum.'%',
    'email'=>'%'.$email.'%' ));
}

// Index view query

$subjects   = DB::query("SELECT * FROM `subjects` ORDER BY `subjects`.`subject_id` ASC");
$courses    = DB::query("SELECT * FROM `courses` ORDER BY `courses`.`course_id` ASC");
$species    = DB::query("SELECT * FROM `specialities` ORDER BY `specialities`.`speciality_id` ASC");

if ( isset ( $_POST['Search'] ) )
{
  $name       = htmlentities($_POST['name']);
  $subjects   = htmlentities($_POST['subjects']);
  $course     = htmlentities($_POST['course']);
  $fnum       = htmlentities($_POST['fnum']);
  $email       = htmlentities($_POST['email']);
  header("Location: ".$host."?name=".$name."&&spec=".$subjects."&&course=".$course."&&fnum=".$fnum."&&email=".$email);
  die();
}


  if( isset( $_GET['type'] ))
  {
    $type = htmlentities($_GET['type']);

    if( isset( $_GET['id'] ) )
    {
      $id = htmlentities($_GET['id']);
      $queryCheck = DB::query("SELECT COUNT(*) AS n FROM `students` WHERE `student_id` = :id",array('id'=>$id))[0]->n;
      if($queryCheck == 1)
      {
        if($type == 0)
        {

          $getName = DB::query("SELECT * FROM `students` WHERE `student_id` = :id",array('id'=>$id))[0];

          if(isset($_POST['AddCourse']))
          {
            $name       = htmlentities($_POST['name']);
            $family     = htmlentities($_POST['family']);
            $fnum       = htmlentities($_POST['fnum']);
            $email      = htmlentities($_POST['email']);
            $subjects   = htmlentities($_POST['subjects']);
            $course     = htmlentities($_POST['course']);
            $sForm      = htmlentities($_POST['sForm']);

            if (filter_var($email, FILTER_VALIDATE_EMAIL))
            {
              DB::query("UPDATE `students` SET `student_course_id`=:cid,`student_speciality_id`=:sid,`student_fname`=:name,`student_lname`=:lname,`student_email`=:email,`student_fnumber`=:fnum,`student_education_form`=:sForm WHERE `student_id` = :id",
              array(
              'name'=>$name,
              'id'=>$id,
              'lname'=>$family,
              'fnum'=>$fnum,
              'email'=>$email,
              'sid'=>$subjects,
              'cid'=>$course,
              'sForm'=>$sForm));
              header("Location: ".$host);
              die();
            }

          }

        }
        else if ($type == 1)
        {
          DB::query("DELETE FROM `students` WHERE `student_id` = :id",array('id'=>$id));
          header("Location: ".$host);
          die();
        }

      }
    }


    if($type == 2)
    {

      if ( isset( $_POST['AddCourse'] ) )
      {
        $name       = htmlentities($_POST['name']);
        $family     = htmlentities($_POST['family']);
        $fnum       = htmlentities($_POST['fnum']);
        $email      = htmlentities($_POST['email']);
        $subjects   = htmlentities($_POST['subjects']);
        $course     = htmlentities($_POST['course']);
        $sForm      = htmlentities($_POST['sForm']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
          DB::query("INSERT INTO `students`( `student_course_id`, `student_speciality_id`, `student_fname`, `student_lname`, `student_email`, `student_fnumber`, `student_education_form`) VALUES (:cid,:sid,:name,:lname,:email,:fnum,:sForm)",
          array(
          'name'=>$name,
          'lname'=>$family,
          'fnum'=>$fnum,
          'email'=>$email,
          'sid'=>$subjects,
          'cid'=>$course,
          'sForm'=>$sForm));
          header("Location: ".$host);
          die();
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
    <input type="email" name="email"><br>
    <label class="labelMainForm">Ф.Номер :</label>
    <input type="text" name="fnum"><br>
    <label class="labelMainForm">Специалност :</label>
    <select name="subjects">
      <?php
        foreach ($species as $specie) {

          echo '<option value="'.$specie->speciality_id.'">'.$specie->speciality_name_long.'</option>';

        }
        ?>
    </select><br>
    <label class="labelMainForm">Курс :</label>
    <select name="course">
      <?php
        foreach ( $courses as $course )
        {
        echo '<option value="'.$course->course_id.'">'.$course->course_name.'</option>';
        }
      ?>
    </select><br>
    <input type="submit" name="Search" value="Търси">
  </form>

<?php else: ?>

  <form  action="" method="post">
    <label class="labelMainForm">Собствено име :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->student_fname;}?>" name="name"><br>
    <label class="labelMainForm">Фамилия :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->student_lname;}?>" name="family"><br>
    <label class="labelMainForm">Факултетен номер :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->student_fnumber;}?>" name="fnum"><br>
    <label class="labelMainForm">E-mail :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->student_email;}?>" name="email"><br>

    <label class="labelMainForm">Курс :</label>
    <select name="course">
      <?php
      if($type == 0){
        foreach ( $courses as $course ){
          if($course->course_id != $getName->student_course_id){
            continue;
          }else {
            echo '<option value="'.$course->course_id.'">'.$course->course_name.'</option>';
          }
        }
        foreach ( $courses as $course ){
          if($course->course_id == $getName->student_course_id){
            continue;
          }else {
            echo '<option value="'.$course->course_id.'">'.$course->course_name.'</option>';
          }
        }
      }else {
        foreach ( $courses as $course )
        {
          echo '<option value="'.$course->course_id.'">'.$course->course_name.'</option>';
        }
      }
      ?>
    </select><br>

    <label class="labelMainForm">Специалност :</label>
    <select name="subjects">
    <?php
    if($type == 0){
      foreach ( $species as $specie ){
        if($specie->speciality_id != $getName->student_speciality_id){
          continue;
        }else {
          echo '<option value="'.$specie->speciality_id.'">('.$specie->speciality_name_short.')'.$specie->speciality_name_long.'</option>';
        }
      }
      foreach ( $species as $specie ){
        if($specie->speciality_id == $getName->student_speciality_id){
          continue;
        }else {
          echo '<option value="'.$specie->speciality_id.'">('.$specie->speciality_name_short.')'.$specie->speciality_name_long.'</option>';
        }
      }
    }else {
      foreach ($species as $specie) {
        echo '<option value="'.$specie->speciality_id.'">('.$specie->speciality_name_short.')'.$specie->speciality_name_long.'</option>';
      }
    }
    ?>
    </select><br>

    <label class="labelMainForm">Специалност :</label>
    <select name="sForm">
    <?php
    if($type == 0){
      if($getName->student_education_form == "З"){
        echo '<option value="З">(З) Задочно</option>';
        echo '<option value="Р">(Р) Редовно</option>';
      }else {
        echo '<option value="Р">(Р) Редовно</option>';
        echo '<option value="З">(З) Задочно</option>';
      }
    }else {
      echo '<option value="З">(З) Задочно</option>';
      echo '<option value="Р">(Р) Редовно</option>';
    }
    ?>
    </select><br>

    <input type="submit" name="AddCourse" value="<?php if($type == 0){echo 'Редактирай';}else { echo 'Добави студент';} ?>">

  </form>

<?php endif; ?>
</div>

<?php
if (isset( $_GET['name'] ,$_GET['spec'] ,$_GET['course'],$_GET['fnum'],$_GET['email'] ))
{
  require "assets/bonus/widgetMain.bonus.php";
  require_once "assets/bonus/studentsTable.view.php";
  require "assets/bonus/widgetMain.bonus.php";
}

require_once "footer.inc.php";
