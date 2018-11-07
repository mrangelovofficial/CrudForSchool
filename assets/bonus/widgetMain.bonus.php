<?php
$prev = $main."&&pageNumber=".max($pageCounter - $pageCounterClass->pageCropOnGet(),0);
$next = $main."&&pageNumber=".max($pageCounter + $pageCounterClass->pageCropOnGet(),0);
$end = $main."&&pageNumber=".max($maxReachNumber - $pageCounterClass->pageCropOnGet(),0);
?>

<a href="<?php echo $main; ?>">Първа
</a>
<?php if($pageCounter >= $pageCounterClass->pageCropOnGet()){ ?>
<a href="<?php echo $prev; ?>">Предходна
</a>
<?php } ?>
Страница
<?php if($maxReachPage > 0){ echo  floor($pageCounterL / $pageCounterClass->pageCropOnGet()). ' от '.$maxReachPage.' ';}else echo '0 от 0'; ?>
<?php if($maxReachNumber- $pageCounterClass->pageCropOnGet() != $pageCounter){?>
<a href="<?php echo $next; ?>">Следваща
</a>
<?php }?>
<a href="<?php echo $end; ?>">Последна
</a>
<div class="spaceResults">
  Резултати

  <?php
  if($dataCount > 0){
    echo ($pageCounter + 1) . ' - '.min($pageCounterL,$dataCount) . ' от ' . $dataCount;
  }else{
    echo '0 от 0';
  }
  ?>
</div>
