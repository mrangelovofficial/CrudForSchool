<?php $counter = $pageCounter + 1; ?>
<table class="tg">
  <tr>
    <th class="tg-031e">
    </th>
    <th class="tg-yw4l" colspan="2">
    </th>
    <th class="tg-baqh" colspan="12">Предмети(хорариум и оценки)
    </th>
  </tr>
  <tr>
    <td class="tg-yw4l">
    </td>
    <td class="tg-yw4l" colspan="2">
    </td>
    <?php foreach ($subjects as $subject ): ?>
    <td class="tg-baqh" colspan="3">
      <?php echo $subject->subject_name; ?>
    </td>
    <?php endforeach; ?>
    <td class="tg-baqh" colspan="3">Общо
    </td>
  </tr>
  <tr>
    <td class="tg-yw4l">#
    </td>
    <td class="tg-yw4l">Име,Фамилия
    </td>
    <td class="tg-yw4l">Курс
    </td>
    <?php foreach ($subjects as $subject ): ?>
    <td class="tg-yw4l">Лекции
    </td>
    <td class="tg-yw4l">Упражнения
    </td>
    <td class="tg-yw4l">Оценка
    </td>
    <?php endforeach; ?>
    <td class="tg-yw4l">Ср. успех
    </td>
    <td class="tg-yw4l">Лекции
    </td>
    <td class="tg-yw4l">Упражнения
    </td>
  </tr>
  <?php  foreach ($data as $person):
$assigments = DB::query("SELECT   `sa_subject_id`, `sa_workload_lectures`, `sa_workload_exercises`, `sa_assesment` FROM `students_assessments` WHERE `sa_student_id` = :id",array('id'=>$person->student_id));
?>
  <tr>
    <td class="tg-yw4l">
      <?php echo $counter; ?>
    </td>
    <td class="tg-yw4l">
      <?php echo $person->student_fname . ' '. $person->student_lname.' ('.$person->student_fnumber.')'; ?>
    </td>
    <td class="tg-yw4l">
      <?php echo $person->course_name . ', '. $person->speciality_name_short.', ('.$person->student_education_form.')'; ?>
    </td>
    <?php
$subject_counter = DB::query("SELECT COUNT(*) as number FROM `subjects`")[0]->number;
$a = 0;
$b = 1;
$lecturesFull = 0;
$lecturesGo = 0;
$exerciseFull = 0;
$exerciseGo = 0;
$assigmentEnd = 0;
while ($a < $subject_counter) {
if($assigments[$a]->sa_subject_id != $b){?>
    <td class="tg-yw4l">
    </td>
    <td class="tg-yw4l">
    </td>
    <td class="tg-yw4l">
    </td>
    <?php }else {
$subject_Assign = DB::query("SELECT `subject_workload_lectures`,`subject_workload_exercises` FROM `subjects` WHERE `subject_id` =  :n ",array('n'=>$b))[0]; ?>
    <td class="tg-yw4l">
      <?php echo '<span class="red">'.$assigments[$a]->sa_workload_lectures.'</span> ('.$subject_Assign->subject_workload_lectures.')'; ?>
    </td>
    <td class="tg-yw4l">
      <?php echo '<span class="red">'.$assigments[$a]->sa_workload_exercises.'</span> ('.$subject_Assign->subject_workload_exercises.')'; ?>
    </td>
    <td class="tg-yw4l">
      <?php echo Scores::ToText($assigments[$a]->sa_assesment); ?>
    </td>
    <?php
$lecturesFull   += $subject_Assign->subject_workload_lectures;
$lecturesGo     += $assigments[$a]->sa_workload_lectures;
$exerciseFull   += $subject_Assign->subject_workload_exercises;
$exerciseGo     += $assigments[$a]->sa_workload_exercises;
$assigmentEnd   += $assigments[$a]->sa_assesment;
}
$a++;
$b++;
}
?>
    <td class="tg-yw4l">
      <?php echo Scores::ToText($assigmentEnd / $a); ?>
    </td>
    <td class="tg-yw4l">
      <?php echo '<span class="red">'.$lecturesGo.'</span> ('.$lecturesFull.')'; ?>
    </td>
    <td class="tg-yw4l">
      <?php echo '<span class="red">'.$exerciseGo.'</span> ('.$exerciseFull.')'; ?>
    </td>
  </tr>
  <?php $counter++; endforeach; ?>
</table>
