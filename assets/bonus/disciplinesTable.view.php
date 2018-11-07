<?php $counter = $pageCounter + 1; ?>
<table class="tg">
  <tr>
    <td class="tg-yw4l">#
    </td>
    <td class="tg-yw4l">Име
    </td>
    <td class="tg-yw4l">Хорариум (Л)
    </td>
    <td class="tg-yw4l">Хорариум (У)
    </td>
    <td class="tg-yw4l">Операнди
    </td>
  </tr>
  <?php foreach ($data as $rows): ?>

    <tr>
      <td class="tg-yw4l"><?php echo $counter; ?></td>
      <td class="tg-yw4l"><?php echo $rows->subject_name; ?></td>
      <td class="tg-yw4l"><?php echo $rows->subject_workload_lectures; ?></td>
      <td class="tg-yw4l"><?php echo $rows->subject_workload_exercises; ?></td>
      <td class="tg-yw4l"><a href="<?php echo $host; ?>?type=0&&id=<?php echo $rows->subject_id; ?>"><div class="edit"></div></a>
      <a onclick="return confirm('Сигурни ли сте, че желаете да изтриете избраната дисциплина ?');" href="<?php echo $host; ?>?type=1&&id=<?php echo $rows->subject_id; ?>"><div class="delete"></div></a></td>
    </tr>

  <?php $counter++; endforeach; ?>
</table>
