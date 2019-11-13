<?php 
	session_start(); 
	if ( isset($_REQUEST['password']) and isset($_REQUEST['login']) ) {	
		try {
			ini_set("soap.wsdl_cache_enabled", "0" );
			$client = new SoapClient("http://metroservice.somee.com/WebService/MetroService.asmx?wsdl", array("exceptions" => false));
			$params = array( "login" => $_REQUEST['login'], "password" => $_REQUEST['password']); 
			$response = $client->__soapCall("GetDataUser", array($params)); 
			if(isset($response->GetDataUserResult)){
				$obj = json_decode($response->GetDataUserResult);
				if(isset($obj->{"fio"}))
				{
					$_SESSION['auth'] = true;
					$_SESSION['login'] = $_REQUEST['login'];
					$_SESSION['password'] = $_REQUEST['password'];
					$_SESSION['name'] = $obj->{"fio"}->{"name"};
					$_SESSION['surname'] = $obj->{"fio"}->{"surname"};
					$_SESSION['patronymic'] = $obj->{"fio"}->{"lastname"};
					header("Location: desktop.php");
				}
			} 
			else echo "Неверный логин или пароль";
		}
		catch (SoapFault $exc) {
			print_r($exc->getMessage());
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Авторизация </title>
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
	<!-- Середина страницы-->
	<div class="wrapper" style="margin-top: 50px; background-color: transparent">
		<form action="main.php" class="ui-form"  method='POST'>
			<h3>Вход в систему</h3>
			<!--<h3>Неверный логин или пароль</h3>-->
			<div class="form-row">
				<input type="text" name="login" id="login" required autocomplete="off"><label for="login">Login</label>
			</div>
			<div class="form-row">
				<input type="password" name="password" id="password" required autocomplete="off"><label for="password">Пароль</label>
			</div>
			<p><input type="submit" value="Войти"></p>
		</form>
	</div>
	<div id="footer">
		<p>Contacts: mos_admin@mail.ru</p>
		<p>Copyright © Московский метрополитен, 2019</p>
	</div>
</body>
</html>