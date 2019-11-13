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
	
	$allgood = false;
	try {
		ini_set("soap.wsdl_cache_enabled", "0" );
		$client = new SoapClient("http://metroservice.somee.com/WebService/MetroService.asmx?wsdl", array("exceptions" => false));
		$params = array( "sekret_key" => "rye3firbvlvjsne3n25123m2n1", "login" => $_SESSION['login'], "password" => $_SESSION['password']); 
		$response = $client->__soapCall("GetNotFamiliarDocuments", array($params)); 
		//var_dump($response);
		if(isset($response->GetNotFamiliarDocumentsResult)){
			$obj = json_decode($response->GetNotFamiliarDocumentsResult);
			if(isset($obj->{"docNotFamiliarLst"}))
			{
				$allgood = true;
				//var_dump($response);
			}
			else echo "Неверный логин или пароль";
		} 
		else echo "Неверный логин или пароль";
	}
	catch (SoapFault $exc) {
		print_r($exc->getMessage());
	}
	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Очередь документов </title>
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
				<li><a href="desktop.php">На рабочий стол</a></li>
				<li><a href="doc_archive.php">Архив документов</a></li>
			</ul>
		</div>
		<div id="sidebar1" class="aside">
			<div id="auth_user">
				<a href="#" > <img src="images/user.png" alt="User_face" ></a>
				<p> <?php echo $_SESSION['surname']; ?> </p>
				<p><?php echo $_SESSION['name']; ?> <?php echo $_SESSION['patronymic']; ?></p>
				<a href="doc_queue.php?out=1" class="logout_button">Выйти</a>
			</div>
		</div>
		<div id="article">
			<h2 style="text-align: center">Документы на очередь</h2>
			<?php 
				$iter = 0;
				while($allgood and isset($obj->{"docNotFamiliarLst"}[$iter]))
				{
					if($obj->{"docNotFamiliarLst"}[$iter]->{"finishDeadLine"})
						$style = 'style="background-color:red"';
					else  $style = '';
					printf('
						<div class="doc_queue_mini">
							<ul>
								<li>
									<div class="doc_queue_left">
										<p class="doc_title"><center><strong>%s</strong></center></p>
										<div class="doc_footer">
											<ul>
												<li>
													<p>получил</p>
													<p>%s</p>

												</li>
												<li %s>
													<p>подписать до</p>
													<p>%s</p>
												</li>
											</ul>
										</div>
									</div>
								</li>
								<li>
									<div class="doc_queue_right">
										<a href="viev_doc.php?docname=%s">
										<span class="button_right" >
											<h2>Изучить</h2>
										  </span>
										</a>
									</div>
								</li>
							</ul>
						</div>',$obj->{"docNotFamiliarLst"}[$iter]->{"header"},$obj->{"docNotFamiliarLst"}[$iter]->{"dateGive"},$style,$obj->{"docNotFamiliarLst"}[$iter]->{"dateDeadLine"},$obj->{"docNotFamiliarLst"}[$iter]->{"Name"});
					$iter=$iter+1;
				}
			?>
		</div>
	</div>
	<!-- Нижний блок информации -->
	<div id="footer">
		<p>Contacts: mos_admin@mail.ru</p>
		<p>Copyright © Московский метрополитен, 2019</p>
	</div>


</body>
</html>
