<?php 
	session_start(); 

	if (!isset($_SESSION['auth']) or empty($_SESSION['auth']) or ($_SESSION['auth'] === false)){
		header("Location: main.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Информация </title>
    <link rel="stylesheet"  type="text/css" href="style.css" >
</head>
<body>


<div id="header">
    <div id="logo_bar">
        <img src="images/metro_logo.png">
    </div>
    <div id="nav">
        <ul>
            <li><a href="desktop.php">Назад</a></li>
        </ul>
    </div>
</div>


<!-- Середина страницы-->
<div class="wrapper" style="margin-top: 50px; background-color: transparent">
    <div id="article_doc">
        <p> Система для организации ознакомдения с документами в Москвоском метрополитене</p>
        <p>За подробной информацией по использованию системы обратитесь с инструктору подразделения или администратору</p>
    </div>
</div>


<div id="footer">
    <p>Contacts: mos_admin@mail.ru</p>
    <p>Copyright © Московский метрополитен, 2019</p>
</div>


</body>
</html>