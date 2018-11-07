<?php $counter = $pageCounter + 1; ?>
<table class="tg">
  <tr>
    <td class="tg-yw4l">#
    </td>
    <td class="tg-yw4l">Пълно име
    </td>
    <td class="tg-yw4l">Абревиатура
    </td>
    <td class="tg-yw4l">Операнди
    </td>
  </tr>
  <?php foreach ($data as $rows): ?>

    <tr>
      <td class="tg-yw4l"><?php echo $counter; ?></td>
      <td class="tg-yw4l"><?php echo $rows->speciality_name_long; ?></td>
      <td class="tg-yw4l"><?php echo $rows->speciality_name_short; ?></td>
      <td class="tg-yw4l"><a href="<?php echo $host; ?>?type=0&&id=<?php echo $rows->speciality_id; ?>"><div class="edit"></div></a>
      <a onclick="return confirm('Сигурни ли сте, че желаете да изтриете избраната специалност ?');" href="<?php echo $host; ?>?type=1&&id=<?php echo $rows->speciality_id; ?>"><div class="delete"></div></a></td>
    </tr>

  <?php $counter++; endforeach; ?>
</table>
