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
    <title> Профиль </title>

    <link rel="stylesheet"  type="text/css" href="style.css" >



</head>
<body>


<div id="header">

    <div id="logo_bar">
        <img src="images/metro_logo.png">
    </div>
    <div id="nav">
        <ul>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="info.php">Справка</a></li>
        </ul>
    </div>


</div>







<div class="wrapper" style="margin-top: 50px">

    <div id="nav2">
        <ul>
            <li><a href="doc_archive.php">Архив</a></li>
            <li><a href="desktop.php">На рабочий стол</a></li>
            <li><a href="doc_queue.php">Документы на очередь</a></li>
        </ul>
    </div>


<!--    <div id="sidebar1" class="aside">-->
<!--        <div id="auth_user">-->
<!---->
<!--            <a href="profile.php" > <img src="images/user.png" alt="User_face" ></a>-->
<!--            <p> ФАМИЛИЯ </p>-->
<!---->
<!--            <p> ИМЯ ОТЧЕСТВО</p>-->
<!--            <p style="color: goldenrod"> Статус</p>-->
<!---->
<!--            <a href="logout.php" class="logout_button">Выйти</a>-->
<!---->
<!--        </div>-->
<!--    </div>-->


    <div id="article" style="  margin-left: 0; width: 100%">
        <h2 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Профиль</h2>

        <div id="profile_page">
            <a> <img class=c_profile src="images/user.png" alt="User_face" ></a>
            <p>ИВАНОВ ИВАН</p>

        </div>



    </div>



</div>



<!-- Нижний блок информации -->
<div id="footer">
    <p>Contacts: mos_admin@mail.ru</p>
    <p>Copyright © Московский метрополитен, 2019</p>
</div>


</body>
</html>
