<?php
require_once "assets/core/db.class.php";
require_once "assets/core/scores.class.php";
$host =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CRUD</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
  </head>
  <body>

    <header>

      <nav>
        <ul>
          <li><a href="index.php">Начало</a></li>
          <li><a href="courses.php">Курсове</a></li>
          <li><a href="specialities.php">Специалности</a></li>
          <li><a href="disciplines.php">Дисциплини</a></li>
          <li><a href="students.php">Студенти</a></li>
          <li><a href="#">Оценки</a></li>
          <li><a href="users.php">Потребители</a></li>
        </ul>
      </nav>


      <ul>
        <li><a href="#">Профил</a></li>
        <li><a href="#">Изход</a></li>
      </ul>

      <p>Здравейте, Оран Гутанович</p>

      <div class="clear"></div>
    </header>
    <div id="containerR">
