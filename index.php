<?php
require_once "header.inc.php";
require_once "assets/core/pageCounter.class.php";


if ( isset( $_GET['name'], $_GET['spec'], $_GET['course'] ))
{
  $nameGet       = $_GET['name'];
  $subjects   = $_GET['spec'];
  $course     = $_GET['course'];
  $name       = "";
  $last       = "";
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
    $main = $host."?name=".$nameGet."&&spec=".$subjects."&&course=".$course;
     
    $dataCountQuery = DB::query("SELECT COUNT(*) as number
      FROM `students` WHERE
      `student_fname` LIKE :name &&
      `student_lname` LIKE :last &&
      `student_course_id` = :cid &&
      `student_speciality_id` = :sid",
      array('name'=>'%'.$name.'%','last'=>'%'.$last.'%','cid'=>$course,'sid'=>$subjects));

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
  $data = DB::query("SELECT `student_id`,`course_name`, `speciality_name_short`,`student_fname`, `student_lname`,`student_fnumber`, `student_education_form`,`courses`.`course_name`
  FROM `students`,`courses`,`specialities` WHERE
  `student_fname` LIKE :name &&
  `student_lname` LIKE :last &&
  `student_course_id` = :cid &&
  `student_speciality_id` = :sid &&
  `courses`.`course_id` = `students`.`student_course_id` &&
  `specialities`.`speciality_id` = `students`.`student_speciality_id`
  ORDER BY `students`.`student_id` ASC LIMIT ".$pageCounterClass->pageCropOnGet()." OFFSET ".$pageCounter ,array('name'=>'%'.$name.'%','last'=>'%'.$last.'%','cid'=>$course,'sid'=>$subjects));
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
  header("Location: index.php?name=".$name."&&spec=".$subjects."&&course=".$course);
  die();
}

?>
<div id="searchMain">

  <form  action="" method="post">
    <label class="labelMainForm">Име :</label>
    <input type="text" name="name"><br>
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

</div>

<?php
if (isset( $_GET['name'] ,$_GET['spec'] ,$_GET['course'] ))
{
  require "assets/bonus/widgetMain.bonus.php";
  require_once "assets/bonus/tableMain.view.php";
  require "assets/bonus/widgetMain.bonus.php";
}

require_once "footer.inc.php";
