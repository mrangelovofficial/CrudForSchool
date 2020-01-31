<?php

class HomeModel Extends Model
{
    public function getPassword($id)
    {
        $SQL = "SELECT `student_password` FROM `students` WHERE `student_id` = :id";
        $Fields = [
            ':id' => $id,
        ];
        return $this->Query($SQL, $Fields);
    }
}