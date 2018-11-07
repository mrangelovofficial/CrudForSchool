<?php $counter = $pageCounter + 1; ?>
<table class="tg">
  <tr>
    <td class="tg-yw4l">#
    </td>
    <td class="tg-yw4l">Име
    </td>
    <td class="tg-yw4l">E-mail
    </td>
    <td class="tg-yw4l">Факултетен №
    </td>
    <td class="tg-yw4l">Операнди
    </td>
  </tr>
  <?php foreach ($data as $rows): ?>

    <tr>
      <td class="tg-yw4l"><?php echo $counter; ?></td>
      <td class="tg-yw4l"><?php echo $rows->student_fname. ' ' . $rows->student_lname; ?></td>
      <td class="tg-yw4l"><?php echo $rows->student_email; ?></td>
      <td class="tg-yw4l"><?php echo $rows->student_fnumber; ?></td>
      <td class="tg-yw4l"><a href="<?php echo $host; ?>?type=0&&id=<?php echo $rows->student_id; ?>"><div class="edit"></div></a>
      <a onclick="return confirm('Сигурни ли сте, че желаете да изтриете избрания студент ?');" href="<?php echo $host; ?>?type=1&&id=<?php echo $rows->student_id; ?>"><div class="delete"></div></a></td>
    </tr>

  <?php $counter++; endforeach; ?>
</table>
