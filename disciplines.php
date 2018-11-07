<?php
require_once "header.inc.php";
require_once "assets/core/pageCounter.class.php";

if ( isset( $_GET['name']))
{
  $nameGet       = htmlentities($_GET['name']);
  // Config
    $pageCounterClass = new PageCounter();
    $pageCounterClass->pageCropOnSet(5);
    $pageCounter = $pageCounterClass->pageCounterGet();
    $main = $host."?name=".$nameGet;

    $dataCountQuery = DB::query("SELECT COUNT(*) as number
      FROM `subjects`
      WHERE `subject_name` LIKE :name ",array('name'=>'%'.$nameGet.'%'));

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
  $data = DB::query("SELECT * FROM `subjects`
  WHERE `subject_name` LIKE :name
  ORDER BY `subjects`.`subject_id` ASC
  LIMIT ".$pageCounterClass->pageCropOnGet()." OFFSET ".$pageCounter,array('name'=>'%'.$nameGet.'%'));
}

// Index view query


if ( isset ( $_POST['Search'] ) )
{
  $name       = htmlentities($_POST['name']);
  header("Location: ".$host."?name=".$name);
  die();
}


  if( isset( $_GET['type'] ))
  {
    $type = htmlentities($_GET['type']);

    if( isset( $_GET['id'] ) )
    {
      $id = htmlentities($_GET['id']);
      $queryCheck = DB::query("SELECT COUNT(*) AS n FROM `subjects` WHERE `subject_id` = :id",array('id'=>$id))[0]->n;
      if($queryCheck == 1)
      {
        if($type == 0)
        {

          $getName = DB::query("SELECT `subject_name`,`subject_workload_lectures`,`subject_workload_exercises` FROM `subjects` WHERE `subject_id` = :id",array('id'=>$id))[0];
          if(isset($_POST['AddCourse']))
          {
            $name       = htmlentities($_POST['name']);
            $xE = htmlentities($_POST['xE']);
            $xY = htmlentities($_POST['xY']);
            DB::query("UPDATE `subjects` SET `subject_name`=:name,`subject_workload_lectures`=:xe,`subject_workload_exercises`=:xy WHERE `subject_id` = :id",array('name'=>$name,'id'=>$id,'xe'=>$xE,'xy'=>$xY));
            header("Location: ".$host);
            die();
          }

        }
        else if ($type == 1)
        {
          DB::query("DELETE FROM `subjects` WHERE `subject_id` = :id",array('id'=>$id));
          header("Location: ".$host);
          die();
        }

      }
    }


    if($type == 2)
    {

      if ( isset( $_POST['AddCourse'] ) )
      {
        $name = htmlentities($_POST['name']);
        $xE = htmlentities($_POST['xE']);
        $xY = htmlentities($_POST['xY']);
        DB::query("INSERT INTO `subjects`(`subject_name`,`subject_workload_lectures`,`subject_workload_exercises`) VALUES (:name,:xe,:xy)",array('name'=>$name,'xe'=>$xE,'xy'=>$xY));
        header("Location: ".$host);
        die();
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

<div id="searchMain">

<?php if (!isset($_GET['type'])): ?>

    <form  action="" method="post">
      <label class="labelMainForm">Име :</label>
      <input type="text" name="name"><br>
      <input type="submit" name="Search" value="Търси">
    </form>

<?php else: ?>

  <form  action="" method="post">
    <label class="labelMainForm">Име :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->subject_name;}?>" name="name"><br>
    <label class="labelMainForm">Хорариум (Л) :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->subject_workload_lectures;}?>" name="xE"><br>
    <label class="labelMainForm">Хорариум (У) :</label>
    <input type="text" value="<?php if($type == 0){echo $getName->subject_workload_exercises;}?>" name="xY"><br>
    <input type="submit" name="AddCourse" value="<?php if($type == 0){echo 'Редактирай';}else { echo 'Добави дисциплина';} ?>">

  </form>

<?php endif; ?>
</div>

<?php
if (isset( $_GET['name']))
{
  require "assets/bonus/widgetMain.bonus.php";
  require_once "assets/bonus/disciplinesTable.view.php";
  require "assets/bonus/widgetMain.bonus.php";
}

require_once "footer.inc.php";
