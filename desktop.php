<?php 
	session_start(); 

	if (!isset($_SESSION['auth']) or empty($_SESSION['auth']) or ($_SESSION['auth'] === false)){
		header("Location: main.php");
	}

	if(isset($_REQUEST['out'])){
		$out = $_REQUEST['out'];
		if($out){
			session_unset();
			session_destroy();
			setcookie();
			header("Location: main.php");
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Рабочий стол </title>
    <link rel="stylesheet"  type="text/css" href="style.css" >
</head>
<body>
	<!-- Верхний блок страницы-->
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
	<!-- Середина страницы-->
	<div class="wrapper" style="margin-top: 50px">
		<div id="nav2">
			<ul>
				<li><a href="#">Профиль</a></li>
				<li><a href="desktop.php">На рабочий стол</a></li>
				<li><a href="doc_archive.php">Архив документов</a></li>
			</ul>
		</div>
		<div id="sidebar1" class="aside">
			<div id="auth_user">
				<a href="#" > <img src="images/user.png" alt="User_face" ></a>
				<p><?php echo $_SESSION['surname']; ?></p>
				<p><?php echo $_SESSION['name']; ?> <?php echo $_SESSION['patronymic']; ?></p>
				<a href="desktop.php?out=1" class="logout_button">Выйти</a>
			</div>
		</div>
		<div id="article">
			<h2 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Рабочий стол</h2>

			<div class="desktop">
				<ul>
					<li>
						<a href="#">
							<p>
								<img src="images/alert_logo.png" width="auto" height="50px" align="middle"  alt="alert_logo">
								Войдите в "профиль" для подтвержения или редактирования своих персональных данных
							</p>
						</a>
					</li>
					<li>
						<a href="doc_archive.php">
							<p>
								<img src="images/doc_logo.png" width="auto" height="50px" align="middle"  alt="alert_logo">
								Новые документы
							</p>
						</a>
					</li>
					<li>
						<a href="doc_queue.php">
							<p>
								<img src="images/on_sub.png" width="auto" height="50px" align="middle"  alt="alert_logo" style="padding-left: 9px">
								Документы на подпись
							</p>
						</a>
					</li>
					<li>
						<a href="info.php">
							<p>
								<img src="images/help_ico.png" width="auto" height="50px" align="middle"  alt="alert_logo" style="padding-left: 4px">
								Поддержка
							</p>
						</a>
					</li>
				</ul>
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
