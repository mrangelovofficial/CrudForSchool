<?php

class Scores
{
  public static function ToText($grade)
    {
      $grade = self::ToInt($grade);
        switch ($grade) {
          case 2:
            return "Слаб (2)";
            break;
          case 3:
            return "Среден (3)";
            break;
          case 4:
            return "Добър (4)";
            break;
          case 5:
            return "Мн.Добър (5)";
            break;
          case 6:
            return "Отличен (6)";
            break;
        }
    }


    protected static function ToInt($grade)
    {
      $int = 0;
      if($grade <= 2.99)
      {
        $int = 2;
      }else if ($grade <= 3.49){
        $int = 3;
      }else if ($grade <= 4.49){
        $int = 4;
      }else if ($grade <= 5.49){
        $int = 5;
      }else {
        $int = 6;
      }

      return $int;
    }

}
