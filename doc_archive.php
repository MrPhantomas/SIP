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
	

	$allgood_first = false;
	$allgood_second = false;
	try {
		ini_set("soap.wsdl_cache_enabled", "0" );
		$client = new SoapClient("http://metroservice.somee.com/WebService/MetroService.asmx?wsdl", array("exceptions" => false));
		$params = array( "sekret_key" => "rye3firbvlvjsne3n25123m2n1", "login" => $_SESSION['login'], "password" => $_SESSION['password']);
		
		
		$response_first = $client->__soapCall("GetNotFamiliarDocuments", array($params)); 
		if(isset($response_first->GetNotFamiliarDocumentsResult)){
			$objnotfam = json_decode($response_first->GetNotFamiliarDocumentsResult);
			if(isset($objnotfam->{"docNotFamiliarLst"}[0]))
			{
				$allgood_first = true;
			}
		} 
		else echo "Неверный логин или пароль";
		
		
		$response_second = $client->__soapCall("GetFamiliarDocuments", array($params)); 
		if(isset($response_second->GetFamiliarDocumentsResult)){
			$objfam = json_decode($response_second->GetFamiliarDocumentsResult);
			if(isset($objfam->{"docFamiliarLst"}[0]))
			{
				$allgood_second = true;
			}
		} 
		else echo "Неверный логин или пароль";
		
		
	}
	catch (SoapFault $exc) {
		print_r($exc->getMessage());
	}
	
	if($allgood_first)
		$objnotfam_json = $objnotfam->{"docNotFamiliarLst"};
	if($allgood_second)
		$objfam_json = $objfam->{"docFamiliarLst"};


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Архив документов </title>
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
	<div class="wrapper" style="margin-top: 50px">
		<div id="nav2">
			<ul>
				<li><a href="#">Профиль</a></li>
				<li><a href="doc_queue.php">Доукменты на очередь</a></li>
				<li><a href="desktop.php">На рабочий стол</a></li>
			</ul>
		</div>
		<div id="sidebar1" class="aside">
			<div id="auth_user">

				<a href="#" > <img src="images/user.png" alt="User_face" ></a>
				<p> <?php echo $_SESSION['surname']; ?> </p>
				<p><?php echo $_SESSION['name']; ?> <?php echo $_SESSION['patronymic']; ?></p>
				<a href="doc_archive.php?out=1" class="logout_button">Выйти</a>
			</div>
		</div>
		<div id="article">
			<h2 style="text-align: center; margin: 15px 0" >Архив документов</h2>

			<!--<div class="d1">
				<form>
					<input type="text" placeholder="Поиск документов....">
					<button type="submit"><img src="images/search.png" alt="Поиск"></button>
				</form>
			</div> -->
	<!--        Вот эта таблица генерируется после запроса к БД и с помощью простого цикла выводиться строка за строкой.
	 Первая строка энифэй должна напечататься. что бы было понятно, что это таблица, остальные по циклу-->
			<table class="cwdtable" cellspacing="0" cellpadding="1" border="1">
				<tr>
					<th>№</th>
					<th>название</th>
					<th>дата</th>
					<th>уровень доступа</th>
					<th>статус</th>
				</tr>
				</thead>
				<tbody>
					
				<?php 
					$iter_first = 0;
					while($allgood_first and isset($objnotfam_json[$iter_first]))
					{
						printf('
							<tr>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td>Общий</td>
							<td>В очереди</td>
							</tr>'
								,$iter_first+1,$objnotfam_json[$iter_first]->{"header"},$objnotfam_json[$iter_first]->{"dateGive"});
						$iter_first=$iter_first+1;
					}
					$iter_second = 0;
					while($allgood_second and isset($objfam_json[$iter_second]))
					{
						printf('
							<tr>
							<td>%s</td>
							<td>%s</td>
							<td>%s</td>
							<td>Общий</td>
							<td>Подписан	</td>
							</tr>'
								,($iter_second + $iter_first)+1,$objfam_json[$iter_second]->{"header"},$objfam_json[$iter_second]->{"dateGive"});
						$iter_second=$iter_second+1;
					}
					
				?>	
			</table>
		</div>
	</div>
	<!-- Нижний блок информации -->
	<div id="footer">
		<p>Contacts: mos_admin@mail.ru</p>
		<p>Copyright © Московский метрополитен, 2019</p>
	</div>


</body>
</html>
