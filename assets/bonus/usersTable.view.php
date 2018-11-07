<?php $counter = $pageCounter + 1; ?>
<table class="tg">
  <tr>
    <td class="tg-yw4l">#
    </td>
    <td class="tg-yw4l">Потребителско име
    </td>
    <td class="tg-yw4l">Email
    </td>
    <td class="tg-yw4l">Операнди
    </td>
  </tr>
  <?php foreach ($data as $rows): ?>

    <tr>
      <td class="tg-yw4l"><?php echo $counter; ?></td>
      <td class="tg-yw4l"><?php echo $rows->user_name; ?></td>
      <td class="tg-yw4l"><?php echo $rows->user_email; ?></td>
      <td class="tg-yw4l"><a href="<?php echo $host; ?>?type=0&&id=<?php echo $rows->user_id; ?>"><div class="edit"></div></a>
      <a onclick="return confirm('Сигурни ли сте, че желаете да изтриете избрания потребител ?');" href="<?php echo $host; ?>?type=1&&id=<?php echo $rows->user_id; ?>"><div class="delete"></div></a></td>
    </tr>

  <?php $counter++; endforeach; ?>
</table>
